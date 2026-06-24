<?php
// index.php - RPLShop Homepage
$path_prefix = '';
$page_title = 'RPLShop - Game Top-Up, Gift Card & Voucher | Game Credits | Mobile Games';

require_once __DIR__ . '/includes/functions.php';

// Add extra CSS file for homepage
$extra_css = ['home-af890912ab.css', 'coupon-1ff5107c71.css'];

include __DIR__ . '/includes/header.php';

// Fetch dynamic products for sections
// 1. Exclusive Offers (Products with packages having discounts)
$stmt = $pdo->query("SELECT p.*, pp.name as package_name, pp.price, pp.discount_percent, pp.id as package_id 
                     FROM products p 
                     JOIN product_packages pp ON p.id = pp.product_id 
                     WHERE pp.discount_percent > 0 
                     ORDER BY pp.discount_percent DESC 
                     LIMIT 10");
$special_deals = $stmt->fetchAll();

// 2. Popular Games (Category id 5, 6, 10, 11)
$popular_games = get_products($pdo, 'game', null, 6);

// 3. Popular Game Cards (Category id 7, 8, 9)
$popular_cards = get_products($pdo, 'card', null, 6);

// 4. Popular Game Top-Up (Category id 10, 11, 12, 5)
$popular_topups = get_products($pdo, 'direct-topup', null, 6);

// 5. Popular Mobile Recharge (Category id 4)
$popular_recharges = get_products($pdo, 'mobile-recharge', null, 6);

// 6. Specific products for featured sections
$featured_ml = get_product_by_slug($pdo, 'mobile-legends-diamonds');
$featured_steam = get_product_by_slug($pdo, 'steam-wallet-code-idr');
$featured_razer = get_product_by_slug($pdo, 'razer-gold-idr');
?>

<!-- Load swiper stylesheet & script -->
<link rel="preload" as="style" href="assets/css/swiper-bundle-fcf7ee058b.min.css">
<link rel="stylesheet" href="assets/css/swiper-bundle-fcf7ee058b.min.css">
<script src="assets/js/swiper-bundle-fcf7ee058b.min.js"></script>
<style>
    #home_cover {
        background:
            radial-gradient(circle at 18% 10%, rgba(255, 196, 0, .12), transparent 30%),
            linear-gradient(180deg, #101827 0%, #0f172a 100%);
        padding-bottom: 24px;
    }

    #home_cover .inner,
    #home_items .inner,
    #home_news .inner,
    #home_card_hot .inner {
        max-width: 1180px;
    }

    #home_slider {
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 18px 50px rgba(0, 0, 0, .22);
    }

    #home_slider .list {
        align-items: stretch;
    }

    #home_slider .slide {
        width: 100% !important;
        max-width: none !important;
        padding-inline: 0 !important;
        opacity: 1 !important;
        filter: none !important;
    }

    #home_slider .slide .img {
        width: 100% !important;
        max-width: none !important;
        border-radius: 8px !important;
        aspect-ratio: 1000 / 360 !important;
        background: #0b1220;
    }

    #home_slider .slide picture,
    #home_slider .slide img {
        display: block;
        width: 100%;
        height: 100%;
    }

    #home_slider .slide img {
        object-fit: contain !important;
        object-position: center;
    }

    .rpl-empty-media {
        width: 100%;
        height: 100%;
        min-height: inherit;
        border: 1px dashed rgba(255, 255, 255, .18);
        border-radius: inherit;
        background:
            linear-gradient(135deg, rgba(255, 255, 255, .04), rgba(255, 255, 255, .01)),
            #111827;
    }

    #home_slider .rpl-empty-media {
        aspect-ratio: 1000 / 360;
    }

    .img .rpl-empty-media,
    .art .rpl-empty-media {
        min-width: 54px;
        min-height: 54px;
    }

    .NewsList .img .rpl-empty-media {
        aspect-ratio: 2 / 1;
        min-height: 120px;
    }

    #home_slider .swiper-pagination-bullet {
        width: 28px;
        height: 6px;
        border-radius: 999px;
        background: rgba(255, 255, 255, .45);
        opacity: 1;
        transition: width .2s ease, background .2s ease;
    }

    #home_slider .swiper-pagination-bullet-active {
        width: 48px;
        background: #ffc400;
    }

    #special_deals,
    #new_coupons,
    #featured_items .category,
    #news_promotion,
    #card_hot {
        border: 1px solid rgba(255, 255, 255, .07);
        border-radius: 8px;
        background: rgba(15, 23, 42, .68);
        box-shadow: 0 12px 32px rgba(0, 0, 0, .14);
    }

    /* Beri jarak dalam agar konten tidak mepet/mentok ke tepi box */
    #special_deals {
        padding: 1.75em 1.5em;
        box-sizing: border-box;
    }

    #new_coupons {
        padding: 1.5em 1.25em;
        box-sizing: border-box;
    }

    #new_coupons .list {
        padding-block-start: 0.75em;
    }

    /* Coupon card spacing */
    #new_coupons .coupon {
        padding: 14px 16px;
        border-radius: 10px;
        background: #fff;
        border: 1px solid rgba(0, 0, 0, .06);
        transition: transform .2s ease, box-shadow .2s ease;
        min-width: 160px;
        display: flex;
        flex-direction: column;
        gap: 10px;
        box-shadow: 0 1px 2px rgba(0, 0, 0, .04);
    }

    #new_coupons .coupon:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, .08);
    }

    #new_coupons .coupon .title {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
    }

    #new_coupons .coupon .value {
        display: flex;
        flex-direction: column;
        line-height: 1.1;
    }

    #new_coupons .coupon .num {
        font-size: 22px;
        font-weight: 800;
        color: #111;
        letter-spacing: -0.3px;
    }

    #new_coupons .coupon .unit {
        font-size: 11px;
        font-weight: 600;
        color: #666;
        letter-spacing: 0.3px;
        text-transform: uppercase;
    }

    #new_coupons .coupon .stat {
        flex-shrink: 0;
    }

    #new_coupons .coupon .fetch_coupon {
        border-radius: 6px;
        padding: 5px 12px;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 0.3px;
        text-transform: uppercase;
        white-space: nowrap;
    }

    #new_coupons .coupon .func {
        padding-block-start: 2px;
    }

    #new_coupons .coupon .name {
        font-size: 13px;
        color: #cbd5e1;
        line-height: 1.3;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    #special_deals .list {
        padding-block-start: 1em;
    }

    @media only screen and (max-width: 1000px) {
        #special_deals {
            padding: 1.5em 1.1em;
        }
    }


    #special_deals .title,
    #new_coupons .title,
    #featured_items .category > .title,
    #news_promotion > .title {
        align-items: center;
    }

    .rpl-quick-actions {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 12px;
        margin: 18px 0 8px;
    }

    .rpl-quick-actions a {
        display: flex;
        align-items: center;
        gap: 12px;
        min-height: 64px;
        padding: 14px 16px;
        border: 1px solid rgba(255, 255, 255, .08);
        border-radius: 8px;
        background: rgba(255, 255, 255, .045);
        color: #fff;
        text-decoration: none;
        transition: transform .2s ease, border-color .2s ease, background .2s ease;
    }

    .rpl-quick-actions a:hover {
        transform: translateY(-2px);
        border-color: rgba(255, 196, 0, .45);
        background: rgba(255, 196, 0, .08);
    }

    .rpl-quick-actions b {
        display: block;
        font-size: 14px;
        line-height: 1.2;
    }

    .rpl-quick-actions small {
        display: block;
        margin-top: 3px;
        color: #94a3b8;
        font-size: 12px;
    }

    .rpl-quick-actions span[icon] {
        color: #ffc400;
        font-size: 24px;
    }

    #new_coupons .coupon.is-claimed {
        opacity: .68;
    }

    #new_coupons .coupon.is-claimed .fetch_coupon span {
        color: #10b981;
    }

    #home_news .NewsList .news,
    #card_hot .category,
    #featured_items .ItemLink {
        transition: transform .18s ease, border-color .18s ease;
    }

    #home_news .NewsList .news:hover,
    #card_hot .category:hover,
    #featured_items .ItemLink:hover {
        transform: translateY(-2px);
    }

    @media (max-width: 760px) {
        .rpl-quick-actions {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 480px) {
        .rpl-quick-actions {
            grid-template-columns: 1fr;
        }
    }
</style>

<div id="home_cover">
    <div class="inner">
        <!-- Hero Swiper Slider -->
        <div id="home_slider" class="swiper-container">
            <div class="list swiper-wrapper">
                <div class="slide swiper-slide">
                    <a class="img" href="pages/product-detail.php?slug=mobile-legends-diamonds" title="All Star Tidal Treasure Event">
                        <?php if ($featured_ml): ?>
                            <img src="<?= $path_prefix . htmlspecialchars(resolve_product_image_url($featured_ml)) ?>" alt="Mobile Legends" style="width:100%;height:100%;object-fit:cover;object-position:center;">
                        <?php else: ?>
                            <div class="rpl-empty-media" style="width:100%;height:100%;min-height:200px;"></div>
                        <?php endif; ?>
                    </a>
                </div>
                <div class="slide swiper-slide">
                    <a class="img" href="pages/products.php?category=game" title="New Game Launch">
                        <div class="rpl-empty-media" style="width:100%;height:100%;min-height:200px;"></div>
                    </a>
                </div>
                <div class="slide swiper-slide">
                    <a class="img" href="pages/products.php?category=mobile-game-topup" title="Top-Up Mobile Game">
                        <div class="rpl-empty-media" style="width:100%;height:100%;min-height:200px;"></div>
                    </a>
                </div>
                <div class="slide swiper-slide">
                    <a class="img" href="#special_deals" title="June 2026 Coupon Deals">
                        <div class="rpl-empty-media" style="width:100%;height:100%;min-height:200px;"></div>
                    </a>
                </div>
            </div>
            <div class="pagination swiper-pagination"></div>
            <div class="navigation">
                <div class="nav prev" icon="chevron_left"></div>
                <div class="nav next" icon="chevron_right"></div>
            </div>
        </div>
        
        <div id="home_slider_bg" class="swiper-container" style="display:none;">
            <div class="list swiper-wrapper">
                <div class="bg swiper-slide" data-hue="2d3a4d"></div>
                <div class="bg swiper-slide" data-hue="26201e"></div>
                <div class="bg swiper-slide" data-hue="4887d3"></div>
                <div class="bg swiper-slide" data-hue="d6954e"></div>
            </div>
        </div>

        <div class="rpl-quick-actions" aria-label="Navigasi cepat">
            <a href="pages/products.php?category=mobile-game-topup">
                <span icon="offline_bolt"></span>
                <span><b>Top-Up Game</b><small>Diamond, UC, VP instan</small></span>
            </a>
            <a href="pages/products.php?category=game-cards">
                <span icon="credit_card"></span>
                <span><b>Game Cards</b><small>Steam, Garena, Razer</small></span>
            </a>
            <a href="pages/products.php?category=gift-cards">
                <span icon="redeem"></span>
                <span><b>Gift Cards</b><small>Voucher digital resmi</small></span>
            </a>
            <a href="pages/search.php?keywords=Mobile+Legends">
                <span icon="search"></span>
                <span><b>Cari Cepat</b><small>Temukan produk populer</small></span>
            </a>
        </div>

        <!-- Exclusive Offers (Special Deals) Swiper Grid -->
        <div id="special_deals" class="swiper-container">
            <div class="title">
                <div>
                    <h3>Exclusive Offers</h3>
                    <p>Don't miss our limited-time offers! Discover current deals today!</p>
                </div>
                <a href="pages/products.php" class="btw more" color="black" title="View more"><span>View more</span></a>
            </div>
            <div class="list swiper-wrapper">
                <?php foreach ($special_deals as $deal): ?>
                    <a class="specialdeals swiper-slide" href="pages/product-detail.php?slug=<?= $deal['slug'] ?>&package_id=<?= $deal['package_id'] ?>" title="<?= htmlspecialchars($deal['name']) ?>">
                        <div class="item" data-hue="40505c">
                            <div class="img">
                                <img src="<?= $path_prefix . htmlspecialchars(resolve_product_image_url($deal)) ?>" alt="<?= htmlspecialchars($deal['name']) ?>" style="width:100%;height:100%;object-fit:cover;">
                            </div>
                            <div class="T">
                                <div class="sku"><?= htmlspecialchars($deal['package_name']) ?></div>
                                <div class="name"><?= htmlspecialchars($deal['name']) ?></div>
                            </div>
                        </div>
                        <div class="promo">
                            <div class="rate">Promo</div>
                            <div class="price"><b>-<?= number_format($deal['discount_percent'], 0) ?>%</b></div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Available Coupons Mockup -->
        <div id="new_coupons" class="swiper-container">
            <div class="title">
                <div>
                    <h3>Available Coupons</h3>
                    <p>Claim your coupon now for extra savings! Do not miss out!</p>
                </div>
            </div>
            <div class="list swiper-wrapper">
                <a class="coupon swiper-slide" href="pages/products.php?category=mobile-game-topup" data-coupon-code="TOPUP10">
                    <div class="title">
                        <div class="value">
                            <span class="num">10%</span><span class="unit">OFF</span>
                        </div>
                        <div class="stat">
                            <div class="btw fetch_coupon"><span>Claim</span></div>
                        </div>
                    </div>
                    <div class="func">
                        <div class="name">Kupon Diskon Game Top-Up 10%</div>
                    </div>
                </a>
                <a class="coupon swiper-slide" href="pages/products.php?category=gift-cards" data-coupon-code="GIFT15">
                    <div class="title">
                        <div class="value">
                            <span class="num">15%</span><span class="unit">OFF</span>
                        </div>
                        <div class="stat">
                            <div class="btw fetch_coupon"><span>Claim</span></div>
                        </div>
                    </div>
                    <div class="func">
                        <div class="name">Kupon Diskon Gift Card 15%</div>
                    </div>
                </a>
                <a class="coupon swiper-slide" href="pages/products.php" data-coupon-code="HEMAT20K">
                    <div class="title">
                        <div class="value">
                            <span class="num">Rp 20K</span><span class="unit">POTONGAN</span>
                        </div>
                        <div class="stat">
                            <div class="btw fetch_coupon"><span>Claim</span></div>
                        </div>
                    </div>
                    <div class="func">
                        <div class="name">Potongan Langsung Belanja Rp 20.000</div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<div id="home_items">
    <div class="inner">
        <div id="featured_items">
            <div class="list">
                <!-- Popular Games Grid -->
                <div class="category">
                    <div class="title">
                        <h3>Popular Games</h3>
                        <a href="pages/products.php?category=game" class="btw more" color="transparent"><span icon="chevron_right">View more</span></a>
                    </div>
                    <div class="ItemList">
                        <?php foreach ($popular_games as $prod): ?>
                            <a class="ItemLink" href="pages/product-detail.php?slug=<?= $prod['slug'] ?>" title="<?= htmlspecialchars($prod['name']) ?>">
                                <div class="img">
                                    <img src="<?= $path_prefix . htmlspecialchars(resolve_product_image_url($prod)) ?>" alt="<?= htmlspecialchars($prod['name']) ?>" style="width:100%; height:100%; object-fit:cover; border-radius:inherit;" loading="lazy">
                                </div>
                                <div class="T">
                                    <div class="name"><?= htmlspecialchars($prod['name']) ?></div>
                                    <div class="info"><span><?= htmlspecialchars($prod['region']) ?></span></div>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Popular Game Cards Grid -->
                <div class="category">
                    <div class="title">
                        <h3>Popular Game Card</h3>
                        <a href="pages/products.php?category=card" class="btw more" color="transparent"><span icon="chevron_right">View more</span></a>
                    </div>
                    <div class="ItemList">
                        <?php foreach ($popular_cards as $prod): ?>
                            <a class="ItemLink" href="pages/product-detail.php?slug=<?= $prod['slug'] ?>" title="<?= htmlspecialchars($prod['name']) ?>">
                                <div class="img">
                                    <img src="<?= $path_prefix . htmlspecialchars(resolve_product_image_url($prod)) ?>" alt="<?= htmlspecialchars($prod['name']) ?>" style="width:100%; height:100%; object-fit:cover; border-radius:inherit;" loading="lazy">
                                </div>
                                <div class="T">
                                    <div class="name"><?= htmlspecialchars($prod['name']) ?></div>
                                    <div class="info"><span><?= htmlspecialchars($prod['region']) ?></span></div>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Popular Game Top-Up Grid -->
                <div class="category">
                    <div class="title">
                        <h3>Popular Game Top-Up</h3>
                        <a href="pages/products.php?category=direct-topup" class="btw more" color="transparent"><span icon="chevron_right">View more</span></a>
                    </div>
                    <div class="ItemList">
                        <?php foreach ($popular_topups as $prod): ?>
                            <a class="ItemLink" href="pages/product-detail.php?slug=<?= $prod['slug'] ?>" title="<?= htmlspecialchars($prod['name']) ?>">
                                <div class="img">
                                    <img src="<?= $path_prefix . htmlspecialchars(resolve_product_image_url($prod)) ?>" alt="<?= htmlspecialchars($prod['name']) ?>" style="width:100%; height:100%; object-fit:cover; border-radius:inherit;" loading="lazy">
                                </div>
                                <div class="T">
                                    <div class="name"><?= htmlspecialchars($prod['name']) ?></div>
                                    <div class="info"><span><?= htmlspecialchars($prod['region']) ?></span></div>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Popular Mobile Recharge Grid -->
                <div class="category">
                    <div class="title">
                        <h3>Popular Mobile Recharge</h3>
                        <a href="pages/products.php?category=mobile-recharge" class="btw more" color="transparent"><span icon="chevron_right">View more</span></a>
                    </div>
                    <div class="ItemList">
                        <?php foreach ($popular_recharges as $prod): ?>
                            <a class="ItemLink" href="pages/product-detail.php?slug=<?= $prod['slug'] ?>" title="<?= htmlspecialchars($prod['name']) ?>">
                                <div class="img">
                                    <img src="<?= $path_prefix . htmlspecialchars(resolve_product_image_url($prod)) ?>" alt="<?= htmlspecialchars($prod['name']) ?>" style="width:100%; height:100%; object-fit:cover; border-radius:inherit;" loading="lazy">
                                </div>
                                <div class="T">
                                    <div class="name"><?= htmlspecialchars($prod['name']) ?></div>
                                    <div class="info"><span><?= htmlspecialchars($prod['region']) ?></span></div>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- News & Promotions Mockup -->
<div id="home_news">
    <div class="inner">
        <div id="news_promotion" style="padding: 24px 24px 28px;">
            <div class="title" style="margin-bottom: 20px;">
                <h3>News & Promotions</h3>
                <div>
                    More gaming news and promotions on <a href="pages/news.php" class="more"><span icon="open_in_new">RPLShop News</span></a>
                </div>
            </div>
            <div class="NewsList" style="gap: 20px;">
                <a class="news" href="pages/products.php" title="Promo Hemat RPLShop">
                    <div class="img" style="border-radius: 8px; overflow: hidden;">
                        <div class="rpl-empty-media" style="width:100%;height:100%;min-height:130px;"></div>
                    </div>
                    <div class="headline" style="padding: 0 2px;">Nikmati Lebih Banyak Hemat Belanja di RPLShop Bulan Juni Ini!</div>
                </a>
                <a class="news" href="pages/product-detail.php?slug=mobile-legends-diamonds" title="Mobile Legends Event">
                    <div class="img" style="border-radius: 8px; overflow: hidden;">
                        <?php if ($featured_ml): ?>
                            <img src="<?= $path_prefix . htmlspecialchars(resolve_product_image_url($featured_ml)) ?>" alt="Mobile Legends" style="width:100%;height:100%;object-fit:cover;">
                        <?php else: ?>
                            <div class="rpl-empty-media" style="width:100%;height:100%;min-height:130px;"></div>
                        <?php endif; ?>
                    </div>
                    <div class="headline" style="padding: 0 2px;">Event Mobile Legends terbaru: top-up Diamonds makin cepat dan hemat.</div>
                </a>
                <a class="news" href="pages/products.php?category=mobile-game-topup" title="Top-Up Mobile Game">
                    <div class="img" style="border-radius: 8px; overflow: hidden;">
                        <div class="rpl-empty-media" style="width:100%;height:100%;min-height:130px;"></div>
                    </div>
                    <div class="headline" style="padding: 0 2px;">Produk top-up mobile game favorit tersedia dengan proses checkout singkat.</div>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Hot Cards / Landing Section Mockup -->
<div id="home_card_hot">
    <div class="inner">
        <div id="card_hot">
            <div class="list">
                <a class="category" href="pages/product-detail.php?slug=steam-wallet-code-idr">
                    <div class="art" style="overflow: hidden; border-radius: 8px; background:#111827;">
                        <?php if ($featured_steam): ?>
                            <img src="<?= $path_prefix . htmlspecialchars(resolve_product_image_url($featured_steam)) ?>" alt="Steam Wallet" style="width:100%;height:100%;object-fit:cover;">
                        <?php else: ?>
                            <div class="rpl-empty-media" style="width:100%;height:100%;min-height:120px;"></div>
                        <?php endif; ?>
                    </div>
                    <div class="headline">
                        <h3>Steam Wallet Code Rp 12.000 - Rp 600.000</h3>
                        <div>Akses ribuan game PC, DLC, dan item market komunitas dengan mengisi saldo akun Steam Wallet Anda hari ini. Pengiriman instan 24 jam!</div>
                    </div>
                </a>
                <a class="category" href="pages/product-detail.php?slug=razer-gold-idr">
                    <div class="art" style="overflow: hidden; border-radius: 8px; background:#111827;">
                        <?php if ($featured_razer): ?>
                            <img src="<?= $path_prefix . htmlspecialchars(resolve_product_image_url($featured_razer)) ?>" alt="Razer Gold" style="width:100%;height:100%;object-fit:cover;">
                        <?php else: ?>
                            <div class="rpl-empty-media" style="width:100%;height:100%;min-height:120px;"></div>
                        <?php endif; ?>
                    </div>
                    <div class="headline">
                        <h3>Razer Gold Indonesia untuk Banyak Game</h3>
                        <div>Isi saldo Razer Gold dan gunakan untuk membeli game, item, serta layanan premium favorit dengan voucher instan digital.</div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        // Initialize Hero Swiper
        const HomeSwiper = new Swiper('#home_slider', {
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: "#home_slider .pagination",
                clickable: true,
            },
            navigation: {
                nextEl: '#home_slider .nav.next',
                prevEl: '#home_slider .nav.prev',
            }
        });

        // Initialize Special Deals Swiper
        const HomeSpecialDeals = new Swiper('#special_deals', {
            slidesPerView: "auto",
            spaceBetween: 12,
            breakpoints: {
                1001: {
                    spaceBetween: 0,
                }
            }
        });

        // Initialize Coupons Swiper
        const HomeNewCoupons = new Swiper('#new_coupons', {
            slidesPerView: "auto",
            spaceBetween: 12,
            breakpoints: {
                1001: {
                    spaceBetween: 0
                }
            }
        });

        $('#new_coupons .coupon').each(function() {
            const code = $(this).data('coupon-code');
            if (localStorage.getItem('rplshop_coupon_' + code) === 'claimed') {
                $(this).addClass('is-claimed').find('.fetch_coupon span').text('Claimed');
            }
        });

        $('#new_coupons .coupon').on('click', function(event) {
            const code = $(this).data('coupon-code');
            if (!code) return;

            if (localStorage.getItem('rplshop_coupon_' + code) !== 'claimed') {
                event.preventDefault();
                localStorage.setItem('rplshop_coupon_' + code, 'claimed');
                $(this).addClass('is-claimed').find('.fetch_coupon span').text('Claimed');
                alert('Kupon ' + code + ' berhasil diklaim. Silakan pilih produk untuk memakai promo.');
            }
        });
    });
</script>

<?php
include __DIR__ . '/includes/footer.php';
?>
