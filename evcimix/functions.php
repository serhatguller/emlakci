<?php
if (!defined('ABSPATH')) exit;

define('YUVA_WA', '902120000000'); // WhatsApp numarası (başında + olmadan)

add_action('after_setup_theme', function () {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form', 'gallery', 'caption']);
    register_nav_menu('main', 'Ana Menü');
});

add_action('wp_enqueue_scripts', function () {
    $v = wp_get_theme()->get('Version');
    wp_enqueue_style('yuva-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap', [], null);
    wp_enqueue_style('yuva',get_template_directory_uri() . '/assets/style.css', [], $v);
    wp_enqueue_script('yuva', get_template_directory_uri() . '/assets/app.js', [], $v, true);
});

/* Favicon */
add_action('wp_head', function () {
    $u = get_template_directory_uri() . '/assets/brand/';
    echo '<link rel="icon" type="image/svg+xml" href="' . esc_url($u . 'favicon.svg') . '">' . "\n";
    echo '<link rel="icon" type="image/png" sizes="32x32" href="' . esc_url($u . 'favicon-32.png') . '">' . "\n";
    echo '<link rel="icon" type="image/png" sizes="16x16" href="' . esc_url($u . 'favicon-16.png') . '">' . "\n";
    echo '<link rel="shortcut icon" href="' . esc_url($u . 'favicon.ico') . '">' . "\n";
    echo '<link rel="apple-touch-icon" href="' . esc_url($u . 'apple-touch-icon.png') . '">' . "\n";
    echo '<meta name="theme-color" content="#0b1b2b">' . "\n";
}, 1);
add_action('admin_head', function () { echo '<link rel="icon" href="' . esc_url(get_template_directory_uri() . '/assets/brand/favicon.ico') . '">'; });

/* İlan içerik tipi + sınıflandırmalar */
add_action('init', function () {
    register_post_type('ilan', [
        'labels' => ['name' => 'İlanlar', 'singular_name' => 'İlan', 'add_new_item' => 'Yeni İlan Ekle', 'menu_name' => 'İlanlar'],
        'public' => true, 'has_archive' => true, 'menu_icon' => 'dashicons-admin-home',
        'supports' => ['title', 'editor', 'thumbnail'], 'rewrite' => ['slug' => 'ilan'], 'show_in_rest' => true,
    ]);
    foreach ([
        'durum'   => ['Durum', 'Satılık / Kiralık'],
        'ilan_kat' => ['Kategori', 'Konut, İş Yeri, Arsa, Bina'],
        'sehir'   => ['Şehir', 'Şehir'],
    ] as $tax => [$label]) {
        register_taxonomy($tax, 'ilan', [
            'label' => $label, 'hierarchical' => true, 'show_admin_column' => true,
            'show_in_rest' => true, 'rewrite' => ['slug' => $tax],
        ]);
    }
});

/* Ek alanlar: fiyat, m², oda, ilçe */
const YUVA_FIELDS = ['fiyat' => 'Fiyat (₺)', 'm2' => 'm²', 'oda' => 'Oda Sayısı (örn. 3+1)', 'ilce' => 'İlçe'];

add_action('add_meta_boxes', function () {
    add_meta_box('ilan_detay', 'İlan Detayları', function ($post) {
        wp_nonce_field('ilan_detay', 'ilan_nonce');
        foreach (YUVA_FIELDS as $k => $label) {
            printf('<p><label><strong>%s</strong><br><input type="%s" name="%s" value="%s" style="width:100%%"></label></p>',
                esc_html($label), in_array($k, ['fiyat', 'm2']) ? 'number' : 'text', esc_attr($k),
                esc_attr(get_post_meta($post->ID, $k, true)));
        }
    }, 'ilan', 'side');
});

