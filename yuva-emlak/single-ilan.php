<?php get_header(); while (have_posts()) : the_post(); $id = get_the_ID(); ?>
<main class="wrap single">
  <span class="eyebrow"><?php echo esc_html(implode(' · ', array_filter([
    implode(', ', wp_get_post_terms($id, 'durum', ['fields' => 'names'])),
    implode(', ', wp_get_post_terms($id, 'ilan_kat', ['fields' => 'names'])),
  ]))); ?></span>
  <?php if (has_post_thumbnail()) the_post_thumbnail('large'); ?>
  <h1 class="sec-title"><?php the_title(); ?></h1>
  <p class="loc"><?php echo esc_html(implode(' · ', array_filter([
    implode(', ', wp_get_post_terms($id, 'sehir', ['fields' => 'names'])),
    get_post_meta($id, 'ilce', true),
    get_post_meta($id, 'm2', true) ? get_post_meta($id, 'm2', true) . ' m²' : '',
    get_post_meta($id, 'oda', true),
  ]))); ?></p>
  <p class="price"><?php echo esc_html(yuva_price($id)); ?></p>
  <div><?php the_content(); ?></div>
  <p style="margin-top:28px"><a class="btn" target="_blank" rel="noopener" href="https://wa.me/<?php echo esc_attr(YUVA_WA); ?>?text=<?php echo rawurlencode('Merhaba, şu ilan hakkında bilgi almak istiyorum: ' . get_the_title()); ?>">WhatsApp ile İletişime Geç</a></p>
</main>
<?php endwhile; get_footer();
