<?php
// admin/index.php - Admin Dashboard
$path_prefix = '../';

require_once __DIR__ . '/../includes/functions.php';

// Restrict access to admins only
require_admin();

// Query Stats
// 1. Total revenue
$stmt = $pdo->query("SELECT SUM(total_amount) FROM orders WHERE status = 'completed'");
$total_revenue = (float)$stmt->fetchColumn();

// 2. Total orders count
$stmt = $pdo->query("SELECT COUNT(*) FROM orders");
$total_orders = (int)$stmt->fetchColumn();

// 3. Total users
$stmt = $pdo->query("SELECT COUNT(*) FROM users WHERE role = 'user'");
$total_users = (int)$stmt->fetchColumn();

// 4. Total products
$stmt = $pdo->query("SELECT COUNT(*) FROM products");
$total_products = (int)$stmt->fetchColumn();

// Recent products for dashboard thumbnails
$stmt = $pdo->query("SELECT id, name, slug, image_url, brand, region FROM products ORDER BY created_at DESC LIMIT 6");
$recent_products = $stmt->fetchAll();

// Recent 5 orders
$stmt = $pdo->query("SELECT o.*, u.username 
                     FROM orders o 
                     JOIN users u ON o.user_id = u.id 
                     ORDER BY o.created_at DESC 
                     LIMIT 5");
$recent_orders = $stmt->fetchAll();

$page_title = 'Admin Dashboard - RPLShop';
include __DIR__ . '/../includes/header.php';
?>

<div style="background-color: #0f172a; min-height: 85vh; padding: 40px 0; color: #fff;">
    <div class="inner" style="max-width: 1200px; margin: 0 auto; padding: 0 20px; display: flex; flex-direction: row; gap: 30px; flex-wrap: wrap;">
        
        <!-- Sidebar Navigation -->
        <div style="flex: 1 1 220px; max-width: 250px; background: rgba(30, 41, 59, 0.6); padding: 25px 20px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.05); align-self: flex-start;">
            <h3 style="color:#64748b; font-size:12px; text-transform:uppercase; letter-spacing:1px; margin-bottom:15px; font-weight:700;">Menu Admin</h3>
            <ul style="list-style:none; padding:0; margin:0; display:flex; flex-direction:column; gap:10px;">
                <li><a href="index.php" style="color:#FFC400; text-decoration:none; font-weight:bold; font-size:15px; display:block; padding:8px 0;">Dashboard</a></li>
                <li><a href="products.php" style="color:#cbd5e1; text-decoration:none; font-size:15px; display:block; padding:8px 0;">Kelola Produk</a></li>
                <li><a href="orders.php" style="color:#cbd5e1; text-decoration:none; font-size:15px; display:block; padding:8px 0;">Daftar Pesanan</a></li>
                <li><a href="users.php" style="color:#cbd5e1; text-decoration:none; font-size:15px; display:block; padding:8px 0;">Kelola Pengguna</a></li>
                <li style="border-top: 1px solid rgba(255,255,255,0.1); margin-top:15px; padding-top:15px;">
                    <a href="../index.php" style="color:#f8fafc; text-decoration:none; font-size:14px; display:block;">&larr; Lihat Toko</a>
                </li>
            </ul>
        </div>

        <!-- Main Dashboard View -->
        <div style="flex: 3 1 700px; min-width: 320px;">
            <div style="margin-bottom: 30px;">
                <h2 style="font-size:28px; font-weight:800; margin-bottom:5px;">Admin Dashboard</h2>
                <p style="color:#94a3b8; font-size:15px;">Ikhtisar penjualan dan manajemen operasional toko RPLShop.</p>
            </div>

            <!-- Stats Grid -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 40px;">
                <!-- Total Sales -->
                <div style="background: rgba(30, 41, 59, 0.4); border: 1px solid rgba(255,255,255,0.05); padding: 25px 20px; border-radius: 12px;">
                    <span style="color:#94a3b8; font-size:13px; font-weight:600; text-transform:uppercase; display:block; margin-bottom:8px;">Total Pendapatan</span>
                    <span style="font-size:22px; font-weight:800; color:#10b981;"><?= format_idr($total_revenue) ?></span>
                </div>
                <!-- Orders -->
                <div style="background: rgba(30, 41, 59, 0.4); border: 1px solid rgba(255,255,255,0.05); padding: 25px 20px; border-radius: 12px;">
                    <span style="color:#94a3b8; font-size:13px; font-weight:600; text-transform:uppercase; display:block; margin-bottom:8px;">Pesanan Masuk</span>
                    <span style="font-size:22px; font-weight:800; color:#FFC400;"><?= $total_orders ?></span>
                </div>
                <!-- Users -->
                <div style="background: rgba(30, 41, 59, 0.4); border: 1px solid rgba(255,255,255,0.05); padding: 25px 20px; border-radius: 12px;">
                    <span style="color:#94a3b8; font-size:13px; font-weight:600; text-transform:uppercase; display:block; margin-bottom:8px;">Pelanggan Terdaftar</span>
                    <span style="font-size:22px; font-weight:800; color:#60a5fa;"><?= $total_users ?></span>
                </div>
                <!-- Products -->
                <div style="background: rgba(30, 41, 59, 0.4); border: 1px solid rgba(255,255,255,0.05); padding: 25px 20px; border-radius: 12px;">
                    <span style="color:#94a3b8; font-size:13px; font-weight:600; text-transform:uppercase; display:block; margin-bottom:8px;">Jumlah Produk</span>
                    <span style="font-size:22px; font-weight:800; color:#c084fc;"><?= $total_products ?></span>
                </div>
            </div>

            <!-- Recent Products Section -->
            <div style="background: rgba(30, 41, 59, 0.4); border: 1px solid rgba(255,255,255,0.05); padding: 30px; border-radius: 12px; margin-bottom: 40px;">
                <h3 style="font-size:18px; font-weight:700; margin-bottom:20px;">Produk Terbaru</h3>
                <?php if (empty($recent_products)): ?>
                    <p style="color:#94a3b8; font-size:14px; text-align:center; padding: 20px 0;">Belum ada produk yang ditambahkan.</p>
                <?php else: ?>
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 18px;">
                        <?php foreach ($recent_products as $product): ?>
                            <div style="background: rgba(15, 23, 42, 0.75); border: 1px solid rgba(255,255,255,0.05); border-radius: 12px; overflow: hidden;">
                                <div style="width: 100%; height: 120px; background: #111827; display: flex; align-items: center; justify-content: center;">
                                    <img src="<?= $path_prefix . htmlspecialchars(resolve_product_image_url($product)) ?>" alt="<?= htmlspecialchars($product['name']) ?>" style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                                <div style="padding: 14px 12px;">
                                    <div style="font-size: 14px; font-weight: 700; color: #fff; margin-bottom: 6px; line-height: 1.3;"><?= htmlspecialchars($product['name']) ?></div>
                                    <div style="font-size: 12px; color: #94a3b8; margin-bottom: 4px;"><?= htmlspecialchars($product['brand']) ?></div>
                                    <div style="font-size: 12px; color: #cbd5e1;"><?= htmlspecialchars($product['region']) ?></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Recent Orders Section -->
            <div style="background: rgba(30, 41, 59, 0.4); border: 1px solid rgba(255,255,255,0.05); padding: 30px; border-radius: 12px;">
                <h3 style="font-size:18px; font-weight:700; margin-bottom:20px;">Pesanan Terbaru</h3>
                
                <?php if (empty($recent_orders)): ?>
                    <p style="color:#94a3b8; font-size:14px; text-align:center; padding: 20px 0;">Belum ada pesanan yang masuk.</p>
                <?php else: ?>
                    <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 14px;">
                        <thead>
                            <tr style="border-bottom: 1px solid rgba(255,255,255,0.1); color: #94a3b8;">
                                <th style="padding: 12px 8px;">Order ID</th>
                                <th style="padding: 12px 8px;">User</th>
                                <th style="padding: 12px 8px;">Tanggal</th>
                                <th style="padding: 12px 8px;">Metode</th>
                                <th style="padding: 12px 8px;">Total</th>
                                <th style="padding: 12px 8px;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recent_orders as $order): ?>
                                <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                                    <td style="padding: 12px 8px; font-weight:600; color:#FFC400;">#RPL-<?= str_pad($order['id'], 6, '0', STR_PAD_LEFT) ?></td>
                                    <td style="padding: 12px 8px;"><?= htmlspecialchars($order['username']) ?></td>
                                    <td style="padding: 12px 8px; color: #94a3b8;"><?= htmlspecialchars($order['created_at']) ?></td>
                                    <td style="padding: 12px 8px; text-transform:uppercase;"><?= htmlspecialchars($order['payment_method']) ?></td>
                                    <td style="padding: 12px 8px; font-weight:600;"><?= format_idr($order['total_amount']) ?></td>
                                    <td style="padding: 12px 8px;">
                                        <span style="background-color: <?= $order['status'] === 'completed' ? 'rgba(16, 185, 129, 0.2)' : 'rgba(245, 158, 11, 0.2)' ?>; color: <?= $order['status'] === 'completed' ? '#10b981' : '#f59e0b' ?>; padding: 4px 8px; border-radius: 6px; font-size: 12px; font-weight: 600;">
                                            <?= htmlspecialchars($order['status']) ?>
                                        </span>
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
