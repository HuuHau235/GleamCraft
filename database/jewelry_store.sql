-- Create Database
drop database if exists gleamcraft;
create database gleamcraft;
use gleamcraft;

-- Table: Users
DROP TABLE IF EXISTS Users; 
CREATE TABLE Users ( 
    user_id INT PRIMARY KEY AUTO_INCREMENT, 
    name VARCHAR(255) NOT NULL, 
    email VARCHAR(255) NOT NULL UNIQUE, 
    password VARCHAR(255) NOT NULL, 
    phone VARCHAR(15), 
    role VARCHAR(50) NOT NULL, 
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP 
);

-- Table: Products
DROP TABLE IF EXISTS Products;
CREATE TABLE Products (
    product_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    color ENUM('red', 'white', 'blue'), -- Giới hạn màu sắc chỉ có 3 lựa chọn: red, white, blue
    gender INT CHECK (gender IN (0, 1, 2)), -- 0: Nữ, 1: Nam, 2: Cả hai
    type_name ENUM('ring', 'necklace', 'bracelet', 'earring'),
    price DECIMAL(10, 2),
    image VARCHAR(255)
);

CREATE TABLE cart (
    cart_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id int not null,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    product_name VARCHAR(255) DEFAULT NULL,
    product_image VARCHAR(255) DEFAULT NULL,
    product_description TEXT DEFAULT NULL,
    product_price DECIMAL(10,2) DEFAULT NULL,
    INDEX product_idx (product_id)
);

-- Table: Orders
DROP TABLE IF EXISTS Orders;
CREATE TABLE Orders (
    order_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    total_price DECIMAL(10, 2) NOT NULL, -- Tổng số tiền của đơn hàng
    customer_name VARCHAR(255),         -- Tên khách hàng
    customer_address TEXT,              -- Địa chỉ giao hàng
    customer_phone VARCHAR(15),         -- Số điện thoại
    customer_note TEXT,                 -- Ghi chú khách hàng
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP, -- Thời gian đặt hàng
    FOREIGN KEY (user_id) REFERENCES Users(user_id) ON DELETE CASCADE
);


-- Table: Order_Items
DROP TABLE IF EXISTS Order_Items;
CREATE TABLE Order_Items (
    order_item_id INT PRIMARY KEY AUTO_INCREMENT,
    order_id INT NOT NULL,            -- Liên kết với bảng Orders
    product_name VARCHAR(255) NOT NULL,  -- Tên sản phẩm từ bảng cart
    product_image VARCHAR(255),       -- Hình ảnh sản phẩm từ bảng cart
    product_description TEXT,         -- Mô tả sản phẩm từ bảng cart
    quantity INT NOT NULL,            -- Số lượng từ bảng cart
    price DECIMAL(10, 2) NOT NULL,    -- Giá tại thời điểm đặt hàng từ bảng cart
    FOREIGN KEY (order_id) REFERENCES Orders(order_id) ON DELETE CASCADE
);



-- Table: Reviews
DROP TABLE IF EXISTS Reviews;
CREATE TABLE Reviews (
    review_id INT PRIMARY KEY AUTO_INCREMENT,
    product_id INT,
    user_id INT,
    comment TEXT,
    created_at DATETIME,
    FOREIGN KEY (product_id) REFERENCES Products(product_id),
    FOREIGN KEY (user_id) REFERENCES Users(user_id) ON DELETE CASCADE
);

-- Table: Payments
DROP TABLE IF EXISTS Payments;
CREATE TABLE Payments (
    payment_id INT PRIMARY KEY AUTO_INCREMENT,
    order_id INT,
    payment_method VARCHAR(50),
    payment_status VARCHAR(50),
    payment_date DATETIME,
    FOREIGN KEY (order_id) REFERENCES Orders(order_id)
);

-- Insert data into the Products table for homepage
-- INSERT INTO products (name, image, price) VALUES
-- ('Diamond necklace', 'Day-chuyen-1.jpg', 817000),
-- ('Diamond necklace', 'Day-chuyen-2.jpg', 785000),
-- ('Diamond necklace', 'Day-chuyen-3.jpg', 1250000),
-- ('Diamond Ring', 'Nhan-1.jpg', 637000),
-- ('Diamond Ring', 'Nhan-2.jpg', 632000),
-- ('Diamond Ring', 'Nhan-3.jpg', 1674000),
-- ('Diamond Earing', 'Khuyen-1.jpg', 708000),
-- ('Diamond Earing', 'Khuyen-2.jpg', 1600000);


INSERT INTO Products (name, description, color, gender, type_name, price, image)
VALUES 
('Silver Women Bracelet Platinum Plated with CZ Four-leaf Clover LILI_612672', 'Silver women bracelet platinum plated with CZ four-leaf clover', 'White', 0, 'bracelet', 816000.00, 'https://lili.vn/wp-content/uploads/2021/12/Lac-tay-bac-nu-ma-bach-kim-dinh-pha-le-co-bon-la-LILI_612672_34-400x400.jpg'),
('Silver Anklet Women with CZ Four-leaf Clover Mildred LILI_763298', 'Silver anklet women with CZ four-leaf clover', 'White', 0, 'bracelet', 810000.00, 'https://lili.vn/wp-content/uploads/2022/09/Lac-chan-bac-nu-dinh-da-CZ-hinh-co-4-la-Mildred-LILI_763298_2-400x400.jpg'),
('Silver Couple Bracelet Forever Love LILI_986852', 'Silver couple bracelet Forever Love', 'White', 2, 'bracelet', 1188000.00, 'https://lili.vn/wp-content/uploads/2020/12/Vong-tay-bac-theo-cap-LILI_986852-04-400x400.jpg'),
('Silver Women Bracelet Swarovski Crystal Ocean Heart LILI_579467', 'Silver women bracelet Swarovski crystal ocean heart', 'White', 0, 'bracelet', 901000.00, 'https://lili.vn/wp-content/uploads/2020/11/vong-tay-bac-925-dinh-pha-le-swarovski-1-400x400.jpg'),
('Silver Men Bracelet Simple Cuban Link Saint Laurent Paris LILI_746785', 'Silver men bracelet simple Cuban link Saint Laurent Paris', 'Red', 1, 'bracelet', 3066000.00, 'https://lili.vn/wp-content/uploads/2022/01/Lac-tay-bac-nam-mat-xich-don-gian-ngau-Cuban-Saint-Laurent-Paris-LILI_746785_30-400x400.jpg'),
('Silver Women Bracelet CZ Rose Flower LILI_787759', 'Silver women bracelet CZ rose flower', 'Red', 0, 'bracelet', 684000.00, 'https://lili.vn/wp-content/uploads/2022/06/Lac-tay-bac-nu-dinh-da-CZ-hinh-bong-hoa-hong-LILI_787759_1-400x400.jpg'),
('Silver Couple Bracelet Gold Plated Love Sunshine LILI_349995', 'Silver couple bracelet gold plated Love Sunshine', 'Red', 2, 'bracelet', 2893000.00, 'https://lili.vn/wp-content/uploads/2021/08/Lac-tay-bac-doi-Love-Sunshine-LILI_349995_1-400x400.jpg'),
('Silver Ta S999 Women Bracelet Four-leaf Clover Styled LILI_661577', 'Silver Ta S999 women bracelet four-leaf clover styled', 'Blue', 0, 'bracelet', 920000.00, 'https://lili.vn/wp-content/uploads/2021/11/Lac-tay-bac-nu-co-4-la-cach-dieu-LILI_661577_6-400x400.jpg'),