add_action('save_post_ilan', function ($id) {
    if (!isset($_POST['ilan_nonce']) || !wp_verify_nonce($_POST['ilan_nonce'], 'ilan_detay')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $id)) return;
    foreach (array_keys(YUVA_FIELDS) as $k) {
        if (isset($_POST[$k])) update_post_meta($id, $k, sanitize_text_field(wp_unslash($_POST[$k])));
    }
});

/* Filtreli sorgu (URL parametreleri: durum, kat, sehir, q, min, max, oda, m2, sirala) */
function yuva_query($per_page = 12) {
    $g = fn($k) => isset($_GET[$k]) ? sanitize_text_field(wp_unslash($_GET[$k])) : '';
    $args = ['post_type' => 'ilan', 'posts_per_page' => $per_page, 'paged' => max(1, get_query_var('paged') ?: (int) $g('sayfa'))];
    $tax = [];
    foreach (['durum' => 'durum', 'kat' => 'ilan_kat', 'sehir' => 'sehir'] as $p => $t) {
        if ($g($p)) $tax[] = ['taxonomy' => $t, 'field' => 'slug', 'terms' => $g($p)];
    }
    if ($tax) $args['tax_query'] = $tax;
    $meta = [];
    if ($g('min') !== '') $meta[] = ['key' => 'fiyat', 'value' => (int) $g('min'), 'type' => 'NUMERIC', 'compare' => '>='];
    if ($g('max') !== '') $meta[] = ['key' => 'fiyat', 'value' => (int) $g('max'), 'type' => 'NUMERIC', 'compare' => '<='];
    if ($g('m2') !== '')  $meta[] = ['key' => 'm2', 'value' => (int) $g('m2'), 'type' => 'NUMERIC', 'compare' => '>='];
    if ($g('oda') !== '') $meta[] = ['key' => 'oda', 'value' => $g('oda')];
    if ($meta) $args['meta_query'] = $meta;
    if ($g('q')) $args['s'] = $g('q');
    switch ($g('sirala')) {
        case 'asc':  $args += ['meta_key' => 'fiyat', 'orderby' => 'meta_value_num', 'order' => 'ASC']; break;
        case 'desc': $args += ['meta_key' => 'fiyat', 'orderby' => 'meta_value_num', 'order' => 'DESC']; break;
        case 'm2':   $args += ['meta_key' => 'm2', 'orderby' => 'meta_value_num', 'order' => 'DESC']; break;
    }
    return new WP_Query($args);
}

function yuva_price($id) {
    $f = (float) get_post_meta($id, 'fiyat', true);
    $kira = has_term('kiralik', 'durum', $id) || has_term('Kiralık', 'durum', $id);
    return $f ? number_format($f, 0, ',', '.') . ' ₺' . ($kira ? ' / ay' : '') : 'Fiyat sorunuz';
}

/* Tema aktifleşince örnek terimleri ekle */
add_action('after_switch_theme', function () {
    foreach (['Satılık', 'Kiralık'] as $t) wp_insert_term($t, 'durum');
    foreach (['Konut', 'İş Yeri', 'Arsa', 'Bina'] as $t) wp_insert_term($t, 'ilan_kat');
    flush_rewrite_rules();
});

/* İletişim formu (admin-post) */
add_action('admin_post_nopriv_yuva_contact', 'yuva_contact');
add_action('admin_post_yuva_contact', 'yuva_contact');
function yuva_contact() {
    if (!isset($_POST['_n']) || !wp_verify_nonce($_POST['_n'], 'yuva_contact')) wp_die('Geçersiz istek');
    $ad = sanitize_text_field(wp_unslash($_POST['ad'] ?? ''));
    $tel = sanitize_text_field(wp_unslash($_POST['tel'] ?? ''));
    $msg = sanitize_textarea_field(wp_unslash($_POST['mesaj'] ?? ''));
    wp_mail(get_option('admin_email'), "Yeni talep: $ad", "Ad: $ad\nTel: $tel\n\n$msg");
    wp_safe_redirect(add_query_arg('gonderildi', '1', home_url('/#iletisim')));
    exit;
}
