<?php
// pages/products.php - Catalog Page
$path_prefix = '../';

require_once __DIR__ . '/../includes/functions.php';

$category_slug = isset($_GET['category']) ? trim($_GET['category']) : null;
$search_query = isset($_GET['search']) ? trim($_GET['search']) : null;

// Determine Page Title & Heading
$page_title = 'Beli Game Top-Up, Gift Card & Voucher | RPLShop';
$heading_title = 'Semua Produk';
$heading_desc = 'Temukan katalog lengkap game top-up, voucher, dan gift card premium kami.';

if ($category_slug) {
    // Fetch category name
    $stmt = $pdo->prepare("SELECT name, slug FROM categories WHERE slug = ?");
    $stmt->execute([$category_slug]);
    $cat = $stmt->fetch();
    if ($cat) {
        $heading_title = $cat['name'];
        $page_title = "Katalog {$cat['name']} - RPLShop";
        
        if ($category_slug === 'game' || $category_slug === 'pc-game' || $category_slug === 'mobile-game') {
            $heading_desc = 'Dapatkan kredit game dan game key resmi dengan instan.';
        } elseif ($category_slug === 'card' || $category_slug === 'game-cards' || $category_slug === 'gift-cards') {
            $heading_desc = 'Beli voucher digital PlayStation, Steam Wallet, Razer Gold, Garena Shells, dan lainnya.';
        } elseif ($category_slug === 'direct-topup') {
            $heading_desc = 'Isi ulang Diamond, UC, Voucher game secara langsung dengan mudah.';
        } elseif ($category_slug === 'mobile-recharge') {
            $heading_desc = 'Isi ulang pulsa reguler prabayar Anda untuk berbagai provider di Indonesia.';
        }
    }
}

// Fetch categories for filter sidebar
$categories = get_parent_categories($pdo);

// Fetch products based on category / search filters
$products = get_products($pdo, $category_slug, $search_query);

// Extra CSS for page catalog styling
$extra_css = ['home-af890912ab.css']; // Reuses home grids classes like ItemList & ItemLink

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
    <div class="inner" style="max-width: 1200px; margin: 0 auto; padding: 0 20px; display: flex; flex-direction: row; gap: 30px; flex-wrap: wrap;">
        
        <!-- Sidebar Filter -->
        <div style="flex: 1 1 250px; max-width: 280px; min-width: 220px; background: rgba(30, 41, 59, 0.5); border-radius: 12px; border: 1px solid rgba(255,255,255,0.05); padding: 25px 20px; align-self: flex-start;">
            <h3 style="color: #fff; font-size: 18px; font-weight: 700; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 1px solid rgba(255,255,255,0.1);">Kategori</h3>
            
            <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 10px;">
                <li>
                    <a href="products.php" style="color: <?= !$category_slug ? '#FFC400' : '#cbd5e1' ?>; text-decoration: none; font-weight: <?= !$category_slug ? 'bold' : 'normal' ?>; font-size: 15px; display: block; padding: 5px 0;">
                        Semua Kategori
                    </a>
                </li>
                <?php foreach ($categories as $parent): ?>
                    <li>
                        <a href="products.php?category=<?= $parent['slug'] ?>" style="color: <?= $category_slug === $parent['slug'] ? '#FFC400' : '#cbd5e1' ?>; text-decoration: none; font-weight: <?= $category_slug === $parent['slug'] ? 'bold' : 'normal' ?>; font-size: 15px; display: block; padding: 5px 0;">
                            <?= htmlspecialchars($parent['name']) ?>
                        </a>
                        
                        <!-- Subcategories -->
                        <?php 
                        $subs = get_subcategories($pdo, $parent['id']);
                        if (!empty($subs)): 
                        ?>
                            <ul style="list-style: none; padding-left: 15px; margin: 5px 0; display: flex; flex-direction: column; gap: 6px;">
                                <?php foreach ($subs as $sub): ?>
                                    <li>
                                        <a href="products.php?category=<?= $sub['slug'] ?>" style="color: <?= $category_slug === $sub['slug'] ? '#FFC400' : '#94a3b8' ?>; text-decoration: none; font-weight: <?= $category_slug === $sub['slug'] ? 'bold' : 'normal' ?>; font-size: 14px; display: block;">
                                            • <?= htmlspecialchars($sub['name']) ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <!-- Main Product Area -->
        <div style="flex: 3 1 700px; min-width: 320px;">
            <!-- Heading -->
            <div style="margin-bottom: 30px;">
                <h2 style="color: #fff; font-size: 28px; font-weight: 800; margin-bottom: 8px;"><?= htmlspecialchars($heading_title) ?></h2>
                <p style="color: #94a3b8; font-size: 15px;"><?= htmlspecialchars($heading_desc) ?></p>
            </div>

            <!-- Products Grid -->
            <?php if (empty($products)): ?>
                <div style="background: rgba(30, 41, 59, 0.3); border: 1px dashed rgba(255, 255, 255, 0.1); border-radius: 12px; padding: 60px 20px; text-align: center; color: #94a3b8;">
                    <span icon="search_off" style="font-size: 48px; color: #64748b; display: block; margin-bottom: 15px;"></span>
                    <p style="font-size: 16px;">Tidak ada produk ditemukan di kategori ini.</p>
                </div>
            <?php else: ?>
                <div id="featured_items" style="padding: 0;">
                    <div class="category" style="padding: 0; margin: 0; background: none;">
                        <div class="ItemList" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 15px;">
                            <?php foreach ($products as $prod): ?>
                                <a class="ItemLink" href="product-detail.php?slug=<?= $prod['slug'] ?>" title="<?= htmlspecialchars($prod['name']) ?>" style="margin: 0; width: 100%;">
                                    <div class="img" style="overflow: hidden; display: flex; align-items: center; justify-content: center; aspect-ratio: 1 / 1; width: 100%; border-radius: 8px; background: #111827;">
                                        <img src="<?= $path_prefix . htmlspecialchars(resolve_product_image_url($prod)) ?>" alt="<?= htmlspecialchars($prod['name']) ?>" style="width: 100%; height: 100%; object-fit: cover;">
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
</div>

<?php
include __DIR__ . '/../includes/footer.php';
?>
