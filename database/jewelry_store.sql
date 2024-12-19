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

-- Table: Orders
DROP TABLE IF EXISTS Orders;
CREATE TABLE Orders (
    order_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    total_price DECIMAL(10, 2),
    status VARCHAR(50),
    created_at DATETIME,
    FOREIGN KEY (user_id) REFERENCES Users(user_id)
);

-- Table: Order_Items
DROP TABLE IF EXISTS Order_Items;
CREATE TABLE Order_Items (
    order_item_id INT PRIMARY KEY AUTO_INCREMENT,
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
    review_id INT PRIMARY KEY AUTO_INCREMENT,
    product_id INT,
    user_id INT,
    comment TEXT,
    created_at DATETIME,
    FOREIGN KEY (product_id) REFERENCES Products(product_id),
    FOREIGN KEY (user_id) REFERENCES Users(user_id)
);

-- Table: Payments
DROP TABLE IF EXISTS Payments;
CREATE TABLE Payments (
    payment_id INT PRIMARY KEY AUTO_INCREMENT,
    order_id INT,
    payment_method VARCHAR(50),
    payment_status VARCHAR(50),
    amount DECIMAL(10, 2),
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
('Lắc tay bạc nữ mạ bạch kim đính đá CZ cỏ 4 lá LILI_612672', 'Lắc tay bạc nữ mạ bạch kim đính đá CZ cỏ 4 lá', 'White', 0, 'bracelet', 816000.00, 'https://lili.vn/wp-content/uploads/2021/12/Lac-tay-bac-nu-ma-bach-kim-dinh-pha-le-co-bon-la-LILI_612672_34-400x400.jpg'),
('Lắc chân bạc nữ đính đá CZ hình cỏ 4 lá Mildred LILI_763298', 'Lắc chân bạc nữ đính đá CZ hình cỏ 4 lá', 'White', 0, 'bracelet', 810000.00, 'https://lili.vn/wp-content/uploads/2022/09/Lac-chan-bac-nu-dinh-da-CZ-hinh-co-4-la-Mildred-LILI_763298_2-400x400.jpg'),
('Lắc tay bạc cặp đôi tình yêu Forever Love LILI_986852', 'Lắc tay bạc cặp đôi tình yêu Forever Love', 'White', 2, 'bracelet', 1188000.00, 'https://lili.vn/wp-content/uploads/2020/12/Vong-tay-bac-theo-cap-LILI_986852-04-400x400.jpg'),
('Lắc tay bạc nữ đính pha lê Swarovski trái tim của biển LILI_579467', 'Lắc tay bạc nữ đính pha lê Swarovski trái tim của biển', 'White', 0, 'bracelet', 901000.00, 'https://lili.vn/wp-content/uploads/2020/11/vong-tay-bac-925-dinh-pha-le-swarovski-1-400x400.jpg'),
('Lắc tay bạc nam mắt xích đơn giản ngầu Cuban Saint Laurent Paris LILI_746785', 'Lắc tay bạc nam mắt xích đơn giản ngầu Cuban Saint Laurent Paris', 'Red', 1, 'bracelet', 3066000.00, 'https://lili.vn/wp-content/uploads/2022/01/Lac-tay-bac-nam-mat-xich-don-gian-ngau-Cuban-Saint-Laurent-Paris-LILI_746785_30-400x400.jpg'),
('Lắc tay bạc nữ đính đá CZ hình bông hoa hồng LILI_787759', 'Lắc tay bạc nữ đính đá CZ hình bông hoa hồng', 'Red', 0, 'bracelet', 684000.00, 'https://lili.vn/wp-content/uploads/2022/06/Lac-tay-bac-nu-dinh-da-CZ-hinh-bong-hoa-hong-LILI_787759_1-400x400.jpg'),
('Vòng tay bạc đặc cặp đôi tình yêu mạ vàng Love Sunshine LILI_349995', 'Vòng tay bạc đặc cặp đôi tình yêu mạ vàng Love Sunshine', 'Red', 2, 'bracelet', 2893000.00, 'https://lili.vn/wp-content/uploads/2021/08/Lac-tay-bac-doi-Love-Sunshine-LILI_349995_1-400x400.jpg'),
('Lắc tay bạc Ta S999 nữ cỏ 4 lá cách điệu đẹp LILI_661577', 'Lắc tay bạc Ta S999 nữ cỏ 4 lá cách điệu đẹp', 'Blue', 0, 'bracelet', 920000.00, 'https://lili.vn/wp-content/uploads/2021/11/Lac-tay-bac-nu-co-4-la-cach-dieu-LILI_661577_6-400x400.jpg'),


('Bông tai bạc nữ hình trái tim cách điệu Raina LILI_132717', 'Bông tai bạc nữ hình trái tim cách điệu', 'White', 0, 'earring', 573000.00, 'https://lili.vn/wp-content/uploads/2024/06/Bong-tai-bac-nu-hinh-trai-tim-cach-dieu-Raina-LILI_132717_4-400x400.jpg'),
('Bông tai bạc nữ/nam giả kẹp vành tai Marleigh LILI_132690', 'Bông tai bạc nữ/nam giả kẹp vành tai Marleigh', 'Blue', 1, 'earring', 659000.00, 'https://lili.vn/wp-content/uploads/2024/06/Bong-tai-bac-nu-nam-gia-kep-vanh-tai-Marleigh-LILI_132690_1-400x400.jpg'),
('Bông tai bạc nữ/nam giả kẹp vành tai Caro LILI_132671', 'Bông tai bạc nữ/nam giả kẹp vành tai Caro', 'Blue', 1, 'earring', 676000.00, 'https://lili.vn/wp-content/uploads/2024/06/Bong-tai-bac-nu-nam-gia-kep-vanh-tai-Caro-LILI_132671_1-400x400.jpg'),
('Bông tai bạc nữ/nam giả kẹp vành tai Ashlynn LILI_132648', 'Bông tai bạc nữ/nam giả kẹp vành tai Ashlynn', 'White', 1, 'earring', 521000.00, 'https://lili.vn/wp-content/uploads/2024/06/Bong-tai-bac-nu-nam-gia-kep-vanh-tai-Ashlynn-LILI_132648_1-400x400.jpg'),
('Bông tai bạc nữ/nam giả kẹp vành tai Rian LILI_132606', 'Bông tai bạc nữ/nam giả kẹp vành tai Rian', 'White', 1, 'earring', 521000.00, 'https://lili.vn/wp-content/uploads/2024/06/Bong-tai-bac-nu-nam-gia-kep-vanh-tai-Rian-LILI_132606_2-400x400.jpg'),
('Bông tai bạc nữ đính ngọc trai kẹp vành tai Kimora LILI_132594', 'Bông tai bạc nữ đính ngọc trai kẹp vành tai Kimora', 'White', 0, 'earring', 536000.00, 'https://lili.vn/wp-content/uploads/2024/06/Bong-tai-bac-nu-dinh-ngoc-trai-kep-vanh-tai-Kimora-LILI_132594_1-400x400.jpg'),
('Bông tai bạc nữ/nam đính đá CZ Magdalena LILI_132581', 'Bông tai bạc nữ/nam đính đá CZ Magdalena', 'Red', 1, 'earring', 584000.00, 'https://lili.vn/wp-content/uploads/2024/06/Bong-tai-bac-nu-nam-dinh-da-CZ-Magdalena-LILI_132581_3-400x400.jpg'),
('Bông tai bạc nữ/nam tròn đen hình số la mã Athena LILI_132574', 'Bông tai bạc nữ/nam tròn đen hình số la mã Athena', 'Red', 1, 'earring', 674000.00, 'https://lili.vn/wp-content/uploads/2024/06/Bong-tai-bac-nu-nam-tron-den-hinh-so-la-ma-Athena-LILI_132574_2-400x400.jpg'),
('Bông tai bạc nữ/nam đính đá CZ kẹp vành chữ C August LILI_132565', 'Bông tai bạc nữ/nam đính đá CZ kẹp vành chữ C August', 'Blue', 1, 'earring', 514000.00, 'https://lili.vn/wp-content/uploads/2024/06/Bong-tai-bac-nu-nam-dinh-da-CZ-kep-vanh-chu-C-August-LILI_132565_3-400x400.jpg'),
('Bông tai bạc nữ đính đá CZ tròn cách điệu Harlee LILI_132556', 'Bông tai bạc nữ đính đá CZ tròn cách điệu Harlee', 'White', 0, 'earring', 624000.00, 'https://lili.vn/wp-content/uploads/2024/06/Bong-tai-bac-nu-dinh-da-CZ-tron-cach-dieu-Harlee-LILI_132556_4-400x400.jpg'),
('Bông tai bạc nữ đính đá CZ hình hồ điệp Amaris LILI_132546', 'Bông tai bạc nữ đính đá CZ hình hồ điệp Amaris', 'Blue', 0, 'earring', 594000.00, 'https://lili.vn/wp-content/uploads/2024/06/Bong-tai-bac-nu-dinh-da-CZ-hinh-ho-diep-Amaris-LILI_132546_3-400x400.jpg'),
('Bông tai bạc nữ đính đá CZ hình cỏ 4 lá Keily LILI_132535', 'Bông tai bạc nữ đính đá CZ hình cỏ 4 lá Keily', 'Blue', 0, 'earring', 536000.00, 'https://lili.vn/wp-content/uploads/2024/06/Bong-tai-bac-nu-dinh-da-CZ-hinh-co-4-la-Keily-LILI_132535_1-400x400.jpg'),
('Bông tai bạc nữ/nam đính đá CZ Yamileth LILI_132525', 'Bông tai bạc nữ/nam đính đá CZ Yamileth', 'Red', 1, 'earring', 711000.00, 'https://lili.vn/wp-content/uploads/2024/06/Bong-tai-bac-nu-nam-dinh-da-CZ-Yamileth-LILI_132525_6-400x400.jpg'),
('Bông tai bạc nữ đính đá CZ hình cỏ 4 lá Jolie LILI_132484', 'Bông tai bạc nữ đính đá CZ hình cỏ 4 lá Jolie', 'Blue', 0, 'earring', 612000.00, 'https://lili.vn/wp-content/uploads/2024/06/Bong-tai-bac-nu-dinh-da-CZ-hinh-co-4-la-Jolie-LILI_132484_1-400x400.jpg'),
('Bông tai bạc nữ hình chiếc nơ Raquel LILI_132475', 'Bông tai bạc nữ hình chiếc nơ Raquel', 'White', 0, 'earring', 631000.00, 'https://lili.vn/wp-content/uploads/2024/06/Bong-tai-bac-nu-hinh-chiec-no-Raquel-LILI_132475_5-400x400.jpg'),
('Bông tai bạc nữ chiếc nơ Cute LILI_132465', 'Bông tai bạc nữ chiếc nơ Cute', 'White', 0, 'earring', 596000.00, 'https://lili.vn/wp-content/uploads/2024/06/Bong-tai-bac-nu-chiec-no-Cute-LILI_132465_6-400x400.jpg'),
('Bông tai bạc nữ hình đuôi cá xinh xắn Judith LILI_132454', 'Bông tai bạc nữ hình đuôi cá xinh xắn Judith', 'Blue', 0, 'earring', 551000.00, 'https://lili.vn/wp-content/uploads/2024/06/Bong-tai-bac-nu-hinh-duoi-ca-Judith-LILI_132454_1-400x400.jpg'),
('Bông tai bạc nữ hình chiếc nơ Dalia LILI_132446', 'Bông tai bạc nữ hình chiếc nơ Dalia', 'White', 0, 'earring', 543000.00, 'https://lili.vn/wp-content/uploads/2024/06/Bong-tai-bac-nu-hinh-chiec-no-Dalia-LILI_132446_2-400x400.jpg'),
('Bông tai bạc nữ đính đá CZ hình chiếc nơ xinh xắn Salma LILI_132433', 'Bông tai bạc nữ đính đá CZ hình chiếc nơ xinh xắn Salma', 'Red', 0, 'earring', 555000.00, 'https://lili.vn/wp-content/uploads/2024/06/Bong-tai-bac-nu-dinh-da-CZ-hinh-chiec-no-xinh-xan-Salma-LILI_132433_1-400x400.jpg'),
('Bông tai bạc nữ giả kẹp vành tai hình hồ điệp Nori LILI_132423', 'Bông tai bạc nữ giả kẹp vành tai hình hồ điệp Nori', 'Blue', 0, 'earring', 652000.00, 'https://lili.vn/wp-content/uploads/2024/06/Bong-tai-bac-nu-gia-kep-vanh-tai-hinh-ho-diep-Nori-LILI_132423_1-400x400.jpg'),
('Bông tai bạc nữ chuỗi xích dài Lilyana LILI_132412', 'Bông tai bạc nữ chuỗi xích dài Lilyana', 'Red', 0, 'earring', 587000.00, 'https://lili.vn/wp-content/uploads/2024/06/Bong-tai-bac-nu-chuoi-xich-dai-Lilyana-LILI_132412_5-400x400.jpg'),
('Bông tai bạc nữ/nam tròn hình vân mây Chandler LILI_132401', 'Bông tai bạc nữ/nam tròn hình vân mây Chandler', 'Blue', 1, 'earring', 587000.00, 'https://lili.vn/wp-content/uploads/2024/06/Bong-tai-bac-nu-nam-tron-hinh-van-may-Chandler-LILI_132401_5-400x400.jpg'),
('Bông tai bạc nữ/nam tròn Hadlee LILI_132385', 'Bông tai bạc nữ/nam tròn Hadlee', 'White', 1, 'earring', 537000.00, 'https://lili.vn/wp-content/uploads/2024/06/Bong-tai-bac-nu-nam-tron-Hadlee-LILI_132385_2-400x400.jpg'),


('Nhẫn bạc nữ đính kim cương Moissanite Aidan LILI_335168', 'Nhẫn bạc nữ đính kim cương Moissanite Aidan LILI_335168', 'white', 0, 'ring', 1145000, 'https://lili.vn/wp-content/uploads/2022/07/Nhan-bac-nu-dinh-kim-cuong-Moissanite-Aidan-LILI_335168_4-400x400.jpg'),
('Nhẫn bạc nữ đính đá CZ hoa bướm LILI_661591', 'Nhẫn bạc nữ đính đá CZ hoa bướm LILI_661591', 'red', 0, 'ring', 620000, 'https://lili.vn/wp-content/uploads/2022/08/Nhan-bac-nu-dinh-da-CZ-hoa-buom-LILI_661591_2-400x400.jpg'),
('Nhẫn bạc nữ đính kim cương Moissanite Scarlett LILI_054807', 'Nhẫn bạc nữ đính kim cương Moissanite Scarlett LILI_054807', 'white', 0, 'ring', 935000, 'https://lili.vn/wp-content/uploads/2022/11/Nhan-bac-nu-dinh-kim-cuong-Moissanite-Scarlett-LILI_054807_4-400x400.jpg'),
('Nhẫn bạc nữ đính đá CZ hình bông hoa đào LILI_289467', 'Nhẫn bạc nữ đính đá CZ hình bông hoa đào LILI_289467', 'red', 0, 'ring', 632000, 'https://lili.vn/wp-content/uploads/2021/11/Nhan-bac-nu-dinh-da-CZ-hinh-bong-hoa-dao-LILI_289467_4-400x400.jpg'),
('Nhẫn bạc nữ mạ vàng đính đá CZ cây ô liu LILI_114577', 'Nhẫn bạc nữ mạ vàng đính đá CZ cây ô liu LILI_114577', 'blue', 0, 'ring', 817000, 'https://lili.vn/wp-content/uploads/2021/01/Nhan-bac-ma-vang-Cay-o-liu-LILI_114577-01-400x400.jpg'),
('Nhẫn bạc nữ mạ vàng 18k đính đá CZ hình trái tim LILI_349632', 'Nhẫn bạc nữ mạ vàng 18k đính đá CZ hình trái tim LILI_349632', 'red', 0, 'ring', 601000, 'https://lili.vn/wp-content/uploads/2021/12/Nhan-bac-nu-ma-vang-18k-dinh-da-CZ-hinh-trai-tim-LILI_349632_10-400x400.jpg'),
('Nhẫn bạc nữ đính kim cương Moissanite Elfleda LILI_564974', 'Nhẫn bạc nữ đính kim cương Moissanite Elfleda LILI_564974', 'white', 0, 'ring', 1070000, 'https://lili.vn/wp-content/uploads/2022/07/Nhan-bac-nu-dinh-kim-cuong-Moissanite-Elfleda-LILI_564974_4-400x400.jpg'),
('Nhẫn bạc nữ mạ vàng đính đá CZ Ares LILI_583794', 'Nhẫn bạc nữ mạ vàng đính đá CZ Ares LILI_583794', 'blue', 0, 'ring', 637000, 'https://lili.vn/wp-content/uploads/2021/11/Nhan-bac-nu-ma-vang-dinh-da-CZ-Ares-LILI_583794_3-400x400.jpg'),
('Nhẫn bạc nữ may mắn Lucky Day LILI_791795', 'Nhẫn bạc nữ may mắn Lucky Day LILI_791795', 'red', 0, 'ring', 647000, 'https://lili.vn/wp-content/uploads/2022/04/Nhan-bac-nu-may-man-Lucky-Day-LILI_791795_4-400x400.jpg'),
('Nhẫn bạc nữ đính kim cương Moissanite hình ngôi sao 6 cánh Gianna LILI_054793', 'Nhẫn bạc nữ đính kim cương Moissanite hình ngôi sao 6 cánh Gianna LILI_054793', 'white', 0, 'ring', 898000, 'https://lili.vn/wp-content/uploads/2022/11/Nhan-bac-nu-dinh-kim-cuong-Moissanite-hinh-ngoi-sao-6-canh-Gianna-LILI_054793_3-1-400x400.jpg'),
('Nhẫn bạc nữ đính pha lê Aurora cá xinh xắn LILI_132741', 'Nhẫn bạc nữ đính pha lê Aurora cá xinh xắn LILI_132741', 'white', 0, 'ring', 653000, 'https://lili.vn/wp-content/uploads/2021/11/Nhan-bac-nu-dinh-da-Aurora-ca-xinh-xan-LILI_132741_3-400x400.jpg'),
('Nhẫn bạc nữ 1 hột đơn giản đính đá CZ Royal Miracle LILI_499436', 'Nhẫn bạc nữ 1 hột đơn giản đính đá CZ Royal Miracle LILI_499436', 'blue', 0, 'ring', 594000, 'https://lili.vn/wp-content/uploads/2021/08/Nhan-bac-dinh-da-Zircon-Royal-LILI_499436_7-400x400.jpg'),
('Nhẫn bạc nữ mạ bạch kim đính đá CZ cỏ 4 lá LILI_372838', 'Nhẫn bạc nữ mạ bạch kim đính đá CZ cỏ 4 lá LILI_372838', 'blue', 0, 'ring', 673000, 'https://lili.vn/wp-content/uploads/2021/12/Nhan-bac-nu-ma-bach-kim-dinh-da-CZ-co-4-la-LILI_372838_5-400x400.jpg'),
('Nhẫn bạc nữ đính kim cương Moissanite Power LILI_563524', 'Nhẫn bạc nữ đính kim cương Moissanite Power LILI_563524', 'red', 0, 'ring', 984000, 'https://lili.vn/wp-content/uploads/2021/12/NHAN-BAC-NU-DINH-KIM-CUONG-MOISSANITE-POWER-LILI_563524_23-400x400.jpg'),
('Nhẫn bạc nữ mạ vàng đính đá CZ ngôi sao may mắn vô cực LILI_189799', 'Nhẫn bạc nữ mạ vàng đính đá CZ ngôi sao may mắn vô cực LILI_189799', 'blue', 0, 'ring', 632000, 'https://lili.vn/wp-content/uploads/2021/11/Nhan-bac-nu-ma-vang-dinh-da-CZ-vo-cuc-ngoi-sao-may-man-LILI_189799_2-400x400.jpg'),
('Nhẫn bạc nữ mạ vàng đính đá Opal hình giọt nước Ula LILI_879391', 'Nhẫn bạc nữ mạ vàng đính đá Opal hình giọt nước Ula LILI_879391', 'blue', 0, 'ring', 927000, 'https://lili.vn/wp-content/uploads/2022/08/Nhan-bac-nu-ma-vang-dinh-da-Opal-hinh-giot-nuoc-Ula-LILI_879391_4-400x400.jpg'),
('Nhẫn bạc nữ đính đá CZ hình cành lộc non LILI_765887', 'Nhẫn bạc nữ đính đá CZ hình cành lộc non LILI_765887', 'red', 0, 'ring', 631000, 'https://lili.vn/wp-content/uploads/2022/04/Nhan-bac-nu-dinh-da-CZ-hinh-canh-loc-non-LILI_765887_4-400x400.jpg'),
('Nhẫn bạc nữ đính kim cương Moissanite hình trái tim Lani LILI_939178', 'Nhẫn bạc nữ đính kim cương Moissanite hình trái tim Lani LILI_939178', 'blue', 0, 'ring', 1575000, 'https://lili.vn/wp-content/uploads/2022/08/Nhan-bac-nu-dinh-kim-cuong-Moissanite-hinh-trai-tim-Lani-LILI_939178_3-400x400.jpg'),
('Nhẫn bạc nữ mạ vàng đính đá CZ 2 tầng đôi bướm xinh LILI_155512', 'Nhẫn bạc nữ mạ vàng đính đá CZ 2 tầng đôi bướm xinh LILI_155512', 'red', 0, 'ring', 593000, 'https://lili.vn/wp-content/uploads/2021/11/Nhan-bac-nu-ma-vang-dinh-da-CZ-2-tang-doi-buom-xinh-LILI_155512_1-400x400.jpg'),
('Bộ 2 nhẫn bạc nữ đính đá CZ 2 tầng vương miện Pandora LILI_825322', 'Bộ 2 nhẫn bạc nữ đính đá CZ 2 tầng vương miện Pandora LILI_825322', 'red', 0, 'ring', 593000, 'https://lili.vn/wp-content/uploads/2021/11/Nhan-bac-nu-xep-chong-ma-vang-dinh-da-CZ-vuong-mien-pandora-LILI_825322_8-400x400.jpg'),
('Nhẫn bạc nữ dạng mảnh đính kim cương Moissanite Cleopatra LILI_053396', 'Nhẫn bạc nữ dạng mảnh đính kim cương Moissanite Cleopatra LILI_053396', 'white', 0, 'ring', 923000, 'https://lili.vn/wp-content/uploads/2022/10/Nhan-bac-nu-dang-manh-dinh-kim-cuong-Moissanite-Cleopatra-LILI_053396_4-400x400.jpg'),
('Nhẫn bạc nữ dạng xoay độc lạ đính đá CZ cỏ 4 lá Victory LILI_482977', 'Nhẫn bạc nữ dạng xoay độc lạ đính đá CZ cỏ 4 lá Victory LILI_482977', 'blue', 0, 'ring', 797000, 'https://lili.vn/wp-content/uploads/2022/06/Nhan-bac-nu-ma-vang-dang-xoay-dinh-da-CZ-co-4-la-Victory-LILI_482977_32-400x400.jpg'),
('Nhẫn bạc nữ dạng đường cách điệu Calantha LILI_796141', 'Nhẫn bạc nữ dạng đường cách điệu Calantha LILI_796141', 'blue', 0, 'ring', 719000, 'https://lili.vn/wp-content/uploads/2022/08/Nhan-bac-nu-dang-duong-cach-dieu-Calantha-LILI_796141_5-400x400.jpg'),


('Nhẫn bạc nam hình mỏ neo Winston LILI_077662', 'Nhẫn bạc nam hình mỏ neo Winston', 'white', 1, 'ring', 1025000, 'https://lili.vn/wp-content/uploads/2023/09/Nhan-bac-nam-hinh-mo-neo-Winston-LILI_077662_1-400x400.jpg'),
('Nhẫn bạc nam đính kim cương Moissanite Meredith LILI_666882', 'Nhẫn bạc nam đính kim cương Moissanite Meredith', 'white', 1, 'ring', 1428000, 'https://lili.vn/wp-content/uploads/2022/08/Nhan-bac-nam-dinh-kim-cuong-Moissanite-Meredith-LILI_666882_4-400x400.jpg'),
('Nhẫn bạc nam hình mỏ neo cách điệu Reign LILI_079395', 'Nhẫn bạc nam hình mỏ neo cách điệu Reign', 'white', 1, 'ring', 910000, 'https://lili.vn/wp-content/uploads/2023/10/Nhan-bac-nam-hinh-mo-neo-cach-dieu-Reign-LILI_079395_2-400x400.jpg'),
('Nhẫn bạc nam hình thánh giá chữ thập Titus LILI_077592', 'Nhẫn bạc nam hình thánh giá chữ thập Titus', 'red', 1, 'ring', 2820000, 'https://lili.vn/wp-content/uploads/2023/09/Nhan-bac-nam-hinh-thanh-gia-chu-thap-Titus-LILI_077592_4-400x400.jpg'),
('Nhẫn bạc nam hình mũi tên Braxton LILI_077224', 'Nhẫn bạc nam hình mũi tên Braxton', 'blue', 1, 'ring', 594000, 'https://lili.vn/wp-content/uploads/2023/09/Nhan-bac-nam-hinh-mui-ten-Braxton-LILI_077224_3-400x400.jpg'),
('Nhẫn bạc nam đính đá CZ Ryker LILI_077261', 'Nhẫn bạc nam đính đá CZ Ryker', 'blue', 1, 'ring', 947000, 'https://lili.vn/wp-content/uploads/2023/09/Nhan-bac-nam-dinh-da-Cubic-Zirconia-Ryker-LILI_077261_3-400x400.jpg'),
('Nhẫn bạc nữ/nam unisex tròn trơn đơn giản Teen Top LILI_194739', 'Nhẫn bạc nữ/nam unisex tròn trơn đơn giản Teen Top', 'white', 2, 'ring', 665000, 'https://lili.vn/wp-content/uploads/2021/12/Nhan-Bac-Tron-Teen-Top-LILI-194739_12-400x400.jpg'),
('Nhẫn bạc nam đính đá CZ hình lá bài Kyson LILI_077804', 'Nhẫn bạc nam đính đá CZ hình lá bài Kyson', 'blue', 1, 'ring', 1888000, 'https://lili.vn/wp-content/uploads/2023/09/Nhan-bac-nam-dinh-da-Cubic-Zirconia-hinh-la-bai-Kyson-LILI_077804_4-400x400.jpg'),
('Nhẫn bạc nam hình ngôi sao 5 cánh Briggs LILI_077637', 'Nhẫn bạc nam hình ngôi sao 5 cánh Briggs', 'blue', 1, 'ring', 1192000, 'https://lili.vn/wp-content/uploads/2023/09/Nhan-bac-nam-hinh-ngoi-sao-5-canh-Briggs-LILI_077637_4-400x400.jpg'),
('Nhẫn bạc nam Brantley LILI_095029', 'Nhẫn bạc nam Brantley', 'white', 1, 'ring', 670000, 'https://lili.vn/wp-content/uploads/2023/12/Nhan-bac-nam-Brantley-LILI_095029_2-400x400.jpg'),
('Nhẫn bạc nữ/nam unisex hình logo Nike LILI_879138', 'Nhẫn bạc nữ/nam unisex hình logo Nike', 'blue', 2, 'ring', 749000, 'https://lili.vn/wp-content/uploads/2021/11/Nhan-bac-nu-nam-hinh-Nike-LILI_879138_4-400x400.jpg'),
('Nhẫn bạc nam đính kim cương Moissanite Kenji LILI_079645', 'Nhẫn bạc nam đính kim cương Moissanite Kenji', 'white', 1, 'ring', 1242000, 'https://lili.vn/wp-content/uploads/2023/10/Nhan-bac-nam-dinh-kim-cuong-Moissanite-Kenji-LILI_079645_3-400x400.jpg'),


('Lắc tay bạc nữ mạ bạch kim đính đá CZ cỏ 4 lá LILI_612672', 'Lắc tay bạc nữ mạ bạch kim đính đá CZ cỏ 4 lá', 'white', 0, 'bracelet', 816000, 'https://lili.vn/wp-content/uploads/2021/12/Lac-tay-bac-nu-ma-bach-kim-dinh-pha-le-co-bon-la-LILI_612672_34-400x400.jpg'),
('Lắc tay bạc Ý 925 nữ mạ vàng đính đá Garnet, CZ hoa hồng Rose LILI_886825', 'Lắc tay bạc Ý 925 nữ mạ vàng đính đá Garnet, CZ hoa hồng Rose', 'red', 0, 'bracelet', 939000, 'https://lili.vn/wp-content/uploads/2021/11/Lac-tay-bac-nu-ma-vang-dinh-da-Garnet-hoa-hong-Rose-LILI_886825_6-400x400.jpg'),
('Lắc tay bạc nữ đính đá CZ cặp trái tim Alvin LILI_267729', 'Lắc tay bạc nữ đính đá CZ cặp trái tim Alvin', 'red', 0, 'bracelet', 968000, 'https://lili.vn/wp-content/uploads/2022/06/Lac-tay-bac-nu-dinh-da-CZ-cap-trai-tim-Alvin-LILI_267729_5-400x400.jpg'),
('Lắc tay bạc nữ đính pha lê Swarovski trái tim của biển LILI_579467', 'Lắc tay bạc nữ đính pha lê Swarovski trái tim của biển', 'blue', 0, 'bracelet', 901000, 'https://lili.vn/wp-content/uploads/2020/11/vong-tay-bac-925-dinh-pha-le-swarovski-1-400x400.jpg'),
('Lắc tay bạc nữ đính đá CZ hình trái tim Love In Heart LILI_295621', 'Lắc tay bạc nữ đính đá CZ hình trái tim Love In Heart', 'red', 0, 'bracelet', 902000, 'https://lili.vn/wp-content/uploads/2022/07/Lac-tay-bac-nu-dinh-da-CZ-hinh-trai-tim-Phedra-LILI_295621_3-400x400.jpg'),
('Lắc tay bạc nữ đính đá CZ hình bông hoa hồng LILI_787759', 'Lắc tay bạc nữ đính đá CZ hình bông hoa hồng', 'red', 0, 'bracelet', 684000, 'https://lili.vn/wp-content/uploads/2022/06/Lac-tay-bac-nu-dinh-da-CZ-hinh-bong-hoa-hong-LILI_787759_1-400x400.jpg'),
('Vòng tay bạc nữ dạng kiềng đính kim cương Moissanite tròn Farah LILI_054678', 'Vòng tay bạc nữ dạng kiềng đính kim cương Moissanite tròn Farah', 'blue', 0, 'bracelet', 1243000, 'https://lili.vn/wp-content/uploads/2022/11/Vong-tay-bac-nu-dang-kieng-dinh-kim-cuong-Moissanite-tron-Farah-LILI_054678_3-400x400.jpg'),
('Lắc tay bạc nữ mạ bạch kim đính đá CZ trái tim cách điệu LILI_276753', 'Lắc tay bạc nữ mạ bạch kim đính đá CZ trái tim cách điệu', 'white', 0, 'bracelet', 919000, 'https://lili.vn/wp-content/uploads/2021/12/Lac-tay-bac-nu-ma-bach-kim-dinh-da-CZ-LILI_276753_12-400x400.jpg'),
('Lắc tay bạc nữ đính đá CZ hình cành lộc non LILI_247931', 'Lắc tay bạc nữ đính đá CZ hình cành lộc non', 'white', 0, 'bracelet', 702000, 'https://lili.vn/wp-content/uploads/2022/04/Lac-tay-bac-nu-dinh-da-CZ-hinh-canh-loc-non-LILI_247931_6-400x400.jpg'),
('Lắc tay bạc nữ đính kim cương Moissanite Curtis LILI_882398', 'Lắc tay bạc nữ đính kim cương Moissanite Curtis', 'blue', 0, 'bracelet', 1809000, 'https://lili.vn/wp-content/uploads/2022/07/Lac-tay-bac-nu-dinh-kim-cuong-Moissanite-Curtis-LILI_882398_2-400x400.jpg'),
('Lắc tay bạc Ta S999 nữ cỏ 4 lá cách điệu đẹp LILI_661577', 'Lắc tay bạc Ta S999 nữ cỏ 4 lá cách điệu đẹp', 'white', 0, 'bracelet', 920000, 'https://lili.vn/wp-content/uploads/2021/11/Lac-tay-bac-nu-co-4-la-cach-dieu-LILI_661577_6-400x400.jpg'),
('Lắc tay bạc nữ Tennis chuỗi đá CZ dạng dây rút thắt nơ LILI_869163', 'Lắc tay bạc nữ Tennis chuỗi đá CZ dạng dây rút thắt nơ', 'blue', 0, 'bracelet', 911000, 'https://lili.vn/wp-content/uploads/2022/10/Lac-tay-bac-nu-chuoi-da-CZ-dang-day-rut-that-no-LILI_869163_31-400x400.jpg'),
('Lắc tay bạc nữ đính đá CZ, pha lê Aurora cá voi Cute LILI_775374', 'Lắc tay bạc nữ đính đá CZ, pha lê Aurora cá voi Cute', 'blue', 0, 'bracelet', 757000, 'https://lili.vn/wp-content/uploads/2021/12/Lac-tay-bac-nu-dinh-da-CZ-pha-le-Aurora-ca-voi-Cute-LILI_775374_2-400x400.jpg'),
('Lắc tay bạc nữ đính đá CZ hình trái tim Heart Of The Sea LILI_427425', 'Lắc tay bạc nữ đính đá CZ hình trái tim Heart Of The Sea', 'blue', 0, 'bracelet', 1188000, 'https://lili.vn/wp-content/uploads/2021/11/Lac-tay-bac-nu-dinh-da-pha-le-hinh-trai-tim-LILI_427425_11-400x400.jpg'),
('Lắc tay bạc nữ đính đá CZ thỏ ngắm trăng LILI_722163', 'Lắc tay bạc nữ đính đá CZ thỏ ngắm trăng', 'blue', 0, 'bracelet', 679000, 'https://lili.vn/wp-content/uploads/2022/08/Lac-tay-bac-nu-dinh-da-CZ-tho-ngam-trang-LILI_722163_1-400x400.jpg'),
('Lắc tay bạc Thái S925 nữ chuỗi vuông tròn trái tim ngôi sao may mắn LILI_884778', 'Lắc tay bạc Thái S925 nữ chuỗi vuông tròn trái tim ngôi sao may mắn', 'blue', 0, 'bracelet', 1625000, 'https://lili.vn/wp-content/uploads/2021/11/Lac-tay-bac-nu-chuoi-vuong-tron-trai-tim-ngoi-sao-may-man-LILI_884778_3-400x400.jpg'),
('Lắc tay bạc nữ đẹp dạng chuỗi hình ngôi sao 5 cánh LILI_379215', 'Lắc tay bạc nữ đẹp dạng chuỗi hình ngôi sao 5 cánh', 'red', 0, 'bracelet', 767000, 'https://lili.vn/wp-content/uploads/2021/11/Lac-tay-bac-nu-ngoi-sao-5-canh-Super-Star-LILI_113819_3-400x400.jpg'),
('Lắc tay bạc nữ đính đá CZ The Beauty LILI_421447', 'Lắc tay bạc nữ đính đá CZ The Beauty', 'blue', 0, 'bracelet', 1010000, 'https://lili.vn/wp-content/uploads/2020/12/Lac-tay-bac-nu-dinh-da-CZ-The-Beauty-LILI_421447_10-400x400.jpg'),
('Lắc tay bạc nữ đính đá CZ hình ngôi sao 5 cánh LILI_532223', 'Lắc tay bạc nữ đính đá CZ hình ngôi sao 5 cánh', 'blue', 0, 'bracelet', 605000, 'https://lili.vn/wp-content/uploads/2022/08/Lac-tay-bac-nu-dinh-da-CZ-hinh-ngoi-sao-5-canh-LILI_532223_5-400x400.jpg'),
('Lắc tay bạc nữ đính đá CZ chuỗi hoa mai vô cực LILI_196734', 'Lắc tay bạc nữ đính đá CZ chuỗi hoa mai vô cực', 'blue', 0, 'bracelet', 1022000, 'https://lili.vn/wp-content/uploads/2022/06/Lac-tay-bac-nu-dinh-da-CZ-chuoi-hoa-mai-vo-cuc-LILI_196734_3-400x400.jpg'),
('Lắc tay bạc nữ đính đá CZ trái tim vô cực Forever Love LILI_877257', 'Lắc tay bạc nữ đính đá CZ trái tim vô cực Forever Love', 'blue', 0, 'bracelet', 695000, 'https://lili.vn/wp-content/uploads/2022/08/Lac-tay-bac-nu-dinh-da-CZ-trai-tim-vo-cuc-Forever-Love-LILI_877257_4-400x400.jpg'),
('Lắc tay bạc nữ đính đá CZ trái tim vĩnh cửu LILI_167424', 'Lắc tay bạc nữ đính đá CZ trái tim vĩnh cửu', 'blue', 0, 'bracelet', 986000, 'https://lili.vn/wp-content/uploads/2021/11/Lac-tay-bac-nu-dinh-da-CZ-trai-tim-vinh-cuu-LILI_167424_2-400x400.jpg'),
('Vòng tay bạc nữ dạng kiềng đính đá pha lê Eye of the muse LILI_814348', 'Vòng tay bạc nữ dạng kiềng đính đá pha lê Eye of the muse', 'blue', 0, 'bracelet', 1267000, 'https://lili.vn/wp-content/uploads/2020/12/Vong-tay-bac-ma-bach-kim-dinh-da-pha-le-Eye-of-the-muse-LILI_814348-01-400x400.jpg'),
('Lắc tay bạc nữ đính đá CZ hình cá tiên Ladonna LILI_132297', 'Lắc tay bạc nữ đính đá CZ hình cá tiên Ladonna', 'blue', 0, 'bracelet', 713000, 'https://lili.vn/wp-content/uploads/2022/09/Lac-tay-bac-nu-dinh-da-CZ-hinh-ca-tien-Ladonna-LILI_132297_5-1-400x400.jpg'),


('Lắc tay bạc nam mắt xích đơn giản ngầu Cuban Saint Laurent Paris LILI_746785', 'Lắc tay bạc nam mắt xích đơn giản ngầu Cuban Saint Laurent Paris', 'white', 1, 'bracelet', 3066000.00, 'https://lili.vn/wp-content/uploads/2022/01/Lac-tay-bac-nam-mat-xich-don-gian-ngau-Cuban-Saint-Laurent-Paris-LILI_746785_30-400x400.jpg'),
('Lắc tay bạc nữ/nam đính kim cương Moissanite chuỗi xích Cuban LILI_069214', 'Lắc tay bạc nữ/nam đính kim cương Moissanite chuỗi xích Cuban', 'red', 2, 'bracelet', 5256000.00, 'https://lili.vn/wp-content/uploads/2023/07/Lac-tay-bac-nu-nam-dinh-kim-cuong-Moissanite-chuoi-xich-Cuban-LILI_069214_4-400x400.jpg'),
('Lắc tay bạc nam nguyên chất dạng xoắn Royal LILI_191894', 'Lắc tay bạc nam nguyên chất dạng xoắn Royal', 'red', 1, 'bracelet', 5360000.00, 'https://lili.vn/wp-content/uploads/2021/12/Lac-tay-bac-nam-nguyen-chat-dang-xoan-Royal-LILI_191894_9-400x400.jpg'),
('Lắc tay bạc nam dây bện 6 ký tự chú Chosen LILI_103661', 'Lắc tay bạc nam dây bện 6 ký tự chú Chosen', 'blue', 1, 'bracelet', 787000.00, 'https://lili.vn/wp-content/uploads/2023/12/Lac-tay-bac-nam-day-ben-6-ky-tu-chu-Chosen-LILI_103661_3-400x400.jpg'),
('Vòng tay bạc đặc nam trơn Fast Boy LILI_466422', 'Vòng tay bạc đặc nam trơn Fast Boy', 'red', 1, 'bracelet', 3162000.00, 'https://lili.vn/wp-content/uploads/2022/05/Vong-tay-bac-nam-tron-Fast-Boy-LILI_466422_4-400x400.jpg'),
('Lắc tay bạc nữ/nam cá tính cuban hình vương miện Henley LILI_096785', 'Lắc tay bạc nữ/nam cá tính cuban hình vương miện Henley', 'white', 2, 'bracelet', 3174000.00, 'https://lili.vn/wp-content/uploads/2023/12/Lac-tay-bac-nu-ca-tinh-cuban-hinh-vuong-mien-Henley-LILI_096785_4-400x400.jpg'),
('Lắc tay bạc Thái nam cá tính dạng xích Dakota LILI_069237', 'Lắc tay bạc Thái nam cá tính dạng xích Dakota', 'white', 1, 'bracelet', 1534000.00, 'https://lili.vn/wp-content/uploads/2023/07/Lac-tay-bac-Thai-nam-ca-tinh-dang-xich-Dakota-LILI_069237_4-1-400x400.jpg'),
('Lắc tay bạc nam hình rồng Grady LILI_078138', 'Lắc tay bạc nam hình rồng Grady', 'white', 1, 'bracelet', 4899000.00, 'https://lili.vn/wp-content/uploads/2023/09/Lac-tay-bac-nam-hinh-rong-Grady-LILI_078138_4-400x400.jpg'),
('Lắc tay bạc nữ/nam cuban đính kim cương Moissanite Miguel LILI_076498', 'Lắc tay bạc nữ/nam cuban đính kim cương Moissanite Miguel', 'white', 2, 'bracelet', 9675000.00, 'https://lili.vn/wp-content/uploads/2023/09/Lac-tay-bac-nu-nam-cuban-dinh-kim-cuong-Moissanite-Miguel-LILI_076498_3-400x400.jpg'),
('Lắc tay bạc nam dây bện dù sáp rồng đen Black Dragon LILI_103670', 'Lắc tay bạc nam dây bện dù sáp rồng đen Black Dragon', 'white', 1, 'bracelet', 842000.00, 'https://lili.vn/wp-content/uploads/2023/12/Lac-tay-bac-nam-day-ben-du-sap-rong-den-Black-Dragon-LILI_103670_2-400x400.jpg'),
('Lắc tay bạc nam chuỗi xích tròn Spencer LILI_077050', 'Lắc tay bạc nam chuỗi xích tròn Spencer', 'blue', 1, 'bracelet', 3863000.00, 'https://lili.vn/wp-content/uploads/2023/09/Lac-tay-bac-nam-chuoi-xich-tron-Spencer-LILI_077050_4-400x400.jpg'),
('Lắc tay bạc đặc nam dạng chuỗi xích Levi LILI_075928', 'Lắc tay bạc đặc nam dạng chuỗi xích Levi', 'blue', 1, 'bracelet', 1411000.00, 'https://lili.vn/wp-content/uploads/2023/09/Lac-tay-bac-dac-nam-dang-chuoi-xich-Levi-LILI_075928_6-400x400.jpg'),
('Lắc tay bạc nam cool ngầu Keel LILI_077969', 'Lắc tay bạc nam cool ngầu Keel', 'blue', 1, 'bracelet', 5588000.00, 'https://lili.vn/wp-content/uploads/2023/09/Lac-tay-bac-nam-cool-ngau-Keel-LILI_077969_2-400x400.jpg'),
('Lắc tay bạc nam cao cấp Barrett LILI_076555', 'Lắc tay bạc nam cao cấp Barrett', 'blue', 1, 'bracelet', 5110000.00, 'https://lili.vn/wp-content/uploads/2023/09/Lac-tay-bac-nam-cao-cap-Barrett-LILI_076555_4-400x400.jpg'),
('Lắc tay bạc nam hình kim tiền may mắn Lawson LILI_078148', 'Lắc tay bạc nam hình kim tiền may mắn Lawson', 'white', 1, 'bracelet', 4899000.00, 'https://lili.vn/wp-content/uploads/2023/09/Lac-tay-bac-nam-hinh-kim-tien-may-man-Lawson-LILI_078148_3-400x400.jpg'),
('Lắc tay bạc nam cá tính Matias LILI_076541', 'Lắc tay bạc nam cá tính Matias', 'white', 1, 'bracelet', 3701000.00, 'https://lili.vn/wp-content/uploads/2023/09/Lac-tay-bac-nam-ca-tinh-Matias-LILI_076541_4-400x400.jpg'),
('Lắc tay bạc nam cuban Conrad LILI_077960', 'Lắc tay bạc nam cuban Conrad', 'blue', 1, 'bracelet', 6006000.00, 'https://lili.vn/wp-content/uploads/2023/09/Lac-tay-bac-nam-cuban-Conrad-LILI_077960_2-400x400.jpg'),
('Lắc tay bạc nam dây bện dù sáp thời trang Zayne LILI_078215', 'Lắc tay bạc nam dây bện dù sáp thời trang Zayne', 'white', 1, 'bracelet', 682000.00, 'https://lili.vn/wp-content/uploads/2023/09/Lac-tay-bac-nam-day-ben-du-sap-thoi-trang-Zayne-LILI_078215_5-400x400.jpg'),
('Lắc tay bạc nam ngầu mặt trơn Bryson LILI_076310', 'Lắc tay bạc nam ngầu mặt trơn Bryson', 'blue', 1, 'bracelet', 2333000.00, 'https://lili.vn/wp-content/uploads/2023/09/Lac-tay-bac-nam-ngau-mat-tron-Bryson-LILI_076310_3-400x400.jpg'),
('Lắc tay bạc nam cuban hình rồng Kade LILI_078064', 'Lắc tay bạc nam cuban hình rồng Kade', 'white', 1, 'bracelet', 3741000.00, 'https://lili.vn/wp-content/uploads/2023/09/Lac-tay-bac-nam-cuban-hinh-rong-Kade-LILI_078064_2-400x400.jpg'),
('Lắc tay bạc nam chuỗi đan nhau ngầu Phoenix LILI_752583', 'Lắc tay bạc nam chuỗi đan nhau ngầu Phoenix', 'red', 1, 'bracelet', 7353000.00, 'https://lili.vn/wp-content/uploads/2021/12/Lac-tay-bac-nam-chuoi-dan-nhau-ngau-Phoenix-LILI_752583_3-400x400.jpg'),
('Lắc tay bạc Thái nam thần chú Holland LILI_069286', 'Lắc tay bạc Thái nam thần chú Holland', 'red', 1, 'bracelet', 3588000.00, 'https://lili.vn/wp-content/uploads/2023/07/Lac-tay-bac-Thai-nam-than-chu-Holland-LILI_069286_7-400x400.jpg'),
('Lắc tay bạc nam dạng cuban cỡ lớn Damien LILI_078029', 'Lắc tay bạc nam dạng cuban cỡ lớn Damien', 'white', 1, 'bracelet', 4775000.00, 'https://lili.vn/wp-content/uploads/2023/09/Lac-tay-bac-nam-dang-cuban-co-lon-Damien-LILI_078029_3-400x400.jpg'),
('Vòng tay bạc nam dạng chuỗi xoắn Lorenzo LILI_076323', 'Vòng tay bạc nam dạng chuỗi xoắn Lorenzo', 'blue', 1, 'bracelet', 3543000.00, 'https://lili.vn/wp-content/uploads/2023/09/Vong-tay-bac-nam-dang-chuoi-xoan-Lorenzo-LILI_076323_7-400x400.jpg'),


('Dây chuyền bạc nữ đính đá CZ cá tiên LILI_831944', '', 'red', 0, 'necklace', 817000, 'https://lili.vn/wp-content/uploads/2021/12/Day-chuyen-bac-nu-phong-cach-co-trang-CZ-LILI_831944_2-400x400.jpg'),
('Dây chuyền bạc nữ đính đá CZ dạng nhẫn đôi Fall In Love LILI_748855', '', 'white', 0, 'necklace', 782000, 'https://lili.vn/wp-content/uploads/2022/08/Day-chuyen-bac-nu-dinh-da-CZ-dang-nhan-doi-Fall-In-Love-LILI_748855_7-400x400.jpg'),
('Dây chuyền bạc nữ đính kim cương Moissanite tròn cách điệu LILI_413898', '', 'white', 0, 'necklace', 1250000, 'https://lili.vn/wp-content/uploads/2022/06/Mat-day-chuyen-bac-nu-dinh-kim-cuong-Moissanite-tron-cach-dieu-LILI_413898_6-400x400.jpg'),
('Dây chuyền bạc nữ đẹp đính pha lê Aurora trái tim hoa lá LILI_866671', '', 'blue', 0, 'necklace', 728000, 'https://lili.vn/wp-content/uploads/2021/12/Day-chuyen-bac-nu-trai-tim-hoa-la-dinh-pha-le-Aurora-LILI_866671_10-400x400.jpg'),
('Dây chuyền bạc nữ đính pha lê Swarovski trái tim đại dương LILI_295787', '', 'blue', 0, 'necklace', 785000, 'https://lili.vn/wp-content/uploads/2020/12/day-chuyen-bac-mat-pha-le-swaroski-trai-tim-dai-duong-LILI_295787-1-1-400x400.jpg'),
('Dây chuyền bạc nữ 2 tầng đẹp và độc hình đôi bướm Hot Trend LILI_361718', '', 'white', 0, 'necklace', 855000, 'https://lili.vn/wp-content/uploads/2024/03/Day-chuyen-bac-nu-2-tang-dep-va-doc-hinh-doi-buom-Hot-Trend-LILI_361718_30-400x400.jpg'),
('Dây chuyền bạc nữ đính đá CZ cỏ 4 lá LILI_426865', '', 'white', 0, 'necklace', 785000, 'https://lili.vn/wp-content/uploads/2022/03/Mat-day-chuyen-bac-nu-dinh-da-CZ-co-4-la-LILI_426865_1-400x400.jpg'),
('Dây chuyền bạc nữ đính kim cương Moissanite hình gạc nai LILI_055097', '', 'blue', 0, 'necklace', 1058000, 'https://lili.vn/wp-content/uploads/2022/11/Day-chuyen-bac-nu-dinh-kim-cuong-Moissanite-hinh-gac-nai-LILI_055097_5-400x400.jpg'),
('Dây chuyền bạc nữ đính đá Aurora mèo nhỏ và mặt trăng LILI_328547', '', 'red', 0, 'necklace', 806000, 'https://lili.vn/wp-content/uploads/2021/12/Day-chuyen-bac-nu-meo-nho-va-mat-trang-dinh-da-Moonstone-LILI_328547_2-400x400.jpg'),
('Dây chuyền bạc nữ đính đá CZ hình trái tim cách điệu đẹp Katalina LILI_352665', '', 'red', 0, 'necklace', 800000, 'https://lili.vn/wp-content/uploads/2021/12/Mat-day-chuyen-bac-nu-trai-tim-cach-dieu-dinh-da-CZ-LILI_352665_2-400x400.jpg'),
('Dây chuyền bạc nữ đính đá CZ trái tim cỏ 4 lá đóng mở LILI_822972', '', 'blue', 0, 'necklace', 817000, 'https://lili.vn/wp-content/uploads/2021/12/Day-chuyen-bac-nu-dinh-da-CZ-trai-tim-co-4-la-dong-mo-LILI_822972_20-400x400.jpg'),
('Dây chuyền bạc nữ đính đá CZ hình thỏ ngắm trăng LILI_899188', '', 'white', 0, 'necklace', 648000, 'https://lili.vn/wp-content/uploads/2022/08/Day-chuyen-bac-nu-dinh-da-CZ-hinh-tho-ngam-trang-LILI_899188_3-400x400.jpg'),
('Dây chuyền bạc nữ đính đá CZ cỏ 4 lá Veronica LILI_172818', '', 'blue', 0, 'necklace', 747000, 'https://lili.vn/wp-content/uploads/2022/08/Day-chuyen-bac-nu-dinh-da-CZ-co-4-la-Veronica-LILI_172818_1-400x400.jpg'),
('Dây chuyền bạc nữ đính pha lê Aurora mặt trăng cách điệu LILI_545817', '', 'red', 0, 'necklace', 787000, 'https://lili.vn/wp-content/uploads/2022/09/Day-chuyen-bac-nu-dinh-pha-le-Aurora-mat-trang-cach-dieu-LILI_545817_2-400x400.jpg'),
('Dây chuyền bạc nữ đính đá CZ 2 trái tim ghép đôi LILI_763116', '', 'blue', 0, 'necklace', 722000, 'https://lili.vn/wp-content/uploads/2021/12/Mat-day-chuyen-bac-nu-2-trai-tim-ghep-doi-LILI_763116_1-400x400.jpg'),
('Vòng cổ bạc nữ đính đá CZ hình ngôi sao băng Farah LILI_053917', '', 'white', 0, 'necklace', 701000, 'https://lili.vn/wp-content/uploads/2022/10/Vong-co-bac-nu-dinh-da-CZ-hinh-ngoi-sao-bang-Farah-LILI_053917_2-400x400.jpg'),
('Dây chuyền bạc nữ đính đá CZ hình chú thiên nga Swan LILI_197559', '', 'white', 0, 'necklace', 782000, 'https://lili.vn/wp-content/uploads/2024/05/Day-chuyen-bac-nu-dinh-da-CZ-hinh-chu-thien-nga-LILI_197559_22-400x400.jpg'),
('Vòng cổ bạc nữ đẹp và độc đính pha lê Swarovski hình trái tim LILI_972812', '', 'blue', 0, 'necklace', 1194000, 'https://lili.vn/wp-content/uploads/2021/01/Day-chuyen-bac-trai-tim-pha-le-Swarovski-LILI_972812-4-400x400.jpg'),
('Dây chuyền bạc đính pha lê Aurora cao cấp, đá CZ nữ hoa lá LILI_955426', '', 'blue', 0, 'necklace', 806000, 'https://lili.vn/wp-content/uploads/2021/12/Day-chuyen-bac-nu-hoa-la-dinh-pha-le-Aurora-da-CZ-LILI_955426_7-400x400.jpg'),
('Dây chuyền bạc nữ mạ vàng 2 tầng đính đá CZ tròn Sunday LILI_531821', '', 'white', 0, 'necklace', 701000, 'https://lili.vn/wp-content/uploads/2022/10/Day-chuyen-bac-nu-ma-vang-2-tang-dinh-da-CZ-tron-Sunday-LILI_531821_1-400x400.jpg'),
('Dây chuyền bạc nữ đính kim cương tự nhiên cỏ 4 lá Lucky LILI_832459', '', 'white', 0, 'necklace', 1016000, 'https://lili.vn/wp-content/uploads/2022/04/Day-chuyen-bac-nu-dinh-kim-cuong-tu-nhieu-co-4-la-LILI_832459_2-400x400.jpg'),
('Dây chuyền bạc nữ pha lê Aurora tròn lấp lánh LILI_974332', '', 'blue', 0, 'necklace', 757000, 'https://lili.vn/wp-content/uploads/2021/12/Day-chuyen-bac-nu-tron-lap-lanh-pha-le-Aurora-LILI_974332_8-400x400.jpg'),
('Dây chuyền bạc nữ đính đá CZ đá nhảy trái tim Grainne LILI_262454', '', 'blue', 0, 'necklace', 812000, 'https://lili.vn/wp-content/uploads/2022/08/Mat-day-chuyen-bac-nu-dinh-da-CZ-trai-tim-Grainne-LILI_262454_4-400x400.jpg'),
('Dây chuyền bạc nữ mảnh nhỏ đính đá CZ hình trái tim cách điệu Nolan LILI_255281', '', 'blue', 0, 'necklace', 765000, 'https://lili.vn/wp-content/uploads/2022/09/Day-chuyen-bac-nu-dinh-da-CZ-hinh-trai-tim-cach-dieu-Nolan-LILI_255281_1-400x400.jpg'),


('Mặt dây chuyền bạc nam hình hoa văn Joziah LILI_080177', 'Mặt dây chuyền bạc nam hình hoa văn Joziah LILI_080177', 'blue', 1, 'pendant', 1858000.00, 'https://lili.vn/wp-content/uploads/2023/10/Mat-day-chuyen-bac-nam-hinh-hoa-van-Joziah-LILI_080177_5-400x400.jpg'),
('Dây chuyền bạc nam đính đá CZ hình chiếc nhẫn Alexis LILI_078869', 'Dây chuyền bạc nam đính đá CZ hình chiếc nhẫn Alexis LILI_078869', 'white', 1, 'necklace', 991000.00, 'https://lili.vn/wp-content/uploads/2023/10/Day-chuyen-bac-nam-dinh-da-CZ-hinh-chiec-nhan-Alexis-LILI_078869_1-400x400.jpg'),
('Dây chuyền bạc nam/nữ dạng cuban chuỗi Vance LILI_080856', 'Dây chuyền bạc nam/nữ dạng cuban chuỗi Vance LILI_080856', 'blue', 2, 'necklace', 4406000.00, 'https://lili.vn/wp-content/uploads/2023/10/Day-chuyen-bac-nam-nu-dang-cuban-chuoi-Vance-LILI_080856_8-400x400.jpg'),
('Dây chuyền bạc cuban đính kim cương Moissanite Vance LILI_081040', 'Dây chuyền bạc cuban đính kim cương Moissanite Vance LILI_081040', 'blue', 2, 'necklace', 10561000.00, 'https://lili.vn/wp-content/uploads/2023/10/Day-chuyen-bac-cuban-dinh-kim-cuong-Moissanite-Vance-LILI_081040_2-400x400.jpg'),
('Mặt dây chuyền bạc Thái nam hình thanh kiếm gãy Cristian LILI_077444', 'Mặt dây chuyền bạc Thái nam hình thanh kiếm gãy Cristian LILI_077444', 'red', 1, 'pendant', 2361000.00, 'https://lili.vn/wp-content/uploads/2023/09/Mat-day-chuyen-bac-Thai-nam-hinh-thanh-kiem-gay-Cristian-LILI_07744_1-400x400.jpg'),
('Dây chuyền bạc nam đính đá CZ nhẫn kèm ngôi sao 6 cánh Scott LILI_078646', 'Dây chuyền bạc nam đính đá CZ nhẫn kèm ngôi sao 6 cánh Scott LILI_078646', 'blue', 1, 'necklace', 920000.00, 'https://lili.vn/wp-content/uploads/2023/09/Day-chuyen-bac-nam-dinh-da-CZ-nhan-kem-ngoi-sao-6-canh-Scott-LILI_078646_2-400x400.jpg'),
('Mặt dây chuyền bạc Thái nam dạng khiên Malcolm phong cách độc lạ LILI_078123', 'Mặt dây chuyền bạc Thái nam dạng khiên Malcolm phong cách độc lạ LILI_078123', 'red', 1, 'pendant', 1710000.00, 'https://lili.vn/wp-content/uploads/2023/09/Mat-day-chuyen-bac-Thai-nam-dang-khien-Malcolm-phong-cach-doc-la-LILI_078123_5-400x400.jpg'),
('Dây chuyền bạc nam cỡ nhỏ chuỗi vuông tròn thời trang Hip Hop LILI_345554', 'Dây chuyền bạc nam cỡ nhỏ chuỗi vuông tròn thời trang Hip Hop LILI_345554', 'blue', 1, 'necklace', 1391000.00, 'https://lili.vn/wp-content/uploads/2021/12/Day-chuyen-bac-nam-tong-hop-chuoi-vuong-tron-thoi-trang-Hip-Hop-LILI_345554_14-400x400.jpg'),
('Mặt dây chuyền bạc nam hình chiếc giày Augustine LILI_076892', 'Mặt dây chuyền bạc nam hình chiếc giày Augustine LILI_076892', 'red', 1, 'pendant', 2138000.00, 'https://lili.vn/wp-content/uploads/2023/09/Mat-day-chuyen-bac-nam-hinh-chiec-giay-Augustine-LILI_076892_1-400x400.jpg'),
('Mặt dây chuyền bạc nam đính đá CZ hình thánh giá Talon LILI_080417', 'Mặt dây chuyền bạc nam đính đá CZ hình thánh giá Talon LILI_080417', 'white', 1, 'pendant', 1821000.00, 'https://lili.vn/wp-content/uploads/2023/10/Mat-day-chuyen-bac-nam-dinh-da-CZ-hinh-thanh-gia-Talon-LILI_080417_2-400x400.jpg');