('Silver Heart-Shaped Earrings for Women Raina LILI_132717', 'Silver Heart-Shaped Earrings for Women', 'White', 0, 'earring', 573000.00, 'https://lili.vn/wp-content/uploads/2024/06/Bong-tai-bac-nu-hinh-trai-tim-cach-dieu-Raina-LILI_132717_4-400x400.jpg'),
('Silver Fake Clip-On Ear Cuffs for Men/Women Marleigh LILI_132690', 'Silver Fake Clip-On Ear Cuffs for Men/Women Marleigh', 'Blue', 1, 'earring', 659000.00, 'https://lili.vn/wp-content/uploads/2024/06/Bong-tai-bac-nu-nam-gia-kep-vanh-tai-Marleigh-LILI_132690_1-400x400.jpg'),
('Silver Fake Clip-On Ear Cuffs for Men/Women Caro LILI_132671', 'Silver Fake Clip-On Ear Cuffs for Men/Women Caro', 'Blue', 1, 'earring', 676000.00, 'https://lili.vn/wp-content/uploads/2024/06/Bong-tai-bac-nu-nam-gia-kep-vanh-tai-Caro-LILI_132671_1-400x400.jpg'),
('Silver Fake Clip-On Ear Cuffs for Men/Women Ashlynn LILI_132648', 'Silver Fake Clip-On Ear Cuffs for Men/Women Ashlynn', 'White', 1, 'earring', 521000.00, 'https://lili.vn/wp-content/uploads/2024/06/Bong-tai-bac-nu-nam-gia-kep-vanh-tai-Ashlynn-LILI_132648_1-400x400.jpg'),
('Silver Fake Clip-On Ear Cuffs for Men/Women Rian LILI_132606', 'Silver Fake Clip-On Ear Cuffs for Men/Women Rian', 'White', 1, 'earring', 521000.00, 'https://lili.vn/wp-content/uploads/2024/06/Bong-tai-bac-nu-nam-gia-kep-vanh-tai-Rian-LILI_132606_2-400x400.jpg'),
('Silver Fake Clip-On Pearl-Decorated Ear Cuffs for Women Kimora LILI_132594', 'Silver Fake Clip-On Pearl-Decorated Ear Cuffs for Women Kimora', 'White', 0, 'earring', 536000.00, 'https://lili.vn/wp-content/uploads/2024/06/Bong-tai-bac-nu-dinh-ngoc-trai-kep-vanh-tai-Kimora-LILI_132594_1-400x400.jpg'),
('Silver CZ Stone-Decorated Ear Cuffs for Men/Women Magdalena LILI_132581', 'Silver CZ Stone-Decorated Ear Cuffs for Men/Women Magdalena', 'Red', 1, 'earring', 584000.00, 'https://lili.vn/wp-content/uploads/2024/06/Bong-tai-bac-nu-nam-dinh-da-CZ-Magdalena-LILI_132581_3-400x400.jpg'),
('Silver Roman Numeral Black Round Earrings for Men/Women Athena LILI_132574', 'Silver Roman Numeral Black Round Earrings for Men/Women Athena', 'Red', 1, 'earring', 674000.00, 'https://lili.vn/wp-content/uploads/2024/06/Bong-tai-bac-nu-nam-tron-den-hinh-so-la-ma-Athena-LILI_132574_2-400x400.jpg'),
('Silver CZ Stone Clip-On C Earrings for Men/Women August LILI_132565', 'Silver CZ Stone Clip-On C Earrings for Men/Women August', 'Blue', 1, 'earring', 514000.00, 'https://lili.vn/wp-content/uploads/2024/06/Bong-tai-bac-nu-nam-dinh-da-CZ-kep-vanh-chu-C-August-LILI_132565_3-400x400.jpg'),
('Silver CZ Stone Round Fashion Earrings Harlee LILI_132556', 'Silver CZ Stone Round Fashion Earrings Harlee', 'White', 0, 'earring', 624000.00, 'https://lili.vn/wp-content/uploads/2024/06/Bong-tai-bac-nu-dinh-da-CZ-tron-cach-dieu-Harlee-LILI_132556_4-400x400.jpg'),
('Silver Butterfly CZ Stone Earrings Amaris LILI_132546', 'Silver Butterfly CZ Stone Earrings Amaris', 'Blue', 0, 'earring', 594000.00, 'https://lili.vn/wp-content/uploads/2024/06/Bong-tai-bac-nu-dinh-da-CZ-hinh-ho-diep-Amaris-LILI_132546_3-400x400.jpg'),
('Silver CZ Stone Four-Leaf Clover Earrings Keily LILI_132535', 'Silver CZ Stone Four-Leaf Clover Earrings Keily', 'Blue', 0, 'earring', 536000.00, 'https://lili.vn/wp-content/uploads/2024/06/Bong-tai-bac-nu-dinh-da-CZ-hinh-co-4-la-Keily-LILI_132535_1-400x400.jpg'),
('Silver CZ Stone Earrings Yamileth LILI_132525', 'Silver CZ Stone Earrings Yamileth', 'Red', 1, 'earring', 711000.00, 'https://lili.vn/wp-content/uploads/2024/06/Bong-tai-bac-nu-nam-dinh-da-CZ-Yamileth-LILI_132525_6-400x400.jpg'),
('Silver CZ Stone Four-Leaf Clover Earrings Jolie LILI_132484', 'Silver CZ Stone Four-Leaf Clover Earrings Jolie', 'Blue', 0, 'earring', 612000.00, 'https://lili.vn/wp-content/uploads/2024/06/Bong-tai-bac-nu-dinh-da-CZ-hinh-co-4-la-Jolie-LILI_132484_1-400x400.jpg'),
('Silver Bow Earrings Raquel LILI_132475', 'Silver Bow Earrings Raquel', 'White', 0, 'earring', 631000.00, 'https://lili.vn/wp-content/uploads/2024/06/Bong-tai-bac-nu-hinh-chiec-no-Raquel-LILI_132475_5-400x400.jpg'),
('Silver Cute Bow Earrings for Women Cute LILI_132465', 'Silver Cute Bow Earrings for Women Cute', 'White', 0, 'earring', 596000.00, 'https://lili.vn/wp-content/uploads/2024/06/Bong-tai-bac-nu-chiec-no-Cute-LILI_132465_6-400x400.jpg'),
('Silver Fish Tail Earrings Judith LILI_132454', 'Silver Fish Tail Earrings Judith', 'Blue', 0, 'earring', 551000.00, 'https://lili.vn/wp-content/uploads/2024/06/Bong-tai-bac-nu-hinh-duoi-ca-Judith-LILI_132454_1-400x400.jpg'),
('Silver Bow Earrings Dalia LILI_132446', 'Silver Bow Earrings Dalia', 'White', 0, 'earring', 543000.00, 'https://lili.vn/wp-content/uploads/2024/06/Bong-tai-bac-nu-hinh-chiec-no-Dalia-LILI_132446_2-400x400.jpg'),
('Silver CZ Stone Cute Bow Earrings Salma LILI_132433', 'Silver CZ Stone Cute Bow Earrings Salma', 'Red', 0, 'earring', 555000.00, 'https://lili.vn/wp-content/uploads/2024/06/Bong-tai-bac-nu-dinh-da-CZ-hinh-chiec-no-xinh-xan-Salma-LILI_132433_1-400x400.jpg'),
('Silver Butterfly Fake Clip-On Earrings Nori LILI_132423', 'Silver Butterfly Fake Clip-On Earrings Nori', 'Blue', 0, 'earring', 652000.00, 'https://lili.vn/wp-content/uploads/2024/06/Bong-tai-bac-nu-gia-kep-vanh-tai-hinh-ho-diep-Nori-LILI_132423_1-400x400.jpg'),
('Silver Long Chain Link Earrings Lilyana LILI_132412', 'Silver Long Chain Link Earrings Lilyana', 'Red', 0, 'earring', 587000.00, 'https://lili.vn/wp-content/uploads/2024/06/Bong-tai-bac-nu-chuoi-xich-dai-Lilyana-LILI_132412_5-400x400.jpg'),
('Silver Round Cloud Pattern Earrings Chandler LILI_132401', 'Silver Round Cloud Pattern Earrings Chandler', 'Blue', 1, 'earring', 587000.00, 'https://lili.vn/wp-content/uploads/2024/06/Bong-tai-bac-nu-nam-tron-hinh-van-may-Chandler-LILI_132401_5-400x400.jpg'),
('Silver Round Earrings Hadlee LILI_132385', 'Silver Round Earrings Hadlee', 'White', 1, 'earring', 537000.00, 'https://lili.vn/wp-content/uploads/2024/06/Bong-tai-bac-nu-nam-tron-Hadlee-LILI_132385_2-400x400.jpg'),


