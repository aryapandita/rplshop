<?php
// pages/product-detail.php - Product Detail Page
$path_prefix = '../';

require_once __DIR__ . '/../includes/functions.php';

$slug = isset($_GET['slug']) ? trim($_GET['slug']) : '';
$preselected_package_id = isset($_GET['package_id']) ? (int)$_GET['package_id'] : 0;

if (empty($slug)) {
    header("Location: products.php");
    exit;
}

$product = get_product_by_slug($pdo, $slug);
if (!$product) {
    die("Produk tidak ditemukan.");
}

$page_title = $product['name'] . ' - Top Up Murah Instan | RPLShop';
$packages = get_product_packages($pdo, $product['id']);
$fields = get_product_fields($pdo, $product['id']);

// Extra CSS files for product page
$extra_css = ['product-d72efc6293.css'];

include __DIR__ . '/../includes/header.php';
?>

<style>
    .rpl-empty-product-cover {
        width: 240px;
        height: 240px;
        max-width: 100%;
        border: 1px dashed rgba(255, 255, 255, .22);
        border-radius: 12px;
        background:
            linear-gradient(135deg, rgba(255, 255, 255, .045), rgba(255, 255, 255, .01)),
            #111827;
    }
</style>

<div id="Product_cover" data-hue="40505c">
    <div class="inner">
        <div class="cover">
            <div class="img topup" style="overflow: hidden; display: flex; align-items: center; justify-content: center; width: 240px; height: 240px; border-radius: 12px; background: #111827; border: 1px solid rgba(255,255,255,0.1);">
                <img src="<?= $path_prefix . htmlspecialchars(resolve_product_image_url($product)) ?>" alt="<?= htmlspecialchars($product['name']) ?>" style="width: 100%; height: 100%; object-fit: cover;">
            </div>
        </div>
        <div class="name">
            <h1><?= htmlspecialchars($product['name']) ?></h1>
        </div>
        <div class="feature">
            <div class="tag" region="id">
                <span><?= htmlspecialchars($product['region']) ?></span>
            </div>
            <div class="tag" icon="offline_bolt">
                <span>Instan & Aman</span>
            </div>
            <div class="tag" style="background-color: #0284c7; color:#fff;">
                <span><?= htmlspecialchars($product['brand']) ?></span>
            </div>
        </div>
        <div class="func">
            <a id="favorite_bt" class="btw" color="outline" title="Add to favorite" href="javascript:void(0)" data-product-slug="<?= htmlspecialchars($product['slug']) ?>">
                <span icon="favorite_border">Tambah Favorit</span>
            </a>
        </div>
    </div>
</div>

