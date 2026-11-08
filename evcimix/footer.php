<footer class="foot" id="iletisim">
  <div class="wrap">
    <div>
      <a class="logo" href="<?php echo esc_url(home_url('/')); ?>"><img class="mark" src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/brand/logo-mark.svg" alt="" width="40" height="40"><span class="lt"><b>Evcimix</b><small>Gayrimenkul</small></span></a>
      <p style="margin:16px 0">Evcimix Gayrimenkul Ticaret Limited Şirketi. Alım, satım ve kiralamada şeffaf, güvenilir ve sonuç odaklı gayrimenkul danışmanlığı.</p>
      <p>📞 0212 000 00 00<br>✉️ info@evcimix.com<br>📍 Sahabiye Mah., Sivas Bulvarı, Yıldız Apt. D:5, No:17<br>&nbsp;&nbsp;&nbsp;&nbsp;Kocasinan / Kayseri</p>
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
  <div class="copy">© <?php echo esc_html(date('Y')); ?> Evcimix Gayrimenkul Ticaret Limited Şirketi. Tüm hakları saklıdır.</div>
</footer>
<a class="wa" href="https://wa.me/<?php echo esc_attr(YUVA_WA); ?>" target="_blank" rel="noopener">WhatsApp</a>
<?php wp_footer(); ?>
</body>
</html>
