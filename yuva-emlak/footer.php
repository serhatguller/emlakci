<footer class="foot" id="iletisim">
  <div class="wrap">
    <div>
      <a class="logo" href="<?php echo esc_url(home_url('/')); ?>" style="color:#fff">Yuva<span>.</span>Gayrimenkul</a>
      <p style="margin:16px 0">Alım, satım ve kiralamada şeffaf, güvenilir ve sonuç odaklı gayrimenkul danışmanlığı.</p>
      <p>📞 0212 000 00 00<br>✉️ info@yuvagayrimenkul.com<br>📍 İstanbul, Türkiye</p>
    </div>
    <div>
      <h3>Hızlı Bağlantılar</h3>
      <ul>
        <li><a href="<?php echo esc_url(add_query_arg('durum', 'satilik', get_post_type_archive_link('ilan'))); ?>">Satılık İlanlar</a></li>
        <li><a href="<?php echo esc_url(add_query_arg('durum', 'kiralik', get_post_type_archive_link('ilan'))); ?>">Kiralık İlanlar</a></li>
        <li><a href="<?php echo esc_url(home_url('/#hizmetler')); ?>">Hizmetlerimiz</a></li>
        <li><a href="<?php echo esc_url(home_url('/#hakkimizda')); ?>">Hakkımızda</a></li>
      </ul>
    </div>
    <div>
      <h3>Bize Ulaşın</h3>
      <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
        <input type="hidden" name="action" value="yuva_contact">
        <?php wp_nonce_field('yuva_contact', '_n'); ?>
        <input name="ad" placeholder="Ad Soyad" required>
        <input name="tel" type="tel" placeholder="Telefon" required>
        <textarea name="mesaj" rows="3" placeholder="Mesajınız"></textarea>
        <button class="btn">Gönder</button>
        <?php if (isset($_GET['gonderildi'])) : ?><p>Teşekkürler, en kısa sürede dönüş yapacağız.</p><?php endif; ?>
      </form>
    </div>
  </div>
  <div class="copy">© <?php echo esc_html(date('Y')); ?> Yuva Gayrimenkul. Tüm hakları saklıdır.</div>
</footer>
<a class="wa" href="https://wa.me/<?php echo esc_attr(YUVA_WA); ?>" target="_blank" rel="noopener">WhatsApp</a>
<?php wp_footer(); ?>
</body>
</html>
