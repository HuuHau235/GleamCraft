<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href=" ../assets/images/brands/logo.jpg" type="image/x-icon">
    <title>GleamCraft</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../../../assets/css/aboutUs.css">
</head>
<body class="body">
<?php
    require_once(__DIR__ . '/../shared/header.php'); 
    ?>

    <div class="banner">
        <img src="https://png.pngtree.com/thumb_back/fw800/background/20240716/pngtree-pendant-with-purple-stones-and-a-diamond-on-black-shiny-surface-image_16005872.jpg" alt="Banner Image">
        <div class="banner-text">About  Us</div>
        <div class="banner-text-p">
            At GleamCraft, we believe in celebrating individuality and timeless beauty. 
            Our journey began with a passion for crafting exquisite jewelry that captures the essence of elegance and refinement
        </div>
    </div> <br>
    
    <div class="container content-section">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h2 class="h2 highlight-text">Radiant around you</h2>
                <p>
                    From delicate pendants to bold jewelry pieces, our collection is inspired by the timeless allure of diamonds. 
                    Each necklace is carefully handcrafted, ensuring that every detail enhances the natural beauty of the diamond.
                </p>
            </div>
            <div class="col-md-6 text-center">
                <img src="https://img.ltwebstatic.com/images3_spmp/2023/05/15/16841523351bafb1708ad53fd56a28a85661b093f7_thumbnail_720x.jpg" alt="" style="width: 500px; height: 600px;">
            </div>
        </div>
    </div>

    <div class="container content-section">
        <div class="row align-items-center">
            <div class="col-md-6 text-center">
                <img src="https://suhiglitz.co.in/wp-content/uploads/2024/12/download-5.jpg" alt="" style="width: 500px; height: 600px;">
            </div>
            <div class="col-md-6">
                <h2 class="h2 highlight-text">Elegance in every detail</h2>
                <p> Our collection ranges from minimalist tennis bracelets to bold artistic designs, 
                    crafted to complement every style—from everyday outfits to formal occasions. 
                    Each piece is meticulously crafted to combine the brilliance of diamonds with timeless design.</p>
            </div>
        </div>
    </div>

    <div class="container content-section">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h2 class="h2 highlight-text">A timeless symbol of love and commitment</h2>
                <p>
                    Our diamond rings are not just accessories—they are symbols of love, promises, and unforgettable moments. 
                    Meticulously crafted with care, each ring tells a unique story, designed to make your special occasions even more meaningful.
                </p>
            </div>
            <div class="col-md-6 text-center">
                <img src="https://down-vn.img.susercontent.com/file/a852e30e49866b17ad245ca7f73a2573" alt="" style="width: 500px; height: 600px;">
            </div>
        </div>
    </div>
    <?php
require_once(__DIR__ . '/../shared/footer.php');  
?>
    <script>
        // Hàm kiểm tra khi phần tử vào trong khung nhìn
        function checkVisibility() {
            const sections = document.querySelectorAll('.content-section');
            sections.forEach(section => {
                const rect = section.getBoundingClientRect();
                if (rect.top >= 0 && rect.bottom <= window.innerHeight) {
                    section.classList.add('visible');

                    // Thêm hiệu ứng cho các thẻ h2, p và img riêng biệt
                    const h2 = section.querySelector('h2');
                    const p = section.querySelector('p');
                    const img = section.querySelector('img');

                    if (h2) h2.classList.add('visible');
                    if (p) p.classList.add('visible');
                    if (img) img.classList.add('visible');
                }
            });
        }

        // Lắng nghe sự kiện cuộn trang
        window.addEventListener('scroll', checkVisibility);

        // Chạy hàm khi tải trang
        document.addEventListener('DOMContentLoaded', checkVisibility);
    </script>
</body>
</html>