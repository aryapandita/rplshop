<?php
// pages/news.php - Berita & Promosi
$path_prefix = '../';
$page_title = 'Berita & Promosi - RPLShop';

require_once __DIR__ . '/../includes/functions.php';

// Fetch some products for news content
$stmt = $pdo->query("SELECT p.*, MIN(pp.price) as min_price, MAX(pp.discount_percent) as max_discount 
                     FROM products p 
                     LEFT JOIN product_packages pp ON p.id = pp.product_id 
                     GROUP BY p.id 
                     ORDER BY p.id DESC 
                     LIMIT 6");
$latest_products = $stmt->fetchAll();

include __DIR__ . '/../includes/header.php';
?>

<div style="min-height: 80vh; background: linear-gradient(180deg, #101827 0%, #0f172a 100%); padding: 60px 0;">
    <div class="inner" style="max-width: 1000px; margin: 0 auto; padding: 0 20px;">

        <!-- Header -->
        <div style="text-align: center; margin-bottom: 50px;">
            <span icon="newspaper" style="font-size: 48px; color: #FFC400; display: block; margin-bottom: 14px;"></span>
            <h1 style="color: #fff; font-size: 32px; font-weight: 800; margin-bottom: 10px;">Berita & Promosi</h1>
            <p style="color: #94a3b8; font-size: 15px; max-width: 550px; margin: 0 auto;">
                Dapatkan info terbaru seputar promo, event game, dan penawaran menarik dari RPLShop.
            </p>
        </div>

        <!-- Featured Promo Banner -->
        <div style="background: linear-gradient(135deg, rgba(255, 196, 0, 0.12), rgba(255, 196, 0, 0.03)); border: 1px solid rgba(255, 196, 0, 0.2); border-radius: 16px; padding: 35px 30px; margin-bottom: 40px; display: flex; align-items: center; gap: 25px; flex-wrap: wrap;">
            <div style="flex: 1; min-width: 260px;">
                <div style="display: inline-block; background: #FFC400; color: #000; font-size: 11px; font-weight: 800; padding: 4px 12px; border-radius: 20px; text-transform: uppercase; margin-bottom: 14px;">🔥 Promo Terbaru</div>
                <h2 style="color: #fff; font-size: 22px; font-weight: 800; margin-bottom: 10px;">Diskon Spesial Bulan Juni 2026!</h2>
                <p style="color: #cbd5e1; font-size: 14px; line-height: 1.6; margin-bottom: 20px;">
                    Nikmati potongan harga hingga 20% untuk semua produk top-up game dan gift card pilihan. Promo berlaku selama persediaan masih ada!
                </p>
                <a href="products.php" class="btw" color="theme" style="padding: 11px 25px; border-radius: 8px; font-weight: bold; font-size: 14px; display: inline-block; text-decoration: none;">
                    <span icon="local_offer">Lihat Promo</span>
                </a>
            </div>
            <div style="flex: 0 0 180px; text-align: center;">
                <div style="width: 160px; height: 160px; border: 1px dashed rgba(255, 196, 0, 0.3); border-radius: 16px; background: rgba(255, 196, 0, 0.05); display: flex; align-items: center; justify-content: center;">
                    <span icon="campaign" style="font-size: 64px; color: rgba(255, 196, 0, 0.5);"></span>
                </div>
            </div>
        </div>

        <!-- News Grid -->
        <h2 style="color: #fff; font-size: 20px; font-weight: 700; margin-bottom: 20px;">Berita Terbaru</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px; margin-bottom: 40px;">

            <!-- News Item 1 -->
            <a href="products.php?category=mobile-game-topup" style="text-decoration: none; background: rgba(30, 41, 59, 0.5); border-radius: 14px; border: 1px solid rgba(255,255,255,0.06); overflow: hidden; transition: transform 0.2s, border-color 0.2s;" onmouseover="this.style.transform='translateY(-3px)'; this.style.borderColor='rgba(255,196,0,0.3)';" onmouseout="this.style.transform='none'; this.style.borderColor='rgba(255,255,255,0.06)';">
                <div style="height: 160px; background:#111827; overflow:hidden;">
                    <img src="<?= $path_prefix ?>assets/media/game_480/mobile-legends.jpg" alt="Mobile Legends" style="width:100%; height:100%; object-fit:cover; display:block;">
                </div>
                <div style="padding: 20px;">
                    <div style="font-size: 11px; color: #FFC400; font-weight: 700; text-transform: uppercase; margin-bottom: 8px;">Event Game</div>
                    <h3 style="color: #fff; font-size: 16px; font-weight: 700; margin-bottom: 8px; line-height: 1.4;">Event Mobile Legends Terbaru: Top-Up Diamond Makin Cepat dan Hemat</h3>
                    <p style="color: #94a3b8; font-size: 13px; line-height: 1.5;">Dapatkan bonus Diamond ekstra untuk setiap top-up selama event berlangsung.</p>
                    <div style="color: #64748b; font-size: 12px; margin-top: 12px;">20 Juni 2026</div>
                </div>
            </a>

            <!-- News Item 2 -->
            <a href="products.php?category=gift-cards" style="text-decoration: none; background: rgba(30, 41, 59, 0.5); border-radius: 14px; border: 1px solid rgba(255,255,255,0.06); overflow: hidden; transition: transform 0.2s, border-color 0.2s;" onmouseover="this.style.transform='translateY(-3px)'; this.style.borderColor='rgba(255,196,0,0.3)';" onmouseout="this.style.transform='none'; this.style.borderColor='rgba(255,255,255,0.06)';">
                <div style="height: 160px; background:#111827; overflow:hidden;">
                    <img src="<?= $path_prefix ?>assets/media/game_480/roblox.jpg" alt="Gift Card" style="width:100%; height:100%; object-fit:cover; display:block;">
                </div>
                <div style="padding: 20px;">
                    <div style="font-size: 11px; color: #a855f7; font-weight: 700; text-transform: uppercase; margin-bottom: 8px;">Gift Card</div>
                    <h3 style="color: #fff; font-size: 16px; font-weight: 700; margin-bottom: 8px; line-height: 1.4;">Koleksi Gift Card Baru Tersedia di RPLShop!</h3>
                    <p style="color: #94a3b8; font-size: 13px; line-height: 1.5;">Tersedia gift card dari berbagai platform gaming dan entertainment terpopuler.</p>
                    <div style="color: #64748b; font-size: 12px; margin-top: 12px;">18 Juni 2026</div>
                </div>
            </a>

            <!-- News Item 3 -->
            <a href="products.php" style="text-decoration: none; background: rgba(30, 41, 59, 0.5); border-radius: 14px; border: 1px solid rgba(255,255,255,0.06); overflow: hidden; transition: transform 0.2s, border-color 0.2s;" onmouseover="this.style.transform='translateY(-3px)'; this.style.borderColor='rgba(255,196,0,0.3)';" onmouseout="this.style.transform='none'; this.style.borderColor='rgba(255,255,255,0.06)';">
                <div style="height: 160px; background:#111827; overflow:hidden;">
                    <img src="<?= $path_prefix ?>assets/media/game_480/pubg-mobile.jpg" alt="Promo RPLShop" style="width:100%; height:100%; object-fit:cover; display:block;">
                </div>
                <div style="padding: 20px;">
                    <div style="font-size: 11px; color: #10b981; font-weight: 700; text-transform: uppercase; margin-bottom: 8px;">Promo</div>
                    <h3 style="color: #fff; font-size: 16px; font-weight: 700; margin-bottom: 8px; line-height: 1.4;">Nikmati Lebih Banyak Hemat Belanja di RPLShop Bulan Juni!</h3>
                    <p style="color: #94a3b8; font-size: 13px; line-height: 1.5;">Klaim kupon diskon dan dapatkan potongan harga untuk pembelian berikutnya.</p>
                    <div style="color: #64748b; font-size: 12px; margin-top: 12px;">15 Juni 2026</div>
                </div>
            </a>

        </div>

        <!-- Linked Latest Products -->
        <?php if (!empty($latest_products)): ?>
        <h2 style="color: #fff; font-size: 20px; font-weight: 700; margin-bottom: 20px;">Produk Terbaru</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 15px;">
            <?php foreach ($latest_products as $prod): ?>
                <a href="product-detail.php?slug=<?= $prod['slug'] ?>" style="text-decoration: none; background: rgba(30, 41, 59, 0.5); border-radius: 12px; border: 1px solid rgba(255,255,255,0.06); padding: 18px 14px; text-align: center; transition: transform 0.2s, border-color 0.2s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.borderColor='rgba(255,196,0,0.3)';" onmouseout="this.style.transform='none'; this.style.borderColor='rgba(255,255,255,0.06)';">
                    <div style="width: 64px; height: 64px; border-radius: 10px; background: #111827; margin: 0 auto 12px auto; overflow:hidden; border: 1px solid rgba(255,255,255,0.08);">
                        <img src="<?= $path_prefix . htmlspecialchars(resolve_product_image_url($prod)) ?>" alt="<?= htmlspecialchars($prod['name']) ?>" style="width:100%; height:100%; object-fit:cover; display:block;">
                    </div>
                    <div style="color: #fff; font-size: 13px; font-weight: 600; line-height: 1.3; margin-bottom: 4px;"><?= htmlspecialchars($prod['name']) ?></div>
                    <div style="color: #94a3b8; font-size: 11px;"><?= htmlspecialchars($prod['region']) ?></div>
                </a>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

    </div>
</div>

<?php
include __DIR__ . '/../includes/footer.php';
?>
