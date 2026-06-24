<?php
// pages/about.php - Tentang RPLShop
$path_prefix = '../';
$page_title = 'Tentang Kami - RPLShop';

require_once __DIR__ . '/../includes/functions.php';
include __DIR__ . '/../includes/header.php';
?>

<div style="min-height: 80vh; background: linear-gradient(180deg, #101827 0%, #0f172a 100%); padding: 60px 0;">
    <div class="inner" style="max-width: 900px; margin: 0 auto; padding: 0 20px;">

        <!-- Hero Section -->
        <div style="text-align: center; margin-bottom: 50px;">
            <span icon="storefront" style="font-size: 56px; color: #FFC400; display: block; margin-bottom: 16px;"></span>
            <h1 style="color: #fff; font-size: 32px; font-weight: 800; margin-bottom: 12px;">Tentang RPLShop</h1>
            <p style="color: #94a3b8; font-size: 16px; max-width: 600px; margin: 0 auto; line-height: 1.7;">
                Platform top-up game, gift card, dan voucher digital terpercaya di Indonesia.
            </p>
        </div>

        <!-- About Cards -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 24px; margin-bottom: 50px;">

            <div style="background: rgba(30, 41, 59, 0.5); border-radius: 14px; border: 1px solid rgba(255,255,255,0.06); padding: 30px 25px; transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-3px)';" onmouseout="this.style.transform='none';">
                <span icon="bolt" style="font-size: 36px; color: #FFC400; display: block; margin-bottom: 14px;"></span>
                <h3 style="color: #fff; font-size: 18px; font-weight: 700; margin-bottom: 10px;">Proses Instan</h3>
                <p style="color: #94a3b8; font-size: 14px; line-height: 1.6;">Top-up dan pengiriman kode voucher dilakukan secara otomatis dan instan setelah pembayaran dikonfirmasi.</p>
            </div>

            <div style="background: rgba(30, 41, 59, 0.5); border-radius: 14px; border: 1px solid rgba(255,255,255,0.06); padding: 30px 25px; transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-3px)';" onmouseout="this.style.transform='none';">
                <span icon="verified_user" style="font-size: 36px; color: #10b981; display: block; margin-bottom: 14px;"></span>
                <h3 style="color: #fff; font-size: 18px; font-weight: 700; margin-bottom: 10px;">100% Resmi & Aman</h3>
                <p style="color: #94a3b8; font-size: 14px; line-height: 1.6;">Semua produk yang kami jual berasal dari distributor resmi dengan jaminan keaslian dan keamanan data transaksi.</p>
            </div>

            <div style="background: rgba(30, 41, 59, 0.5); border-radius: 14px; border: 1px solid rgba(255,255,255,0.06); padding: 30px 25px; transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-3px)';" onmouseout="this.style.transform='none';">
                <span icon="support_agent" style="font-size: 36px; color: #3b82f6; display: block; margin-bottom: 14px;"></span>
                <h3 style="color: #fff; font-size: 18px; font-weight: 700; margin-bottom: 10px;">Layanan 24/7</h3>
                <p style="color: #94a3b8; font-size: 14px; line-height: 1.6;">Tim customer service kami siap membantu Anda kapan saja melalui email dan live chat untuk setiap pertanyaan.</p>
            </div>

        </div>

        <!-- About Description -->
        <div style="background: rgba(30, 41, 59, 0.5); border-radius: 14px; border: 1px solid rgba(255,255,255,0.06); padding: 35px 30px; margin-bottom: 40px;">
            <h2 style="color: #fff; font-size: 22px; font-weight: 700; margin-bottom: 18px;">Siapa Kami?</h2>
            <div style="color: #cbd5e1; font-size: 15px; line-height: 1.8;">
                <p style="margin-bottom: 16px;">
                    <strong style="color: #FFC400;">RPLShop</strong> adalah platform e-commerce yang berfokus pada penyediaan layanan top-up game, gift card, dan voucher digital di Indonesia. Kami berdedikasi untuk memberikan pengalaman belanja digital yang cepat, aman, dan terjangkau bagi para gamer dan pengguna digital di seluruh Indonesia.
                </p>
                <p style="margin-bottom: 16px;">
                    Didirikan dengan visi untuk menjadi platform top-up game terdepan, RPLShop menyediakan berbagai produk mulai dari Diamond Mobile Legends, UC PUBG Mobile, Steam Wallet Code, Razer Gold, Google Play Gift Card, dan masih banyak lagi.
                </p>
                <p>
                    Kami bekerja sama langsung dengan publisher dan distributor resmi untuk memastikan setiap transaksi yang Anda lakukan di RPLShop terjamin keamanan dan keasliannya. Dengan metode pembayaran yang beragam seperti GoPay, DANA, dan QRIS, proses pembelian menjadi semakin mudah dan fleksibel.
                </p>
            </div>
        </div>

        <!-- Stats -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 20px; margin-bottom: 40px;">
            <div style="text-align: center; padding: 25px 15px; background: rgba(255, 196, 0, 0.06); border-radius: 12px; border: 1px solid rgba(255, 196, 0, 0.15);">
                <div style="color: #FFC400; font-size: 32px; font-weight: 800; margin-bottom: 6px;">50+</div>
                <div style="color: #94a3b8; font-size: 13px;">Produk Digital</div>
            </div>
            <div style="text-align: center; padding: 25px 15px; background: rgba(16, 185, 129, 0.06); border-radius: 12px; border: 1px solid rgba(16, 185, 129, 0.15);">
                <div style="color: #10b981; font-size: 32px; font-weight: 800; margin-bottom: 6px;">10K+</div>
                <div style="color: #94a3b8; font-size: 13px;">Transaksi Sukses</div>
            </div>
            <div style="text-align: center; padding: 25px 15px; background: rgba(59, 130, 246, 0.06); border-radius: 12px; border: 1px solid rgba(59, 130, 246, 0.15);">
                <div style="color: #3b82f6; font-size: 32px; font-weight: 800; margin-bottom: 6px;">24/7</div>
                <div style="color: #94a3b8; font-size: 13px;">Customer Support</div>
            </div>
            <div style="text-align: center; padding: 25px 15px; background: rgba(168, 85, 247, 0.06); border-radius: 12px; border: 1px solid rgba(168, 85, 247, 0.15);">
                <div style="color: #a855f7; font-size: 32px; font-weight: 800; margin-bottom: 6px;">99.9%</div>
                <div style="color: #94a3b8; font-size: 13px;">Uptime Layanan</div>
            </div>
        </div>

        <!-- CTA -->
        <div style="text-align: center;">
            <a href="products.php" class="btw" color="theme" style="padding: 14px 35px; border-radius: 8px; font-weight: bold; font-size: 15px; display: inline-block; text-decoration: none;">
                <span icon="shopping_bag">Mulai Belanja Sekarang</span>
            </a>
        </div>

    </div>
</div>

<?php
include __DIR__ . '/../includes/footer.php';
?>
