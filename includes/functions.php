<?php
// includes/functions.php

require_once __DIR__ . '/../config/database.php';

// Format price to IDR Currency format (e.g. Rp 15.000)
function format_idr($amount) {
    return 'Rp ' . number_format($amount, 0, ',', '.');
}

// Get all parent categories
function get_parent_categories($pdo) {
    $stmt = $pdo->query("SELECT * FROM categories WHERE parent_id IS NULL");
    return $stmt->fetchAll();
}

// Get subcategories of a parent category
function get_subcategories($pdo, $parent_id) {
    $stmt = $pdo->prepare("SELECT * FROM categories WHERE parent_id = ?");
    $stmt->execute([$parent_id]);
    return $stmt->fetchAll();
}

// Get popular products
function get_popular_products($pdo, $limit = 8) {
    $stmt = $pdo->prepare("SELECT p.*, MIN(pp.price) as min_price, MAX(pp.discount_percent) as max_discount 
                           FROM products p 
                           LEFT JOIN product_packages pp ON p.id = pp.product_id 
                           WHERE p.is_popular = 1 
                           GROUP BY p.id 
                           LIMIT ?");
    $stmt->execute([$limit]);
    return $stmt->fetchAll();
}

// Get featured products
// Note: MIN(pp.price) retrieves the starting price of the product from its packages/denominations
function get_featured_products($pdo, $limit = 8) {
    $stmt = $pdo->prepare("SELECT p.*, MIN(pp.price) as min_price, MAX(pp.discount_percent) as max_discount 
                           FROM products p 
                           LEFT JOIN product_packages pp ON p.id = pp.product_id 
                           WHERE p.is_featured = 1 
                           GROUP BY p.id 
                           LIMIT ?");
    $stmt->execute([$limit]);
    return $stmt->fetchAll();
}

// Get all products, optionally filtered by category slug
function get_products($pdo, $category_slug = null, $search = null, $limit = null) {
    $query = "SELECT p.*, MIN(pp.price) as min_price, MAX(pp.discount_percent) as max_discount 
              FROM products p 
              LEFT JOIN product_packages pp ON p.id = pp.product_id";
    $params = [];
    $where = [];

    if ($category_slug) {
        if ($category_slug === 'game') {
            // Game category matches categories 1 (Game), 5 (Mobile Game), 6 (PC Game)
            // AND also matches 10 (Mobile Game Top-Up), 11 (Game Direct Top-Up)
            $where[] = "p.category_id IN (1, 5, 6, 10, 11)";
        } elseif ($category_slug === 'mobile-game') {
            // Mobile Game category matches category 5 (Mobile Game) and 10 (Mobile Game Top-Up)
            $where[] = "p.category_id IN (5, 10)";
        } elseif ($category_slug === 'pc-game') {
            // PC Game category matches category 6 (PC Game) and 11 (Game Direct Top-Up)
            $where[] = "p.category_id IN (6, 11)";
        } elseif ($category_slug === 'direct-topup') {
            // Direct Top-up category matches 3, 5, 10, 11, 12
            $where[] = "p.category_id IN (3, 5, 10, 11, 12)";
        } else {
            // Default subcategory query
            $where[] = "p.category_id IN (
                SELECT id FROM categories WHERE slug = ? 
                UNION 
                SELECT id FROM categories WHERE parent_id = (SELECT id FROM categories WHERE slug = ?)
            )";
            $params[] = $category_slug;
            $params[] = $category_slug;
        }
    }

    if ($search) {
        $where[] = "p.name LIKE ?";
        $params[] = '%' . $search . '%';
    }

    if (!empty($where)) {
        $query .= " WHERE " . implode(" AND ", $where);
    }

    $query .= " GROUP BY p.id ORDER BY p.name ASC";
    
    if ($limit) {
        $query .= " LIMIT " . (int)$limit;
    }
    
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

// Resolve the best available product image URL
function resolve_product_image_url($product) {
    $defaultGameImages = [
        'mobile-legends-diamonds' => 'assets/media/game_480/mobile-legends.jpg',
        'pubg-mobile-uc' => 'assets/media/game_480/pubg-mobile.jpg',
        'free-fire-diamonds' => 'assets/media/game_480/free-fire.jpg',
        'minecraft-java-bedrock' => 'assets/media/game_480/minecraft.jpg',
        'gta-v-premium-edition' => 'assets/media/game_480/gtav.jpg',
        'genshin-impact-genesis-crystals' => 'assets/media/game_480/genshin.jpg',
        'valorant-points' => 'assets/media/game_480/valorant.jpg',
        'roblox-gift-card-usd' => 'assets/media/game_480/roblox.jpg',
        'razer-gold-idr' => 'assets/media/game_480/razer-gold.jpg',
    ];

    $gameNameMapping = [
        'mobile legends' => 'assets/media/game_480/mobile-legends.jpg',
        'mlbb' => 'assets/media/game_480/mobile-legends.jpg',
        'pubg mobile' => 'assets/media/game_480/pubg-mobile.jpg',
        'free fire' => 'assets/media/game_480/free-fire.jpg',
        'minecraft' => 'assets/media/game_480/minecraft.jpg',
        'gta v' => 'assets/media/game_480/gtav.jpg',
        'gta' => 'assets/media/game_480/gtav.jpg',
        'genshin impact' => 'assets/media/game_480/genshin.jpg',
        'valorant' => 'assets/media/game_480/valorant.jpg',
        'roblox' => 'assets/media/game_480/roblox.jpg',
        'razer gold' => 'assets/media/game_480/razer-gold.jpg',
    ];

    if (!empty($product['image_url'])) {
        $candidate = ltrim($product['image_url'], '/');
        $fullPath = __DIR__ . '/../' . $candidate;

        if (file_exists($fullPath)) {
            return $candidate;
        }
    }

    $slugKey = !empty($product['slug']) ? strtolower(trim($product['slug'])) : '';
    if ($slugKey && isset($defaultGameImages[$slugKey])) {
        return $defaultGameImages[$slugKey];
    }

    $nameKey = !empty($product['name']) ? strtolower($product['name']) : '';
    foreach ($gameNameMapping as $gameTerm => $imagePath) {
        if (strpos($nameKey, $gameTerm) !== false) {
            return $imagePath;
        }
    }

    return 'assets/images/placeholder/gamepic-0b3becd65a.svg';
}

// Get product details by slug
function get_product_by_slug($pdo, $slug) {
    $stmt = $pdo->prepare("SELECT p.*, c.name as category_name, c.slug as category_slug 
                           FROM products p 
                           LEFT JOIN categories c ON p.category_id = c.id 
                           WHERE p.slug = ?");
    $stmt->execute([$slug]);
    return $stmt->fetch();
}

// Get packages for a product
function get_product_packages($pdo, $product_id) {
    $stmt = $pdo->prepare("SELECT * FROM product_packages WHERE product_id = ? ORDER BY price ASC");
    $stmt->execute([$product_id]);
    return $stmt->fetchAll();
}

// Get custom input fields for a product
function get_product_fields($pdo, $product_id) {
    $stmt = $pdo->prepare("SELECT * FROM product_fields WHERE product_id = ? ORDER BY id ASC");
    $stmt->execute([$product_id]);
    return $stmt->fetchAll();
}

// Auth: Check if user is logged in
function is_logged_in() {
    return isset($_SESSION['user_id']);
}

// Auth: Check if logged in user is admin
function is_admin() {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
}

// Auth: Require login
function require_login() {
    if (!is_logged_in()) {
        header("Location: pages/login.php");
        exit;
    }
}

// Auth: Require admin
function require_admin() {
    if (!is_admin()) {
        header("Location: ../index.php");
        exit;
    }
}

// Cart: Add item to cart
function add_to_cart($pdo, $user_id, $product_package_id, $quantity = 1, $custom_fields = []) {
    // Check if item already in cart with same custom fields
    $custom_fields_json = json_encode($custom_fields);
    
    $stmt = $pdo->prepare("SELECT id, quantity FROM cart WHERE user_id = ? AND product_package_id = ? AND custom_fields = ?");
    $stmt->execute([$user_id, $product_package_id, $custom_fields_json]);
    $existing = $stmt->fetch();
    
    if ($existing) {
        $new_qty = $existing['quantity'] + $quantity;
        $stmt = $pdo->prepare("UPDATE cart SET quantity = ? WHERE id = ?");
        return $stmt->execute([$new_qty, $existing['id']]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO cart (user_id, product_package_id, quantity, custom_fields) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$user_id, $product_package_id, $quantity, $custom_fields_json]);
    }
}

// Cart: Get total items count in cart
function get_cart_count($pdo, $user_id) {
    $stmt = $pdo->prepare("SELECT SUM(quantity) FROM cart WHERE user_id = ?");
    $stmt->execute([$user_id]);
    return (int)$stmt->fetchColumn();
}

// Cart: Get cart items for a user
function get_cart_items($pdo, $user_id) {
    $stmt = $pdo->prepare("SELECT c.*, pp.name as package_name, pp.price, pp.discount_percent, p.name as product_name, p.image_url, p.slug as product_slug 
                           FROM cart c
                           JOIN product_packages pp ON c.product_package_id = pp.id
                           JOIN products p ON pp.product_id = p.id
                           WHERE c.user_id = ?
                           ORDER BY c.created_at DESC");
    $stmt->execute([$user_id]);
    return $stmt->fetchAll();
}

// Cart: Delete item from cart
function delete_cart_item($pdo, $cart_id, $user_id) {
    $stmt = $pdo->prepare("DELETE FROM cart WHERE id = ? AND user_id = ?");
    return $stmt->execute([$cart_id, $user_id]);
}

// Cart: Clear cart
function clear_cart($pdo, $user_id) {
    $stmt = $pdo->prepare("DELETE FROM cart WHERE user_id = ?");
    return $stmt->execute([$user_id]);
}
