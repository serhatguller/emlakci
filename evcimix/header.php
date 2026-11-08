<!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open();
$arsiv = get_post_type_archive_link('ilan') ?: home_url('/'); ?>
<header class="nav">
  <a class="logo" href="<?php echo esc_url(home_url('/')); ?>"><img class="mark" src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/brand/logo-mark.svg" alt="" width="40" height="40"><span class="lt"><b>Evcimix</b><small>Gayrimenkul</small></span></a>
  <nav class="menu">
    <a href="<?php echo esc_url(add_query_arg('durum', 'satilik', $arsiv)); ?>">Satılık</a>
    <a href="<?php echo esc_url(add_query_arg('durum', 'kiralik', $arsiv)); ?>">Kiralık</a>
    <a href="<?php echo esc_url(home_url('/#hizmetler')); ?>">Hizmetler</a>
    <a href="<?php echo esc_url(home_url('/#hakkimizda')); ?>">Hakkımızda</a>
    <a href="<?php echo esc_url(home_url('/#iletisim')); ?>">İletişim</a>
  </nav>
  <div class="right">
    <button class="link" id="favBtn" type="button">♥ <span id="favCount">0</span></button>
    <a class="btn small" href="<?php echo esc_url(home_url('/#iletisim')); ?>">Ücretsiz Değerleme</a>
  </div>
</header>
