<?php
// pages/search.php - Search Results Page
$path_prefix = '../';

require_once __DIR__ . '/../includes/functions.php';

$keywords = isset($_GET['keywords']) ? trim($_GET['keywords']) : '';

$page_title = 'Hasil Pencarian "' . htmlspecialchars($keywords) . '" - RPLShop';

// Fetch products based on search keyword
$products = [];
if (!empty($keywords)) {
    $products = get_products($pdo, null, $keywords);
}

// Reuses catalog layout classes
$extra_css = ['home-af890912ab.css'];

include __DIR__ . '/../includes/header.php';
?>

<style>
    .rpl-empty-product-thumb {
        width: 60px;
        height: 60px;
        border: 1px dashed rgba(255, 255, 255, .2);
        border-radius: 8px;
        background: #111827;
    }
</style>

<div style="min-height: 80vh; background-color: #0f172a; padding: 40px 0;">
    <div class="inner" style="max-width: 1000px; margin: 0 auto; padding: 0 20px;">
        
        <!-- Search Header -->
        <div style="margin-bottom: 40px; border-bottom: 1px solid rgba(255,255,255,0.06); padding-bottom: 20px;">
            <h2 style="color: #fff; font-size: 26px; font-weight: 800; margin-bottom: 6px;">Hasil Pencarian</h2>
            <p style="color: #94a3b8; font-size: 15px;">
                Menampilkan hasil untuk kata kunci: <strong style="color: #FFC400;">"<?= htmlspecialchars($keywords) ?>"</strong>
            </p>
        </div>

        <!-- Products Grid -->
        <?php if (empty($products)): ?>
            <div style="background: rgba(30, 41, 59, 0.3); border: 1px dashed rgba(255, 255, 255, 0.1); border-radius: 12px; padding: 70px 20px; text-align: center; color: #94a3b8; max-width: 600px; margin: 0 auto;">
                <span icon="search_off" style="font-size: 56px; color: #64748b; display: block; margin-bottom: 20px;"></span>
                <h3 style="color:#fff; font-size:18px; font-weight:700; margin-bottom:8px;">Produk Tidak Ditemukan</h3>
                <p style="font-size: 14px; margin-bottom: 25px; line-height: 1.5;">Maaf, kami tidak dapat menemukan produk dengan kata kunci tersebut. Silakan coba kata kunci lain atau jelajahi kategori kami.</p>
                <a href="products.php" class="btw" color="theme" style="padding: 11px 25px; border-radius: 8px; font-weight: bold; display: inline-block; text-decoration: none;">
                    <span>JELAJAHI PRODUK</span>
                </a>
            </div>
        <?php else: ?>
            <div id="featured_items" style="padding: 0;">
                <div class="category" style="padding: 0; margin: 0; background: none;">
                    <div class="ItemList" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 15px;">
                        <?php foreach ($products as $prod): ?>
                            <a class="ItemLink" href="product-detail.php?slug=<?= $prod['slug'] ?>" title="<?= htmlspecialchars($prod['name']) ?>" style="margin: 0; width: 100%;">
                                <div class="img" style="overflow: hidden; display: flex; align-items: center; justify-content: center; aspect-ratio: 1 / 1; width: 100%; border-radius: 8px; background: #111827;">
                                    <div class="rpl-empty-product-thumb" aria-label="Gambar produk kosong" style="width: 100%; height: 100%;"></div>
                                </div>
                                <div class="T">
                                    <div class="name"><?= htmlspecialchars($prod['name']) ?></div>
                                    <div class="info">
                                        <span><?= htmlspecialchars($prod['region']) ?></span>
                                        <?php if ($prod['max_discount'] > 0): ?>
                                            <span style="color:#ef4444; font-weight:bold; margin-left: 5px;">-<?= number_format($prod['max_discount'], 0) ?>%</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

    </div>
</div>

<?php
include __DIR__ . '/../includes/footer.php';
?>
