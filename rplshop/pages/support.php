<?php
// pages/support.php - Bantuan & Dukungan
$path_prefix = '../';
$page_title = 'Bantuan & Dukungan - RPLShop';

require_once __DIR__ . '/../includes/functions.php';
include __DIR__ . '/../includes/header.php';
?>

<div style="min-height: 80vh; background: linear-gradient(180deg, #101827 0%, #0f172a 100%); padding: 60px 0;">
    <div class="inner" style="max-width: 900px; margin: 0 auto; padding: 0 20px;">

        <!-- Header -->
        <div style="text-align: center; margin-bottom: 50px;">
            <span icon="contact_support" style="font-size: 56px; color: #FFC400; display: block; margin-bottom: 14px;"></span>
            <h1 style="color: #fff; font-size: 32px; font-weight: 800; margin-bottom: 10px;">Bantuan & Dukungan</h1>
            <p style="color: #94a3b8; font-size: 15px; max-width: 550px; margin: 0 auto; line-height: 1.6;">
                Ada pertanyaan? Kami siap membantu Anda. Cari jawaban dari FAQ atau hubungi tim support kami.
            </p>
        </div>

        <!-- Contact Cards -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 20px; margin-bottom: 50px;">

            <a href="mailto:support@rplshop.local" style="text-decoration: none; background: rgba(30, 41, 59, 0.5); border-radius: 14px; border: 1px solid rgba(255,255,255,0.06); padding: 30px 25px; text-align: center; transition: transform 0.2s, border-color 0.2s;" onmouseover="this.style.transform='translateY(-3px)'; this.style.borderColor='rgba(255,196,0,0.3)';" onmouseout="this.style.transform='none'; this.style.borderColor='rgba(255,255,255,0.06)';">
                <span icon="email" style="font-size: 36px; color: #FFC400; display: block; margin-bottom: 14px;"></span>
                <h3 style="color: #fff; font-size: 16px; font-weight: 700; margin-bottom: 6px;">Email Support</h3>
                <p style="color: #94a3b8; font-size: 13px; margin-bottom: 10px;">Kirim pertanyaan Anda via email</p>
                <span style="color: #FFC400; font-size: 14px; font-weight: 600;">support@rplshop.local</span>
            </a>

            <div style="background: rgba(30, 41, 59, 0.5); border-radius: 14px; border: 1px solid rgba(255,255,255,0.06); padding: 30px 25px; text-align: center;">
                <span icon="schedule" style="font-size: 36px; color: #10b981; display: block; margin-bottom: 14px;"></span>
                <h3 style="color: #fff; font-size: 16px; font-weight: 700; margin-bottom: 6px;">Jam Operasional</h3>
                <p style="color: #94a3b8; font-size: 13px; margin-bottom: 10px;">Layanan customer service</p>
                <span style="color: #10b981; font-size: 14px; font-weight: 600;">24/7 (Setiap Hari)</span>
            </div>

            <div style="background: rgba(30, 41, 59, 0.5); border-radius: 14px; border: 1px solid rgba(255,255,255,0.06); padding: 30px 25px; text-align: center;">
                <span icon="timer" style="font-size: 36px; color: #3b82f6; display: block; margin-bottom: 14px;"></span>
                <h3 style="color: #fff; font-size: 16px; font-weight: 700; margin-bottom: 6px;">Respon Cepat</h3>
                <p style="color: #94a3b8; font-size: 13px; margin-bottom: 10px;">Rata-rata waktu respon</p>
                <span style="color: #3b82f6; font-size: 14px; font-weight: 600;">< 30 Menit</span>
            </div>

        </div>

        <!-- FAQ Section -->
        <div style="background: rgba(30, 41, 59, 0.5); border-radius: 16px; border: 1px solid rgba(255,255,255,0.06); padding: 35px 30px; margin-bottom: 30px;">
            <h2 style="color: #fff; font-size: 22px; font-weight: 700; margin-bottom: 25px; display: flex; align-items: center; gap: 10px;">
                <span icon="help_outline" style="font-size: 26px; color: #FFC400;"></span>
                Pertanyaan yang Sering Diajukan (FAQ)
            </h2>

            <div style="display: flex; flex-direction: column; gap: 16px;">

                <details style="background: rgba(15, 23, 42, 0.5); border: 1px solid rgba(255,255,255,0.05); border-radius: 10px; overflow: hidden;">
                    <summary style="padding: 18px 20px; color: #fff; font-size: 15px; font-weight: 600; cursor: pointer; list-style: none; display: flex; align-items: center; gap: 10px; user-select: none;">
                        <span icon="expand_more" style="font-size: 20px; color: #FFC400; transition: transform 0.2s;"></span>
                        Bagaimana cara melakukan top-up game di RPLShop?
                    </summary>
                    <div style="padding: 0 20px 18px 50px; color: #94a3b8; font-size: 14px; line-height: 1.7;">
                        Pilih produk game yang ingin Anda top-up, masukkan ID akun game Anda, pilih nominal denominasi, lalu selesaikan pembayaran. Kredit game akan otomatis masuk ke akun Anda dalam 1-5 menit.
                    </div>
                </details>

                <details style="background: rgba(15, 23, 42, 0.5); border: 1px solid rgba(255,255,255,0.05); border-radius: 10px; overflow: hidden;">
                    <summary style="padding: 18px 20px; color: #fff; font-size: 15px; font-weight: 600; cursor: pointer; list-style: none; display: flex; align-items: center; gap: 10px; user-select: none;">
                        <span icon="expand_more" style="font-size: 20px; color: #FFC400; transition: transform 0.2s;"></span>
                        Metode pembayaran apa saja yang tersedia?
                    </summary>
                    <div style="padding: 0 20px 18px 50px; color: #94a3b8; font-size: 14px; line-height: 1.7;">
                        RPLShop mendukung pembayaran melalui GoPay, DANA, dan QRIS. QRIS dapat digunakan oleh semua e-wallet dan mobile banking yang mendukung standar QRIS.
                    </div>
                </details>

                <details style="background: rgba(15, 23, 42, 0.5); border: 1px solid rgba(255,255,255,0.05); border-radius: 10px; overflow: hidden;">
                    <summary style="padding: 18px 20px; color: #fff; font-size: 15px; font-weight: 600; cursor: pointer; list-style: none; display: flex; align-items: center; gap: 10px; user-select: none;">
                        <span icon="expand_more" style="font-size: 20px; color: #FFC400; transition: transform 0.2s;"></span>
                        Berapa lama proses pengiriman produk digital?
                    </summary>
                    <div style="padding: 0 20px 18px 50px; color: #94a3b8; font-size: 14px; line-height: 1.7;">
                        Untuk produk direct top-up, pengiriman instan 1-5 menit setelah pembayaran berhasil. Untuk voucher dan gift card, kode akan ditampilkan langsung di halaman transaksi dan dikirim via email.
                    </div>
                </details>

                <details style="background: rgba(15, 23, 42, 0.5); border: 1px solid rgba(255,255,255,0.05); border-radius: 10px; overflow: hidden;">
                    <summary style="padding: 18px 20px; color: #fff; font-size: 15px; font-weight: 600; cursor: pointer; list-style: none; display: flex; align-items: center; gap: 10px; user-select: none;">
                        <span icon="expand_more" style="font-size: 20px; color: #FFC400; transition: transform 0.2s;"></span>
                        Apakah saya bisa mendapatkan refund?
                    </summary>
                    <div style="padding: 0 20px 18px 50px; color: #94a3b8; font-size: 14px; line-height: 1.7;">
                        Karena sifat produk digital, transaksi yang berhasil bersifat final. Namun, jika terjadi kegagalan sistem dari pihak RPLShop, Anda dapat mengajukan refund dengan menghubungi tim support kami. Selengkapnya di halaman <a href="sales-policy.php" style="color: #FFC400; text-decoration: none;">Ketentuan Penjualan</a>.
                    </div>
                </details>

                <details style="background: rgba(15, 23, 42, 0.5); border: 1px solid rgba(255,255,255,0.05); border-radius: 10px; overflow: hidden;">
                    <summary style="padding: 18px 20px; color: #fff; font-size: 15px; font-weight: 600; cursor: pointer; list-style: none; display: flex; align-items: center; gap: 10px; user-select: none;">
                        <span icon="expand_more" style="font-size: 20px; color: #FFC400; transition: transform 0.2s;"></span>
                        Bagaimana cara menggunakan kupon diskon?
                    </summary>
                    <div style="padding: 0 20px 18px 50px; color: #94a3b8; font-size: 14px; line-height: 1.7;">
                        Klaim kupon di halaman <a href="rewards.php" style="color: #FFC400; text-decoration: none;">RPLSHOP Rewards</a> atau di beranda utama. Kupon akan otomatis tersimpan dan dapat digunakan saat checkout pembayaran.
                    </div>
                </details>

                <details style="background: rgba(15, 23, 42, 0.5); border: 1px solid rgba(255,255,255,0.05); border-radius: 10px; overflow: hidden;">
                    <summary style="padding: 18px 20px; color: #fff; font-size: 15px; font-weight: 600; cursor: pointer; list-style: none; display: flex; align-items: center; gap: 10px; user-select: none;">
                        <span icon="expand_more" style="font-size: 20px; color: #FFC400; transition: transform 0.2s;"></span>
                        Apakah produk di RPLShop resmi dan aman?
                    </summary>
                    <div style="padding: 0 20px 18px 50px; color: #94a3b8; font-size: 14px; line-height: 1.7;">
                        Ya, semua produk di RPLShop berasal dari distributor resmi dan legal. Kami menjamin 100% keaslian produk dan keamanan data transaksi Anda.
                    </div>
                </details>

            </div>
        </div>

        <!-- CTA -->
        <div style="text-align: center; color: #94a3b8; font-size: 14px;">
            <p style="margin-bottom: 15px;">Tidak menemukan jawaban yang Anda cari?</p>
            <a href="mailto:support@rplshop.local" class="btw" color="theme" style="padding: 14px 35px; border-radius: 8px; font-weight: bold; font-size: 15px; display: inline-block; text-decoration: none;">
                <span icon="email">Hubungi Kami</span>
            </a>
        </div>

    </div>
</div>

<?php
include __DIR__ . '/../includes/footer.php';
?>
