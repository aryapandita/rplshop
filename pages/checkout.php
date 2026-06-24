<?php
// pages/checkout.php - Checkout Page
$path_prefix = '../';
$page_title = 'Checkout Pembayaran - RPLShop';

require_once __DIR__ . '/../includes/functions.php';

// Require login
require_login();

$user_id = $_SESSION['user_id'];
$success = false;
$order_id = 0;

// Handle Order Placement (Place Order POST action)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['place_order'])) {
    $payment_method = isset($_POST['payment_method']) ? trim($_POST['payment_method']) : '';
    
    if (empty($payment_method)) {
        $_SESSION['checkout_error'] = 'Silakan pilih metode pembayaran terlebih dahulu.';
        header("Location: checkout.php");
        exit;
    }
    
    // Fetch cart items
    $cart_items = get_cart_items($pdo, $user_id);
    if (empty($cart_items)) {
        header("Location: products.php");
        exit;
    }
    
    // Calculate total amount
    $total_amount = 0;
    foreach ($cart_items as $item) {
        $price = $item['price'] * (1 - $item['discount_percent']/100);
        $total_amount += $price * $item['quantity'];
    }
    
    try {
        $pdo->beginTransaction();
        
        // Insert into orders
        $stmt = $pdo->prepare("INSERT INTO orders (user_id, total_amount, status, payment_method) VALUES (?, ?, 'completed', ?)");
        $stmt->execute([$user_id, $total_amount, $payment_method]);
        $order_id = $pdo->lastInsertId();
        
        // Insert into order_items
        $stmt_item = $pdo->prepare("INSERT INTO order_items (order_id, product_package_id, quantity, price, custom_fields) VALUES (?, ?, ?, ?, ?)");
        foreach ($cart_items as $item) {
            $price = $item['price'] * (1 - $item['discount_percent']/100);
            $stmt_item->execute([$order_id, $item['product_package_id'], $item['quantity'], $price, $item['custom_fields']]);
        }
        
        // Clear user cart
        clear_cart($pdo, $user_id);
        
        $pdo->commit();
        
        // Redirect to success screen
        header("Location: checkout.php?success=true&order_id=" . $order_id);
        exit;
        
    } catch (\Exception $e) {
        $pdo->rollBack();
        $_SESSION['checkout_error'] = 'Gagal memproses transaksi Anda: ' . $e->getMessage();
        header("Location: checkout.php");
        exit;
    }
}

