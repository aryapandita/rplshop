<?php
// pages/terms.php - Syarat Penggunaan
$path_prefix = '../';
$page_title = 'Syarat Penggunaan - RPLShop';

require_once __DIR__ . '/../includes/functions.php';
include __DIR__ . '/../includes/header.php';
?>

<div style="min-height: 80vh; background: linear-gradient(180deg, #101827 0%, #0f172a 100%); padding: 60px 0;">
    <div class="inner" style="max-width: 800px; margin: 0 auto; padding: 0 20px;">

        <!-- Header -->
        <div style="margin-bottom: 40px; border-bottom: 1px solid rgba(255,255,255,0.06); padding-bottom: 25px;">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 10px;">
                <span icon="gavel" style="font-size: 32px; color: #FFC400;"></span>
                <h1 style="color: #fff; font-size: 28px; font-weight: 800;">Syarat Penggunaan</h1>
            </div>
            <p style="color: #64748b; font-size: 13px;">Terakhir diperbarui: 20 Juni 2026</p>
        </div>

        <!-- Content -->
        <div style="background: rgba(30, 41, 59, 0.5); border-radius: 14px; border: 1px solid rgba(255,255,255,0.06); padding: 35px 30px; color: #cbd5e1; font-size: 15px; line-height: 1.8;">

            <h2 style="color: #fff; font-size: 18px; font-weight: 700; margin-bottom: 12px;">1. Penerimaan Syarat</h2>
            <p style="margin-bottom: 24px;">Dengan mengakses dan menggunakan layanan RPLShop, Anda menyatakan setuju dan terikat dengan seluruh syarat dan ketentuan yang tercantum di halaman ini. Jika Anda tidak setuju dengan salah satu syarat, mohon untuk tidak melanjutkan penggunaan layanan kami.</p>

            <h2 style="color: #fff; font-size: 18px; font-weight: 700; margin-bottom: 12px;">2. Definisi Layanan</h2>
            <p style="margin-bottom: 24px;">RPLShop adalah platform e-commerce yang menyediakan layanan pembelian top-up game, gift card, voucher digital, dan produk digital lainnya. Layanan ini tersedia melalui situs web kami dan dapat diakses oleh pengguna yang telah terdaftar.</p>

            <h2 style="color: #fff; font-size: 18px; font-weight: 700; margin-bottom: 12px;">3. Pendaftaran Akun</h2>
            <ul style="padding-left: 20px; margin-bottom: 24px;">
                <li style="margin-bottom: 8px;">Pengguna wajib memberikan informasi yang akurat dan lengkap saat mendaftarkan akun.</li>
                <li style="margin-bottom: 8px;">Setiap pengguna bertanggung jawab penuh atas keamanan akun dan password mereka.</li>
                <li style="margin-bottom: 8px;">RPLShop berhak menangguhkan atau menutup akun yang melanggar ketentuan yang berlaku.</li>
                <li>Satu pengguna hanya diperbolehkan memiliki satu akun aktif.</li>
            </ul>

            <h2 style="color: #fff; font-size: 18px; font-weight: 700; margin-bottom: 12px;">4. Transaksi & Pembayaran</h2>
            <ul style="padding-left: 20px; margin-bottom: 24px;">
                <li style="margin-bottom: 8px;">Seluruh harga yang tercantum dalam mata uang Rupiah (IDR) dan sudah termasuk pajak yang berlaku.</li>
                <li style="margin-bottom: 8px;">Pembayaran dilakukan melalui metode yang tersedia di platform (GoPay, DANA, QRIS).</li>
                <li style="margin-bottom: 8px;">Transaksi yang telah dikonfirmasi dan diproses bersifat final dan tidak dapat dibatalkan.</li>
                <li>Pengguna wajib memastikan informasi akun game yang diinput sudah benar sebelum menyelesaikan transaksi.</li>
            </ul>

            <h2 style="color: #fff; font-size: 18px; font-weight: 700; margin-bottom: 12px;">5. Penggunaan yang Dilarang</h2>
            <p style="margin-bottom: 12px;">Pengguna dilarang untuk:</p>
            <ul style="padding-left: 20px; margin-bottom: 24px;">
                <li style="margin-bottom: 8px;">Menggunakan layanan untuk tujuan ilegal atau penipuan.</li>
                <li style="margin-bottom: 8px;">Melakukan manipulasi harga, eksploitasi bug, atau tindakan curang lainnya.</li>
                <li style="margin-bottom: 8px;">Menjual kembali produk yang dibeli tanpa izin tertulis dari RPLShop.</li>
                <li>Mengganggu sistem keamanan dan operasional platform.</li>
            </ul>

            <h2 style="color: #fff; font-size: 18px; font-weight: 700; margin-bottom: 12px;">6. Pembatasan Tanggung Jawab</h2>
            <p style="margin-bottom: 24px;">RPLShop tidak bertanggung jawab atas kerugian yang timbul akibat kesalahan input data oleh pengguna, gangguan pada pihak ketiga (penyedia game, payment gateway), atau kejadian force majeure di luar kendali kami.</p>

            <h2 style="color: #fff; font-size: 18px; font-weight: 700; margin-bottom: 12px;">7. Perubahan Syarat</h2>
            <p style="margin-bottom: 24px;">RPLShop berhak mengubah syarat penggunaan ini kapan saja. Perubahan akan diumumkan melalui situs web dan berlaku efektif sejak tanggal publikasi. Pengguna disarankan untuk memeriksa halaman ini secara berkala.</p>

            <h2 style="color: #fff; font-size: 18px; font-weight: 700; margin-bottom: 12px;">8. Kontak</h2>
            <p>Jika Anda memiliki pertanyaan mengenai syarat penggunaan ini, silakan hubungi tim kami melalui email di <a href="mailto:support@rplshop.local" style="color: #FFC400; text-decoration: none;">support@rplshop.local</a>.</p>

        </div>

    </div>
</div>

<?php
include __DIR__ . '/../includes/footer.php';
?>