('Silver ring for women with Moissanite diamond Aidan LILI_335168', 'Silver ring for women with Moissanite diamond Aidan LILI_335168', 'white', 0, 'ring', 1145000, 'https://lili.vn/wp-content/uploads/2022/07/Nhan-bac-nu-dinh-kim-cuong-Moissanite-Aidan-LILI_335168_4-400x400.jpg'),
('Silver ring for women with CZ stone butterfly flower LILI_661591', 'Silver ring for women with CZ stone butterfly flower LILI_661591', 'red', 0, 'ring', 620000, 'https://lili.vn/wp-content/uploads/2022/08/Nhan-bac-nu-dinh-da-CZ-hoa-buom-LILI_661591_2-400x400.jpg'),
('Silver ring for women with Moissanite diamond Scarlett LILI_054807', 'Silver ring for women with Moissanite diamond Scarlett LILI_054807', 'white', 0, 'ring', 935000, 'https://lili.vn/wp-content/uploads/2022/11/Nhan-bac-nu-dinh-kim-cuong-Moissanite-Scarlett-LILI_054807_4-400x400.jpg'),
('Silver ring for women with CZ stone peach blossom LILI_289467', 'Silver ring for women with CZ stone peach blossom LILI_289467', 'red', 0, 'ring', 632000, 'https://lili.vn/wp-content/uploads/2021/11/Nhan-bac-nu-dinh-da-CZ-hinh-bong-hoa-dao-LILI_289467_4-400x400.jpg'),
('Silver ring for women with gold plating and CZ stone olive tree LILI_114577', 'Silver ring for women with gold plating and CZ stone olive tree LILI_114577', 'blue', 0, 'ring', 817000, 'https://lili.vn/wp-content/uploads/2021/01/Nhan-bac-ma-vang-Cay-o-liu-LILI_114577-01-400x400.jpg'),
('Silver ring for women with 18k gold plating and CZ stone heart shape LILI_349632', 'Silver ring for women with 18k gold plating and CZ stone heart shape LILI_349632', 'red', 0, 'ring', 601000, 'https://lili.vn/wp-content/uploads/2021/12/Nhan-bac-nu-ma-vang-18k-dinh-da-CZ-hinh-trai-tim-LILI_349632_10-400x400.jpg'),
('Silver ring for women with Moissanite diamond Elfleda LILI_564974', 'Silver ring for women with Moissanite diamond Elfleda LILI_564974', 'white', 0, 'ring', 1070000, 'https://lili.vn/wp-content/uploads/2022/07/Nhan-bac-nu-dinh-kim-cuong-Moissanite-Elfleda-LILI_564974_4-400x400.jpg'),
('Silver ring for women with gold plating and CZ stone Ares LILI_583794', 'Silver ring for women with gold plating and CZ stone Ares LILI_583794', 'blue', 0, 'ring', 637000, 'https://lili.vn/wp-content/uploads/2021/11/Nhan-bac-nu-ma-vang-dinh-da-CZ-Ares-LILI_583794_3-400x400.jpg'),
('Silver ring for women Lucky Day LILI_791795', 'Silver ring for women Lucky Day LILI_791795', 'red', 0, 'ring', 647000, 'https://lili.vn/wp-content/uploads/2022/04/Nhan-bac-nu-may-man-Lucky-Day-LILI_791795_4-400x400.jpg'),
('Silver ring for women with Moissanite diamond 6-point star Gianna LILI_054793', 'Silver ring for women with Moissanite diamond 6-point star Gianna LILI_054793', 'white', 0, 'ring', 898000, 'https://lili.vn/wp-content/uploads/2022/11/Nhan-bac-nu-dinh-kim-cuong-Moissanite-hinh-ngoi-sao-6-canh-Gianna-LILI_054793_3-1-400x400.jpg'),
('Silver ring for women with Aurora crystal fish shape LILI_132741', 'Silver ring for women with Aurora crystal fish shape LILI_132741', 'white', 0, 'ring', 653000, 'https://lili.vn/wp-content/uploads/2021/11/Nhan-bac-nu-dinh-da-Aurora-ca-xinh-xan-LILI_132741_3-400x400.jpg'),
('Silver ring for women with simple CZ stone Royal Miracle LILI_499436', 'Silver ring for women with simple CZ stone Royal Miracle LILI_499436', 'blue', 0, 'ring', 594000, 'https://lili.vn/wp-content/uploads/2021/08/Nhan-bac-dinh-da-Zircon-Royal-LILI_499436_7-400x400.jpg'),
('Silver ring for women with platinum plating and CZ stone four-leaf clover LILI_372838', 'Silver ring for women with platinum plating and CZ stone four-leaf clover LILI_372838', 'blue', 0, 'ring', 673000, 'https://lili.vn/wp-content/uploads/2021/12/Nhan-bac-nu-ma-bach-kim-dinh-da-CZ-co-4-la-LILI_372838_5-400x400.jpg'),
('Silver ring for women with Moissanite diamond Power LILI_563524', 'Silver ring for women with Moissanite diamond Power LILI_563524', 'red', 0, 'ring', 984000, 'https://lili.vn/wp-content/uploads/2021/12/NHAN-BAC-NU-DINH-KIM-CUONG-MOISSANITE-POWER-LILI_563524_23-400x400.jpg'),
('Silver ring for women with gold plating and CZ stone infinity star LILI_189799', 'Silver ring for women with gold plating and CZ stone infinity star LILI_189799', 'blue', 0, 'ring', 632000, 'https://lili.vn/wp-content/uploads/2021/11/Nhan-bac-nu-ma-vang-dinh-da-CZ-vo-cuc-ngoi-sao-may-man-LILI_189799_2-400x400.jpg'),
('Silver ring for women with gold plating and Opal stone water drop shape Ula LILI_879391', 'Silver ring for women with gold plating and Opal stone water drop shape Ula LILI_879391', 'blue', 0, 'ring', 927000, 'https://lili.vn/wp-content/uploads/2022/08/Nhan-bac-nu-ma-vang-dinh-da-Opal-hinh-giot-nuoc-Ula-LILI_879391_4-400x400.jpg'),
('Silver ring for women with CZ stone spring branch shape LILI_765887', 'Silver ring for women with CZ stone spring branch shape LILI_765887', 'red', 0, 'ring', 631000, 'https://lili.vn/wp-content/uploads/2022/04/Nhan-bac-nu-dinh-da-CZ-hinh-canh-loc-non-LILI_765887_4-400x400.jpg'),
('Silver ring for women with Moissanite diamond heart shape Lani LILI_939178', 'Silver ring for women with Moissanite diamond heart shape Lani LILI_939178', 'blue', 0, 'ring', 1575000, 'https://lili.vn/wp-content/uploads/2022/08/Nhan-bac-nu-dinh-kim-cuong-Moissanite-hinh-trai-tim-Lani-LILI_939178_3-400x400.jpg'),
('Silver ring for women with gold plating and CZ stone two-layer butterfly LILI_155512', 'Silver ring for women with gold plating and CZ stone two-layer butterfly LILI_155512', 'red', 0, 'ring', 593000, 'https://lili.vn/wp-content/uploads/2021/11/Nhan-bac-nu-ma-vang-dinh-da-CZ-2-tang-doi-buom-xinh-LILI_155512_1-400x400.jpg'),
('Set of 2 silver rings for women with CZ stone two-layer Pandora crown LILI_825322', 'Set of 2 silver rings for women with CZ stone two-layer Pandora crown LILI_825322', 'red', 0, 'ring', 593000, 'https://lili.vn/wp-content/uploads/2021/11/Nhan-bac-nu-xep-chong-ma-vang-dinh-da-CZ-vuong-mien-pandora-LILI_825322_8-400x400.jpg'),
('Silver ring for women with Moissanite diamond Cleopatra LILI_053396', 'Silver ring for women with Moissanite diamond Cleopatra LILI_053396', 'white', 0, 'ring', 923000, 'https://lili.vn/wp-content/uploads/2022/10/Nhan-bac-nu-dang-manh-dinh-kim-cuong-Moissanite-Cleopatra-LILI_053396_4-400x400.jpg'),
('Silver ring for women with rotating CZ stone four-leaf clover Victory LILI_482977', 'Silver ring for women with rotating CZ stone four-leaf clover Victory LILI_482977', 'blue', 0, 'ring', 797000, 'https://lili.vn/wp-content/uploads/2022/06/Nhan-bac-nu-ma-vang-dang-xoay-dinh-da-CZ-co-4-la-Victory-LILI_482977_32-400x400.jpg'),
('Silver ring for women with stylish wave design Calantha LILI_796141', 'Silver ring for women with stylish wave design Calantha LILI_796141', 'blue', 0, 'ring', 719000, 'https://lili.vn/wp-content/uploads/2022/08/Nhan-bac-nu-dang-duong-cach-dieu-Calantha-LILI_796141_5-400x400.jpg'),