<div style="background-color: #0f172a; padding: 40px 0; min-height: 50vh;">
    <div class="inner" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
        
        <form method="post" action="cart.php">
            <input type="hidden" name="action" value="add">
            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
            <input type="hidden" name="product_slug" value="<?= htmlspecialchars($product['slug']) ?>">
            
            <div style="display: flex; flex-direction: row; gap: 30px; flex-wrap: wrap;">
                
                <!-- Left Column: Top-Up Fields & Denominations -->
                <div style="flex: 2 1 650px; min-width: 320px; display: flex; flex-direction: column; gap: 25px;">
                    
                    <!-- 1. Custom Fields Form Box -->
                    <?php if (!empty($fields)): ?>
                        <div style="background: rgba(30, 41, 59, 0.5); border-radius: 12px; border: 1px solid rgba(255,255,255,0.05); padding: 30px 25px;">
                            <h3 style="color: #fff; font-size: 18px; font-weight: 700; margin-bottom: 20px; display: flex; align-items: center; gap: 8px;">
                                <span style="background: #FFC400; color: #000; width: 24px; height: 24px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 14px; font-weight: bold;">1</span>
                                Masukkan Informasi Akun
                            </h3>
                            
                            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 24px;">
                                <?php foreach ($fields as $field): ?>
                                    <div style="display: flex; flex-direction: column; gap: 6px;">
                                        <label style="display: block; color: #e2e8f0; font-size: 14px; font-weight: 700; letter-spacing: 0.3px;">
                                            <?= htmlspecialchars($field['field_name']) ?>
                                            <?php if ($field['is_required']): ?>
                                                <span style="color:#ef4444; margin-left: 2px;">*</span>
                                            <?php endif; ?>
                                        </label>
                                        <input type="<?= htmlspecialchars($field['field_type']) ?>" 
                                               name="custom_fields[<?= htmlspecialchars($field['field_name']) ?>]" 
                                               placeholder="<?= htmlspecialchars($field['placeholder']) ?>"
                                               <?= $field['is_required'] ? 'required' : '' ?>
                                               style="width: 100%; padding: 14px 16px; background-color: #0f172a; border: 2px solid rgba(255,255,255,0.08); border-radius: 10px; color: #fff; font-size: 15px; font-weight: 500; outline: none; transition: all 0.2s ease; box-sizing: border-box;"
                                               onfocus="this.style.borderColor='#FFC400'; this.style.backgroundColor='#0b1222'; this.style.boxShadow='0 0 0 3px rgba(255,196,0,0.1)';" 
                                               onblur="this.style.borderColor='rgba(255,255,255,0.08)'; this.style.backgroundColor='#0f172a'; this.style.boxShadow='none';">
                                        <?php if (!empty($field['help_text'])): ?>
                                            <p style="color: #64748b; font-size: 12px; margin: 0; line-height: 1.5; padding-left: 2px;"><?= htmlspecialchars($field['help_text']) ?></p>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- 2. Denominations Package Selection Box -->
                    <div style="background: rgba(30, 41, 59, 0.5); border-radius: 12px; border: 1px solid rgba(255,255,255,0.05); padding: 30px 25px;">
                        <h3 style="color: #fff; font-size: 18px; font-weight: 700; margin-bottom: 20px; display: flex; align-items: center; gap: 8px;">
                            <span style="background: #FFC400; color: #000; width: 24px; height: 24px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 14px; font-weight: bold;">
                                <?= !empty($fields) ? '2' : '1' ?>
                            </span>
                            Pilih Denominasi
                        </h3>
                        
                        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 15px;">
                            <?php foreach ($packages as $pkg): 
                                $discounted_price = $pkg['price'] * (1 - $pkg['discount_percent']/100);
                                $is_selected = ($pkg['id'] === $preselected_package_id || ($preselected_package_id === 0 && $pkg === reset($packages)));
                            ?>
                                <div class="pkg-card" data-id="<?= $pkg['id'] ?>" data-price="<?= $discounted_price ?>"
                                     style="border: 2px solid <?= $is_selected ? '#FFC400' : 'rgba(255,255,255,0.06)' ?>; background: rgba(15, 23, 42, 0.6); padding: 20px 15px; border-radius: 10px; cursor: pointer; position: relative; transition: all 0.2s;"
                                     onclick="selectPackage(<?= $pkg['id'] ?>, <?= $discounted_price ?>, this);">
                                    
                                    <?php if ($pkg['discount_percent'] > 0): ?>
                                        <span style="position: absolute; top: 10px; right: 10px; background-color: #ef4444; color: #fff; font-size: 11px; font-weight: bold; padding: 2px 6px; border-radius: 4px;">
                                            -<?= number_format($pkg['discount_percent'], 0) ?>%
                                        </span>
                                    <?php endif; ?>

                                    <div style="color: #fff; font-size: 15px; font-weight: 700; margin-bottom: 12px; width: 80%; line-height: 1.3;">
                                        <?= htmlspecialchars($pkg['name']) ?>
                                    </div>
                                    
                                    <div style="display: flex; flex-direction: column;">
                                        <?php if ($pkg['discount_percent'] > 0): ?>
                                            <span style="color: #64748b; font-size: 12px; text-decoration: line-through; margin-bottom: 2px;">
                                                <?= format_idr($pkg['price']) ?>
                                            </span>
                                        <?php endif; ?>
                                        <span style="color: #FFC400; font-size: 16px; font-weight: 800;">
                                            <?= format_idr($discounted_price) ?>
                                        </span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <!-- Hidden input for selected package -->
                        <input type="hidden" name="product_package_id" id="selected_package_id" value="<?= $preselected_package_id !== 0 ? $preselected_package_id : ($packages[0]['id'] ?? 0) ?>">
                    </div>

                </div>

                <!-- Right Column: Purchase Panel -->
                <div style="flex: 1 1 350px; max-width: 400px; min-width: 280px; display: flex; flex-direction: column; gap: 25px;">
                    
                    <!-- 3. Checkout Box -->
                    <div style="background: rgba(30, 41, 59, 0.5); border-radius: 12px; border: 1px solid rgba(255,255,255,0.05); padding: 30px 25px; position: sticky; top: 100px;">
                        <h3 style="color: #fff; font-size: 18px; font-weight: 700; margin-bottom: 20px; display: flex; align-items: center; gap: 8px;">
                            <span style="background: #FFC400; color: #000; width: 24px; height: 24px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 14px; font-weight: bold;">
                                <?= !empty($fields) ? '3' : '2' ?>
                            </span>
                            Beli Langsung
                        </h3>

                        <!-- Quantity -->
                        <div style="margin-bottom: 25px;">
                            <label style="display: block; color: #cbd5e1; font-size: 14px; font-weight: 600; margin-bottom: 8px;">Jumlah Pembelian</label>
                            <div style="display: flex; align-items: center; gap: 10px; width: 140px;">
                                <button type="button" onclick="adjustQty(-1);" 
                                        style="background: rgba(255,255,255,0.08); border: none; color: #fff; width: 36px; height: 36px; border-radius: 8px; font-weight: bold; cursor: pointer; font-size: 18px;">-</button>
                                <input type="number" id="qty_input" name="quantity" value="1" min="1" max="99" required readonly
                                       style="width: 50px; text-align: center; background: none; border: none; color: #fff; font-size: 16px; font-weight: bold; outline: none; -moz-appearance: textfield;">
                                <button type="button" onclick="adjustQty(1);" 
                                        style="background: rgba(255,255,255,0.08); border: none; color: #fff; width: 36px; height: 36px; border-radius: 8px; font-weight: bold; cursor: pointer; font-size: 18px;">+</button>
                            </div>
                        </div>

                        <!-- Price summary -->
                        <div style="border-top: 1px solid rgba(255,255,255,0.1); padding-top: 20px; margin-bottom: 25px;">
                            <div style="display: flex; justify-content: space-between; color: #94a3b8; font-size: 14px; margin-bottom: 10px;">
                                <span>Harga Satuan:</span>
                                <span id="summary_unit_price" style="color: #fff; font-weight: 600;">Rp 0</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <span style="color: #cbd5e1; font-size: 15px; font-weight: 600;">Total Pembayaran:</span>
                                <span id="summary_total_price" style="color: #FFC400; font-size: 22px; font-weight: 800;">Rp 0</span>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div style="display: flex; flex-direction: column; gap: 12px;">
                            <button type="submit" name="buy_now" value="1" class="btw" color="theme" style="width:100%; padding:14px; font-weight:bold; font-size:16px; border:none; border-radius:8px; cursor:pointer; text-align:center;">
                                <span>BELI SEKARANG</span>
                            </button>
                            
                            <button type="submit" name="add_to_cart" value="1" class="btw" color="outline" style="width:100%; padding:14px; font-weight:bold; font-size:15px; border-radius:8px; cursor:pointer; text-align:center;">
                                <span icon="shopping_cart">TAMBAH KERANJANG</span>
                            </button>
                        </div>
                    </div>

                </div>

            </div>
        </form>

        <!-- Product Description / Guide -->
        <div style="margin-top: 40px; background: rgba(30, 41, 59, 0.5); border-radius: 12px; border: 1px solid rgba(255,255,255,0.05); padding: 30px 25px; color: #cbd5e1; line-height: 1.6;">
            <h3 style="color: #fff; font-size: 18px; font-weight: 700; margin-bottom: 15px;">Informasi & Panduan Cara Top-Up</h3>
            <div style="font-size: 14px;">
                <p style="margin-bottom: 15px;"><?= nl2br(htmlspecialchars($product['description'])) ?></p>
                <h4 style="color:#fff; font-weight:600; margin-bottom:8px; margin-top:20px;">Cara membeli:</h4>
                <ol style="padding-left: 20px; display: flex; flex-direction: column; gap: 8px;">
                    <li>Masukkan data ID Akun Anda (dan Zone ID jika diperlukan) pada form di atas.</li>
                    <li>Pilih nominal denominasi / paket koin game yang ingin Anda beli.</li>
                    <li>Tentukan jumlah pembelian lalu klik tombol <b>Beli Sekarang</b> atau <b>Tambah Keranjang</b>.</li>
                    <li>Selesaikan pembayaran menggunakan e-wallet pilihan Anda (GoPay, DANA, QRIS).</li>
                    <li>Kredit game akan otomatis ditambahkan ke akun game Anda secara instan setelah pembayaran terkonfirmasi.</li>
                </ol>
            </div>
        </div>

    </div>
