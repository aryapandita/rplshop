<?php
// admin/orders.php - Manage Orders
$path_prefix = '../';

require_once __DIR__ . '/../includes/functions.php';

// Restrict access to admins only
require_admin();

// Handle status updates
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $order_id = (int)$_POST['order_id'];
    $status = trim($_POST['status']);
    
    $valid_statuses = ['pending', 'processing', 'completed', 'cancelled'];
    if (in_array($status, $valid_statuses)) {
        $stmt = $pdo->prepare("UPDATE orders SET status = ? WHERE id = ?");
        $stmt->execute([$status, $order_id]);
        $_SESSION['orders_success'] = 'Status pesanan berhasil diperbarui!';
    }
    header("Location: orders.php");
    exit;
}

$success = '';
if (isset($_SESSION['orders_success'])) {
    $success = $_SESSION['orders_success'];
    unset($_SESSION['orders_success']);
}

// Fetch all orders
$stmt = $pdo->query("SELECT o.*, u.username, u.email 
                     FROM orders o 
                     JOIN users u ON o.user_id = u.id 
                     ORDER BY o.created_at DESC");
$all_orders = $stmt->fetchAll();

$page_title = 'Daftar Pesanan - Admin Panel';
include __DIR__ . '/../includes/header.php';
?>

<div style="background-color: #0f172a; min-height: 85vh; padding: 40px 0; color: #fff;">
    <div class="inner" style="max-width: 1200px; margin: 0 auto; padding: 0 20px; display: flex; flex-direction: row; gap: 30px; flex-wrap: wrap;">
        
        <!-- Sidebar Navigation -->
        <div style="flex: 1 1 220px; max-width: 250px; background: rgba(30, 41, 59, 0.6); padding: 25px 20px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.05); align-self: flex-start;">
            <h3 style="color:#64748b; font-size:12px; text-transform:uppercase; letter-spacing:1px; margin-bottom:15px; font-weight:700;">Menu Admin</h3>
            <ul style="list-style:none; padding:0; margin:0; display:flex; flex-direction:column; gap:10px;">
                <li><a href="index.php" style="color:#cbd5e1; text-decoration:none; font-size:15px; display:block; padding:8px 0;">Dashboard</a></li>
                <li><a href="products.php" style="color:#cbd5e1; text-decoration:none; font-size:15px; display:block; padding:8px 0;">Kelola Produk</a></li>
                <li><a href="orders.php" style="color:#FFC400; text-decoration:none; font-weight:bold; font-size:15px; display:block; padding:8px 0;">Daftar Pesanan</a></li>
                <li><a href="users.php" style="color:#cbd5e1; text-decoration:none; font-size:15px; display:block; padding:8px 0;">Kelola Pengguna</a></li>
                <li style="border-top: 1px solid rgba(255,255,255,0.1); margin-top:15px; padding-top:15px;">
                    <a href="../index.php" style="color:#f8fafc; text-decoration:none; font-size:14px; display:block;">&larr; Lihat Toko</a>
                </li>
            </ul>
        </div>

        <!-- Main Content Area -->
        <div style="flex: 3 1 700px; min-width: 320px;">
            <div style="margin-bottom: 30px;">
                <h2 style="font-size:28px; font-weight:800; margin-bottom:5px;">Daftar Pesanan</h2>
                <p style="color:#94a3b8; font-size:15px;">Kelola status transaksi pembelian dan pengiriman top-up game.</p>
            </div>

            <?php if (!empty($success)): ?>
                <div style="background-color: rgba(16, 185, 129, 0.15); border: 1px solid #10b981; color: #a7f3d0; padding: 12px 16px; border-radius: 8px; font-size: 14px; margin-bottom: 25px; text-align: center;">
                    <?= htmlspecialchars($success) ?>
                </div>
            <?php endif; ?>

            <div style="background: rgba(30, 41, 59, 0.4); border: 1px solid rgba(255,255,255,0.05); padding: 25px; border-radius: 12px; overflow-x:auto;">
                <?php if (empty($all_orders)): ?>
                    <p style="color:#94a3b8; font-size:14px; text-align:center; padding: 20px 0;">Belum ada pesanan masuk.</p>
                <?php else: ?>
                    <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 14px;">
                        <thead>
                            <tr style="border-bottom: 1px solid rgba(255,255,255,0.1); color: #94a3b8;">
                                <th style="padding: 12px 8px;">Order ID</th>
                                <th style="padding: 12px 8px;">Pelanggan</th>
                                <th style="padding: 12px 8px;">Tanggal</th>
                                <th style="padding: 12px 8px;">Metode</th>
                                <th style="padding: 12px 8px;">Total Bayar</th>
                                <th style="padding: 12px 8px;">Status</th>
                                <th style="padding: 12px 8px; text-align:center;">Update Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($all_orders as $order): ?>
                                <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                                    <td style="padding: 12px 8px; font-weight:600; color:#FFC400;">#RPL-<?= str_pad($order['id'], 6, '0', STR_PAD_LEFT) ?></td>
                                    <td style="padding: 12px 8px;">
                                        <div style="font-weight:600;"><?= htmlspecialchars($order['username']) ?></div>
                                        <div style="font-size:11px; color:#64748b;"><?= htmlspecialchars($order['email']) ?></div>
                                    </td>
                                    <td style="padding: 12px 8px; color:#cbd5e1;"><?= htmlspecialchars($order['created_at']) ?></td>
                                    <td style="padding: 12px 8px; text-transform:uppercase;"><?= htmlspecialchars($order['payment_method']) ?></td>
                                    <td style="padding: 12px 8px; font-weight:600;"><?= format_idr($order['total_amount']) ?></td>
                                    <td style="padding: 12px 8px;">
                                        <span style="background-color: 
                                            <?= $order['status'] === 'completed' ? 'rgba(16, 185, 129, 0.15)' : 
                                               ($order['status'] === 'processing' ? 'rgba(96, 165, 250, 0.15)' : 
                                               ($order['status'] === 'cancelled' ? 'rgba(239, 68, 68, 0.15)' : 'rgba(245, 158, 11, 0.15)')) ?>; 
                                            color: 
                                            <?= $order['status'] === 'completed' ? '#10b981' : 
                                               ($order['status'] === 'processing' ? '#60a5fa' : 
                                               ($order['status'] === 'cancelled' ? '#ef4444' : '#f59e0b')) ?>; 
                                            padding: 4px 8px; border-radius: 6px; font-size: 12px; font-weight: 600; text-transform: uppercase;">
                                            <?= htmlspecialchars($order['status']) ?>
                                        </span>
                                    </td>
                                    <td style="padding: 12px 8px; text-align:center;">
                                        <form method="post" action="orders.php" style="display:inline-flex; align-items:center; gap:8px;">
                                            <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                                            <select name="status" style="background:#0f172a; border:1px solid rgba(255,255,255,0.1); border-radius:6px; color:#fff; font-size:12px; padding:4px 8px; outline:none;">
                                                <option value="pending" <?= $order['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                                                <option value="processing" <?= $order['status'] === 'processing' ? 'selected' : '' ?>>Processing</option>
                                                <option value="completed" <?= $order['status'] === 'completed' ? 'selected' : '' ?>>Completed</option>
                                                <option value="cancelled" <?= $order['status'] === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                                            </select>
                                            <button type="submit" name="update_status" class="btw" color="theme" style="padding:4px 8px; font-size:12px; border-radius:6px; border:none; cursor:pointer;">
                                                <span>Update</span>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>

        </div>
    </div>
</div>

<?php
include __DIR__ . '/../includes/footer.php';
?>
