<?php
get_header();
$arsiv = get_post_type_archive_link('ilan') ?: home_url('/');
$sehirler = get_terms(['taxonomy' => 'sehir', 'hide_empty' => false]);
$cats = get_terms(['taxonomy' => 'ilan_kat', 'hide_empty' => false]);
$one = new WP_Query(['post_type' => 'ilan', 'posts_per_page' => 6]);
?>
<section class="hero">
  <div class="in">
    <span class="eyebrow">Gayrimenkul Danışmanlığı</span>
    <h1>Doğru mülk, doğru zamanda, <em>doğru fiyata.</em></h1>
    <p class="lead">Satın alma, satış ve kiralamada uçtan uca danışmanlık. Değerleme, pazarlık ve tapu sürecinde yanınızdayız.</p>
    <form class="pill" method="get" action="<?php echo esc_url($arsiv); ?>">
      <input name="q" placeholder="Konum veya anahtar kelime">
      <select name="durum"><option value="">Satılık / Kiralık</option><option value="satilik">Satılık</option><option value="kiralik">Kiralık</option></select>
      <select name="kat"><option value="">Mülk tipi</option>
        <?php foreach ($cats as $t) printf('<option value="%s">%s</option>', esc_attr($t->slug), esc_html($t->name)); ?></select>
      <button>Ara</button>
    </form>
  </div>
</section>

<section class="stats"><div class="wrap">
  <div><b>850+</b><span>Mutlu müşteri</span></div>
  <div><b>15 Yıl</b><span>Sektör tecrübesi</span></div>
  <div><b>₺2,4 Milyar</b><span>Tamamlanan satış hacmi</span></div>
  <div><b>%98</b><span>Müşteri memnuniyeti</span></div>
</div></section>

<section class="wrap">
  <span class="eyebrow">Öne Çıkan Portföy</span>
  <h2 class="sec-title">Seçilmiş gayrimenkuller</h2>
  <p class="sec-sub">Uzman ekibimiz tarafından değerlendirilen en güncel ilanlar.</p>
  <div class="grid">
    <?php if ($one->have_posts()) : while ($one->have_posts()) : $one->the_post(); get_template_part('parts/card'); endwhile; wp_reset_postdata();
    else : ?><p class="empty">Henüz ilan eklenmedi. Yönetim panelinden İlanlar → Yeni Ekle ile başlayın.</p><?php endif; ?>
  </div>
  <p class="more"><a class="btn" href="<?php echo esc_url($arsiv); ?>">Tüm İlanları Gör</a></p>
</section>

<section class="alt" id="hizmetler"><div class="wrap">
  <span class="eyebrow">Hizmetlerimiz</span>
  <h2 class="sec-title">Gayrimenkulde tam kapsamlı destek</h2>
  <p class="sec-sub">İhtiyacınıza göre planlanan, baştan sona yönetilen süreçler.</p>
  <div class="svc">
    <div><i>🏡</i><h3>Satış Danışmanlığı</h3><p>Doğru fiyatlama, profesyonel fotoğraf ve hedefli pazarlama ile mülkünüzü hızlı satın.</p></div>
    <div><i>🔑</i><h3>Kiralama Yönetimi</h3><p>Kiracı bulma, sözleşme ve tahsilat süreçlerini sizin adınıza yönetiyoruz.</p></div>
    <div><i>📊</i><h3>Değerleme & Analiz</h3><p>Bölge verileriyle ücretsiz piyasa değerleme ve yatırım getirisi analizi.</p></div>
    <div><i>📑</i><h3>Tapu & Hukuki Destek</h3><p>Tapu devri, ekspertiz ve hukuki kontrol süreçlerinde uçtan uca destek.</p></div>
  </div>
</div></section>

<section class="wrap about" id="hakkimizda">
  <img loading="lazy" alt="Danışman ekibi" src="https://images.unsplash.com/photo-1560250097-0b93528c311a?w=900">
  <div>
    <span class="eyebrow">Hakkımızda</span>
    <h2 class="sec-title">Güven, şeffaflık ve sonuç.</h2>
    <p style="color:var(--mut)">15 yılı aşkın tecrübemizle yüzlerce aileye ve yatırımcıya doğru gayrimenkulü bulduk. Her adımda net bilgi, dürüst yönlendirme ve ölçülebilir sonuç sunuyoruz.</p>
    <ul class="checks">
      <li>Ücretsiz ve bağlayıcı olmayan değerleme</li>
      <li>Bölgesine hâkim uzman danışmanlar</li>
      <li>Başından sonuna şeffaf süreç yönetimi</li>
      <li>Satış sonrası destek</li>
    </ul>
    <a class="btn" href="#iletisim">Bizimle Görüşün</a>
  </div>
</section>

<section class="alt"><div class="wrap">
  <span class="eyebrow">Müşteri Yorumları</span>
  <h2 class="sec-title">Bizi tercih edenler ne diyor?</h2>
  <div class="tst" style="margin-top:36px">
    <blockquote><div class="st">★★★★★</div><p>“Evimiz iki haftada, beklediğimizden yüksek fiyata satıldı. Süreç boyunca her şeyden haberdardık.”</p><cite>Ayşe K. — Kadıköy</cite></blockquote>
    <blockquote><div class="st">★★★★★</div><p>“Yatırım için doğru bölgeyi veriyle gösterdiler. Profesyonel ve çok dürüst bir ekip.”</p><cite>Murat D. — Yatırımcı</cite></blockquote>
    <blockquote><div class="st">★★★★★</div><p>“Kiracı bulma ve sözleşme işlerinin hepsini üstlendiler, hiç uğraşmadım.”</p><cite>Selin T. — Ev sahibi</cite></blockquote>
  </div>
</div></section>

<section class="cta"><div class="wrap">
  <h2 class="sec-title">Mülkünüzün değerini öğrenmek ister misiniz?</h2>
  <p>Ücretsiz değerleme için bilgilerinizi bırakın, 24 saat içinde dönüş yapalım.</p>
  <a class="btn" href="#iletisim">Ücretsiz Değerleme Al</a>
</div></section>
<?php get_footer();
