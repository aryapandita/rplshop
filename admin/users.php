<?php
// admin/users.php - Manage Users
$path_prefix = '../';

require_once __DIR__ . '/../includes/functions.php';

// Restrict access to admins only
require_admin();

// Handle role update or delete
if (isset($_GET['action']) && isset($_GET['id'])) {
    $target_id = (int)$_GET['id'];
    
    // Prevent admin from deleting themselves
    if ($target_id === $_SESSION['user_id']) {
        $_SESSION['users_error'] = 'Anda tidak dapat menghapus atau mengubah akun Anda sendiri di sini.';
    } else {
        $action = $_GET['action'];
        
        if ($action === 'toggle_role') {
            // Get current role
            $stmt = $pdo->prepare("SELECT role FROM users WHERE id = ?");
            $stmt->execute([$target_id]);
            $current_role = $stmt->fetchColumn();
            
            $new_role = $current_role === 'admin' ? 'user' : 'admin';
            
            $stmt = $pdo->prepare("UPDATE users SET role = ? WHERE id = ?");
            $stmt->execute([$new_role, $target_id]);
            $_SESSION['users_success'] = 'Role pengguna berhasil diperbarui!';
        } elseif ($action === 'delete') {
            $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
            $stmt->execute([$target_id]);
            $_SESSION['users_success'] = 'Pengguna berhasil dihapus!';
        }
    }
    header("Location: users.php");
    exit;
}

$success = '';
$error = '';
if (isset($_SESSION['users_success'])) {
    $success = $_SESSION['users_success'];
    unset($_SESSION['users_success']);
}
if (isset($_SESSION['users_error'])) {
    $error = $_SESSION['users_error'];
    unset($_SESSION['users_error']);
}

// Fetch all users
$stmt = $pdo->query("SELECT * FROM users ORDER BY created_at DESC");
$all_users = $stmt->fetchAll();

$page_title = 'Kelola Pengguna - Admin Panel';
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
                <li><a href="orders.php" style="color:#cbd5e1; text-decoration:none; font-size:15px; display:block; padding:8px 0;">Daftar Pesanan</a></li>
                <li><a href="users.php" style="color:#FFC400; text-decoration:none; font-weight:bold; font-size:15px; display:block; padding:8px 0;">Kelola Pengguna</a></li>
                <li style="border-top: 1px solid rgba(255,255,255,0.1); margin-top:15px; padding-top:15px;">
                    <a href="../index.php" style="color:#f8fafc; text-decoration:none; font-size:14px; display:block;">&larr; Lihat Toko</a>
                </li>
            </ul>
        </div>

        <!-- Main Content Area -->
        <div style="flex: 3 1 700px; min-width: 320px;">
            <div style="margin-bottom: 30px;">
                <h2 style="font-size:28px; font-weight:800; margin-bottom:5px;">Kelola Pengguna</h2>
                <p style="color:#94a3b8; font-size:15px;">Manajemen akun pengguna terdaftar dan hak akses.</p>
            </div>

            <?php if (!empty($success)): ?>
                <div style="background-color: rgba(16, 185, 129, 0.15); border: 1px solid #10b981; color: #a7f3d0; padding: 12px 16px; border-radius: 8px; font-size: 14px; margin-bottom: 25px; text-align: center;">
                    <?= htmlspecialchars($success) ?>
                </div>
            <?php endif; ?>
            <?php if (!empty($error)): ?>
                <div style="background-color: rgba(239, 68, 68, 0.15); border: 1px solid #ef4444; color: #fca5a5; padding: 12px 16px; border-radius: 8px; font-size: 14px; margin-bottom: 25px; text-align: center;">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <div style="background: rgba(30, 41, 59, 0.4); border: 1px solid rgba(255,255,255,0.05); padding: 25px; border-radius: 12px; overflow-x:auto;">
                <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 14px;">
                    <thead>
                        <tr style="border-bottom: 1px solid rgba(255,255,255,0.1); color: #94a3b8;">
                            <th style="padding: 12px 8px;">ID</th>
                            <th style="padding: 12px 8px;">Username</th>
                            <th style="padding: 12px 8px;">Email</th>
                            <th style="padding: 12px 8px;">Nama Lengkap</th>
                            <th style="padding: 12px 8px;">Tanggal Daftar</th>
                            <th style="padding: 12px 8px;">Role</th>
                            <th style="padding: 12px 8px; text-align:center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($all_users as $user): ?>
                            <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                                <td style="padding: 12px 8px; font-weight:600;"><?= $user['id'] ?></td>
                                <td style="padding: 12px 8px; font-weight:600; color:#FFC400;"><?= htmlspecialchars($user['username']) ?></td>
                                <td style="padding: 12px 8px;"><?= htmlspecialchars($user['email']) ?></td>
                                <td style="padding: 12px 8px;"><?= htmlspecialchars($user['full_name']) ?></td>
                                <td style="padding: 12px 8px; color:#94a3b8;"><?= htmlspecialchars($user['created_at']) ?></td>
                                <td style="padding: 12px 8px;">
                                    <span style="background-color: <?= $user['role'] === 'admin' ? 'rgba(192, 132, 252, 0.2)' : 'rgba(96, 165, 250, 0.2)' ?>; color: <?= $user['role'] === 'admin' ? '#c084fc' : '#60a5fa' ?>; padding: 4px 8px; border-radius: 6px; font-size: 12px; font-weight: 600; text-transform: uppercase;">
                                        <?= htmlspecialchars($user['role']) ?>
                                    </span>
                                </td>
                                <td style="padding: 12px 8px; text-align:center; white-space:nowrap;">
                                    <?php if ($user['id'] !== $_SESSION['user_id']): ?>
                                        <a href="users.php?action=toggle_role&id=<?= $user['id'] ?>" style="color:#60a5fa; text-decoration:none; margin-right:15px; font-weight:600;">Ubah Role</a>
                                        <a href="users.php?action=delete&id=<?= $user['id'] ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?');" style="color:#ef4444; text-decoration:none; font-weight:600;">Hapus</a>
                                    <?php else: ?>
                                        <span style="color:#64748b; font-style:italic;">Akun Anda</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<?php
include __DIR__ . '/../includes/footer.php';
?>
