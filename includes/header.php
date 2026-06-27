<?php
if (!isset($path_prefix)) {
    $path_prefix = '';
}
if (!isset($page_title)) {
    $page_title = 'RPLShop - Game Top-Up, Gift Card & Voucher';
}
require_once __DIR__ . '/functions.php';
$cart_count = 0;
if (is_logged_in()) {
    $cart_count = get_cart_count($pdo, $_SESSION['user_id']);
}
?>
<!doctype html>
<html lang="id" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <title><?= htmlspecialchars($page_title) ?></title>
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=5">
    <link rel="apple-touch-icon" href="<?= $path_prefix ?>assets/images/favicon-0bbc387493.png">
    <link rel="shortcut icon" type="image/x-icon" href="<?= $path_prefix ?>assets/images/favicon-867fb402f0.ico">
    <link rel="preload" as="style" href="<?= $path_prefix ?>assets/css/component-862cb6c03e.v24.min.css">
    <link rel="preload" as="style" href="<?= $path_prefix ?>assets/css/style-2276b56dd3.css">
    <link rel="preload" as="style" href="<?= $path_prefix ?>assets/css/style_dark-8f18dc6cac.css">
    <link rel="stylesheet" href="<?= $path_prefix ?>assets/css/component-862cb6c03e.v24.min.css">
    <link rel="stylesheet" href="<?= $path_prefix ?>assets/css/style-2276b56dd3.css">
    <link rel="stylesheet" href="<?= $path_prefix ?>assets/css/style_dark-8f18dc6cac.css" media="(prefers-color-scheme:dark)">
    <?php if (isset($extra_css)): foreach ($extra_css as $css_file): ?>
        <link rel="stylesheet" href="<?= $path_prefix ?>assets/css/<?= $css_file ?>">
    <?php endforeach; endif; ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="preload" href="<?= $path_prefix ?>assets/fonts/manrope/v15/manrope-8951283ba1.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="<?= $path_prefix ?>assets/iconfont/materialicons/v143/MaterialIconsx-a4160421d2.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="<?= $path_prefix ?>assets/iconfont/brandicons/v13/brand-iconsx-6f85522d89.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="<?= $path_prefix ?>assets/images/platform_icons-91b7acd68a.svg" as="image">
    <link rel="preload" href="<?= $path_prefix ?>assets/images/category_icons-bda5098a45.svg" as="image">
    <link rel="preload" href="<?= $path_prefix ?>assets/images/placeholder/loading-701269f903.svg" as="image">
    <script src="<?= $path_prefix ?>assets/js/jquery-3.5-dc5e7f18c8.1.min.js"></script>
    <script src="<?= $path_prefix ?>assets/js/jquery-b67c6b00d9.tuki.js"></script>
    <script src="<?= $path_prefix ?>assets/js/php-9c29335b33.js"></script>
    <script src="<?= $path_prefix ?>assets/js/tuki-d92e491a75.js"></script>
    <script src="<?= $path_prefix ?>assets/js/jquery-a4d0da9e52.tukimenu.js"></script>
    <script src="<?= $path_prefix ?>assets/js/jquery-1b5c108829.tukiselect.js"></script>
    <script src="<?= $path_prefix ?>assets/js/jquery-26506c9d08.tukislide.js"></script>
    <script src="<?= $path_prefix ?>assets/js/jquery-e326281e2d.tukicountdown.js"></script>
    <script src="<?= $path_prefix ?>assets/js/jquery-c4c50db716.tukitip.js"></script>
    <script src="<?= $path_prefix ?>assets/js/jquery-69136f67e9.tukibox.js"></script>
    <script src="<?= $path_prefix ?>assets/js/jquery-d5679d5a53.tukivalidator.js"></script>
    <script src="<?= $path_prefix ?>assets/js/jquery-ba7e5f6060.md5.min.js"></script>
    <script src="<?= $path_prefix ?>assets/js/lazysizes-45bacd312d.min.js"></script>

    <style>
        /* ========== UNIFIED HEADER ========== */
        #site_header {
            background: rgba(255, 196, 0, .15);
            -webkit-backdrop-filter: blur(24px) saturate(200%);
            backdrop-filter: blur(24px) saturate(200%);
            border: 1px solid rgba(255, 196, 0, .35);
            border-radius: 16px;
            position: sticky;
            top: 10px;
            z-index: 1000;
            width: calc(100% - 28px);
            margin-inline: 14px;
            box-shadow: 0 4px 28px rgba(255, 196, 0, .12);
        }
        
        /* Main inner container */
        #main_nav > .inner {
            height: 3.3em !important;
            display: flex;
            align-items: center;
            padding: 0 14px;
            gap: 10px;
            overflow: hidden;
        }

        /* Logo */
        #nav_logo a {
            font-weight: 800;
            font-size: 18px;
            letter-spacing: 0.5px;
            text-decoration: none;
            flex-shrink: 0;
            display: flex;
            align-items: center;
        }
        #nav_logo a::before,
        #nav_logo a::after {
            content: none !important;
            display: none !important;
            background: none !important;
            width: 0 !important;
            height: 0 !important;
        }
        #nav_logo a span {
            display: inline-block !important;
            font-size: 22px;
            letter-spacing: 2px;
            font-family: "Inter", -apple-system, BlinkMacSystemFont, "SF Pro Display", "Helvetica Neue", Arial, sans-serif;
            font-weight: 900;
            background: linear-gradient(135deg, #fff 0%, #FFD700 25%, #fff 50%, #FFC400 75%, #fff 100%);
            background-size: 300% auto;
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: logoShine 3s linear infinite, lightningFlicker 0.12s infinite, logoFloat 2s ease-in-out infinite;
            filter: drop-shadow(0 0 8px rgba(255, 196, 0, .4));
        }
        @keyframes logoShine {
            0% { background-position: 0% center; }
            100% { background-position: 300% center; }
        }
        @keyframes lightningFlicker {
            0%, 100% { opacity: 1; }
            10% { opacity: 0.85; }
            15% { opacity: 1; }
            20% { opacity: 0.75; }
            25% { opacity: 1; }
            35% { opacity: 0.9; }
            40% { opacity: 1; }
            45% { opacity: 0.8; }
            50% { opacity: 1; }
            55% { opacity: 0.95; }
            60% { opacity: 1; }
            80% { opacity: 0.88; }
            85% { opacity: 1; }
            90% { opacity: 0.92; }
            95% { opacity: 1; }
        }
        @keyframes logoFloat {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-2px); }
        }
        @keyframes logoShine {
            0% { background-position: 0% center; }
            100% { background-position: 300% center; }
        }
        @keyframes lightningFlicker {
            0%, 100% { opacity: 1; }
            10% { opacity: 0.85; }
            15% { opacity: 1; }
            20% { opacity: 0.75; }
            25% { opacity: 1; }
            35% { opacity: 0.9; }
            40% { opacity: 1; }
            45% { opacity: 0.8; }
            50% { opacity: 1; }
            55% { opacity: 0.95; }
            60% { opacity: 1; }
            80% { opacity: 0.88; }
            85% { opacity: 1; }
            90% { opacity: 0.92; }
            95% { opacity: 1; }
        }
        #nav_logo a:hover span {
            animation: logoShine 2s linear infinite, lightningFlicker 0.08s infinite, logoFloat 1.5s ease-in-out infinite, logoPulse 0.6s ease-in-out infinite alternate;
            filter: drop-shadow(0 0 12px rgba(255, 220, 100, 0.9)) drop-shadow(0 0 24px rgba(255, 196, 0, 0.6));
        }
        @keyframes logoPulse {
            0% { filter: drop-shadow(0 0 8px rgba(255, 220, 100, 0.6)); }
            100% { filter: drop-shadow(0 0 20px rgba(255, 240, 150, 1)); }
        }

        /* Nav Zone - Categories */
        #nav_zone {
            display: flex;
            align-items: center;
            gap: 2px;
            flex: 1;
            justify-content: center;
            flex-shrink: 1;
            min-width: 0;
        }
        #nav_zone .type {
            display: flex;
            align-items: center;
            gap: 2px;
            position: relative;
        }
        #nav_zone .bt {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            color: rgba(255, 255, 255, .8);
            padding-inline: 10px;
            padding-block: 4px;
            border-radius: 4px;
            background: transparent;
            border: none;
            transition: all 0.2s ease;
            white-space: nowrap;
            text-decoration: none;
            flex-shrink: 0;
        }
        #nav_zone .bt:hover {
            color: #fff;
            background: rgba(255, 255, 255, .1);
        }
        #nav_zone .type:not(:last-child)::after {
            content: '';
            width: 2px;
            height: 2px;
            background: rgba(255, 255, 255, .3);
            border-radius: 50%;
            margin-inline: 5px;
            flex-shrink: 0;
            align-self: center;
        }
        #nav_zone .type:has(.dropmenu_ctrl) .bt {
            padding-inline-end: 22px;
        }
        #nav_zone .dropmenu_ctrl {
            position: absolute;
            right: 3px;
            top: 50%;
            transform: translateY(-50%);
            width: 1em;
            height: 1em;
            border-radius: 2px;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        #nav_zone .dropmenu_ctrl::before {
            font-size: 1em;
            opacity: .5;
        }
        #nav_zone .dropmenu_ctrl:hover {
            background: rgba(255, 196, 0, .12);
        }
        #nav_zone .dropmenu {
            background: rgba(15, 23, 42, .96);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border: 1px solid rgba(255, 255, 255, .08);
            border-radius: 8px;
            box-shadow: 0 10px 28px rgba(0, 0, 0, .4);
            padding: 5px;
            width: 18em;
        }
        #nav_zone .category {
            font-size: 12px;
            font-weight: 600;
            height: 2.2em;
            padding-inline: 10px;
            border-radius: 5px;
            color: rgba(255, 255, 255, .85);
            transition: all 0.2s ease;
        }
        #nav_zone .category:hover {
            background: rgba(255, 255, 255, .06);
            color: #FFC400;
        }
        #nav_zone .category::before {
            font-size: 1.2em;
            opacity: .5;
        }

        /* Right menu section */
        .menu {
            display: flex;
            align-items: center;
            gap: 6px;
            flex-shrink: 0;
        }
        
        /* Search */
        #universal_search .cpt-search {
            background: rgba(255, 255, 255, .08);
            border: 1px solid rgba(255, 255, 255, .15);
            border-radius: 6px;
            height: 2.4em;
            transition: all 0.25s ease;
        }
        #universal_search .cpt-search:focus-within {
            background: rgba(255, 255, 255, .12);
            border-color: rgba(255, 255, 255, .3);
            box-shadow: 0 0 0 3px rgba(255, 255, 255, .06);
        }
        #universal_search .cpt-search input {
            color: #fff;
            font-size: 12px;
        }
        #universal_search .cpt-search input::placeholder {
            color: rgba(255, 255, 255, .4);
        }

        /* Cart */
        .cart-icon-wrapper {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background: rgba(255, 255, 255, .09);
            border: 1px solid rgba(255, 255, 255, .16);
            transition: all 0.25s ease;
            flex-shrink: 0;
            color: #fff;
            text-decoration: none;
        }
        .cart-icon-wrapper:hover {
            background: rgba(255, 196, 0, .14);
            border-color: rgba(255, 196, 0, .45);
            color: #FFC400;
        }
        .cart-icon-wrapper [icon-only] {
            display: block;
            width: 22px;
            height: 22px;
            overflow: hidden;
        }
        .cart-icon-wrapper [icon-only]::before {
            content: attr(icon-only);
            font-size: 22px;
            color: currentColor;
        }
        .cart-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #ff3b30;
            color: #fff;
            font-size: 9px;
            font-weight: 700;
            min-width: 14px;
            height: 14px;
            padding: 0 3px;
            border-radius: 7px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 6px rgba(255, 59, 48, .3);
        }

        /* User */
        .user {
            display: flex;
            align-items: center;
            gap: 6px;
            min-width: 0;
        }
        .user_info_box {
            background: rgba(255, 255, 255, .08);
            border: 1px solid rgba(255, 255, 255, .15);
            border-radius: 8px;
            padding: 4px 10px 4px 4px;
            height: 36px;
            transition: all 0.25s ease;
            cursor: pointer;
            flex-shrink: 0;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            max-width: 190px;
            box-sizing: border-box;
        }
        .user_info_box:hover {
            background: rgba(255, 255, 255, .12);
            border-color: rgba(255, 255, 255, .25);
        }
        .user_info_box img {
            width: 26px;
            height: 26px;
            border-radius: 50%;
            border: 1px solid rgba(255, 255, 255, .15);
            background: rgba(255, 255, 255, .1);
            flex: none;
        }
        .user_info_box span {
            font-size: 11px;
            font-weight: 600;
            color: #fff;
            letter-spacing: 0.2px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            min-width: 0;
        }
        .header-logout-btn {
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            background: rgba(239, 68, 68, .11);
            border: 1px solid rgba(239, 68, 68, .32);
            color: #fca5a5;
            text-decoration: none;
            transition: all .2s ease;
            flex-shrink: 0;
        }
        .header-logout-btn:hover {
            background: rgba(239, 68, 68, .2);
            border-color: rgba(239, 68, 68, .5);
            color: #fff;
        }
        .header-logout-btn [icon-only] {
            display: block;
            width: 22px;
            height: 22px;
            overflow: hidden;
        }
        .header-logout-btn [icon-only]::before {
            content: attr(icon-only);
            font-size: 22px;
            color: currentColor;
        }
        .rpl-flash {
            max-width: 1000px;
            margin: 18px auto 0;
            padding: 0 20px;
            box-sizing: border-box;
        }
        .rpl-flash-inner {
            border: 1px solid rgba(16, 185, 129, .55);
            border-radius: 8px;
            background: rgba(16, 185, 129, .14);
            color: #a7f3d0;
            padding: 12px 16px;
            font-size: 14px;
            font-weight: 600;
        }

        /* Right section wrapper */
        .header-right {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-shrink: 0;
        }

        /* Sign In button - invisible box, only text */
        .auth-signin-btn {
            font-size: 9px !important;
            font-weight: 700 !important;
            letter-spacing: 0.3px !important;
            text-transform: uppercase;
            padding: 0px !important;
            border-radius: 0 !important;
            border: none !important;
            background: transparent !important;
            color: #fff !important;
            transition: all 0.2s ease !important;
            height: auto !important;
            min-height: 0 !important;
            line-height: 1.1 !important;
            white-space: nowrap;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            margin: 0 !important;
            text-decoration: none !important;
            box-shadow: none !important;
        }
        /* Force override framework btw class */
        .auth-signin-btn.btw,
        .auth-signin-btn.bt.btw {
            padding: 0px !important;
            height: auto !important;
            min-height: 0 !important;
            line-height: 1.1 !important;
            font-size: 9px !important;
            border-radius: 0 !important;
            margin: 0 !important;
            border: none !important;
            background: transparent !important;
            color: #fff !important;
            box-shadow: none !important;
        }
        .auth-signin-btn:hover {
            color: #FFD700 !important;
            transform: translateY(-1px);
        }

        /* Utility links in header - light theme */
        .header-utils {
            display: flex;
            align-items: center;
            gap: 2px;
            flex-shrink: 0;
            padding: 3px 6px;
            border-radius: 8px;
            background: rgba(0, 0, 0, .02);
            border: 1px solid rgba(0, 0, 0, .06);
        }
        .header-utils a {
            color: rgba(255, 255, 255, .7);
            text-decoration: none;
            font-size: 9.5px;
            font-weight: 500;
            letter-spacing: 0.1px;
            padding: 4px 8px;
            border-radius: 4px;
            transition: all 0.2s ease;
            white-space: nowrap;
        }
        .header-utils a:hover {
            color: #fff;
            background: rgba(255, 255, 255, .1);
        }
        .header-utils a span[icon] {
            font-size: 12px;
            opacity: .6;
            vertical-align: middle;
            margin-inline-end: 2px;
        }
        .header-utils a:hover span[icon] {
            opacity: 1;
        }
        .header-utils .utils-cta {
            font-weight: 600;
            border: 1px solid rgba(0, 0, 0, .1);
            background: rgba(0, 0, 0, .02);
        }
        .header-utils .utils-cta:hover {
            background: rgba(26, 26, 46, .06);
            border-color: rgba(26, 26, 46, .15);
        }
        .header-utils-divider {
            width: 1px;
            height: 11px;
            background: rgba(255, 255, 255, .15);
            margin: 0 3px;
            flex-shrink: 0;
        }
        .header-utils-lang {
            color: rgba(255, 255, 255, .6);
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 0.8px;
            padding: 4px 7px;
            border-radius: 3px;
            background: rgba(255, 255, 255, .05);
            border: 1px solid rgba(255, 255, 255, .1);
            cursor: default;
        }

        /* Responsive */
        @media (max-width: 1280px) {
            #main_nav > .inner { height: 3.8em; padding: 0 16px; }
            #nav_logo a { font-size: 16px; }
            #nav_logo a span { font-size: 18px; letter-spacing: 1.5px; }
            #nav_zone .bt { font-size: 9px; padding-inline: 8px; }
            .header-utils a { font-size: 9px; padding: 3px 6px; }
            .header-utils a span[icon] { display: none; }
        }
        @media (max-width: 1000px) {
            #main_nav > .inner { height: 3.5em; padding: 0 12px; gap: 10px; }
            #nav_logo a { font-size: 15px; }
            #nav_logo a span { font-size: 17px; letter-spacing: 1px; }
            #nav_zone { gap: 1px; }
            #nav_zone .bt { font-size: 8px; padding-inline: 6px; letter-spacing: 0.3px; }
            #nav_zone .type:not(:last-child)::after { margin-inline: 2px; }
            .header-utils a { font-size: 8px; padding: 3px 5px; }
            .header-utils-lang { font-size: 8px; padding: 3px 5px; }
        }
        @media (max-width: 768px) {
            #main_nav > .inner { height: 3.2em; padding: 0 10px; gap: 8px; }
            #nav_logo a { font-size: 14px; }
            #nav_logo a span { font-size: 16px; letter-spacing: 1px; }
            #nav_zone .bt { font-size: 7.5px; padding-inline: 5px; }
            #nav_zone .type:not(:last-child)::after { display: none; }
            #universal_search { display: none; }
            .header-utils a:not(.utils-cta) { display: none; }
            .header-utils-divider { display: none; }
            .header-utils-lang { display: none; }
            .header-utils { padding: 2px 4px; }
        }

        /* Footer override */
        #footer_copyright::before {
            content: 'RPLSHOP' !important;
            width: auto !important;
            height: auto !important;
            background: none !important;
            color: #ffc400;
            font-weight: 800;
            letter-spacing: 0;
            opacity: .9 !important;
            filter: none !important;
        }
        #footer_app a.download::after {
            content: none !important;
            display: none !important;
            background: none !important;
        }
    </style>
