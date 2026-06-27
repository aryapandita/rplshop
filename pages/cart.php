<?php
// pages/cart.php - Shopping Cart Page
$path_prefix = '../';
$page_title = 'Keranjang Belanja - RPLShop';

require_once __DIR__ . '/../includes/functions.php';

// Handle Actions (Add, Delete) before rendering layout
$action = isset($_POST['action']) ? $_POST['action'] : (isset($_GET['action']) ? $_GET['action'] : '');

if ($action === 'add' || $action === 'delete') {
    // Require login for any modifications
    if (!is_logged_in()) {
        $_SESSION['login_error'] = 'Silakan masuk terlebih dahulu untuk melakukan transaksi.';
        header("Location: login.php");
        exit;
    }
}

if ($action === 'add' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $product_package_id = (int)$_POST['product_package_id'];
    $quantity = (int)$_POST['quantity'];
    $custom_fields = isset($_POST['custom_fields']) ? $_POST['custom_fields'] : [];
    $product_slug = $_POST['product_slug'];
    $buy_now = isset($_POST['buy_now']) ? true : false;
    
    if ($product_package_id <= 0) {
        die("Invalid Package.");
    }
    
    // Add to cart in database
    add_to_cart($pdo, $user_id, $product_package_id, $quantity, $custom_fields);
    
    if ($buy_now) {
        header("Location: checkout.php");
        exit;
    } else {
        // Redirect to cart page showing updated items
        header("Location: cart.php?added=1");
        exit;
    }
}

if ($action === 'delete' && isset($_GET['id'])) {
    $cart_id = (int)$_GET['id'];
    $user_id = $_SESSION['user_id'];
    
    delete_cart_item($pdo, $cart_id, $user_id);
    header("Location: cart.php");
    exit;
}

