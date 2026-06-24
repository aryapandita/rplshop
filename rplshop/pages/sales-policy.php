<?php
// pages/sales-policy.php - Ketentuan Penjualan
$path_prefix = '../';
$page_title = 'Ketentuan Penjualan - RPLShop';

require_once __DIR__ . '/../includes/functions.php';
include __DIR__ . '/../includes/header.php';
?>

<div style="min-height: 80vh; background: linear-gradient(180deg, #101827 0%, #0f172a 100%); padding: 60px 0;">
    <div class="inner" style="max-width: 800px; margin: 0 auto; padding: 0 20px;">

        <!-- Header -->
        <div style="margin-bottom: 40px; border-bottom: 1px solid rgba(255,255,255,0.06); padding-bottom: 25px;">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 10px;">
                <span icon="receipt_long" style="font-size: 32px; color: #FFC400;"></span>
                <h1 style="color: #fff; font-size: 28px; font-weight: 800;">Ketentuan Penjualan</h1>
            </div>
            <p style="color: #64748b; font-size: 13px;">Terakhir diperbarui: 20 Juni 2026</p>
        </div>

        <!-- Content -->
        <div style="background: rgba(30, 41, 59, 0.5); border-radius: 14px; border: 1px solid rgba(255,255,255,0.06); padding: 35px 30px; color: #cbd5e1; font-size: 15px; line-height: 1.8;">

            <h2 style="color: #fff; font-size: 18px; font-weight: 700; margin-bottom: 12px;">1. Jenis Produk</h2>
            <p style="margin-bottom: 16px;">RPLShop menjual produk digital yang meliputi:</p>
            <ul style="padding-left: 20px; margin-bottom: 24px;">
                <li style="margin-bottom: 8px;"><strong style="color: #fff;">Game Top-Up:</strong> Diamond, UC, VP, dan mata uang dalam game lainnya.</li>
                <li style="margin-bottom: 8px;"><strong style="color: #fff;">Game Cards:</strong> Steam Wallet Code, Razer Gold, Garena Shells, dan lainnya.</li>
                <li style="margin-bottom: 8px;"><strong style="color: #fff;">Gift Cards:</strong> Google Play, Apple/iTunes, dan voucher digital lainnya.</li>
                <li><strong style="color: #fff;">Direct Top-Up:</strong> Pengisian langsung ke akun game tanpa kode voucher.</li>
            </ul>

            <h2 style="color: #fff; font-size: 18px; font-weight: 700; margin-bottom: 12px;">2. Proses Pembelian</h2>
            <div style="display: flex; flex-direction: column; gap: 12px; margin-bottom: 24px;">
                <div style="display: flex; gap: 14px; align-items: flex-start;">
                    <span style="background: #FFC400; color: #000; min-width: 26px; height: 26px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 13px; font-weight: bold; margin-top: 2px;">1</span>
                    <p style="margin: 0;">Pilih produk dan denominasi yang diinginkan dari katalog RPLShop.</p>
                </div>
                <div style="display: flex; gap: 14px; align-items: flex-start;">
                    <span style="background: #FFC400; color: #000; min-width: 26px; height: 26px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 13px; font-weight: bold; margin-top: 2px;">2</span>
                    <p style="margin: 0;">Masukkan informasi akun yang diperlukan (ID Akun, Zone ID, dsb.).</p>
                </div>
                <div style="display: flex; gap: 14px; align-items: flex-start;">
                    <span style="background: #FFC400; color: #000; min-width: 26px; height: 26px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 13px; font-weight: bold; margin-top: 2px;">3</span>
                    <p style="margin: 0;">Lakukan pembayaran menggunakan metode yang tersedia.</p>
                </div>
                <div style="display: flex; gap: 14px; align-items: flex-start;">
                    <span style="background: #FFC400; color: #000; min-width: 26px; height: 26px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 13px; font-weight: bold; margin-top: 2px;">4</span>
                    <p style="margin: 0;">Produk akan dikirim secara otomatis setelah pembayaran terverifikasi.</p>
                </div>
            </div>

            <h2 style="color: #fff; font-size: 18px; font-weight: 700; margin-bottom: 12px;">3. Harga & Pembayaran</h2>
            <ul style="padding-left: 20px; margin-bottom: 24px;">
                <li style="margin-bottom: 8px;">Semua harga ditampilkan dalam Rupiah (IDR) dan bersifat final pada saat transaksi.</li>
                <li style="margin-bottom: 8px;">RPLShop berhak mengubah harga produk sewaktu-waktu tanpa pemberitahuan sebelumnya.</li>
                <li style="margin-bottom: 8px;">Promo dan diskon berlaku sesuai periode yang ditentukan dan dapat berakhir kapan saja.</li>
                <li>Tidak ada biaya transaksi tambahan untuk setiap pembelian.</li>
            </ul>

            <h2 style="color: #fff; font-size: 18px; font-weight: 700; margin-bottom: 12px;">4. Kebijakan Pengembalian & Refund</h2>
            <div style="background: rgba(239, 68, 68, 0.08); border: 1px solid rgba(239, 68, 68, 0.2); border-radius: 10px; padding: 18px 20px; margin-bottom: 24px;">
                <p style="margin-bottom: 12px;"><strong style="color: #fca5a5;">Penting:</strong> Karena sifat produk digital, seluruh transaksi yang telah berhasil diproses bersifat <strong style="color: #fff;">final dan tidak dapat dikembalikan (non-refundable)</strong>.</p>
                <p style="margin: 0;">Pengecualian refund hanya berlaku apabila:</p>
                <ul style="padding-left: 20px; margin-top: 8px;">
                    <li style="margin-bottom: 6px;">Terjadi kegagalan sistem dari pihak RPLShop yang menyebabkan produk tidak terkirim.</li>
                    <li style="margin-bottom: 6px;">Produk yang diterima tidak sesuai dengan pesanan (kesalahan denominasi).</li>
                    <li>Pembayaran berhasil tetapi produk tidak masuk ke akun game dalam waktu 1x24 jam.</li>
                </ul>
            </div>

            <h2 style="color: #fff; font-size: 18px; font-weight: 700; margin-bottom: 12px;">5. Waktu Pengiriman</h2>
            <ul style="padding-left: 20px; margin-bottom: 24px;">
                <li style="margin-bottom: 8px;"><strong style="color: #10b981;">Direct Top-Up:</strong> 1-5 menit setelah pembayaran dikonfirmasi.</li>
                <li style="margin-bottom: 8px;"><strong style="color: #10b981;">Voucher/Gift Card:</strong> Kode dikirim secara instan via email atau ditampilkan di halaman transaksi.</li>
                <li><strong style="color: #FFC400;">Catatan:</strong> Dalam kondisi tertentu, pengiriman dapat memakan waktu hingga 1x24 jam kerja.</li>
            </ul>

            <h2 style="color: #fff; font-size: 18px; font-weight: 700; margin-bottom: 12px;">6. Hubungi Kami</h2>
            <p>Untuk pertanyaan terkait penjualan, silakan hubungi <a href="mailto:support@rplshop.local" style="color: #FFC400; text-decoration: none;">support@rplshop.local</a> atau kunjungi halaman <a href="support.php" style="color: #FFC400; text-decoration: none;">Bantuan & Dukungan</a>.</p>

        </div>

    </div>
</div>

<?php
include __DIR__ . '/../includes/footer.php';
?>
