-- ============================================================
--  MELT AND MORE BAKERY - Database Schema
--  Import in phpMyAdmin, then run setup.php
-- ============================================================

CREATE DATABASE IF NOT EXISTS melt_and_more CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE melt_and_more;

-- Admin users
CREATE TABLE IF NOT EXISTS admins (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    username   VARCHAR(100) NOT NULL UNIQUE,
    password   VARCHAR(255) NOT NULL,
    full_name  VARCHAR(200) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Customer accounts
CREATE TABLE IF NOT EXISTS users (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    name       VARCHAR(200) NOT NULL,
    email      VARCHAR(200) NOT NULL UNIQUE,
    phone      VARCHAR(50)  NOT NULL,
    password   VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Products / cakes
CREATE TABLE IF NOT EXISTS cakes (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    name         VARCHAR(200) NOT NULL,
    category     VARCHAR(100) NOT NULL,
    description  TEXT,
    price        DECIMAL(10,2) NOT NULL,
    unit         VARCHAR(100) DEFAULT '1 piece',
    image_url    VARCHAR(500) DEFAULT '',
    is_available TINYINT(1)   DEFAULT 1,
    created_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Ingredients / stock
CREATE TABLE IF NOT EXISTS ingredients (
    id        INT AUTO_INCREMENT PRIMARY KEY,
    name      VARCHAR(200)   NOT NULL,
    quantity  DECIMAL(10,2)  DEFAULT 0,
    unit      VARCHAR(50)    DEFAULT 'grams',
    min_stock DECIMAL(10,2)  DEFAULT 100,
    created_at TIMESTAMP     DEFAULT CURRENT_TIMESTAMP
);

-- Customer orders
CREATE TABLE IF NOT EXISTS orders (
    id               INT AUTO_INCREMENT PRIMARY KEY,
    order_number     VARCHAR(50)  UNIQUE NOT NULL,
    customer_name    VARCHAR(200) NOT NULL,
    customer_email   VARCHAR(200) DEFAULT '',
    customer_phone   VARCHAR(50)  NOT NULL,
    delivery_address VARCHAR(500) DEFAULT '',
    cake_name        VARCHAR(200) DEFAULT '',
    quantity         INT          DEFAULT 1,
    total_amount     DECIMAL(10,2) NOT NULL,
    delivery_date    DATE          DEFAULT NULL,
    special_notes    TEXT,
    status           ENUM('pending','confirmed','preparing','delivered','cancelled') DEFAULT 'pending',
    created_at       TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at       TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- ============================================================
--  IMPORTANT: Admin password is set by setup.php
--  Run http://localhost/melt-and-more/setup.php after importing
-- ============================================================

-- Sample products
INSERT INTO cakes (name, category, description, price, unit, image_url) VALUES
('1 Pound Vanilla Cake',       'occasion_cakes','Homemade vanilla sponge with fresh cream frosting. Perfect for birthdays.',  1400.00,'1 Pound',  ''),
('2 Pound Chocolate Cake',     'occasion_cakes','Rich chocolate cake. Serves 10-12 people. Custom design available.',         2400.00,'2 Pound',  ''),
('Cupcakes - 6 Pieces',        'cupcakes',      'Assorted cupcakes with buttercream frosting. Mix or single flavour.',        1000.00,'6 Pieces', ''),
('Chocolate Mousse',           'desserts',      'Creamy mousse made with premium dark chocolate.',                            350.00, '1 Cup',    ''),
('Red Velvet Cake (1 Pound)',   'occasion_cakes','Classic red velvet with cream cheese frosting.',                            1600.00,'1 Pound',  ''),
('Strawberry Cupcakes - 6 Pcs','cupcakes',      'Fresh strawberry cupcakes with pink frosting. Great for gifting.',          1200.00,'6 Pieces', ''),
('Black Forest Cake (2 Pound)','occasion_cakes','Traditional Black Forest gateau with cherries and cream.',                  2800.00,'2 Pound',  ''),
('Cheesecake Slice',           'desserts',      'Creamy New York style cheesecake with berry topping.',                      450.00, '1 Slice',  '');

-- Sample ingredients
INSERT INTO ingredients (name, quantity, unit, min_stock) VALUES
('All Purpose Flour', 5000,'grams',1000),
('Sugar',             3000,'grams', 500),
('Butter',            2000,'grams', 300),
('Eggs',                48,'pieces',  12),
('Milk',              5000,'ml',    1000),
('Vanilla Extract',    200,'ml',      50),
('Baking Powder',      500,'grams',  100),
('Cocoa Powder',      1000,'grams',  200),
('Heavy Cream',       2000,'ml',     500),
('Cream Cheese',      1500,'grams',  300),
('Dark Chocolate',    2000,'grams',  300),
('Food Color Red',     100,'ml',      20),
('Icing Sugar',       2000,'grams',  500);

-- Sample orders (for testing)
INSERT INTO orders (order_number, customer_name, customer_email, customer_phone, delivery_address, cake_name, quantity, total_amount, status) VALUES
('MAM-260501-DEMO1','Ayesha Khan','ayesha@email.com','0300-1234567','House 5, Sahiwal','2 Pound Chocolate Cake',1,2400.00,'delivered'),
('MAM-260501-DEMO2','Sara Ahmed', 'sara@email.com',  '0321-7654321','Fatehsher, Sahiwal','Cupcakes - 6 Pieces',  1,1000.00,'confirmed'),
('MAM-260501-DEMO3','Zara Malik', 'zara@email.com',  '0333-9876543','Block B, Sahiwal',  '1 Pound Vanilla Cake', 2,2800.00,'pending');
