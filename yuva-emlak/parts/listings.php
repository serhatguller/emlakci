<?php
$g = fn($k) => isset($_GET[$k]) ? sanitize_text_field(wp_unslash($_GET[$k])) : '';
$q = yuva_query(12);
$sehirler = get_terms(['taxonomy' => 'sehir', 'hide_empty' => false]);
$cats = get_terms(['taxonomy' => 'ilan_kat', 'hide_empty' => false]);
$action = get_post_type_archive_link('ilan') ?: home_url('/');
$baslik = ['satilik' => 'Satılık İlanlar', 'kiralik' => 'Kiralık İlanlar'][$g('durum')] ?? 'Tüm İlanlar';
?>
<section class="pagehead">
  <span class="eyebrow">Portföyümüz</span>
  <h1><?php echo esc_html($baslik); ?></h1>
  <p>Size en uygun gayrimenkulü filtreleyerek bulun.</p>
</section>

<div class="fbar">
  <form method="get" action="<?php echo esc_url($action); ?>">
    <label>Arama<input name="q" value="<?php echo esc_attr($g('q')); ?>" placeholder="Şehir, ilçe, başlık"></label>
    <label>Durum<select name="durum"><option value="">Tümü</option>
      <?php foreach (['satilik' => 'Satılık', 'kiralik' => 'Kiralık'] as $s => $l) printf('<option value="%s"%s>%s</option>', $s, selected($g('durum'), $s, false), $l); ?></select></label>
    <label>Kategori<select name="kat"><option value="">Tümü</option>
      <?php foreach ($cats as $t) printf('<option value="%s"%s>%s</option>', esc_attr($t->slug), selected($g('kat'), $t->slug, false), esc_html($t->name)); ?></select></label>
    <label>Şehir<select name="sehir"><option value="">Tümü</option>
      <?php foreach ($sehirler as $t) printf('<option value="%s"%s>%s</option>', esc_attr($t->slug), selected($g('sehir'), $t->slug, false), esc_html($t->name)); ?></select></label>
    <label>Min. Fiyat (₺)<input name="min" type="number" min="0" value="<?php echo esc_attr($g('min')); ?>"></label>
    <label>Maks. Fiyat (₺)<input name="max" type="number" min="0" value="<?php echo esc_attr($g('max')); ?>"></label>
    <label>Oda<input name="oda" placeholder="3+1" value="<?php echo esc_attr($g('oda')); ?>"></label>
    <label>Min. m²<input name="m2" type="number" min="0" value="<?php echo esc_attr($g('m2')); ?>"></label>
    <label>Sırala<select name="sirala">
      <?php foreach (['' => 'En yeni', 'asc' => 'Fiyat ↑', 'desc' => 'Fiyat ↓', 'm2' => 'm² ↓'] as $v => $l) printf('<option value="%s"%s>%s</option>', $v, selected($g('sirala'), $v, false), $l); ?></select></label>
    <div class="act">
      <button class="btn">Filtrele</button>
      <a href="<?php echo esc_url($action); ?>" style="color:var(--mut);padding-bottom:12px">Temizle</a>
    </div>
  </form>
</div>

<main class="wrap">
  <p class="count"><b><?php echo (int) $q->found_posts; ?></b> ilan bulundu</p>
  <div class="grid">
    <?php if ($q->have_posts()) : while ($q->have_posts()) : $q->the_post(); get_template_part('parts/card'); endwhile; wp_reset_postdata();
    else : ?><p class="empty">Kriterlere uygun ilan bulunamadı.</p><?php endif; ?>
  </div>
  <div class="pager">
    <?php echo wp_kses_post(paginate_links(['total' => $q->max_num_pages, 'current' => max(1, (int) $q->get('paged')), 'add_args' => array_filter($_GET), 'prev_text' => '←', 'next_text' => '→'])); ?>
  </div>
</main>
