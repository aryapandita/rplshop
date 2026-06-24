<?php
// pages/privacy.php - Kebijakan Privasi
$path_prefix = '../';
$page_title = 'Kebijakan Privasi - RPLShop';

require_once __DIR__ . '/../includes/functions.php';
include __DIR__ . '/../includes/header.php';
?>

<div style="min-height: 80vh; background: linear-gradient(180deg, #101827 0%, #0f172a 100%); padding: 60px 0;">
    <div class="inner" style="max-width: 800px; margin: 0 auto; padding: 0 20px;">

        <!-- Header -->
        <div style="margin-bottom: 40px; border-bottom: 1px solid rgba(255,255,255,0.06); padding-bottom: 25px;">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 10px;">
                <span icon="shield" style="font-size: 32px; color: #FFC400;"></span>
                <h1 style="color: #fff; font-size: 28px; font-weight: 800;">Kebijakan Privasi</h1>
            </div>
            <p style="color: #64748b; font-size: 13px;">Terakhir diperbarui: 20 Juni 2026</p>
        </div>

        <!-- Content -->
        <div style="background: rgba(30, 41, 59, 0.5); border-radius: 14px; border: 1px solid rgba(255,255,255,0.06); padding: 35px 30px; color: #cbd5e1; font-size: 15px; line-height: 1.8;">

            <p style="margin-bottom: 24px;">RPLShop berkomitmen untuk melindungi privasi dan keamanan data pribadi Anda. Kebijakan ini menjelaskan bagaimana kami mengumpulkan, menggunakan, dan melindungi informasi Anda ketika menggunakan layanan kami.</p>

            <h2 style="color: #fff; font-size: 18px; font-weight: 700; margin-bottom: 12px;">1. Data yang Kami Kumpulkan</h2>
            <p style="margin-bottom: 12px;">Kami mengumpulkan informasi berikut saat Anda menggunakan layanan RPLShop:</p>
            <ul style="padding-left: 20px; margin-bottom: 24px;">
                <li style="margin-bottom: 8px;"><strong style="color: #fff;">Informasi Akun:</strong> Username, alamat email, nama lengkap, dan password terenkripsi.</li>
                <li style="margin-bottom: 8px;"><strong style="color: #fff;">Informasi Transaksi:</strong> Detail pembelian, metode pembayaran, dan riwayat order.</li>
                <li style="margin-bottom: 8px;"><strong style="color: #fff;">Informasi Game:</strong> ID akun game dan data terkait yang diperlukan untuk top-up.</li>
                <li><strong style="color: #fff;">Data Teknis:</strong> Alamat IP, jenis browser, dan informasi perangkat untuk keamanan.</li>
            </ul>

            <h2 style="color: #fff; font-size: 18px; font-weight: 700; margin-bottom: 12px;">2. Penggunaan Data</h2>
            <p style="margin-bottom: 12px;">Data Anda digunakan untuk:</p>
            <ul style="padding-left: 20px; margin-bottom: 24px;">
                <li style="margin-bottom: 8px;">Memproses dan menyelesaikan transaksi pembelian Anda.</li>
                <li style="margin-bottom: 8px;">Mengirimkan konfirmasi pesanan dan informasi terkait transaksi.</li>
                <li style="margin-bottom: 8px;">Meningkatkan kualitas layanan dan pengalaman pengguna.</li>
                <li style="margin-bottom: 8px;">Mendeteksi dan mencegah aktivitas penipuan atau penyalahgunaan.</li>
                <li>Mengirimkan informasi promo dan penawaran khusus (dengan persetujuan Anda).</li>
            </ul>

            <h2 style="color: #fff; font-size: 18px; font-weight: 700; margin-bottom: 12px;">3. Keamanan Data</h2>
            <div style="background: rgba(16, 185, 129, 0.08); border: 1px solid rgba(16, 185, 129, 0.2); border-radius: 10px; padding: 18px 20px; margin-bottom: 24px;">
                <p style="margin: 0;">Kami menerapkan standar keamanan tinggi untuk melindungi data Anda, termasuk:</p>
                <ul style="padding-left: 20px; margin-top: 10px; margin-bottom: 0;">
                    <li style="margin-bottom: 6px;">Enkripsi password menggunakan algoritma bcrypt.</li>
                    <li style="margin-bottom: 6px;">Perlindungan terhadap serangan SQL injection dan XSS.</li>
                    <li>Akses data dibatasi hanya untuk pihak yang berwenang.</li>
                </ul>
            </div>

            <h2 style="color: #fff; font-size: 18px; font-weight: 700; margin-bottom: 12px;">4. Berbagi Data dengan Pihak Ketiga</h2>
            <p style="margin-bottom: 24px;">Kami <strong style="color: #fff;">tidak menjual</strong> data pribadi Anda kepada pihak ketiga. Data hanya dibagikan kepada pihak ketiga yang diperlukan untuk memproses transaksi (misalnya, payment gateway) dan sesuai dengan kewajiban hukum yang berlaku.</p>

            <h2 style="color: #fff; font-size: 18px; font-weight: 700; margin-bottom: 12px;">5. Cookie & Penyimpanan Lokal</h2>
            <p style="margin-bottom: 24px;">RPLShop menggunakan cookie dan localStorage untuk menyimpan preferensi pengguna, status login, dan data kupon. Anda dapat menghapus data ini melalui pengaturan browser Anda kapan saja.</p>

            <h2 style="color: #fff; font-size: 18px; font-weight: 700; margin-bottom: 12px;">6. Hak Pengguna</h2>
            <ul style="padding-left: 20px; margin-bottom: 24px;">
                <li style="margin-bottom: 8px;">Anda berhak mengakses dan memperbarui data pribadi Anda melalui pengaturan akun.</li>
                <li style="margin-bottom: 8px;">Anda berhak meminta penghapusan akun dan data pribadi Anda.</li>
                <li>Anda berhak menolak penerimaan email promosi dari kami.</li>
            </ul>

            <h2 style="color: #fff; font-size: 18px; font-weight: 700; margin-bottom: 12px;">7. Perubahan Kebijakan</h2>
            <p style="margin-bottom: 24px;">Kebijakan privasi ini dapat diperbarui sewaktu-waktu. Perubahan signifikan akan diberitahukan melalui email atau pemberitahuan di situs web kami.</p>

            <h2 style="color: #fff; font-size: 18px; font-weight: 700; margin-bottom: 12px;">8. Kontak</h2>
            <p>Untuk pertanyaan terkait kebijakan privasi, hubungi kami di <a href="mailto:support@rplshop.local" style="color: #FFC400; text-decoration: none;">support@rplshop.local</a>.</p>

        </div>

    </div>
</div>

<?php
include __DIR__ . '/../includes/footer.php';
?>
