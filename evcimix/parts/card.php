<?php
$id = get_the_ID();
$d = wp_get_post_terms($id, 'durum', ['fields' => 'names'])[0] ?? '';
$k = wp_get_post_terms($id, 'ilan_kat', ['fields' => 'names'])[0] ?? '';
$s = wp_get_post_terms($id, 'sehir', ['fields' => 'names'])[0] ?? '';
$oda = get_post_meta($id, 'oda', true);
$m2 = get_post_meta($id, 'm2', true);
$ilce = get_post_meta($id, 'ilce', true);
?>
<article class="card" data-id="<?php echo $id; ?>">
  <a class="ph" href="<?php the_permalink(); ?>">
    <?php echo has_post_thumbnail() ? get_the_post_thumbnail($id, 'medium_large', ['loading' => 'lazy']) : '<img loading="lazy" alt="" src="https://images.unsplash.com/photo-1560518883-ce09059eeffa?w=700">'; ?>
  </a>
  <span class="badge <?php echo $d === 'Kiralık' ? 'k' : ''; ?>"><?php echo esc_html($d ?: 'İlan'); ?></span>
  <button class="fav" type="button" data-fav="<?php echo $id; ?>" aria-label="Favorilere ekle">♥</button>
  <div class="info">
    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
    <p class="loc"><?php echo esc_html(implode(' / ', array_filter([$s, $ilce]))); ?></p>
    <div class="specs">
      <?php if ($k) echo '<span>' . esc_html($k) . '</span>'; ?>
      <?php if ($m2) echo '<span>' . esc_html($m2) . ' m²</span>'; ?>
      <?php if ($oda) echo '<span>' . esc_html($oda) . '</span>'; ?>
    </div>
    <p class="price"><?php echo esc_html(yuva_price($id)); ?></p>
  </div>
</article>
