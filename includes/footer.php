<?php
// includes/footer.php

if (!isset($path_prefix)) {
    $path_prefix = '';
}

$site_root = $path_prefix === '../' ? '../' : '';
?>

<footer id="site_footer">
    <div class="inner">
        <div id="footer_payments_wrp">
            <div class="channel_list">
                <div class="logo" title="QRIS"><span>QRIS</span></div>
                <div class="logo" title="DANA"><span>DANA</span></div>
                <div class="logo" title="BRI"><span>BRI</span></div>
                <div class="logo" title="GoPay"><span>GoPay</span></div>
                <div class="logo" title="Dana"><span>Dana</span></div>
            </div>
        </div>
        
        <div id="footer_sns_wrp">
            <h3>Hubungi Kami</h3>
            <div id="footer_sns" class="sns_list">
                <a href="mailto:support@rplshop.local" class="btw" color="facebook" title="Email Support"><span icon-only icon-brand="facebook">Email</span></a>
                <a href="mailto:support@rplshop.local" class="btw" color="xcom" title="Hubungi Kami di X"><span icon-only icon-brand="xcom">X</span></a>
                <a href="<?= $site_root ?>pages/news.php" class="btw" color="youtube" title="RPLShop di YouTube"><span icon-only icon-brand="youtube">YouTube</span></a>
                <a href="<?= $site_root ?>pages/news.php" class="btw" color="instagram" title="RPLShop di Instagram"><span icon-only icon-brand="instagram">Instagram</span></a>
                <a href="<?= $site_root ?>pages/news.php" class="btw" color="tiktok" title="RPLShop di TikTok"><span icon-only icon-brand="tiktok">TikTok</span></a>
            </div>
        </div>
        
        <div id="footer_nav_wrp">
            <div id="footer_nav">
                <div class="group">
                    <div class="title"><span>Tentang RPLShop</span></div>
                    <a class="link" href="<?= $site_root ?>pages/about.php">Tentang Kami</a>
                    <a class="link" href="<?= $site_root ?>pages/news.php">RPLShop News</a>
                    <a class="link" href="mailto:support@rplshop.local">Hubungi Kami</a>
                </div>
                <div class="group">
                    <div class="title"><span>Belanja</span></div>
                    <a class="link" href="<?= $site_root ?>pages/rewards.php">RPLShop STAR Rewards</a>
                    <a class="link" href="<?= $site_root ?>pages/products.php?category=card">Voucher Digital</a>
                </div>
                <div class="group">
                    <div class="title"><span>Legal</span></div>
                    <a class="link" href="<?= $site_root ?>pages/terms.php">Syarat Penggunaan</a>
                    <a class="link" href="<?= $site_root ?>pages/sales-policy.php">Ketentuan Penjualan</a>
                    <a class="link" href="<?= $site_root ?>pages/privacy.php">Kebijakan Privasi</a>
                </div>
                <div class="group">
                    <div class="title"><span>Partners</span></div>
                    <a class="link" href="mailto:partner@rplshop.local">Kemitraan</a>
                </div>
            </div>
        </div>
        
        <div id="footer_app">
            <a class="download" href="<?= $site_root ?>pages/download-app.php" color="theme" icon="open_in_new" title="RPLShop APP">
                <div class="text">
                    <div>RPLShop di Saku Anda</div>
                    <i>Dapatkan Aplikasi Sekarang!</i>
                </div>
            </a>
        </div>
        
        <div id="footer_copyright">
            <h3>© 2026 RPLShop. All Rights Reserved. Powered by XAMPP.</h3>
        </div>
    </div>
</footer>

<script type="text/javascript">
    // Initialize premium animations and menus
    $.tukibox();
    $.tukimenu();
    $.tukivalidator();
    
    // Check if select_s class elements exist before initializing
    if ($('.select_s').length > 0) {
        $('.select_s').tukiselect();
    }
    
    if ($('div.tukislide').length > 0) {
        $('div.tukislide').tukislide();
    }
    
    if ($('div.countdown').length > 0) {
        $('div.countdown').tukicountdown();
    }
    
    $.tukitip();
</script>

</body>
</html>