('Men’s Silver Anchor Ring Winston LILI_077662', 'Men’s Silver Anchor Ring Winston', 'white', 1, 'ring', 1025000, 'https://lili.vn/wp-content/uploads/2023/09/Nhan-bac-nam-hinh-mo-neo-Winston-LILI_077662_1-400x400.jpg'),
('Men’s Silver Ring with Moissanite Diamond Meredith LILI_666882', 'Men’s Silver Ring with Moissanite Diamond Meredith', 'white', 1, 'ring', 1428000, 'https://lili.vn/wp-content/uploads/2022/08/Nhan-bac-nam-dinh-kim-cuong-Moissanite-Meredith-LILI_666882_4-400x400.jpg'),
('Men’s Silver Stylized Anchor Ring Reign LILI_079395', 'Men’s Silver Stylized Anchor Ring Reign', 'white', 1, 'ring', 910000, 'https://lili.vn/wp-content/uploads/2023/10/Nhan-bac-nam-hinh-mo-neo-cach-dieu-Reign-LILI_079395_2-400x400.jpg'),
('Men’s Silver Cross Ring Titus LILI_077592', 'Men’s Silver Cross Ring Titus', 'red', 1, 'ring', 2820000, 'https://lili.vn/wp-content/uploads/2023/09/Nhan-bac-nam-hinh-thanh-gia-chu-thap-Titus-LILI_077592_4-400x400.jpg'),
('Men’s Silver Arrow Ring Braxton LILI_077224', 'Men’s Silver Arrow Ring Braxton', 'blue', 1, 'ring', 594000, 'https://lili.vn/wp-content/uploads/2023/09/Nhan-bac-nam-hinh-mui-ten-Braxton-LILI_077224_3-400x400.jpg'),
('Men’s Silver CZ Stone Ring Ryker LILI_077261', 'Men’s Silver CZ Stone Ring Ryker', 'blue', 1, 'ring', 947000, 'https://lili.vn/wp-content/uploads/2023/09/Nhan-bac-nam-dinh-da-Cubic-Zirconia-Ryker-LILI_077261_3-400x400.jpg'),
('Unisex Silver Simple Round Ring Teen Top LILI_194739', 'Unisex Silver Simple Round Ring Teen Top', 'white', 2, 'ring', 665000, 'https://lili.vn/wp-content/uploads/2021/12/Nhan-Bac-Tron-Teen-Top-LILI-194739_12-400x400.jpg'),
('Men’s Silver CZ Playing Card Ring Kyson LILI_077804', 'Men’s Silver CZ Playing Card Ring Kyson', 'blue', 1, 'ring', 1888000, 'https://lili.vn/wp-content/uploads/2023/09/Nhan-bac-nam-dinh-da-Cubic-Zirconia-hinh-la-bai-Kyson-LILI_077804_4-400x400.jpg'),
('Men’s Silver Star Ring Briggs LILI_077637', 'Men’s Silver Star Ring Briggs', 'blue', 1, 'ring', 1192000, 'https://lili.vn/wp-content/uploads/2023/09/Nhan-bac-nam-hinh-ngoi-sao-5-canh-Briggs-LILI_077637_4-400x400.jpg'),
('Men’s Silver Brantley Ring LILI_095029', 'Men’s Silver Brantley Ring', 'white', 1, 'ring', 670000, 'https://lili.vn/wp-content/uploads/2023/12/Nhan-bac-nam-Brantley-LILI_095029_2-400x400.jpg'),
('Unisex Silver Nike Logo Ring LILI_879138', 'Unisex Silver Nike Logo Ring', 'blue', 2, 'ring', 749000, 'https://lili.vn/wp-content/uploads/2021/11/Nhan-bac-nu-nam-hinh-Nike-LILI_879138_4-400x400.jpg'),
('Men’s Silver Moissanite Diamond Ring Kenji LILI_079645', 'Men’s Silver Moissanite Diamond Ring Kenji', 'white', 1, 'ring', 1242000, 'https://lili.vn/wp-content/uploads/2023/10/Nhan-bac-nam-dinh-kim-cuong-Moissanite-Kenji-LILI_079645_3-400x400.jpg'),


