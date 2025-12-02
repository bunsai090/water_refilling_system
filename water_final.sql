-- ============================================================
-- Water Refilling Station Management System - Database Schema
-- ============================================================
-- Database: water_refilling_db
-- Created: 2025-12-02
-- ============================================================

-- Drop existing database if exists and create new one
DROP DATABASE IF EXISTS water_refilling_db;
CREATE DATABASE water_refilling_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE water_refilling_db;

-- ============================================================
-- TABLE: users
-- Description: Stores user accounts and authentication info
-- ============================================================
DROP TABLE IF EXISTS users;
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    phone VARCHAR(20),
    role ENUM('Administrator', 'Staff', 'Manager') DEFAULT 'Staff',
    status ENUM('Active', 'Inactive') DEFAULT 'Active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    last_login TIMESTAMP NULL,
    INDEX idx_username (username),
    INDEX idx_role (role)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- TABLE: customers
-- Description: Stores customer information
-- ============================================================
DROP TABLE IF EXISTS customers;
CREATE TABLE customers (
    customer_id INT AUTO_INCREMENT PRIMARY KEY,
    customer_code VARCHAR(20) NOT NULL UNIQUE,
    full_name VARCHAR(100) NOT NULL,
    address TEXT,
    phone VARCHAR(20),
    email VARCHAR(100),
    total_orders INT DEFAULT 0,
    total_spent DECIMAL(10, 2) DEFAULT 0.00,
    status ENUM('Active', 'Inactive') DEFAULT 'Active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_customer_code (customer_code),
    INDEX idx_name (full_name),
    INDEX idx_phone (phone)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- TABLE: inventory
-- Description: Stores inventory items (bottles, water stock)
-- ============================================================
DROP TABLE IF EXISTS inventory;
CREATE TABLE inventory (
    inventory_id INT AUTO_INCREMENT PRIMARY KEY,
    item_name VARCHAR(100) NOT NULL,
    item_type ENUM('Full Bottle', 'Empty Bottle', 'Water Stock', 'Other') NOT NULL,
    quantity INT NOT NULL DEFAULT 0,
    unit VARCHAR(20) DEFAULT 'pcs',
    price DECIMAL(10, 2) DEFAULT 0.00,
    min_stock_level INT DEFAULT 10,
    status ENUM('In Stock', 'Low Stock', 'Out of Stock') DEFAULT 'In Stock',
    last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_item_type (item_type),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- TABLE: orders
-- Description: Stores customer orders
-- ============================================================
DROP TABLE IF EXISTS orders;
CREATE TABLE orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    order_code VARCHAR(20) NOT NULL UNIQUE,
    customer_id INT NOT NULL,
    order_type ENUM('Refill', 'New Bottle', 'Return', 'Other') DEFAULT 'Refill',
    quantity INT NOT NULL DEFAULT 1,
    unit_price DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    total_amount DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    order_status ENUM('Pending', 'Processing', 'Completed', 'Cancelled') DEFAULT 'Pending',
    payment_status ENUM('Unpaid', 'Paid', 'Partial') DEFAULT 'Unpaid',
    notes TEXT,
    created_by INT,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    completed_date TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES customers(customer_id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(user_id) ON DELETE SET NULL,
    INDEX idx_order_code (order_code),
    INDEX idx_customer (customer_id),
    INDEX idx_order_status (order_status),
    INDEX idx_payment_status (payment_status),
    INDEX idx_order_date (order_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- TABLE: payments
-- Description: Stores payment transactions
-- ============================================================
DROP TABLE IF EXISTS payments;
CREATE TABLE payments (
    payment_id INT AUTO_INCREMENT PRIMARY KEY,
    payment_code VARCHAR(20) NOT NULL UNIQUE,
    order_id INT NOT NULL,
    customer_id INT NOT NULL,
    amount DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    payment_method ENUM('Cash', 'GCash', 'Bank Transfer', 'Credit Card', 'Other') DEFAULT 'Cash',
    payment_status ENUM('Pending', 'Completed', 'Failed', 'Refunded') DEFAULT 'Completed',
    reference_number VARCHAR(100),
    notes TEXT,
    processed_by INT,
    payment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(order_id) ON DELETE CASCADE,
    FOREIGN KEY (customer_id) REFERENCES customers(customer_id) ON DELETE CASCADE,
    FOREIGN KEY (processed_by) REFERENCES users(user_id) ON DELETE SET NULL,
    INDEX idx_payment_code (payment_code),
    INDEX idx_order (order_id),
    INDEX idx_customer (customer_id),
    INDEX idx_payment_date (payment_date),
    INDEX idx_payment_status (payment_status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- TABLE: inventory_transactions
-- Description: Tracks all inventory movements
-- ============================================================
DROP TABLE IF EXISTS inventory_transactions;
CREATE TABLE inventory_transactions (
    transaction_id INT AUTO_INCREMENT PRIMARY KEY,
    inventory_id INT NOT NULL,
    transaction_type ENUM('Stock In', 'Stock Out', 'Adjustment', 'Return') NOT NULL,
    quantity INT NOT NULL,
    reference_type ENUM('Order', 'Manual', 'System') DEFAULT 'Manual',
    reference_id INT NULL,
    notes TEXT,
    created_by INT,
    transaction_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (inventory_id) REFERENCES inventory(inventory_id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(user_id) ON DELETE SET NULL,
    INDEX idx_inventory (inventory_id),
    INDEX idx_transaction_type (transaction_type),
    INDEX idx_transaction_date (transaction_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- TABLE: reports
-- Description: Stores generated reports
-- ============================================================
DROP TABLE IF EXISTS reports;
CREATE TABLE reports (
    report_id INT AUTO_INCREMENT PRIMARY KEY,
    report_name VARCHAR(100) NOT NULL,
    report_type ENUM('Sales', 'Inventory', 'Customer', 'Payment', 'Custom') NOT NULL,
    report_period VARCHAR(50),
    file_path VARCHAR(255),
    generated_by INT,
    generated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (generated_by) REFERENCES users(user_id) ON DELETE SET NULL,
    INDEX idx_report_type (report_type),
    INDEX idx_generated_at (generated_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- INSERT SAMPLE DATA
-- ============================================================

-- Insert Admin User (password: admin123 - hashed with PASSWORD_DEFAULT)
INSERT INTO users (username, password, full_name, email, phone, role, status) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator', 'admin@waterrefilling.com', '0917-000-0000', 'Administrator', 'Active');


-- ============================================================
-- VIEWS FOR REPORTING
-- ============================================================

-- View: Daily Sales Summary
CREATE OR REPLACE VIEW daily_sales_summary AS
SELECT 
    DATE(order_date) as sales_date,
    COUNT(order_id) as total_orders,
    SUM(total_amount) as total_sales,
    SUM(CASE WHEN payment_status = 'Paid' THEN total_amount ELSE 0 END) as paid_amount,
    SUM(CASE WHEN payment_status = 'Unpaid' THEN total_amount ELSE 0 END) as unpaid_amount
FROM orders
GROUP BY DATE(order_date)
ORDER BY sales_date DESC;

-- View: Customer Statistics
CREATE OR REPLACE VIEW customer_statistics AS
SELECT 
    c.customer_id,
    c.customer_code,
    c.full_name,
    c.phone,
    COUNT(o.order_id) as total_orders,
    COALESCE(SUM(o.total_amount), 0) as total_spent,
    COALESCE(SUM(CASE WHEN o.payment_status = 'Paid' THEN o.total_amount ELSE 0 END), 0) as paid_amount,
    COALESCE(SUM(CASE WHEN o.payment_status = 'Unpaid' THEN o.total_amount ELSE 0 END), 0) as unpaid_amount,
    MAX(o.order_date) as last_order_date
FROM customers c
LEFT JOIN orders o ON c.customer_id = o.customer_id
GROUP BY c.customer_id, c.customer_code, c.full_name, c.phone;

-- View: Inventory Status
CREATE OR REPLACE VIEW inventory_status_view AS
SELECT 
    i.inventory_id,
    i.item_name,
    i.item_type,
    i.quantity,
    i.unit,
    i.min_stock_level,
    CASE 
        WHEN i.quantity <= 0 THEN 'Out of Stock'
        WHEN i.quantity <= i.min_stock_level THEN 'Low Stock'
        ELSE 'In Stock'
    END as stock_status,
    i.last_updated
FROM inventory i;

-- ============================================================
-- STORED PROCEDURES
-- ============================================================

-- Procedure: Create New Order
DELIMITER //
CREATE PROCEDURE create_order(
    IN p_customer_id INT,
    IN p_order_type VARCHAR(20),
    IN p_quantity INT,
    IN p_unit_price DECIMAL(10,2),
    IN p_created_by INT,
    OUT p_order_code VARCHAR(20)
)
BEGIN
    DECLARE v_order_id INT;
    DECLARE v_total_amount DECIMAL(10,2);
    
    -- Calculate total amount
    SET v_total_amount = p_quantity * p_unit_price;
    
    -- Generate order code
    SET p_order_code = CONCAT('ORD-', LPAD((SELECT COALESCE(MAX(order_id), 0) + 1 FROM orders), 4, '0'));
    
    -- Insert order
    INSERT INTO orders (order_code, customer_id, order_type, quantity, unit_price, total_amount, created_by)
    VALUES (p_order_code, p_customer_id, p_order_type, p_quantity, p_unit_price, v_total_amount, p_created_by);
    
    -- Update customer total orders
    UPDATE customers 
    SET total_orders = total_orders + 1
    WHERE customer_id = p_customer_id;
    
END //
DELIMITER ;

-- Procedure: Process Payment
DELIMITER //
CREATE PROCEDURE process_payment(
    IN p_order_id INT,
    IN p_amount DECIMAL(10,2),
    IN p_payment_method VARCHAR(20),
    IN p_processed_by INT,
    OUT p_payment_code VARCHAR(20)
)
BEGIN
    DECLARE v_customer_id INT;
    DECLARE v_order_amount DECIMAL(10,2);
    
    -- Get order details
    SELECT customer_id, total_amount INTO v_customer_id, v_order_amount
    FROM orders WHERE order_id = p_order_id;
    
    -- Generate payment code
    SET p_payment_code = CONCAT('PAY-', LPAD((SELECT COALESCE(MAX(payment_id), 0) + 1 FROM payments), 3, '0'));
    
    -- Insert payment
    INSERT INTO payments (payment_code, order_id, customer_id, amount, payment_method, processed_by)
    VALUES (p_payment_code, p_order_id, v_customer_id, p_amount, p_payment_method, p_processed_by);
    
    -- Update order payment status
    UPDATE orders 
    SET payment_status = CASE 
        WHEN p_amount >= v_order_amount THEN 'Paid'
        WHEN p_amount > 0 THEN 'Partial'
        ELSE 'Unpaid'
    END
    WHERE order_id = p_order_id;
    
    -- Update customer total spent
    UPDATE customers 
    SET total_spent = total_spent + p_amount
    WHERE customer_id = v_customer_id;
    
END //
DELIMITER ;

-- ============================================================
-- TRIGGERS
-- ============================================================

-- Trigger: Update inventory status based on quantity
DELIMITER //
CREATE TRIGGER update_inventory_status 
BEFORE UPDATE ON inventory
FOR EACH ROW
BEGIN
    IF NEW.quantity <= 0 THEN
        SET NEW.status = 'Out of Stock';
    ELSEIF NEW.quantity <= NEW.min_stock_level THEN
        SET NEW.status = 'Low Stock';
    ELSE
        SET NEW.status = 'In Stock';
    END IF;
END //
DELIMITER ;

-- ============================================================
-- INDEXES FOR PERFORMANCE
-- ============================================================
-- Additional composite indexes for common queries

CREATE INDEX idx_orders_customer_date ON orders(customer_id, order_date);
CREATE INDEX idx_payments_customer_date ON payments(customer_id, payment_date);
CREATE INDEX idx_orders_status ON orders(order_status, payment_status);

-- ============================================================
-- DATABASE SETUP COMPLETE
-- ============================================================

-- Display success message
SELECT 'Database water_refilling_db created successfully!' as Status;
SELECT 'Default admin user created - Username: admin, Password: admin123' as LoginInfo;
SELECT COUNT(*) as TotalUsers FROM users;

