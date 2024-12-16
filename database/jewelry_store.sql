-- Create Database
drop database if exists gleamcraft;
create database gleamcraft;
use gleamcraft;

-- Table: Users
DROP TABLE IF EXISTS Users; -- sửa lại bảng user để tự động tăng user_id
CREATE TABLE Users ( 
    user_id INT PRIMARY KEY AUTO_INCREMENT, 
    name VARCHAR(255) NOT NULL, 
    email VARCHAR(255) NOT NULL UNIQUE, 
    password VARCHAR(255) NOT NULL, 
    phone VARCHAR(15), 
    role VARCHAR(50) NOT NULL, 
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP 
);

-- Table: Categories
DROP TABLE IF EXISTS Categories;
CREATE TABLE Categories (
    category_id INT PRIMARY KEY auto_increment,
    name VARCHAR(255),
    description TEXT,
    gender VARCHAR(50) 
);

DROP TABLE IF EXISTS Brands;
CREATE TABLE Brands (
    brand_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
-- Table: Products
DROP TABLE IF EXISTS Products;
CREATE TABLE Products (
    product_id INT PRIMARY KEY auto_increment,
    name VARCHAR(255),
    description TEXT,
    price DECIMAL(10, 2),
    category_id INT,
    brand_id INT,
    image VARCHAR(255),
    created_at DATETIME,
    FOREIGN KEY (category_id) REFERENCES Categories(category_id),
    FOREIGN KEY (brand_id) REFERENCES Brands(brand_id)
);

-- Table: Orders
DROP TABLE IF EXISTS Orders;
CREATE TABLE Orders (
    order_id INT PRIMARY KEY auto_increment,
    user_id INT,
    total_price DECIMAL(10, 2),
    status VARCHAR(50),
    created_at DATETIME,
    FOREIGN KEY (user_id) REFERENCES Users(user_id)
);

-- Table: Order_Items
DROP TABLE IF EXISTS Order_Items;
CREATE TABLE Order_Items (
    order_item_id INT PRIMARY KEY auto_increment,
    order_id INT,
    product_id INT,
    quantity INT,
    price DECIMAL(10, 2),
    FOREIGN KEY (order_id) REFERENCES Orders(order_id),
    FOREIGN KEY (product_id) REFERENCES Products(product_id)
);

-- Table: Reviews
DROP TABLE IF EXISTS Reviews;
CREATE TABLE Reviews (
    review_id INT PRIMARY KEY auto_increment,
    product_id INT,
    user_id INT,
    rating INT,
    comment TEXT,
    created_at DATETIME,
    FOREIGN KEY (product_id) REFERENCES Products(product_id),
    FOREIGN KEY (user_id) REFERENCES Users(user_id)
);

-- Table: Payments
DROP TABLE IF EXISTS Payments;
CREATE TABLE Payments (
    payment_id INT PRIMARY KEY auto_increment,
    order_id INT,
    payment_method VARCHAR(50),
    payment_status VARCHAR(50),
    amount DECIMAL(10, 2),
    payment_date DATETIME,
    FOREIGN KEY (order_id) REFERENCES Orders(order_id)
);

-- Insert data into the Products table for homepage
INSERT INTO products (name, image, price) VALUES
('Diamond necklace', 'Day-chuyen-1.jpg', 817000),
('Diamond necklace', 'Day-chuyen-2.jpg', 785000),
('Diamond necklace', 'Day-chuyen-3.jpg', 1250000),
('Diamond Ring', 'Nhan-1.jpg', 637000),
('Diamond Ring', 'Nhan-2.jpg', 632000),
('Diamond Ring', 'Nhan-3.jpg', 1674000),
('Diamond Earing', 'Khuyen-1.jpg', 708000),
('Diamond Earing', 'Khuyen-2.jpg', 1600000);