('Silver bracelet for women, platinum-plated, with CZ four-leaf clover stones LILI_612672', 'Silver bracelet for women, platinum-plated, with CZ four-leaf clover stones', 'white', 0, 'bracelet', 816000, 'https://lili.vn/wp-content/uploads/2021/12/Lac-tay-bac-nu-ma-bach-kim-dinh-pha-le-co-bon-la-LILI_612672_34-400x400.jpg'),
('925 silver bracelet for women, gold-plated, with Garnet and CZ rose stones LILI_886825', '925 silver bracelet for women, gold-plated, with Garnet and CZ rose stones', 'red', 0, 'bracelet', 939000, 'https://lili.vn/wp-content/uploads/2021/11/Lac-tay-bac-nu-ma-vang-dinh-da-Garnet-hoa-hong-Rose-LILI_886825_6-400x400.jpg'),
('Silver bracelet for women with CZ stones, heart-shaped pair Alvin LILI_267729', 'Silver bracelet for women with CZ stones, heart-shaped pair Alvin', 'red', 0, 'bracelet', 968000, 'https://lili.vn/wp-content/uploads/2022/06/Lac-tay-bac-nu-dinh-da-CZ-cap-trai-tim-Alvin-LILI_267729_5-400x400.jpg'),
('Silver bracelet for women, Swarovski heart crystal, The Sea Heart LILI_579467', 'Silver bracelet for women, Swarovski heart crystal, The Sea Heart', 'blue', 0, 'bracelet', 901000, 'https://lili.vn/wp-content/uploads/2020/11/vong-tay-bac-925-dinh-pha-le-swarovski-1-400x400.jpg'),
('Silver bracelet for women, CZ heart-shaped stone Love In Heart LILI_295621', 'Silver bracelet for women, CZ heart-shaped stone Love In Heart', 'red', 0, 'bracelet', 902000, 'https://lili.vn/wp-content/uploads/2022/07/Lac-tay-bac-nu-dinh-da-CZ-hinh-trai-tim-Phedra-LILI_295621_3-400x400.jpg'),
('Silver bracelet for women with CZ rose-shaped stones LILI_787759', 'Silver bracelet for women with CZ rose-shaped stones', 'red', 0, 'bracelet', 684000, 'https://lili.vn/wp-content/uploads/2022/06/Lac-tay-bac-nu-dinh-da-CZ-hinh-bong-hoa-hong-LILI_787759_1-400x400.jpg'),
('Silver bracelet for women, platinum-plated, with Moissanite diamond round stones Farah LILI_054678', 'Silver bracelet for women, platinum-plated, with Moissanite diamond round stones Farah', 'blue', 0, 'bracelet', 1243000, 'https://lili.vn/wp-content/uploads/2022/11/Vong-tay-bac-nu-dang-kieng-dinh-kim-cuong-Moissanite-tron-Farah-LILI_054678_3-400x400.jpg'),
('Silver bracelet for women, platinum-plated, with CZ heart-shaped stones LILI_276753', 'Silver bracelet for women, platinum-plated, with CZ heart-shaped stones', 'white', 0, 'bracelet', 919000, 'https://lili.vn/wp-content/uploads/2021/12/Lac-tay-bac-nu-ma-bach-kim-dinh-da-CZ-LILI_276753_12-400x400.jpg'),
('Silver bracelet for women with CZ stones, young bud branch shape LILI_247931', 'Silver bracelet for women with CZ stones, young bud branch shape', 'white', 0, 'bracelet', 702000, 'https://lili.vn/wp-content/uploads/2022/04/Lac-tay-bac-nu-dinh-da-CZ-hinh-canh-loc-non-LILI_247931_6-400x400.jpg'),
('Silver bracelet for women with Moissanite diamond Curtis LILI_882398', 'Silver bracelet for women with Moissanite diamond Curtis', 'blue', 0, 'bracelet', 1809000, 'https://lili.vn/wp-content/uploads/2022/07/Lac-tay-bac-nu-dinh-kim-cuong-Moissanite-Curtis-LILI_882398_2-400x400.jpg'),
('Silver bracelet for women, 999 silver, four-leaf clover design LILI_661577', 'Silver bracelet for women, 999 silver, four-leaf clover design', 'white', 0, 'bracelet', 920000, 'https://lili.vn/wp-content/uploads/2021/11/Lac-tay-bac-nu-co-4-la-cach-dieu-LILI_661577_6-400x400.jpg'),
('Silver bracelet for women, tennis chain with CZ stones, adjustable pull string bow LILI_869163', 'Silver bracelet for women, tennis chain with CZ stones, adjustable pull string bow', 'blue', 0, 'bracelet', 911000, 'https://lili.vn/wp-content/uploads/2022/10/Lac-tay-bac-nu-chuoi-da-CZ-dang-day-rut-that-no-LILI_869163_31-400x400.jpg'),
('Silver bracelet for women, CZ stones, Aurora whale crystal LILI_775374', 'Silver bracelet for women, CZ stones, Aurora whale crystal', 'blue', 0, 'bracelet', 757000, 'https://lili.vn/wp-content/uploads/2021/12/Lac-tay-bac-nu-dinh-da-CZ-pha-le-Aurora-ca-voi-Cute-LILI_775374_2-400x400.jpg'),
('Silver bracelet for women, CZ heart-shaped stones, Heart of the Sea LILI_427425', 'Silver bracelet for women, CZ heart-shaped stones, Heart of the Sea', 'blue', 0, 'bracelet', 1188000, 'https://lili.vn/wp-content/uploads/2021/11/Lac-tay-bac-nu-dinh-da-pha-le-hinh-trai-tim-LILI_427425_11-400x400.jpg'),
('Silver bracelet for women with CZ stones, moon gazing rabbit LILI_722163', 'Silver bracelet for women with CZ stones, moon gazing rabbit', 'blue', 0, 'bracelet', 679000, 'https://lili.vn/wp-content/uploads/2022/08/Lac-tay-bac-nu-dinh-da-CZ-tho-ngam-trang-LILI_722163_1-400x400.jpg'),
('Silver bracelet for women, Thai S925, square round chain with heart-shaped and lucky star design LILI_884778', 'Silver bracelet for women, Thai S925, square round chain with heart-shaped and lucky star design', 'blue', 0, 'bracelet', 1625000, 'https://lili.vn/wp-content/uploads/2021/11/Lac-tay-bac-nu-chuoi-vuong-tron-trai-tim-ngoi-sao-may-man-LILI_884778_3-400x400.jpg'),
('Silver bracelet for women, beautiful chain with 5-pointed star LILI_379215', 'Silver bracelet for women, beautiful chain with 5-pointed star', 'red', 0, 'bracelet', 767000, 'https://lili.vn/wp-content/uploads/2021/11/Lac-tay-bac-nu-ngoi-sao-5-canh-Super-Star-LILI_113819_3-400x400.jpg'),
('Silver bracelet for women with CZ stones, The Beauty LILI_421447', 'Silver bracelet for women with CZ stones, The Beauty', 'blue', 0, 'bracelet', 1010000, 'https://lili.vn/wp-content/uploads/2020/12/Lac-tay-bac-nu-dinh-da-CZ-The-Beauty-LILI_421447_10-400x400.jpg'),
('Silver bracelet for women with CZ stones, 5-pointed star shape LILI_532223', 'Silver bracelet for women with CZ stones, 5-pointed star shape', 'blue', 0, 'bracelet', 605000, 'https://lili.vn/wp-content/uploads/2022/08/Lac-tay-bac-nu-dinh-da-CZ-hinh-ngoi-sao-5-canh-LILI_532223_5-400x400.jpg'),
('Silver bracelet for women with CZ stones, infinity plum blossom chain LILI_196734', 'Silver bracelet for women with CZ stones, infinity plum blossom chain', 'blue', 0, 'bracelet', 1022000, 'https://lili.vn/wp-content/uploads/2022/06/Lac-tay-bac-nu-dinh-da-CZ-chuoi-hoa-mai-vo-cuc-LILI_196734_3-400x400.jpg'),
('Silver bracelet for women with CZ stones, infinity heart Forever Love LILI_877257', 'Silver bracelet for women with CZ stones, infinity heart Forever Love', 'blue', 0, 'bracelet', 695000, 'https://lili.vn/wp-content/uploads/2022/08/Lac-tay-bac-nu-dinh-da-CZ-trai-tim-vo-cuc-Forever-Love-LILI_877257_4-400x400.jpg'),
('Silver bracelet for women with CZ stones, eternal heart LILI_167424', 'Silver bracelet for women with CZ stones, eternal heart', 'blue', 0, 'bracelet', 986000, 'https://lili.vn/wp-content/uploads/2021/11/Lac-tay-bac-nu-dinh-da-CZ-trai-tim-vinh-cuu-LILI_167424_2-400x400.jpg'),
('Silver bracelet for women, platinum-plated, with Eye of the Muse crystal LILI_814348', 'Silver bracelet for women, platinum-plated, with Eye of the Muse crystal', 'blue', 0, 'bracelet', 1267000, 'https://lili.vn/wp-content/uploads/2020/12/Vong-tay-bac-ma-bach-kim-dinh-da-pha-le-Eye-of-the-muse-LILI_814348-01-400x400.jpg'),
('Silver bracelet for women with CZ stones, fairy fish Ladonna LILI_132297', 'Silver bracelet for women with CZ stones, fairy fish Ladonna', 'blue', 0, 'bracelet', 713000, 'https://lili.vn/wp-content/uploads/2022/09/Lac-tay-bac-nu-dinh-da-CZ-hinh-ca-tien-Ladonna-LILI_132297_5-1-400x400.jpg'),


