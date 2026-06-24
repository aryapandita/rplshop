<?php
// pages/download-app.php - Download Aplikasi RPLShop
$path_prefix = '../';
$page_title = 'Download Aplikasi - RPLShop';

require_once __DIR__ . '/../includes/functions.php';
include __DIR__ . '/../includes/header.php';
?>

<div style="min-height: 80vh; background: linear-gradient(180deg, #101827 0%, #0f172a 100%); padding: 60px 0;">
    <div class="inner" style="max-width: 900px; margin: 0 auto; padding: 0 20px;">

        <!-- Hero Section -->
        <div style="display: flex; align-items: center; gap: 40px; flex-wrap: wrap; margin-bottom: 60px;">
            <div style="flex: 1; min-width: 300px;">
                <div style="display: inline-block; background: rgba(255, 196, 0, 0.12); color: #FFC400; font-size: 11px; font-weight: 800; padding: 5px 14px; border-radius: 20px; text-transform: uppercase; margin-bottom: 16px;">📱 Segera Hadir</div>
                <h1 style="color: #fff; font-size: 34px; font-weight: 800; margin-bottom: 14px; line-height: 1.2;">
                    RPLShop di <span style="color: #FFC400;">Saku Anda</span>
                </h1>
                <p style="color: #94a3b8; font-size: 15px; line-height: 1.7; margin-bottom: 25px;">
                    Nikmati pengalaman top-up game, beli gift card, dan klaim voucher diskon langsung dari ponsel Anda. Lebih cepat, lebih mudah, dan lebih hemat!
                </p>
                <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                    <div style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1); border-radius: 10px; padding: 12px 20px; display: flex; align-items: center; gap: 10px; cursor: default; opacity: 0.7;">
                        <span icon="android" style="font-size: 28px; color: #a4c639;"></span>
                        <div>
                            <div style="color: #94a3b8; font-size: 10px; text-transform: uppercase;">Segera di</div>
                            <div style="color: #fff; font-size: 15px; font-weight: 700;">Google Play</div>
                        </div>
                    </div>
                    <div style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1); border-radius: 10px; padding: 12px 20px; display: flex; align-items: center; gap: 10px; cursor: default; opacity: 0.7;">
                        <span icon="phone_iphone" style="font-size: 28px; color: #fff;"></span>
                        <div>
                            <div style="color: #94a3b8; font-size: 10px; text-transform: uppercase;">Segera di</div>
                            <div style="color: #fff; font-size: 15px; font-weight: 700;">App Store</div>
                        </div>
                    </div>
                </div>
            </div>
            <div style="flex: 0 0 260px; text-align: center;">
                <div style="width: 220px; height: 380px; border: 2px dashed rgba(255, 196, 0, 0.2); border-radius: 28px; background: rgba(255, 196, 0, 0.03); display: flex; flex-direction: column; align-items: center; justify-content: center; margin: 0 auto; gap: 12px;">
                    <span icon="install_mobile" style="font-size: 56px; color: rgba(255, 196, 0, 0.3);"></span>
                    <span style="color: rgba(255, 196, 0, 0.4); font-size: 13px; font-weight: 600;">App Preview</span>
                </div>
            </div>
        </div>

        <!-- Features -->
        <h2 style="color: #fff; font-size: 22px; font-weight: 700; margin-bottom: 25px; text-align: center;">Fitur Unggulan Aplikasi</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 50px;">

            <div style="background: rgba(30, 41, 59, 0.5); border-radius: 14px; border: 1px solid rgba(255,255,255,0.06); padding: 25px 20px; text-align: center; transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-3px)';" onmouseout="this.style.transform='none';">
                <span icon="flash_on" style="font-size: 32px; color: #FFC400; display: block; margin-bottom: 12px;"></span>
                <h3 style="color: #fff; font-size: 15px; font-weight: 700; margin-bottom: 6px;">Top-Up Instan</h3>
                <p style="color: #94a3b8; font-size: 12px; line-height: 1.5;">Proses top-up lebih cepat langsung dari smartphone Anda.</p>
            </div>

            <div style="background: rgba(30, 41, 59, 0.5); border-radius: 14px; border: 1px solid rgba(255,255,255,0.06); padding: 25px 20px; text-align: center; transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-3px)';" onmouseout="this.style.transform='none';">
                <span icon="notifications_active" style="font-size: 32px; color: #3b82f6; display: block; margin-bottom: 12px;"></span>
                <h3 style="color: #fff; font-size: 15px; font-weight: 700; margin-bottom: 6px;">Notifikasi Promo</h3>
                <p style="color: #94a3b8; font-size: 12px; line-height: 1.5;">Dapatkan pemberitahuan langsung saat ada promo menarik.</p>
            </div>

            <div style="background: rgba(30, 41, 59, 0.5); border-radius: 14px; border: 1px solid rgba(255,255,255,0.06); padding: 25px 20px; text-align: center; transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-3px)';" onmouseout="this.style.transform='none';">
                <span icon="history" style="font-size: 32px; color: #10b981; display: block; margin-bottom: 12px;"></span>
                <h3 style="color: #fff; font-size: 15px; font-weight: 700; margin-bottom: 6px;">Riwayat Transaksi</h3>
                <p style="color: #94a3b8; font-size: 12px; line-height: 1.5;">Lacak semua transaksi dan pembelian Anda dengan mudah.</p>
            </div>

            <div style="background: rgba(30, 41, 59, 0.5); border-radius: 14px; border: 1px solid rgba(255,255,255,0.06); padding: 25px 20px; text-align: center; transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-3px)';" onmouseout="this.style.transform='none';">
                <span icon="lock" style="font-size: 32px; color: #a855f7; display: block; margin-bottom: 12px;"></span>
                <h3 style="color: #fff; font-size: 15px; font-weight: 700; margin-bottom: 6px;">Keamanan Tinggi</h3>
                <p style="color: #94a3b8; font-size: 12px; line-height: 1.5;">Proteksi data dan transaksi dengan teknologi enkripsi modern.</p>
            </div>

        </div>

        <!-- Notify Me -->
        <div style="background: linear-gradient(135deg, rgba(255, 196, 0, 0.08), rgba(255, 196, 0, 0.02)); border: 1px solid rgba(255, 196, 0, 0.15); border-radius: 16px; padding: 35px 30px; text-align: center;">
            <h2 style="color: #fff; font-size: 20px; font-weight: 700; margin-bottom: 10px;">Mau jadi yang pertama tahu?</h2>
            <p style="color: #94a3b8; font-size: 14px; margin-bottom: 24px;">Kami akan segera merilis aplikasi RPLShop. Sementara itu, nikmati layanan kami melalui website!</p>
            <a href="products.php" class="btw" color="theme" style="padding: 14px 35px; border-radius: 8px; font-weight: bold; font-size: 15px; display: inline-block; text-decoration: none;">
                <span icon="shopping_bag">Belanja via Website</span>
            </a>
        </div>

    </div>
</div>

<?php
include __DIR__ . '/../includes/footer.php';
?>
