-- SQL Schema for RPLShop (SEAGM Replica)
-- Database name: rplshop

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

-- --------------------------------------------------------

-- Table: users
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100),
    role ENUM('user', 'admin') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table: categories
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) UNIQUE NOT NULL,
    icon VARCHAR(50),
    parent_id INT DEFAULT NULL,
    FOREIGN KEY (parent_id) REFERENCES categories(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table: products
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(200) NOT NULL,
    slug VARCHAR(200) UNIQUE NOT NULL,
    description TEXT,
    category_id INT,
    image_url VARCHAR(500),
    brand VARCHAR(100),
    region VARCHAR(50),
    platform VARCHAR(50),
    is_featured BOOLEAN DEFAULT FALSE,
    is_popular BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table: product_packages (variants/denominations)
CREATE TABLE IF NOT EXISTS product_packages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    name VARCHAR(200) NOT NULL,
    price DECIMAL(15,2) NOT NULL,
    discount_percent DECIMAL(5,2) DEFAULT 0.00,
    stock INT DEFAULT 999,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table: product_fields (custom inputs required for purchase, e.g. User ID, Zone ID)
CREATE TABLE IF NOT EXISTS product_fields (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    field_name VARCHAR(100) NOT NULL,
    field_type VARCHAR(50) DEFAULT 'text',
    placeholder VARCHAR(200),
    help_text VARCHAR(500),
    is_required BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table: cart
CREATE TABLE IF NOT EXISTS cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_package_id INT NOT NULL,
    quantity INT DEFAULT 1,
    -- JSON string of user custom field inputs (e.g. {"User ID":"123456", "Zone ID":"1234"})
    custom_fields TEXT, 
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_package_id) REFERENCES product_packages(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table: orders
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    total_amount DECIMAL(15,2) NOT NULL,
    status ENUM('pending', 'processing', 'completed', 'cancelled') DEFAULT 'pending',
    payment_method VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table: order_items
CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_package_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(15,2) NOT NULL,
    custom_fields TEXT,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_package_id) REFERENCES product_packages(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

-- Seed Data

-- Users (password is 'admin123' and 'user123' respectively, hashed using password_hash() in PHP)
-- password_hash('admin123', PASSWORD_BCRYPT) -> $2y$10$Q7wA.d5Yv3iB4Xy9b5ZJKeoK2w9K/yB81D0b2k7c7gE6a4t9P/i6a
-- password_hash('user123', PASSWORD_BCRYPT) -> $2y$10$P/1xGq4d7j0JzE0.oM4yKeP8tU.Z0L3S3A.z0qPZ0b5Yv4k1T/e5W
INSERT INTO users (username, email, password, full_name, role) VALUES
('admin', 'admin@rplshop.com', '$2y$10$Q7wA.d5Yv3iB4Xy9b5ZJKeoK2w9K/yB81D0b2k7c7gE6a4t9P/i6a', 'Administrator', 'admin'),
('user', 'user@rplshop.com', '$2y$10$P/1xGq4d7j0JzE0.oM4yKeP8tU.Z0L3S3A.z0qPZ0b5Yv4k1T/e5W', 'Regular User', 'user');

-- Categories
INSERT INTO categories (id, name, slug, icon, parent_id) VALUES
(1, 'Game', 'game', 'sports_esports', NULL),
(2, 'Card', 'card', 'credit_card', NULL),
(3, 'Direct Top-Up', 'direct-topup', 'offline_bolt', NULL),
(4, 'Mobile Recharge', 'mobile-recharge', 'install_mobile', NULL);

-- Subcategories
INSERT INTO categories (id, name, slug, icon, parent_id) VALUES
(5, 'Mobile Game', 'mobile-game', NULL, 1),
(6, 'PC Game', 'pc-game', NULL, 1),
(7, 'Game Cards', 'game-cards', NULL, 2),
(8, 'Gift Cards', 'gift-cards', NULL, 2),
(9, 'Payment Cards', 'payment-cards', NULL, 2),
(10, 'Mobile Game Top-Up', 'mobile-game-topup', NULL, 3),
(11, 'Game Direct Top-Up', 'game-direct-topup', NULL, 3),
(12, 'Live Streaming', 'live-streaming', NULL, 3);

-- Products
INSERT INTO products (id, name, slug, description, category_id, image_url, brand, region, platform, is_featured, is_popular) VALUES
(1, 'Mobile Legends Diamonds', 'mobile-legends-diamonds', 'Top Up Mobile Legends: Bang Bang Diamonds secara instan dan aman di RPLShop. Cukup masukkan ID & Zone Anda, pilih denominasi, selesaikan pembayaran, dan Diamonds akan langsung ditambahkan ke akun Anda!', 10, 'assets/media/game_480/415873fd.jpg', 'Moonton', 'Indonesia', 'Mobile', TRUE, TRUE),
(2, 'PUBG Mobile UC', 'pubg-mobile-uc', 'Beli PUBG Mobile Unknown Cash (UC) dengan harga murah dan pengiriman instan. Masukkan ID Karakter Anda, pilih jumlah UC, dan dapatkan UC langsung di game untuk membeli skin senjata, pakaian, Royal Pass, dan lainnya!', 10, 'assets/media/game_480/436653c5.jpg', 'Tencent Games', 'Global', 'Mobile', TRUE, TRUE),
(3, 'Free Fire Diamonds', 'free-fire-diamonds', 'Top up Free Fire Diamonds murah dan instan di RPLShop. Cukup masukkan Player ID Anda, pilih jumlah Diamonds, selesaikan pembayaran dan Diamonds akan otomatis dikirim ke akun Free Fire Anda.', 10, 'assets/media/game_480/3845c97d.jpg', 'Garena', 'Indonesia', 'Mobile', TRUE, FALSE),
(4, 'Steam Wallet Code (IDR)', 'steam-wallet-code-idr', 'Dapatkan Steam Wallet Code dalam mata uang Rupiah (IDR) untuk mengisi saldo Steam Anda. Gunakan saldo tersebut untuk membeli game PC terbaru, DLC, item game di pasar Steam komunitas, dan konten menarik lainnya!', 7, 'assets/media/game_480/385018fa.jpg', 'Valve', 'Indonesia', 'PC', FALSE, TRUE),
(5, 'Roblox Gift Card (USD)', 'roblox-gift-card-usd', 'Roblox Robux Gift Card untuk membeli Robux atau berlangganan Roblox Premium. Kartu ini dikirimkan secara instan sebagai kode digital yang bisa Anda klaim langsung di situs Roblox.', 6, 'assets/media/game_480/4832101b.jpg', 'Roblox', 'Global', 'Multi-platform', TRUE, TRUE),
(6, 'Razer Gold (IDR)', 'razer-gold-idr', 'Razer Gold adalah kredit virtual terpadu untuk para gamer di seluruh dunia. Gunakan Razer Gold untuk membeli game dan konten dalam game untuk mendapatkan keuntungan lebih, termasuk Razer Silver dan promo eksklusif.', 9, 'assets/media/game_480/5120a9ae.jpg', 'Razer', 'Indonesia', 'Multi-platform', FALSE, TRUE),
(7, 'Valorant Points', 'valorant-points', 'Beli Valorant Points (VP) murah untuk membeli Radianite Points, skin senjata premium, gantungan senjata, dan Battle Pass di Valorant. Cukup masukkan Riot ID Anda!', 11, 'assets/media/game_480/53108fb0.jpg', 'Riot Games', 'Indonesia', 'PC', FALSE, FALSE),
(8, 'Garena Shells (ID)', 'garena-shells-id', 'Garena Shells adalah mata uang virtual yang dapat digunakan untuk membeli game, item, atau layanan premium dari Garena, seperti Call of Duty: Mobile, League of Legends, Free Fire, dan lainnya.', 7, 'assets/media/game_480/3138d49a.jpg', 'Garena', 'Indonesia', 'PC/Mobile', FALSE, FALSE),
(9, 'Telkomsel Pulsa', 'telkomsel-pulsa', 'Isi ulang pulsa Telkomsel prabayar secara instan dan aman. Cukup masukkan nomor HP Telkomsel Anda, pilih nominal pulsa yang diinginkan, dan selesaikan pembayaran!', 4, 'assets/media/game_480/telkomsel-pulsa.jpg', 'Telkomsel', 'Indonesia', 'Mobile', TRUE, TRUE),
(10, 'XL Pulsa', 'xl-pulsa', 'Isi ulang pulsa XL Axiata prabayar secara instan dan aman. Cukup masukkan nomor HP XL Anda, pilih nominal pulsa yang diinginkan, dan selesaikan pembayaran!', 4, 'assets/media/game_480/xl-pulsa.jpg', 'XL Axiata', 'Indonesia', 'Mobile', FALSE, TRUE),
(11, 'Minecraft Java & Bedrock Edition', 'minecraft-java-bedrock', 'Beli Minecraft Java & Bedrock Edition resmi untuk PC. Rasakan petualangan tanpa batas di dunia blok kreatif.', 6, 'assets/media/game_480/minecraft.jpg', 'Mojang', 'Global', 'PC', TRUE, TRUE),
(12, 'Grand Theft Auto V (Premium Edition)', 'gta-v-premium-edition', 'Dapatkan Grand Theft Auto V Premium Edition resmi PC. Masuk ke dunia Los Santos yang megah dan lakukan misi seru.', 6, 'assets/media/game_480/gtav.jpg', 'Rockstar Games', 'Global', 'PC', FALSE, TRUE),
(13, 'Genshin Impact Genesis Crystals', 'genshin-impact-genesis-crystals', 'Top up Genesis Crystals Genshin Impact instan. Masukkan UID & Server Anda, pilih nominal, dan dapatkan Crystals langsung di dalam game.', 5, 'assets/media/game_480/genshin.jpg', 'HoYoverse', 'Global', 'Mobile/PC', TRUE, TRUE),
(14, 'Indosat Ooredoo Pulsa', 'indosat-pulsa', 'Isi ulang pulsa Indosat Ooredoo prabayar secara instan dan aman. Cukup masukkan nomor HP Indosat Anda, pilih nominal pulsa yang diinginkan, dan selesaikan pembayaran!', 4, 'assets/media/game_480/indosat-pulsa.jpg', 'Indosat Ooredoo', 'Indonesia', 'Mobile', FALSE, TRUE),
(15, 'Smartfren Pulsa', 'smartfren-pulsa', 'Isi ulang pulsa Smartfren prabayar secara instan dan aman. Cukup masukkan nomor HP Smartfren Anda, pilih nominal pulsa yang diinginkan, dan selesaikan pembayaran!', 4, 'assets/media/game_480/smartfren-pulsa.jpg', 'Smartfren', 'Indonesia', 'Mobile', FALSE, FALSE);

-- Product Input Fields (Custom inputs for purchase)
INSERT INTO product_fields (product_id, field_name, field_type, placeholder, help_text, is_required) VALUES
(1, 'User ID', 'number', 'Masukkan User ID (contoh: 12345678)', 'User ID bisa ditemukan dengan mengklik avatar Anda di pojok kiri atas game.', TRUE),
(1, 'Zone ID', 'number', 'Masukkan Zone ID (contoh: 1234)', 'Zone ID berada di dalam tanda kurung di sebelah User ID Anda.', TRUE),
(2, 'Character ID', 'number', 'Masukkan Character ID (contoh: 5123456789)', 'Temukan Character ID di profil game Anda, tepat di bawah username Anda.', TRUE),
(3, 'Player ID', 'number', 'Masukkan Player ID (contoh: 847291039)', 'Player ID dapat ditemukan di menu profil game Free Fire Anda.', TRUE),
(7, 'Riot ID', 'text', 'Masukkan Riot ID + Tagline (contoh: Gamer#ID)', 'Riot ID dapat ditemukan di menu profil game Valorant Anda.', TRUE),
(9, 'Nomor Telepon', 'text', 'Masukkan Nomor Telkomsel Anda (contoh: 081234567890)', 'Nomor telepon harus diawali dengan angka 08 atau +62.', TRUE),
(10, 'Nomor Telepon', 'text', 'Masukkan Nomor XL Anda (contoh: 081734567890)', 'Nomor telepon harus diawali dengan angka 08 atau +62.', TRUE),
(13, 'UID', 'number', 'Masukkan UID Anda (contoh: 812345678)', 'UID bisa dilihat di pojok kanan bawah layar game Anda.', TRUE),
(13, 'Server', 'text', 'Masukkan Server (contoh: Asia, America, Europe)', 'Pilih server tempat karakter Anda dibuat.', TRUE),
(14, 'Nomor Telepon', 'text', 'Masukkan Nomor Indosat Anda (contoh: 085712345678)', 'Nomor telepon harus diawali dengan angka 08 atau +62.', TRUE),
(15, 'Nomor Telepon', 'text', 'Masukkan Nomor Smartfren Anda (contoh: 088212345678)', 'Nomor telepon harus diawali dengan angka 08 atau +62.', TRUE);

-- Product Packages (Denominations / Prices)
-- Product 1: Mobile Legends Diamonds
INSERT INTO product_packages (product_id, name, price, discount_percent) VALUES
(1, '13 Diamonds + 1 Bonus', 4600.00, 5.00),
(1, '38 Diamonds + 4 Bonus', 13700.00, 5.00),
(1, '64 Diamonds + 6 Bonus', 22700.00, 5.00),
(1, '127 Diamonds + 13 Bonus', 45400.00, 5.00),
(1, '254 Diamonds + 30 Bonus', 91100.00, 5.00),
(1, '633 Diamonds + 83 Bonus', 227800.00, 5.00),
(1, '1252 Diamonds + 194 Bonus', 454300.00, 5.00),
(1, '2501 Diamonds + 475 Bonus', 911100.00, 5.00);

-- Product 2: PUBG Mobile UC
INSERT INTO product_packages (product_id, name, price, discount_percent) VALUES
(2, '60 UC', 14000.00, 0.00),
(2, '325 UC', 70000.00, 2.00),
(2, '660 UC', 14000.00, 3.00),
(2, '1800 UC', 350000.00, 5.00),
(2, '3850 UC', 700000.00, 5.00),
(2, '8100 UC', 1400000.00, 6.00);

-- Product 3: Free Fire Diamonds
INSERT INTO product_packages (product_id, name, price, discount_percent) VALUES
(3, '5 Diamonds', 1000.00, 0.00),
(3, '12 Diamonds', 2000.00, 0.00),
(3, '50 Diamonds', 8000.00, 2.00),
(3, '70 Diamonds', 10000.00, 2.00),
(3, '140 Diamonds', 20000.00, 3.00),
(3, '355 Diamonds', 50000.00, 4.00),
(3, '720 Diamonds', 100000.00, 5.00),
(3, '1450 Diamonds', 200000.00, 5.00);

-- Product 4: Steam Wallet Code (IDR)
INSERT INTO product_packages (product_id, name, price, discount_percent) VALUES
(4, 'Steam Wallet IDR 12,000', 15000.00, 0.00),
(4, 'Steam Wallet IDR 45,000', 55000.00, 2.00),
(4, 'Steam Wallet IDR 60,000', 72000.00, 2.00),
(4, 'Steam Wallet IDR 90,000', 108000.00, 3.00),
(4, 'Steam Wallet IDR 120,000', 142000.00, 3.00),
(4, 'Steam Wallet IDR 250,000', 290000.00, 4.00),
(4, 'Steam Wallet IDR 400,000', 460000.00, 4.00),
(4, 'Steam Wallet IDR 600,000', 690000.00, 5.00);

-- Product 5: Roblox Gift Card (USD)
INSERT INTO product_packages (product_id, name, price, discount_percent) VALUES
(5, 'Roblox $10 Gift Card (1,000 Robux)', 150000.00, 0.00),
(5, 'Roblox $25 Gift Card (2,500 Robux)', 375000.00, 2.00),
(5, 'Roblox $50 Gift Card (5,000 Robux)', 750000.00, 3.00),
(5, 'Roblox $100 Gift Card (10,000 Robux)', 1500000.00, 5.00);

-- Product 6: Razer Gold (IDR)
INSERT INTO product_packages (product_id, name, price, discount_percent) VALUES
(6, 'Razer Gold 10,000', 11500.00, 0.00),
(6, 'Razer Gold 20,000', 22500.00, 1.00),
(6, 'Razer Gold 50,000', 55000.00, 1.00),
(6, 'Razer Gold 100,000', 109000.00, 2.00),
(6, 'Razer Gold 200,000', 217000.00, 2.00),
(6, 'Razer Gold 500,000', 540000.00, 3.00);

-- Product 7: Valorant Points
INSERT INTO product_packages (product_id, name, price, discount_percent) VALUES
(7, '125 Valorant Points', 15000.00, 0.00),
(7, '380 Valorant Points', 45000.00, 1.00),
(7, '790 Valorant Points', 90000.00, 2.00),
(7, '1650 Valorant Points', 180000.00, 3.00),
(7, '2850 Valorant Points', 300000.00, 4.00),
(7, '5800 Valorant Points', 600000.00, 5.00);

-- Product 8: Garena Shells (ID)
INSERT INTO product_packages (product_id, name, price, discount_percent) VALUES
(8, '33 Garena Shells', 11000.00, 0.00),
(8, '66 Garena Shells', 21000.00, 1.00),
(8, '165 Garena Shells', 52000.00, 1.00),
(8, '330 Garena Shells', 103000.00, 2.00),
(8, '825 Garena Shells', 255000.00, 3.00);

-- Product 9: Telkomsel Pulsa
INSERT INTO product_packages (product_id, name, price, discount_percent) VALUES
(9, 'Pulsa Rp 5.000', 6000.00, 0.00),
(9, 'Pulsa Rp 10.000', 11000.00, 0.00),
(9, 'Pulsa Rp 25.000', 25500.00, 1.00),
(9, 'Pulsa Rp 50.000', 49500.00, 2.00),
(9, 'Pulsa Rp 100.000', 97500.00, 3.00);

-- Product 10: XL Pulsa
INSERT INTO product_packages (product_id, name, price, discount_percent) VALUES
(10, 'Pulsa Rp 5.000', 6000.00, 0.00),
(10, 'Pulsa Rp 10.000', 11000.00, 0.00),
(10, 'Pulsa Rp 25.000', 25500.00, 1.00),
(10, 'Pulsa Rp 50.000', 49500.00, 2.00),
(10, 'Pulsa Rp 100.000', 97500.00, 3.00);

-- Product 11: Minecraft Java & Bedrock Edition
INSERT INTO product_packages (product_id, name, price, discount_percent) VALUES
(11, 'Minecraft PC Key Global', 390000.00, 5.00);

-- Product 12: GTA V Premium Edition
INSERT INTO product_packages (product_id, name, price, discount_percent) VALUES
(12, 'GTA V Premium Edition Epic Key', 180000.00, 0.00);

-- Product 13: Genshin Impact Genesis Crystals
INSERT INTO product_packages (product_id, name, price, discount_percent) VALUES
(13, '60 Genesis Crystals', 16000.00, 0.00),
(13, '300 + 30 Genesis Crystals', 79000.00, 2.00),
(13, '980 + 110 Genesis Crystals', 249000.00, 3.00),
(13, '1980 + 260 Genesis Crystals', 479000.00, 3.00),
(13, '3280 + 600 Genesis Crystals', 799000.00, 4.00),
(13, '6480 + 1600 Genesis Crystals', 1599000.00, 5.00);

-- Product 14: Indosat Pulsa
INSERT INTO product_packages (product_id, name, price, discount_percent) VALUES
(14, 'Pulsa Rp 5.000', 6000.00, 0.00),
(14, 'Pulsa Rp 10.000', 11000.00, 0.00),
(14, 'Pulsa Rp 25.000', 25500.00, 1.00),
(14, 'Pulsa Rp 50.000', 49500.00, 2.00),
(14, 'Pulsa Rp 100.000', 97500.00, 3.00);

-- Product 15: Smartfren Pulsa
INSERT INTO product_packages (product_id, name, price, discount_percent) VALUES
(15, 'Pulsa Rp 5.000', 6000.00, 0.00),
(15, 'Pulsa Rp 10.000', 11000.00, 0.00),
(15, 'Pulsa Rp 25.000', 25500.00, 1.00),
(15, 'Pulsa Rp 50.000', 49500.00, 2.00),
(15, 'Pulsa Rp 100.000', 97500.00, 3.00);