('Men Silver Bracelet Simple Link Cuban Saint Laurent Paris LILI_746785', 'Men Silver Bracelet Simple Link Cuban Saint Laurent Paris', 'white', 1, 'bracelet', 3066000.00, 'https://lili.vn/wp-content/uploads/2022/01/Lac-tay-bac-nam-mat-xich-don-gian-ngau-Cuban-Saint-Laurent-Paris-LILI_746785_30-400x400.jpg'),
('Men/Women Silver Bracelet with Moissanite Diamond Cuban Chain LILI_069214', 'Men/Women Silver Bracelet with Moissanite Diamond Cuban Chain', 'red', 2, 'bracelet', 5256000.00, 'https://lili.vn/wp-content/uploads/2023/07/Lac-tay-bac-nu-nam-dinh-kim-cuong-Moissanite-chuoi-xich-Cuban-LILI_069214_4-400x400.jpg'),
('Men Silver Pure Twisted Bracelet Royal LILI_191894', 'Men Silver Pure Twisted Bracelet Royal', 'red', 1, 'bracelet', 5360000.00, 'https://lili.vn/wp-content/uploads/2021/12/Lac-tay-bac-nam-nguyen-chat-dang-xoan-Royal-LILI_191894_9-400x400.jpg'),
('Men Silver Bracelet with Braided Cord Chosen LILI_103661', 'Men Silver Bracelet with Braided Cord Chosen', 'blue', 1, 'bracelet', 787000.00, 'https://lili.vn/wp-content/uploads/2023/12/Lac-tay-bac-nam-day-ben-6-ky-tu-chu-Chosen-LILI_103661_3-400x400.jpg'),
('Men Solid Silver Bracelet Fast Boy LILI_466422', 'Men Solid Silver Bracelet Fast Boy', 'red', 1, 'bracelet', 3162000.00, 'https://lili.vn/wp-content/uploads/2022/05/Vong-tay-bac-nam-tron-Fast-Boy-LILI_466422_4-400x400.jpg'),
('Men/Women Silver Bracelet Cuban with Crown Henley LILI_096785', 'Men/Women Silver Bracelet Cuban with Crown Henley', 'white', 2, 'bracelet', 3174000.00, 'https://lili.vn/wp-content/uploads/2023/12/Lac-tay-bac-nu-ca-tinh-cuban-hinh-vuong-mien-Henley-LILI_096785_4-400x400.jpg'),
('Men Silver Thai Style Bracelet Dakota LILI_069237', 'Men Silver Thai Style Bracelet Dakota', 'white', 1, 'bracelet', 1534000.00, 'https://lili.vn/wp-content/uploads/2023/07/Lac-tay-bac-Thai-nam-ca-tinh-dang-xich-Dakota-LILI_069237_4-1-400x400.jpg'),
('Men Silver Dragon Bracelet Grady LILI_078138', 'Men Silver Dragon Bracelet Grady', 'white', 1, 'bracelet', 4899000.00, 'https://lili.vn/wp-content/uploads/2023/09/Lac-tay-bac-nam-hinh-rong-Grady-LILI_078138_4-400x400.jpg'),
('Men/Women Silver Cuban Bracelet with Moissanite Diamond Miguel LILI_076498', 'Men/Women Silver Cuban Bracelet with Moissanite Diamond Miguel', 'white', 2, 'bracelet', 9675000.00, 'https://lili.vn/wp-content/uploads/2023/09/Lac-tay-bac-nu-nam-cuban-dinh-kim-cuong-Moissanite-Miguel-LILI_076498_3-400x400.jpg'),
('Men Silver Braided Cord Black Dragon Bracelet LILI_103670', 'Men Silver Braided Cord Black Dragon Bracelet', 'white', 1, 'bracelet', 842000.00, 'https://lili.vn/wp-content/uploads/2023/12/Lac-tay-bac-nam-day-ben-du-sap-rong-den-Black-Dragon-LILI_103670_2-400x400.jpg'),
('Men Silver Round Chain Bracelet Spencer LILI_077050', 'Men Silver Round Chain Bracelet Spencer', 'blue', 1, 'bracelet', 3863000.00, 'https://lili.vn/wp-content/uploads/2023/09/Lac-tay-bac-nam-chuoi-xich-tron-Spencer-LILI_077050_4-400x400.jpg'),
('Men Solid Silver Chain Bracelet Levi LILI_075928', 'Men Solid Silver Chain Bracelet Levi', 'blue', 1, 'bracelet', 1411000.00, 'https://lili.vn/wp-content/uploads/2023/09/Lac-tay-bac-dac-nam-dang-chuoi-xich-Levi-LILI_075928_6-400x400.jpg'),
('Men Cool Silver Bracelet Keel LILI_077969', 'Men Cool Silver Bracelet Keel', 'blue', 1, 'bracelet', 5588000.00, 'https://lili.vn/wp-content/uploads/2023/09/Lac-tay-bac-nam-cool-ngau-Keel-LILI_077969_2-400x400.jpg'),
('Men Premium Silver Bracelet Barrett LILI_076555', 'Men Premium Silver Bracelet Barrett', 'blue', 1, 'bracelet', 5110000.00, 'https://lili.vn/wp-content/uploads/2023/09/Lac-tay-bac-nam-cao-cap-Barrett-LILI_076555_4-400x400.jpg'),
('Men Lucky Silver Coin Bracelet Lawson LILI_078148', 'Men Lucky Silver Coin Bracelet Lawson', 'white', 1, 'bracelet', 4899000.00, 'https://lili.vn/wp-content/uploads/2023/09/Lac-tay-bac-nam-hinh-kim-tien-may-man-Lawson-LILI_078148_3-400x400.jpg'),
('Men Trendy Silver Bracelet Matias LILI_076541', 'Men Trendy Silver Bracelet Matias', 'white', 1, 'bracelet', 3701000.00, 'https://lili.vn/wp-content/uploads/2023/09/Lac-tay-bac-nam-ca-tinh-Matias-LILI_076541_4-400x400.jpg'),
('Men Cuban Silver Bracelet Conrad LILI_077960', 'Men Cuban Silver Bracelet Conrad', 'blue', 1, 'bracelet', 6006000.00, 'https://lili.vn/wp-content/uploads/2023/09/Lac-tay-bac-nam-cuban-Conrad-LILI_077960_2-400x400.jpg'),
('Men Fashion Silver Braided Cord Bracelet Zayne LILI_078215', 'Men Fashion Silver Braided Cord Bracelet Zayne', 'white', 1, 'bracelet', 682000.00, 'https://lili.vn/wp-content/uploads/2023/09/Lac-tay-bac-nam-day-ben-du-sap-thoi-trang-Zayne-LILI_078215_5-400x400.jpg'),
('Men Silver Bracelet Simple Round Bryson LILI_076310', 'Men Silver Bracelet Simple Round Bryson', 'blue', 1, 'bracelet', 2333000.00, 'https://lili.vn/wp-content/uploads/2023/09/Lac-tay-bac-nam-ngau-mat-tron-Bryson-LILI_076310_3-400x400.jpg'),
('Men Cuban Silver Dragon Bracelet Kade LILI_078064', 'Men Cuban Silver Dragon Bracelet Kade', 'white', 1, 'bracelet', 3741000.00, 'https://lili.vn/wp-content/uploads/2023/09/Lac-tay-bac-nam-cuban-hinh-rong-Kade-LILI_078064_2-400x400.jpg'),
('Men Silver Chain Link Bracelet Phoenix LILI_752583', 'Men Silver Chain Link Bracelet Phoenix', 'red', 1, 'bracelet', 7353000.00, 'https://lili.vn/wp-content/uploads/2021/12/Lac-tay-bac-nam-chuoi-dan-nhau-ngau-Phoenix-LILI_752583_3-400x400.jpg'),
('Men Thai Silver Bracelet Holland LILI_069286', 'Men Thai Silver Bracelet Holland', 'red', 1, 'bracelet', 3588000.00, 'https://lili.vn/wp-content/uploads/2023/07/Lac-tay-bac-Thai-nam-than-chu-Holland-LILI_069286_7-400x400.jpg'),
('Men Large Cuban Silver Bracelet Damien LILI_078029', 'Men Large Cuban Silver Bracelet Damien', 'white', 1, 'bracelet', 4775000.00, 'https://lili.vn/wp-content/uploads/2023/09/Lac-tay-bac-nam-dang-cuban-co-lon-Damien-LILI_078029_3-400x400.jpg'),
('Men Twisted Chain Silver Bracelet Lorenzo LILI_076323', 'Men Twisted Chain Silver Bracelet Lorenzo', 'blue', 1, 'bracelet', 3543000.00, 'https://lili.vn/wp-content/uploads/2023/09/Vong-tay-bac-nam-dang-chuoi-xoan-Lorenzo-LILI_076323_7-400x400.jpg'),


