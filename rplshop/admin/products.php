<?php
// admin/products.php - Manage Products CRUD
$path_prefix = '../';

require_once __DIR__ . '/../includes/functions.php';

// Restrict access to admins only
require_admin();

$action = isset($_GET['action']) ? $_GET['action'] : 'list';
$error = '';
$success = '';

// Handle actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_product'])) {
        $name = trim($_POST['name']);
        $slug = trim($_POST['slug']);
        $description = trim($_POST['description']);
        $category_id = (int)$_POST['category_id'];
        $image_url = trim($_POST['image_url']);
        $brand = trim($_POST['brand']);
        $region = trim($_POST['region']);
        $platform = trim($_POST['platform']);
        $is_featured = isset($_POST['is_featured']) ? 1 : 0;
        $is_popular = isset($_POST['is_popular']) ? 1 : 0;
        
        if (empty($name) || empty($slug) || empty($category_id) || empty($image_url)) {
            $error = 'Wajib mengisi Nama, Slug, Kategori, dan Image URL.';
        } else {
            // Check if slug exists
            $stmt = $pdo->prepare("SELECT id FROM products WHERE slug = ?");
            $stmt->execute([$slug]);
            if ($stmt->fetch()) {
                $error = 'Slug produk sudah digunakan.';
            } else {
                $stmt = $pdo->prepare("INSERT INTO products (name, slug, description, category_id, image_url, brand, region, platform, is_featured, is_popular) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                if ($stmt->execute([$name, $slug, $description, $category_id, $image_url, $brand, $region, $platform, $is_featured, $is_popular])) {
                    // Create default package automatically so it is purchasable immediately
                    $new_product_id = $pdo->lastInsertId();
                    $stmt_pkg = $pdo->prepare("INSERT INTO product_packages (product_id, name, price) VALUES (?, 'Default Package', 10000.00)");
                    $stmt_pkg->execute([$new_product_id]);
                    
                    $_SESSION['crud_success'] = 'Produk berhasil ditambahkan!';
                    header("Location: products.php");
                    exit;
                } else {
                    $error = 'Gagal menyimpan data ke database.';
                }
            }
        }
    }
    
    if (isset($_POST['edit_product'])) {
        $id = (int)$_POST['id'];
        $name = trim($_POST['name']);
        $slug = trim($_POST['slug']);
        $description = trim($_POST['description']);
        $category_id = (int)$_POST['category_id'];
        $image_url = trim($_POST['image_url']);
        $brand = trim($_POST['brand']);
        $region = trim($_POST['region']);
        $platform = trim($_POST['platform']);
        $is_featured = isset($_POST['is_featured']) ? 1 : 0;
        $is_popular = isset($_POST['is_popular']) ? 1 : 0;
        
        if (empty($name) || empty($slug) || empty($category_id) || empty($image_url)) {
            $error = 'Wajib mengisi Nama, Slug, Kategori, dan Image URL.';
        } else {
            // Check if slug exists on other products
            $stmt = $pdo->prepare("SELECT id FROM products WHERE slug = ? AND id != ?");
            $stmt->execute([$slug, $id]);
            if ($stmt->fetch()) {
                $error = 'Slug produk sudah digunakan.';
            } else {
                $stmt = $pdo->prepare("UPDATE products SET name=?, slug=?, description=?, category_id=?, image_url=?, brand=?, region=?, platform=?, is_featured=?, is_popular=? WHERE id=?");
                if ($stmt->execute([$name, $slug, $description, $category_id, $image_url, $brand, $region, $platform, $is_featured, $is_popular, $id])) {
                    $_SESSION['crud_success'] = 'Data produk berhasil diperbarui!';
                    header("Location: products.php");
                    exit;
                } else {
                    $error = 'Gagal memperbarui data ke database.';
                }
            }
        }
    }
}

if ($action === 'delete' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    if ($stmt->execute([$id])) {
        $_SESSION['crud_success'] = 'Produk berhasil dihapus!';
    } else {
        $_SESSION['crud_error'] = 'Gagal menghapus produk.';
    }
    header("Location: products.php");
    exit;
}