</head>
<body>
<div id="tukigrowl_wrapper"></div>
<div id="tukibox_overlay"><div class="tukibox"></div></div>
<div id="tukitip_wrp"><div id="tukitip"><div class="load"><div class="loading">Loading</div></div></div></div>

<header id="site_header">
    <div id="main_nav">
        <div class="inner">
            <!-- Mobile menu toggle -->
            <div class="nav_ctrl_on btw" color="transparent"><span icon-only="menu"></span></div>
            
            <!-- Logo -->
            <div id="nav_logo">
                <a href="<?= $path_prefix ?>index.php" title="RPLShop"><span>RPLShop</span></a>
            </div>

            <!-- Center: Category Navigation -->
            <div id="nav_zone">
                <div class="type">
                    <a class="bt" href="<?= $path_prefix ?>pages/products.php?category=game"><span>Game</span></a>
                    <div class="dropmenu_ctrl" icon></div>
                    <div class="dropmenu">
                        <a class="category" href="<?= $path_prefix ?>pages/products.php?category=pc-game" data-platform-icon="1"><span>PC Game</span></a>
                        <a class="category" href="<?= $path_prefix ?>pages/products.php?category=mobile-game" data-platform-icon="4"><span>Mobile Game</span></a>
                    </div>
                </div>
                <div class="type">
                    <a class="bt" href="<?= $path_prefix ?>pages/products.php?category=card"><span>Card</span></a>
                    <div class="dropmenu_ctrl" icon></div>
                    <div class="dropmenu">
                        <a class="category" href="<?= $path_prefix ?>pages/products.php?category=game-cards" data-category-icon="01"><span>Game Cards</span></a>
                        <a class="category" href="<?= $path_prefix ?>pages/products.php?category=gift-cards" data-category-icon="03"><span>Gift Cards</span></a>
                        <a class="category" href="<?= $path_prefix ?>pages/products.php?category=payment-cards" data-category-icon="02"><span>Payment Cards</span></a>
                    </div>
                </div>
                <div class="type">
                    <a class="bt" href="<?= $path_prefix ?>pages/products.php?category=direct-topup"><span>Direct Top-Up</span></a>
                    <div class="dropmenu_ctrl" icon></div>
                    <div class="dropmenu">
                        <a class="category" href="<?= $path_prefix ?>pages/products.php?category=mobile-game-topup" data-category-icon="34"><span>Mobile Game Top-Up</span></a>
                        <a class="category" href="<?= $path_prefix ?>pages/products.php?category=game-direct-topup" data-category-icon="14"><span>Game Direct Top-Up</span></a>
                        <a class="category" href="<?= $path_prefix ?>pages/products.php?category=live-streaming" data-category-icon="27"><span>Live Streaming</span></a>
                    </div>
                </div>
                <div class="type">
                    <a class="bt" href="<?= $path_prefix ?>pages/products.php?category=mobile-recharge"><span>Mobile Recharge</span></a>
                </div>
            </div>

            <!-- Right: utilities + menu -->
            <div class="header-right">
                
                <!-- Utility links -->
                <div class="header-utils">
                    <a href="<?= $path_prefix ?>pages/news.php"><span icon="newspaper"></span>News</a>
                    <a href="<?= $path_prefix ?>pages/rewards.php"><span icon="stars"></span>Rewards</a>
                    <a href="<?= $path_prefix ?>pages/support.php"><span icon="contact_support"></span>Support</a>
                    <div class="header-utils-divider"></div>
                    <a href="<?= $path_prefix ?>pages/download-app.php" class="utils-cta"><span icon="install_mobile"></span>APP</a>
                    <div class="header-utils-divider"></div>
                    <div class="header-utils-lang">ID / IDR</div>
                </div>

                <!-- Search, Cart, User -->
                <div class="menu">
                    <div id="universal_search">
                        <form method="get" action="<?= $path_prefix ?>pages/search.php">
                            <label id="header_search" class="cpt-search">
                                <input type="search" placeholder="Cari..." value="<?= isset($_GET['keywords']) ? htmlspecialchars($_GET['keywords']) : '' ?>" name="keywords" tabindex="1" autocomplete="off" required>
                                <label class="btw" color="transparent"><span icon-only="search">Cari</span><input type="submit"></label>
                            </label>
                        </form>
                    </div>
                    <a href="<?= $path_prefix ?>pages/cart.php" class="cart-icon-wrapper" title="Keranjang" aria-label="Keranjang">
                        <span icon-only="shopping_cart"></span>
                        <?php if ($cart_count > 0): ?>
                            <span class="cart-badge"><?= $cart_count ?></span>
                        <?php endif; ?>
                    </a>
                    <div class="user">
                        <?php if (is_logged_in()): ?>
                            <div class="user_info_box user_dropdown_ctrl_on">
                                <img src="<?= $path_prefix ?>assets/images/placeholder/avatar_default-c4b39b0bde.svg" alt="Avatar">
                                <span><?= htmlspecialchars($_SESSION['user_username']) ?></span>
                            </div>
                            <a href="<?= $path_prefix ?>auth/logout.php" class="header-logout-btn" title="Keluar" aria-label="Keluar">
                                <span icon-only="power_settings_new"></span>
                            </a>
                            <section id="user_dropdown">
                                <div class="user_dropdown_ctrl_off"></div>
                                <div class="inner">
                                    <div class="user_dropdown_ctrl_off close btw" color="transparent"><span icon-only="close"></span></div>
                                    <div class="welcome">
                                        <h3>Halo, <b><?= htmlspecialchars($_SESSION['user_fullname'] ? $_SESSION['user_fullname'] : $_SESSION['user_username']) ?></b></h3>
                                        <p style="font-size:11px;color:#888;margin-bottom:12px;"><?= htmlspecialchars($_SESSION['user_email']) ?></p>
                                        <div class="btc" style="display:flex; flex-direction:column; gap: 6px; width:100%;">
                                            <?php if (is_admin()): ?>
                                                <a href="<?= $path_prefix ?>admin/index.php" class="btw" color="yellowgreen" style="width:100%;"><span>Admin Panel</span></a>
                                            <?php endif; ?>
                                            <a href="<?= $path_prefix ?>auth/logout.php" class="btw" color="theme" style="width:100%;"><span>Logout</span></a>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        <?php else: ?>
                            <a id="login-btn" class="user_dropdown_ctrl_on btw auth-signin-btn" color="outline" href="<?= $path_prefix ?>pages/login.php"><span>Sign In</span></a>
                <section id="user_dropdown" style="display:none;">
                    <div class="user_dropdown_ctrl_off"></div>
                    <div class="inner" style="max-width:260px;margin:0 auto;">
                                    <div class="user_dropdown_ctrl_off close btw" color="transparent"><span icon-only="close"></span></div>
                                    <div class="welcome">
                                        <h3 style="font-size:15px;margin-bottom:10px;text-align:center;">RPLShop</h3>
                                        <div class="btc" style="gap:6px;flex-direction:column;align-items:stretch;">
                                            <a href="<?= $path_prefix ?>pages/login.php" class="btw auth-dropdown-signin"><span>Sign In</span></a>
                                            <a href="<?= $path_prefix ?>pages/register.php" class="btw auth-dropdown-register"><span>Sign Up</span></a>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Close buttons -->
            <div class="nav_ctrl_off close btw" color="transparent"><span icon-only="close"></span></div>
        </div>
    </div>
</header>
<?php if (isset($_GET['logout']) && $_GET['logout'] === '1'): ?>
    <div class="rpl-flash">
        <div class="rpl-flash-inner">Anda berhasil logout dari RPLShop.</div>
    </div>
<?php endif; ?>