('Silver Necklace for Women with CZ Stones in Fish Shape LILI_831944', '', 'red', 0, 'necklace', 817000, 'https://lili.vn/wp-content/uploads/2021/12/Day-chuyen-bac-nu-phong-cach-co-trang-CZ-LILI_831944_2-400x400.jpg'),
('Silver Necklace for Women with CZ Stones in Double Ring Shape Fall In Love LILI_748855', '', 'white', 0, 'necklace', 782000, 'https://lili.vn/wp-content/uploads/2022/08/Day-chuyen-bac-nu-dinh-da-CZ-dang-nhan-doi-Fall-In-Love-LILI_748855_7-400x400.jpg'),
('Silver Necklace for Women with Moissanite Diamonds in Round and Stylized Shape LILI_413898', '', 'white', 0, 'necklace', 1250000, 'https://lili.vn/wp-content/uploads/2022/06/Mat-day-chuyen-bac-nu-dinh-kim-cuong-Moissanite-tron-cach-dieu-LILI_413898_6-400x400.jpg'),
('Beautiful Silver Necklace for Women with Aurora Crystal Heart and Leaves Shape LILI_866671', '', 'blue', 0, 'necklace', 728000, 'https://lili.vn/wp-content/uploads/2021/12/Day-chuyen-bac-nu-trai-tim-hoa-la-dinh-pha-le-Aurora-LILI_866671_10-400x400.jpg'),
('Silver Necklace for Women with Swarovski Crystal Ocean Heart LILI_295787', '', 'blue', 0, 'necklace', 785000, 'https://lili.vn/wp-content/uploads/2020/12/day-chuyen-bac-mat-pha-le-swaroski-trai-tim-dai-duong-LILI_295787-1-1-400x400.jpg'),
('Beautiful and Unique Silver Necklace for Women with Double Butterfly Shape Hot Trend LILI_361718', '', 'white', 0, 'necklace', 855000, 'https://lili.vn/wp-content/uploads/2024/03/Day-chuyen-bac-nu-2-tang-dep-va-doc-hinh-doi-buom-Hot-Trend-LILI_361718_30-400x400.jpg'),
('Silver Necklace for Women with CZ Stones in Four-Leaf Clover Shape LILI_426865', '', 'white', 0, 'necklace', 785000, 'https://lili.vn/wp-content/uploads/2022/03/Mat-day-chuyen-bac-nu-dinh-da-CZ-co-4-la-LILI_426865_1-400x400.jpg'),
('Silver Necklace for Women with Moissanite Diamonds in Stag Horn Shape LILI_055097', '', 'blue', 0, 'necklace', 1058000, 'https://lili.vn/wp-content/uploads/2022/11/Day-chuyen-bac-nu-dinh-kim-cuong-Moissanite-hinh-gac-nai-LILI_055097_5-400x400.jpg'),
('Silver Necklace for Women with Aurora Stones in Small Cat and Moon Shape LILI_328547', '', 'red', 0, 'necklace', 806000, 'https://lili.vn/wp-content/uploads/2021/12/Day-chuyen-bac-nu-meo-nho-va-mat-trang-dinh-da-Moonstone-LILI_328547_2-400x400.jpg'),
('Silver Necklace for Women with CZ Stones in Stylized Heart Shape Katalina LILI_352665', '', 'red', 0, 'necklace', 800000, 'https://lili.vn/wp-content/uploads/2021/12/Mat-day-chuyen-bac-nu-trai-tim-cach-dieu-dinh-da-CZ-LILI_352665_2-400x400.jpg'),
('Silver Necklace for Women with CZ Stones in Four-Leaf Clover Heart LILI_822972', '', 'blue', 0, 'necklace', 817000, 'https://lili.vn/wp-content/uploads/2021/12/Day-chuyen-bac-nu-dinh-da-CZ-trai-tim-co-4-la-dong-mo-LILI_822972_20-400x400.jpg'),
('Silver Necklace for Women with CZ Stones in Rabbit and Moon Gazing Shape LILI_899188', '', 'white', 0, 'necklace', 648000, 'https://lili.vn/wp-content/uploads/2022/08/Day-chuyen-bac-nu-dinh-da-CZ-hinh-tho-ngam-trang-LILI_899188_3-400x400.jpg'),
('Silver Necklace for Women with CZ Stones in Four-Leaf Clover Veronica Shape LILI_172818', '', 'blue', 0, 'necklace', 747000, 'https://lili.vn/wp-content/uploads/2022/08/Day-chuyen-bac-nu-dinh-da-CZ-co-4-la-Veronica-LILI_172818_1-400x400.jpg'),
('Silver Necklace for Women with Aurora Crystal in Moon Shape LILI_545817', '', 'red', 0, 'necklace', 787000, 'https://lili.vn/wp-content/uploads/2022/09/Day-chuyen-bac-nu-dinh-pha-le-Aurora-mat-trang-cach-dieu-LILI_545817_2-400x400.jpg'),
('Silver Necklace for Women with CZ Stones in Two Joined Hearts Shape LILI_763116', '', 'blue', 0, 'necklace', 722000, 'https://lili.vn/wp-content/uploads/2021/12/Mat-day-chuyen-bac-nu-2-trai-tim-ghep-doi-LILI_763116_1-400x400.jpg'),
('Silver Necklace for Women with CZ Stones in Shooting Star Shape Farah LILI_053917', '', 'white', 0, 'necklace', 701000, 'https://lili.vn/wp-content/uploads/2022/10/Vong-co-bac-nu-dinh-da-CZ-hinh-ngoi-sao-bang-Farah-LILI_053917_2-400x400.jpg'),
('Silver Necklace for Women with CZ Stones in Swan Shape LILI_197559', '', 'white', 0, 'necklace', 782000, 'https://lili.vn/wp-content/uploads/2024/05/Day-chuyen-bac-nu-dinh-da-CZ-hinh-chu-thien-nga-LILI_197559_22-400x400.jpg'),
('Beautiful and Unique Silver Necklace for Women with Swarovski Crystal Heart Shape LILI_972812', '', 'blue', 0, 'necklace', 1194000, 'https://lili.vn/wp-content/uploads/2021/01/Day-chuyen-bac-trai-tim-pha-le-Swarovski-LILI_972812-4-400x400.jpg'),
('Silver Necklace for Women with Premium Aurora Crystal and CZ Stones in Flower Shape LILI_955426', '', 'blue', 0, 'necklace', 806000, 'https://lili.vn/wp-content/uploads/2021/12/Day-chuyen-bac-nu-hoa-la-dinh-pha-le-Aurora-da-CZ-LILI_955426_7-400x400.jpg'),
('Gold-Plated Silver Necklace for Women with CZ Stones in Round Shape Sunday LILI_531821', '', 'white', 0, 'necklace', 701000, 'https://lili.vn/wp-content/uploads/2022/10/Day-chuyen-bac-nu-ma-vang-2-tang-dinh-da-CZ-tron-Sunday-LILI_531821_1-400x400.jpg'),
('Silver Necklace for Women with Natural Diamonds in Four-Leaf Clover Lucky Shape LILI_832459', '', 'white', 0, 'necklace', 1016000, 'https://lili.vn/wp-content/uploads/2022/04/Day-chuyen-bac-nu-dinh-kim-cuong-tu-nhieu-co-4-la-LILI_832459_2-400x400.jpg'),
('Silver Necklace for Women with Sparkling Aurora Crystal Round Shape LILI_974332', '', 'blue', 0, 'necklace', 757000, 'https://lili.vn/wp-content/uploads/2021/12/Day-chuyen-bac-nu-tron-lap-lanh-pha-le-Aurora-LILI_974332_8-400x400.jpg'),
('Silver Necklace for Women with CZ Stones in Jumping Heart Shape Grainne LILI_262454', '', 'blue', 0, 'necklace', 812000, 'https://lili.vn/wp-content/uploads/2022/08/Mat-day-chuyen-bac-nu-dinh-da-CZ-trai-tim-Grainne-LILI_262454_4-400x400.jpg'),
('Silver Necklace for Women with Small CZ Stones in Stylized Heart Shape Nolan LILI_255281', '', 'blue', 0, 'necklace', 765000, 'https://lili.vn/wp-content/uploads/2022/09/Day-chuyen-bac-nu-dinh-da-CZ-hinh-trai-tim-cach-dieu-Nolan-LILI_255281_1-400x400.jpg'),