// Redirect to login if user tries to view cart without login
if (!is_logged_in()) {
    $_SESSION['login_error'] = 'Silakan masuk terlebih dahulu untuk melihat keranjang belanja Anda.';
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$cart_items = get_cart_items($pdo, $user_id);

include __DIR__ . '/../includes/header.php';
?>

<style>
    .rpl-empty-cart-thumb {
        width: 70px;
        height: 70px;
        flex: none;
        border: 1px dashed rgba(255, 255, 255, .2);
        border-radius: 8px;
        background: #111827;
    }
</style>

<div style="min-height: 80vh; background-color: #0f172a; padding: 40px 0;">
    <div class="inner" style="max-width: 1000px; margin: 0 auto; padding: 0 20px;">
        
        <div style="margin-bottom: 30px;">
            <h2 style="color: #fff; font-size: 28px; font-weight: 800; display: flex; align-items: center; gap: 10px;">
                <span icon="shopping_cart" style="font-size: 32px; color:#FFC400;"></span>
                Keranjang Belanja
            </h2>
        </div>

        <?php if (isset($_GET['added'])): ?>
            <div style="background-color: rgba(16, 185, 129, 0.15); border: 1px solid #10b981; color: #a7f3d0; padding: 12px 16px; border-radius: 8px; font-size: 14px; margin-bottom: 25px; display: flex; justify-content: space-between; align-items: center;">
                <span>Produk berhasil ditambahkan ke keranjang belanja Anda!</span>
                <a href="products.php" style="color: #FFC400; text-decoration: none; font-weight: bold; font-size: 13px;">Lanjut Belanja &rarr;</a>
            </div>
        <?php endif; ?>

        <?php if (empty($cart_items)): ?>
            <div style="background: rgba(30, 41, 59, 0.4); border: 1px dashed rgba(255, 255, 255, 0.1); border-radius: 12px; padding: 80px 20px; text-align: center; color: #94a3b8;">
                <span icon="remove_shopping_cart" style="font-size: 64px; color: #64748b; display: block; margin-bottom: 20px;"></span>
                <h3 style="color: #fff; font-size: 20px; font-weight: 700; margin-bottom: 8px;">Keranjang Belanja Kosong</h3>
                <p style="font-size: 15px; margin-bottom: 25px;">Anda belum menambahkan produk apa pun ke keranjang belanja Anda.</p>
                <a href="products.php" class="btw" color="theme" style="padding: 12px 30px; border-radius: 8px; font-weight: bold; display: inline-block; text-decoration: none;">
                    <span>MULAI BELANJA</span>
                </a>
            </div>
        <?php else: ?>
            <div style="display: flex; flex-direction: row; gap: 30px; flex-wrap: wrap;">
                
                <!-- Cart Items List -->
                <div style="flex: 2 1 600px; min-width: 320px; display: flex; flex-direction: column; gap: 15px;">
                    <?php 
                    $subtotal = 0;
                    foreach ($cart_items as $item): 
                        $price = $item['price'] * (1 - $item['discount_percent']/100);
                        $item_total = $price * $item['quantity'];
                        $subtotal += $item_total;
                        
                        $fields_data = json_decode($item['custom_fields'], true);
                        $product_image = resolve_product_image_url([
                            'name' => $item['product_name'],
                            'slug' => $item['product_slug'],
                            'image_url' => $item['image_url']
                        ]);
                    ?>
                        <div style="background: rgba(30, 41, 59, 0.5); border-radius: 12px; border: 1px solid rgba(255,255,255,0.05); padding: 20px; display: flex; gap: 20px; align-items: center; position: relative;">
                            
                            <!-- Product Image -->
                            <div class="rpl-empty-cart-thumb" style="overflow:hidden; background:#111827;">
                                <img src="<?= $path_prefix . htmlspecialchars($product_image) ?>" alt="<?= htmlspecialchars($item['product_name']) ?>" style="width:100%; height:100%; object-fit:cover; display:block;">
                            </div>
                            
                            <!-- Product Details -->
                            <div style="flex: 1;">
                                <h4 style="margin: 0 0 6px 0; color: #fff; font-size: 16px; font-weight: 700;">
                                    <?= htmlspecialchars($item['product_name']) ?>
                                </h4>
                                <p style="margin: 0 0 8px 0; color: #FFC400; font-size: 14px; font-weight: 600;">
                                    <?= htmlspecialchars($item['package_name']) ?>
                                </p>
                                
                                <!-- Custom Fields (User ID etc) -->
                                <?php if (!empty($fields_data)): ?>
                                    <div style="background: rgba(15, 23, 42, 0.4); padding: 6px 12px; border-radius: 6px; display: inline-flex; flex-wrap: wrap; gap: 12px; font-size: 12px; color: #94a3b8;">
                                        <?php foreach ($fields_data as $fname => $fval): ?>
                                            <span><strong><?= htmlspecialchars($fname) ?>:</strong> <?= htmlspecialchars($fval) ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Qty & Price -->
                            <div style="text-align: right; min-width: 140px; display: flex; flex-direction: column; align-items: flex-end; gap: 8px;">
                                <span style="color: #cbd5e1; font-size: 13px;">Jumlah: <strong><?= $item['quantity'] ?>x</strong></span>
                                <div style="display: flex; flex-direction: column; align-items: flex-end;">
                                    <?php if ($item['discount_percent'] > 0): ?>
                                        <span style="color:#64748b; font-size:12px; text-decoration:line-through; margin-bottom: 2px;">
                                            <?= format_idr($item['price'] * $item['quantity']) ?>
                                        </span>
                                    <?php endif; ?>
                                    <span style="color: #FFC400; font-size: 16px; font-weight: 800;">
                                        <?= format_idr($item_total) ?>
                                    </span>
                                </div>
                            </div>

                            <!-- Delete button -->
                            <a href="cart.php?action=delete&id=<?= $item['id'] ?>" title="Hapus dari keranjang"
                               style="position: absolute; top: 15px; right: 15px; color: #64748b; text-decoration: none; font-size: 18px; transition: color 0.2s;"
                               onmouseover="this.style.color='#ef4444';" onmouseout="this.style.color='#64748b';">
                               <span icon="close"></span>
                            </a>

                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Cart Summary & Checkout -->
                <div style="flex: 1 1 300px; max-width: 400px; min-width: 280px;">
                    <div style="background: rgba(30, 41, 59, 0.5); border-radius: 12px; border: 1px solid rgba(255,255,255,0.05); padding: 25px; position: sticky; top: 100px;">
                        <h3 style="color: #fff; font-size: 18px; font-weight: 700; margin-bottom: 20px; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 12px;">Ringkasan Belanja</h3>
                        
                        <div style="display: flex; justify-content: space-between; color: #94a3b8; font-size: 14px; margin-bottom: 12px;">
                            <span>Subtotal:</span>
                            <span style="color: #fff; font-weight: 600;"><?= format_idr($subtotal) ?></span>
                        </div>
                        <div style="display: flex; justify-content: space-between; color: #94a3b8; font-size: 14px; margin-bottom: 20px;">
                            <span>Biaya Transaksi:</span>
                            <span style="color: #10b981; font-weight: 600;">GRATIS</span>
                        </div>
                        
                        <div style="border-top: 1px dashed rgba(255,255,255,0.1); padding-top: 15px; margin-bottom: 25px; display: flex; justify-content: space-between; align-items: center;">
                            <span style="color: #fff; font-size: 15px; font-weight: 700;">Total Belanja:</span>
                            <span style="color: #FFC400; font-size: 20px; font-weight: 800;"><?= format_idr($subtotal) ?></span>
                        </div>

                        <a href="checkout.php" class="btw" color="theme" style="width: 100%; padding: 14px; border-radius: 8px; font-weight: bold; font-size: 16px; border: none; cursor: pointer; display: block; text-align: center; text-decoration: none;">
                            <span>LANJUT KE PEMBAYARAN</span>
                        </a>
                        
                        <a href="products.php" style="display: block; text-align: center; margin-top: 15px; color: #cbd5e1; text-decoration: none; font-size: 14px;">
                            &larr; Lanjut Belanja
                        </a>
                    </div>
                </div>

            </div>
        <?php endif; ?>

    </div>
</div>

<?php
include __DIR__ . '/../includes/footer.php';
?>