// Check if success redirect
if (isset($_GET['success']) && $_GET['success'] === 'true') {
    $success = true;
    $order_id = (int)$_GET['order_id'];
    
    // Fetch order details
    $stmt = $pdo->prepare("SELECT * FROM orders WHERE id = ? AND user_id = ?");
    $stmt->execute([$order_id, $user_id]);
    $order = $stmt->fetch();
    
    if (!$order) {
        die("Order tidak ditemukan.");
    }
    
    // Fetch order items
    $stmt_items = $pdo->prepare("SELECT oi.*, pp.name as package_name, p.name as product_name, p.image_url 
                                 FROM order_items oi
                                 JOIN product_packages pp ON oi.product_package_id = pp.id
                                 JOIN products p ON pp.product_id = p.id
                                 WHERE oi.order_id = ?");
    $stmt_items->execute([$order_id]);
    $order_items = $stmt_items->fetchAll();
} else {
    // Normal Checkout flow
    $cart_items = get_cart_items($pdo, $user_id);
    if (empty($cart_items)) {
        header("Location: cart.php");
        exit;
    }
    
    $total_amount = 0;
    foreach ($cart_items as $item) {
        $price = $item['price'] * (1 - $item['discount_percent']/100);
        $total_amount += $price * $item['quantity'];
    }
}

$error = '';
if (isset($_SESSION['checkout_error'])) {
    $error = $_SESSION['checkout_error'];
    unset($_SESSION['checkout_error']);
}

include __DIR__ . '/../includes/header.php';
?>

<div style="min-height: 80vh; background-color: #0f172a; padding: 40px 0;">
    <div class="inner" style="max-width: 900px; margin: 0 auto; padding: 0 20px;">
        
        <?php if ($success): ?>
            <!-- Success Screen -->
            <div style="background: rgba(30, 41, 59, 0.5); border-radius: 16px; border: 1px solid rgba(255,255,255,0.06); padding: 40px 30px; text-align: center; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3);">
                <span icon="check_circle" style="font-size: 72px; color: #10b981; display: block; margin-bottom: 20px;"></span>
                <h2 style="color: #fff; font-size: 26px; font-weight: 800; margin-bottom: 8px;">Pembayaran Berhasil!</h2>
                <p style="color: #94a3b8; font-size: 15px; margin-bottom: 30px;">Terima kasih atas pembelian Anda. Invoice transaksi Anda telah dibuat.</p>
                
                <!-- Receipt Details Card -->
                <div style="background-color: #0f172a; border-radius: 12px; border: 1px solid rgba(255,255,255,0.05); padding: 25px; text-align: left; max-width: 500px; margin: 0 auto 30px auto;">
                    <h3 style="color:#fff; font-size: 16px; font-weight: 700; margin-bottom: 15px; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 10px;">Detail Invoice #RPL-<?= str_pad($order['id'], 6, '0', STR_PAD_LEFT) ?></h3>
                    
                    <div style="display: flex; justify-content: space-between; font-size: 13px; color: #94a3b8; margin-bottom: 8px;">
                        <span>Metode Pembayaran:</span>
                        <span style="color: #fff; font-weight: 600; text-transform: uppercase;"><?= htmlspecialchars($order['payment_method']) ?></span>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: 13px; color: #94a3b8; margin-bottom: 15px;">
                        <span>Tanggal Transaksi:</span>
                        <span style="color: #fff; font-weight: 600;"><?= htmlspecialchars($order['created_at']) ?></span>
                    </div>
                    
                    <h4 style="color:#fff; font-size:14px; font-weight:700; margin-bottom:10px;">Item Produk:</h4>
                    <div style="display:flex; flex-direction:column; gap:10px; margin-bottom:15px;">
                        <?php foreach ($order_items as $item): 
                            $fields_data = json_decode($item['custom_fields'], true);
                        ?>
                            <div style="display:flex; justify-content:space-between; align-items:center; font-size:13px; border-bottom: 1px solid rgba(255,255,255,0.03); padding-bottom: 8px;">
                                <div>
                                    <div style="color:#fff; font-weight:600;"><?= htmlspecialchars($item['product_name']) ?></div>
                                    <div style="color:#FFC400; font-size:12px;"><?= htmlspecialchars($item['package_name']) ?></div>
                                    <?php if (!empty($fields_data)): ?>
                                        <div style="color:#64748b; font-size:11px; margin-top:2px;">
                                            <?php foreach ($fields_data as $fname => $fval): ?>
                                                <span><?= htmlspecialchars($fname) ?>: <?= htmlspecialchars($fval) ?> | </span>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <span style="color:#fff; font-weight:600;"><?= $item['quantity'] ?>x</span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px dashed rgba(255,255,255,0.1); padding-top: 15px;">
                        <span style="color: #fff; font-size: 15px; font-weight: 700;">Total Bayar:</span>
                        <span style="color: #FFC400; font-size: 18px; font-weight: 800;"><?= format_idr($order['total_amount']) ?></span>
                    </div>
                </div>

                <a href="../index.php" class="btw" color="theme" style="padding: 12px 30px; border-radius: 8px; font-weight: bold; display: inline-block; text-decoration: none;">
                    <span>KEMBALI KE HOMEPAGE</span>
                </a>
            </div>
            
        <?php else: ?>
            <!-- Checkout Form Flow -->
            <div style="margin-bottom: 30px;">
                <h2 style="color: #fff; font-size: 28px; font-weight: 800; display: flex; align-items: center; gap: 10px;">
                    <span icon="payment" style="font-size: 32px; color:#FFC400;"></span>
                    Checkout Pembayaran
                </h2>
            </div>

            <?php if (!empty($error)): ?>
                <div style="background-color: rgba(239, 68, 68, 0.15); border: 1px solid #ef4444; color: #fca5a5; padding: 12px 16px; border-radius: 8px; font-size: 14px; margin-bottom: 25px; text-align: center;">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form method="post" action="checkout.php">
                <div style="display: flex; flex-direction: row; gap: 30px; flex-wrap: wrap;">
                    
                    <!-- Left: Select Payment Method -->
                    <div style="flex: 2 1 500px; min-width: 320px; display: flex; flex-direction: column; gap: 20px;">
                        <div style="background: rgba(30, 41, 59, 0.5); border-radius: 12px; border: 1px solid rgba(255,255,255,0.05); padding: 25px;">
                            <h3 style="color: #fff; font-size: 17px; font-weight: 700; margin-bottom: 20px;">Pilih Metode Pembayaran</h3>
                            
                            <div style="display: flex; flex-direction: column; gap: 12px;">
                                <!-- GoPay -->
                                <label style="display: flex; align-items: center; gap: 15px; background-color: #0f172a; padding: 16px 20px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.08); cursor: pointer; position: relative;">
                                    <input type="radio" name="payment_method" value="gopay" required checked style="accent-color: #FFC400;">
                                    <span style="min-width: 54px; color:#FFC400; font-weight:800; font-size:13px;">GoPay</span>
                                    <span style="color:#fff; font-weight:600; font-size:14px; margin-left: 10px;">GoPay (E-Wallet)</span>
                                </label>
                                
                                <!-- DANA -->
                                <label style="display: flex; align-items: center; gap: 15px; background-color: #0f172a; padding: 16px 20px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.08); cursor: pointer; position: relative;">
                                    <input type="radio" name="payment_method" value="dana" style="accent-color: #FFC400;">
                                    <span style="min-width: 54px; color:#FFC400; font-weight:800; font-size:13px;">DANA</span>
                                    <span style="color:#fff; font-weight:600; font-size:14px; margin-left: 10px;">DANA (E-Wallet)</span>
                                </label>
                                
                                <!-- QRIS -->
                                <label style="display: flex; align-items: center; gap: 15px; background-color: #0f172a; padding: 16px 20px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.08); cursor: pointer; position: relative;">
                                    <input type="radio" name="payment_method" value="qris" style="accent-color: #FFC400;">
                                    <span style="min-width: 54px; color:#FFC400; font-weight:800; font-size:13px;">QRIS</span>
                                    <span style="color:#fff; font-weight:600; font-size:14px; margin-left: 10px;">QRIS (Semua Bank / E-Wallet)</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Summary & Checkout button -->
                    <div style="flex: 1 1 300px; max-width: 400px; min-width: 280px;">
                        <div style="background: rgba(30, 41, 59, 0.5); border-radius: 12px; border: 1px solid rgba(255,255,255,0.05); padding: 25px;">
                            <h3 style="color: #fff; font-size: 17px; font-weight: 700; margin-bottom: 20px; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 12px;">Detail Pembayaran</h3>
                            
                            <div style="display:flex; flex-direction:column; gap:12px; margin-bottom:20px; max-height: 200px; overflow-y: auto;">
                                <?php foreach ($cart_items as $item): 
                                    $price = $item['price'] * (1 - $item['discount_percent']/100);
                                ?>
                                    <div style="display:flex; justify-content:space-between; font-size:13px; color:#cbd5e1;">
                                        <div style="max-width: 70%;">
                                            <div style="font-weight:600; color:#fff; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;"><?= htmlspecialchars($item['product_name']) ?></div>
                                            <div style="font-size:11px; color:#94a3b8;"><?= htmlspecialchars($item['package_name']) ?></div>
                                        </div>
                                        <span><?= $item['quantity'] ?>x</span>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <div style="border-top: 1px dashed rgba(255,255,255,0.1); padding-top: 15px; margin-bottom: 25px; display: flex; justify-content: space-between; align-items: center;">
                                <span style="color: #fff; font-size: 15px; font-weight: 700;">Total Bayar:</span>
                                <span style="color: #FFC400; font-size: 20px; font-weight: 800;"><?= format_idr($total_amount) ?></span>
                            </div>

                            <button type="submit" name="place_order" value="1" class="btw" color="theme" 
                                    style="width: 100%; padding: 14px; border-radius: 8px; font-weight: bold; font-size: 16px; border: none; cursor: pointer; display: block; text-align: center;">
                                <span>BAYAR SEKARANG</span>
                            </button>
                            
                            <a href="cart.php" style="display: block; text-align: center; margin-top: 15px; color: #cbd5e1; text-decoration: none; font-size: 14px;">
                                &larr; Kembali ke Keranjang
                            </a>
                        </div>
                    </div>

                </div>
            </form>
        <?php endif; ?>

    </div>
</div>

<?php
include __DIR__ . '/../includes/footer.php';
?>
