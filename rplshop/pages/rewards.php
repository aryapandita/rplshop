<?php
// pages/rewards.php - RPLSHOP Rewards
$path_prefix = '../';
$page_title = 'RPLSHOP Rewards - RPLShop';

require_once __DIR__ . '/../includes/functions.php';
include __DIR__ . '/../includes/header.php';
?>

<div style="min-height: 80vh; background: linear-gradient(180deg, #101827 0%, #0f172a 100%); padding: 60px 0;">
    <div class="inner" style="max-width: 900px; margin: 0 auto; padding: 0 20px;">

        <!-- Hero -->
        <div style="text-align: center; margin-bottom: 50px;">
            <span icon="stars" style="font-size: 56px; color: #FFC400; display: block; margin-bottom: 14px;"></span>
            <h1 style="color: #fff; font-size: 32px; font-weight: 800; margin-bottom: 10px;">RPLSHOP <span style="color: #FFC400;">Rewards</span></h1>
            <p style="color: #94a3b8; font-size: 15px; max-width: 550px; margin: 0 auto; line-height: 1.6;">
                Dapatkan poin reward, kupon eksklusif, dan penawaran spesial setiap kali Anda bertransaksi di RPLShop.
            </p>
        </div>

        <!-- How It Works -->
        <div style="background: rgba(30, 41, 59, 0.5); border-radius: 16px; border: 1px solid rgba(255,255,255,0.06); padding: 35px 30px; margin-bottom: 30px;">
            <h2 style="color: #fff; font-size: 20px; font-weight: 700; margin-bottom: 25px; text-align: center;">Cara Kerja Rewards</h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 24px;">

                <div style="text-align: center;">
                    <div style="width: 56px; height: 56px; border-radius: 50%; background: rgba(255, 196, 0, 0.1); border: 2px solid rgba(255, 196, 0, 0.3); display: flex; align-items: center; justify-content: center; margin: 0 auto 14px auto;">
                        <span icon="shopping_bag" style="font-size: 24px; color: #FFC400;"></span>
                    </div>
                    <h3 style="color: #fff; font-size: 15px; font-weight: 700; margin-bottom: 6px;">1. Belanja</h3>
                    <p style="color: #94a3b8; font-size: 13px; line-height: 1.5;">Lakukan pembelian produk apapun di RPLShop.</p>
                </div>

                <div style="text-align: center;">
                    <div style="width: 56px; height: 56px; border-radius: 50%; background: rgba(16, 185, 129, 0.1); border: 2px solid rgba(16, 185, 129, 0.3); display: flex; align-items: center; justify-content: center; margin: 0 auto 14px auto;">
                        <span icon="toll" style="font-size: 24px; color: #10b981;"></span>
                    </div>
                    <h3 style="color: #fff; font-size: 15px; font-weight: 700; margin-bottom: 6px;">2. Kumpulkan Poin</h3>
                    <p style="color: #94a3b8; font-size: 13px; line-height: 1.5;">Dapatkan 1 poin untuk setiap Rp 1.000 belanja Anda.</p>
                </div>

                <div style="text-align: center;">
                    <div style="width: 56px; height: 56px; border-radius: 50%; background: rgba(59, 130, 246, 0.1); border: 2px solid rgba(59, 130, 246, 0.3); display: flex; align-items: center; justify-content: center; margin: 0 auto 14px auto;">
                        <span icon="redeem" style="font-size: 24px; color: #3b82f6;"></span>
                    </div>
                    <h3 style="color: #fff; font-size: 15px; font-weight: 700; margin-bottom: 6px;">3. Tukar Hadiah</h3>
                    <p style="color: #94a3b8; font-size: 13px; line-height: 1.5;">Tukar poin dengan kupon diskon dan voucher eksklusif.</p>
                </div>

            </div>
        </div>

        <!-- Available Rewards -->
        <h2 style="color: #fff; font-size: 20px; font-weight: 700; margin-bottom: 20px;">Kupon yang Tersedia</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 18px; margin-bottom: 40px;">

            <div style="background: linear-gradient(135deg, rgba(255, 196, 0, 0.08), rgba(255, 196, 0, 0.02)); border: 1px solid rgba(255, 196, 0, 0.2); border-radius: 14px; padding: 25px 20px; position: relative; overflow: hidden;">
                <div style="position: absolute; top: -20px; right: -20px; width: 80px; height: 80px; border-radius: 50%; background: rgba(255, 196, 0, 0.06);"></div>
                <div style="font-size: 28px; font-weight: 800; color: #FFC400; margin-bottom: 6px;">10% OFF</div>
                <div style="color: #fff; font-size: 15px; font-weight: 600; margin-bottom: 4px;">Kupon Diskon Game Top-Up</div>
                <div style="color: #94a3b8; font-size: 12px; margin-bottom: 16px;">Berlaku untuk semua produk top-up game</div>
                <div style="display: flex; align-items: center; justify-content: space-between;">
                    <span style="color: #64748b; font-size: 12px;">Kode: <strong style="color: #FFC400;">TOPUP10</strong></span>
                    <a href="products.php?category=mobile-game-topup" class="btw" color="theme" style="padding: 7px 16px; font-size: 12px; border-radius: 6px; text-decoration: none;">
                        <span>Gunakan</span>
                    </a>
                </div>
            </div>

            <div style="background: linear-gradient(135deg, rgba(168, 85, 247, 0.08), rgba(168, 85, 247, 0.02)); border: 1px solid rgba(168, 85, 247, 0.2); border-radius: 14px; padding: 25px 20px; position: relative; overflow: hidden;">
                <div style="position: absolute; top: -20px; right: -20px; width: 80px; height: 80px; border-radius: 50%; background: rgba(168, 85, 247, 0.06);"></div>
                <div style="font-size: 28px; font-weight: 800; color: #a855f7; margin-bottom: 6px;">15% OFF</div>
                <div style="color: #fff; font-size: 15px; font-weight: 600; margin-bottom: 4px;">Kupon Diskon Gift Card</div>
                <div style="color: #94a3b8; font-size: 12px; margin-bottom: 16px;">Berlaku untuk semua produk gift card</div>
                <div style="display: flex; align-items: center; justify-content: space-between;">
                    <span style="color: #64748b; font-size: 12px;">Kode: <strong style="color: #a855f7;">GIFT15</strong></span>
                    <a href="products.php?category=gift-cards" class="btw" color="theme" style="padding: 7px 16px; font-size: 12px; border-radius: 6px; text-decoration: none;">
                        <span>Gunakan</span>
                    </a>
                </div>
            </div>

            <div style="background: linear-gradient(135deg, rgba(16, 185, 129, 0.08), rgba(16, 185, 129, 0.02)); border: 1px solid rgba(16, 185, 129, 0.2); border-radius: 14px; padding: 25px 20px; position: relative; overflow: hidden;">
                <div style="position: absolute; top: -20px; right: -20px; width: 80px; height: 80px; border-radius: 50%; background: rgba(16, 185, 129, 0.06);"></div>
                <div style="font-size: 28px; font-weight: 800; color: #10b981; margin-bottom: 6px;">Rp 20K</div>
                <div style="color: #fff; font-size: 15px; font-weight: 600; margin-bottom: 4px;">Potongan Langsung</div>
                <div style="color: #94a3b8; font-size: 12px; margin-bottom: 16px;">Min. belanja Rp 100.000</div>
                <div style="display: flex; align-items: center; justify-content: space-between;">
                    <span style="color: #64748b; font-size: 12px;">Kode: <strong style="color: #10b981;">HEMAT20K</strong></span>
                    <a href="products.php" class="btw" color="theme" style="padding: 7px 16px; font-size: 12px; border-radius: 6px; text-decoration: none;">
                        <span>Gunakan</span>
                    </a>
                </div>
            </div>

        </div>

        <!-- Member Tiers -->
        <div style="background: rgba(30, 41, 59, 0.5); border-radius: 16px; border: 1px solid rgba(255,255,255,0.06); padding: 35px 30px; margin-bottom: 30px;">
            <h2 style="color: #fff; font-size: 20px; font-weight: 700; margin-bottom: 25px; text-align: center;">Level Member</h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 18px;">

                <div style="text-align: center; padding: 25px 15px; border-radius: 12px; border: 1px solid rgba(148, 163, 184, 0.2); background: rgba(148, 163, 184, 0.04);">
                    <div style="font-size: 32px; margin-bottom: 8px;">🥉</div>
                    <h3 style="color: #94a3b8; font-size: 16px; font-weight: 700; margin-bottom: 6px;">Bronze</h3>
                    <p style="color: #64748b; font-size: 12px; line-height: 1.5;">0 - 999 poin<br>Bonus reward 1x</p>
                </div>

                <div style="text-align: center; padding: 25px 15px; border-radius: 12px; border: 1px solid rgba(255, 196, 0, 0.3); background: rgba(255, 196, 0, 0.04);">
                    <div style="font-size: 32px; margin-bottom: 8px;">🥈</div>
                    <h3 style="color: #FFC400; font-size: 16px; font-weight: 700; margin-bottom: 6px;">Silver</h3>
                    <p style="color: #64748b; font-size: 12px; line-height: 1.5;">1.000 - 4.999 poin<br>Bonus reward 1.5x</p>
                </div>

                <div style="text-align: center; padding: 25px 15px; border-radius: 12px; border: 1px solid rgba(251, 191, 36, 0.4); background: rgba(251, 191, 36, 0.06);">
                    <div style="font-size: 32px; margin-bottom: 8px;">🥇</div>
                    <h3 style="color: #fbbf24; font-size: 16px; font-weight: 700; margin-bottom: 6px;">Gold</h3>
                    <p style="color: #64748b; font-size: 12px; line-height: 1.5;">5.000+ poin<br>Bonus reward 2x</p>
                </div>

            </div>
        </div>

        <!-- CTA -->
        <div style="text-align: center;">
            <a href="products.php" class="btw" color="theme" style="padding: 14px 35px; border-radius: 8px; font-weight: bold; font-size: 15px; display: inline-block; text-decoration: none;">
                <span icon="shopping_bag">Mulai Kumpulkan Poin</span>
            </a>
        </div>

    </div>
</div>

<?php
include __DIR__ . '/../includes/footer.php';
?>