('Men Silver Pendant with Joziah Pattern LILI_080177', 'Men Silver Pendant with Joziah Pattern LILI_080177', 'blue', 1, 'necklace', 1858000.00, 'https://lili.vn/wp-content/uploads/2023/10/Mat-day-chuyen-bac-nam-hinh-hoa-van-Joziah-LILI_080177_5-400x400.jpg'),
('Men Silver Necklace with CZ Stones in Ring Shape Alexis LILI_078869', 'Men Silver Necklace with CZ Stones in Ring Shape Alexis LILI_078869', 'white', 1, 'necklace', 991000.00, 'https://lili.vn/wp-content/uploads/2023/10/Day-chuyen-bac-nam-dinh-da-CZ-hinh-chiec-nhan-Alexis-LILI_078869_1-400x400.jpg'),
('Men/Women Silver Cuban Chain Necklace Vance LILI_080856', 'Men/Women Silver Cuban Chain Necklace Vance LILI_080856', 'blue', 2, 'necklace', 4406000.00, 'https://lili.vn/wp-content/uploads/2023/10/Day-chuyen-bac-nam-nu-dang-cuban-chuoi-Vance-LILI_080856_8-400x400.jpg'),
('Men Silver Cuban Necklace with Moissanite Diamonds Vance LILI_081040', 'Men Silver Cuban Necklace with Moissanite Diamonds Vance LILI_081040', 'blue', 2, 'necklace', 10561000.00, 'https://lili.vn/wp-content/uploads/2023/10/Day-chuyen-bac-cuban-dinh-kim-cuong-Moissanite-Vance-LILI_081040_2-400x400.jpg'),
('Men Thai Silver Pendant with Broken Sword Cristian LILI_077444', 'Men Thai Silver Pendant with Broken Sword Cristian LILI_077444', 'red', 1, 'pendant', 2361000.00, 'https://lili.vn/wp-content/uploads/2023/09/Mat-day-chuyen-bac-Thai-nam-hinh-thanh-kiem-gay-Cristian-LILI_07744_1-400x400.jpg'),
('Men Silver Necklace with CZ Stones and 6-Pointed Star Ring Scott LILI_078646', 'Men Silver Necklace with CZ Stones and 6-Pointed Star Ring Scott LILI_078646', 'blue', 1, 'necklace', 920000.00, 'https://lili.vn/wp-content/uploads/2023/09/Day-chuyen-bac-nam-dinh-da-CZ-nhan-kem-ngoi-sao-6-canh-Scott-LILI_078646_2-400x400.jpg'),
('Men Thai Silver Pendant in Shield Shape Malcolm Unique Style LILI_078123', 'Men Thai Silver Pendant in Shield Shape Malcolm Unique Style LILI_078123', 'red', 1, 'pendant', 1710000.00, 'https://lili.vn/wp-content/uploads/2023/09/Mat-day-chuyen-bac-Thai-nam-dang-khien-Malcolm-phong-cach-doc-la-LILI_078123_5-400x400.jpg'),
('Men Small Silver Necklace with Square and Round Fashion Hip Hop Chain LILI_345554', 'Men Small Silver Necklace with Square and Round Fashion Hip Hop Chain LILI_345554', 'blue', 1, 'necklace', 1391000.00, 'https://lili.vn/wp-content/uploads/2021/12/Day-chuyen-bac-nam-tong-hop-chuoi-vuong-tron-thoi-trang-Hip-Hop-LILI_345554_14-400x400.jpg'),
('Men Silver Pendant in Shoe Shape Augustine LILI_076892', 'Men Silver Pendant in Shoe Shape Augustine LILI_076892', 'red', 1, 'pendant', 2138000.00, 'https://lili.vn/wp-content/uploads/2023/09/Mat-day-chuyen-bac-nam-hinh-chiec-giay-Augustine-LILI_076892_1-400x400.jpg'),
('Men Silver Pendant with CZ Stones in Cross Shape Talon LILI_080417', 'Men Silver Pendant with CZ Stones in Cross Shape Talon LILI_080417', 'white', 1, 'pendant', 1821000.00, 'https://lili.vn/wp-content/uploads/2023/10/Mat-day-chuyen-bac-nam-dinh-da-CZ-hinh-thanh-gia-Talon-LILI_080417_2-400x400.jpg');