if (isset($_SESSION['crud_success'])) {
    $success = $_SESSION['crud_success'];
    unset($_SESSION['crud_success']);
}
if (isset($_SESSION['crud_error'])) {
    $error = $_SESSION['crud_error'];
    unset($_SESSION['crud_error']);
}

// Fetch all categories for inputs
$stmt_cats = $pdo->query("SELECT * FROM categories ORDER BY name ASC");
$all_categories = $stmt_cats->fetchAll();

// Fetch products for list
$stmt_prods = $pdo->query("SELECT p.*, c.name as category_name 
                           FROM products p 
                           LEFT JOIN categories c ON p.category_id = c.id 
                           ORDER BY p.id DESC");
$all_products = $stmt_prods->fetchAll();

$page_title = 'Kelola Produk - Admin Panel';
include __DIR__ . '/../includes/header.php';
?>

<div style="background-color: #0f172a; min-height: 85vh; padding: 40px 0; color: #fff;">
    <div class="inner" style="max-width: 1200px; margin: 0 auto; padding: 0 20px; display: flex; flex-direction: row; gap: 30px; flex-wrap: wrap;">
        
        <!-- Sidebar Navigation -->
        <div style="flex: 1 1 220px; max-width: 250px; background: rgba(30, 41, 59, 0.6); padding: 25px 20px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.05); align-self: flex-start;">
            <h3 style="color:#64748b; font-size:12px; text-transform:uppercase; letter-spacing:1px; margin-bottom:15px; font-weight:700;">Menu Admin</h3>
            <ul style="list-style:none; padding:0; margin:0; display:flex; flex-direction:column; gap:10px;">
                <li><a href="index.php" style="color:#cbd5e1; text-decoration:none; font-size:15px; display:block; padding:8px 0;">Dashboard</a></li>
                <li><a href="products.php" style="color:#FFC400; text-decoration:none; font-weight:bold; font-size:15px; display:block; padding:8px 0;">Kelola Produk</a></li>
                <li><a href="orders.php" style="color:#cbd5e1; text-decoration:none; font-size:15px; display:block; padding:8px 0;">Daftar Pesanan</a></li>
                <li><a href="users.php" style="color:#cbd5e1; text-decoration:none; font-size:15px; display:block; padding:8px 0;">Kelola Pengguna</a></li>
                <li style="border-top: 1px solid rgba(255,255,255,0.1); margin-top:15px; padding-top:15px;">
                    <a href="../index.php" style="color:#f8fafc; text-decoration:none; font-size:14px; display:block;">&larr; Lihat Toko</a>
                </li>
            </ul>
        </div>

        <!-- Main Content Area -->
        <div style="flex: 3 1 700px; min-width: 320px;">
            
            <?php if ($action === 'list'): ?>
                <!-- List Products -->
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:30px;">
                    <div>
                        <h2 style="font-size:28px; font-weight:800; margin-bottom:5px;">Kelola Produk</h2>
                        <p style="color:#94a3b8; font-size:15px;">Manajemen katalog produk di toko RPLShop.</p>
                    </div>
                    <a href="products.php?action=add" class="btw" color="theme" style="padding:10px 20px; border-radius:8px; font-weight:bold; text-decoration:none; font-size:14px;">
                        <span>Tambah Produk</span>
                    </a>
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
                                <th style="padding: 12px 8px;">Gambar</th>
                                <th style="padding: 12px 8px;">Nama Produk</th>
                                <th style="padding: 12px 8px;">Kategori</th>
                                <th style="padding: 12px 8px;">Brand</th>
                                <th style="padding: 12px 8px;">Region</th>
                                <th style="padding: 12px 8px; text-align:center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($all_products as $prod): ?>
                                <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                                    <td style="padding: 12px 8px; font-weight:600;"><?= $prod['id'] ?></td>
                                    <td style="padding: 12px 8px;">
                                        <img src="<?= $path_prefix . htmlspecialchars($prod['image_url']) ?>" alt="Cover" style="width:40px; height:40px; border-radius:6px; object-fit:cover; background-color:#0f172a;">
                                    </td>
                                    <td style="padding: 12px 8px; font-weight:600; color:#FFC400;"><?= htmlspecialchars($prod['name']) ?></td>
                                    <td style="padding: 12px 8px;"><?= htmlspecialchars($prod['category_name']) ?></td>
                                    <td style="padding: 12px 8px;"><?= htmlspecialchars($prod['brand']) ?></td>
                                    <td style="padding: 12px 8px;"><?= htmlspecialchars($prod['region']) ?></td>
                                    <td style="padding: 12px 8px; text-align:center; white-space:nowrap;">
                                        <a href="products.php?action=edit&id=<?= $prod['id'] ?>" style="color:#60a5fa; text-decoration:none; margin-right:15px; font-weight:600;">Edit</a>
                                        <a href="products.php?action=delete&id=<?= $prod['id'] ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?');" style="color:#ef4444; text-decoration:none; font-weight:600;">Hapus</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            <?php elseif ($action === 'add' || $action === 'edit'): 
                $prod = ['id'=>'', 'name'=>'', 'slug'=>'', 'description'=>'', 'category_id'=>'', 'image_url'=>'', 'brand'=>'', 'region'=>'', 'platform'=>'', 'is_featured'=>0, 'is_popular'=>0];
                if ($action === 'edit' && isset($_GET['id'])) {
                    $id = (int)$_GET['id'];
                    $stmt_edit = $pdo->prepare("SELECT * FROM products WHERE id = ?");
                    $stmt_edit->execute([$id]);
                    $fetched = $stmt_edit->fetch();
                    if ($fetched) {
                        $prod = $fetched;
                    }
                }
            ?>
                <!-- Form Add / Edit -->
                <div style="margin-bottom: 30px;">
                    <h2 style="font-size:28px; font-weight:800; margin-bottom:5px;"><?= $action === 'add' ? 'Tambah Produk Baru' : 'Edit Produk: ' . htmlspecialchars($prod['name']) ?></h2>
                    <a href="products.php" style="color:#FFC400; text-decoration:none; font-size:14px;">&larr; Kembali ke Daftar Produk</a>
                </div>

                <?php if (!empty($error)): ?>
                    <div style="background-color: rgba(239, 68, 68, 0.15); border: 1px solid #ef4444; color: #fca5a5; padding: 12px 16px; border-radius: 8px; font-size: 14px; margin-bottom: 25px;">
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>

                <div style="background: rgba(30, 41, 59, 0.4); border: 1px solid rgba(255,255,255,0.05); padding: 30px; border-radius: 12px;">
                    <form method="post" action="products.php">
                        <input type="hidden" name="id" value="<?= $prod['id'] ?>">
                        
                        <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap:20px; margin-bottom:20px;">
                            <div>
                                <label style="display:block; font-size:14px; font-weight:600; margin-bottom:8px; color:#cbd5e1;">Nama Produk</label>
                                <input type="text" name="name" value="<?= htmlspecialchars($prod['name']) ?>" required placeholder="Masukkan nama produk"
                                       style="width: 100%; padding: 12px; background-color: #0f172a; border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: #fff; font-size:14px; outline:none;">
                            </div>
                            
                            <div>
                                <label style="display:block; font-size:14px; font-weight:600; margin-bottom:8px; color:#cbd5e1;">Slug URL</label>
                                <input type="text" name="slug" value="<?= htmlspecialchars($prod['slug']) ?>" required placeholder="contoh: mobile-legends-diamonds"
                                       style="width: 100%; padding: 12px; background-color: #0f172a; border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: #fff; font-size:14px; outline:none;">
                            </div>
                        </div>

                        <div style="margin-bottom:20px;">
                            <label style="display:block; font-size:14px; font-weight:600; margin-bottom:8px; color:#cbd5e1;">Deskripsi Produk</label>
                            <textarea name="description" rows="4" placeholder="Panduan cara top up atau info produk..."
                                      style="width: 100%; padding: 12px; background-color: #0f172a; border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: #fff; font-size:14px; outline:none; resize:vertical;"><?= htmlspecialchars($prod['description']) ?></textarea>
                        </div>

                        <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap:20px; margin-bottom:20px;">
                            <div>
                                <label style="display:block; font-size:14px; font-weight:600; margin-bottom:8px; color:#cbd5e1;">Kategori</label>
                                <select name="category_id" required style="width: 100%; padding: 12px; background-color: #0f172a; border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: #fff; font-size:14px; outline:none;">
                                    <option value="">-- Pilih Kategori --</option>
                                    <?php foreach ($all_categories as $cat): ?>
                                        <option value="<?= $cat['id'] ?>" <?= $prod['category_id'] == $cat['id'] ? 'selected' : '' ?>><?= htmlspecialchars($cat['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div>
                                <label style="display:block; font-size:14px; font-weight:600; margin-bottom:8px; color:#cbd5e1;">Image URL (Asset Path)</label>
                                <input type="text" name="image_url" value="<?= htmlspecialchars($prod['image_url']) ?>" required placeholder="contoh: assets/media/game_480/415873fd.jpg"
                                       style="width: 100%; padding: 12px; background-color: #0f172a; border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: #fff; font-size:14px; outline:none;">
                            </div>
                        </div>

                        <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap:20px; margin-bottom:25px;">
                            <div>
                                <label style="display:block; font-size:14px; font-weight:600; margin-bottom:8px; color:#cbd5e1;">Brand</label>
                                <input type="text" name="brand" value="<?= htmlspecialchars($prod['brand']) ?>" placeholder="contoh: Moonton"
                                       style="width: 100%; padding: 12px; background-color: #0f172a; border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: #fff; font-size:14px; outline:none;">
                            </div>
                            <div>
                                <label style="display:block; font-size:14px; font-weight:600; margin-bottom:8px; color:#cbd5e1;">Region</label>
                                <input type="text" name="region" value="<?= htmlspecialchars($prod['region']) ?>" placeholder="contoh: Indonesia"
                                       style="width: 100%; padding: 12px; background-color: #0f172a; border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: #fff; font-size:14px; outline:none;">
                            </div>
                            <div>
                                <label style="display:block; font-size:14px; font-weight:600; margin-bottom:8px; color:#cbd5e1;">Platform</label>
                                <input type="text" name="platform" value="<?= htmlspecialchars($prod['platform']) ?>" placeholder="contoh: Mobile"
                                       style="width: 100%; padding: 12px; background-color: #0f172a; border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: #fff; font-size:14px; outline:none;">
                            </div>
                        </div>

                        <div style="display:flex; gap:30px; margin-bottom:30px;">
                            <label style="display:flex; align-items:center; gap:8px; cursor:pointer; font-size:14px;">
                                <input type="checkbox" name="is_featured" value="1" <?= $prod['is_featured'] ? 'checked' : '' ?> style="accent-color:#FFC400;">
                                Unggulan (Featured)
                            </label>
                            <label style="display:flex; align-items:center; gap:8px; cursor:pointer; font-size:14px;">
                                <input type="checkbox" name="is_popular" value="1" <?= $prod['is_popular'] ? 'checked' : '' ?> style="accent-color:#FFC400;">
                                Populer (Popular)
                            </label>
                        </div>

                        <button type="submit" name="<?= $action === 'add' ? 'add_product' : 'edit_product' ?>" class="btw" color="theme" style="padding:12px 30px; border-radius:8px; font-weight:bold; border:none; cursor:pointer;">
                            <span>SIMPAN PRODUK</span>
                        </button>
                    </form>
                </div>
            <?php endif; ?>

        </div>

    </div>
</div>

<?php
include __DIR__ . '/../includes/footer.php';
?>