</div>

<script type="text/javascript">
    let currentPrice = 0;

    function selectPackage(id, price, element) {
        // Set selected package id
        document.getElementById('selected_package_id').value = id;
        
        // Remove active class from all cards
        document.querySelectorAll('.pkg-card').forEach(card => {
            card.style.borderColor = 'rgba(255,255,255,0.06)';
        });
        
        // Add active style to selected element
        element.style.borderColor = '#FFC400';
        
        // Update price
        currentPrice = price;
        updateSummary();
    }

    function adjustQty(amount) {
        let input = document.getElementById('qty_input');
        let val = parseInt(input.value) + amount;
        if (val < 1) val = 1;
        if (val > 99) val = 99;
        input.value = val;
        updateSummary();
    }

    function formatCurrency(amount) {
        return 'Rp ' + amount.toLocaleString('id-ID').replace(/,/g, '.');
    }

    function updateSummary() {
        let qty = parseInt(document.getElementById('qty_input').value);
        let total = currentPrice * qty;
        
        document.getElementById('summary_unit_price').innerText = formatCurrency(currentPrice);
        document.getElementById('summary_total_price').innerText = formatCurrency(total);
    }

    // Initialize selection on page load
    window.addEventListener('DOMContentLoaded', () => {
        // Check if there is a preselected package, otherwise default to first
        let activeCard = document.querySelector('.pkg-card[style*="border: 2px solid rgb(255, 196, 0)"]') || document.querySelector('.pkg-card');
        if (activeCard) {
            activeCard.click();
        }

        const favoriteButton = document.getElementById('favorite_bt');
        if (favoriteButton) {
            const slug = favoriteButton.dataset.productSlug;
            const storageKey = 'rplshop_favorite_' + slug;
            const label = favoriteButton.querySelector('span');

            const syncFavoriteLabel = () => {
                const isFavorite = localStorage.getItem(storageKey) === '1';
                label.setAttribute('icon', isFavorite ? 'favorite' : 'favorite_border');
                label.textContent = isFavorite ? 'Favorit Tersimpan' : 'Tambah Favorit';
                favoriteButton.setAttribute('color', isFavorite ? 'theme' : 'outline');
            };

            syncFavoriteLabel();

            favoriteButton.addEventListener('click', (event) => {
                event.preventDefault();
                const isFavorite = localStorage.getItem(storageKey) === '1';
                if (isFavorite) {
                    localStorage.removeItem(storageKey);
                } else {
                    localStorage.setItem(storageKey, '1');
                }
                syncFavoriteLabel();
            });
        }
    });
</script>

<?php
include __DIR__ . '/../includes/footer.php';
?>
