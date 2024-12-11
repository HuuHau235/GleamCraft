<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../../assets/css/register.css">
</head>
<body>
    <div class = "container">
        <div class = "image">
            <img src="../../../assets/images/anh_login_logout.png" alt="">
        </div>

        <form class = "register-form" action="../../models/register-back.php" method="POST">
            <h1>Tạo tài khoản của bạn</h1>
            <div class = "cta">
                <p>Bạn đã có tài khoản?</p>
                <p class="login"><a href="../views/user/login.php">Đăng nhập</a></p>
            </div>
            <div class = "information">
                <div class = "first-name">
                    <p>Họ Tên</p>
                    <input type="text" name="username" placeholder="Nhập họ tên...">
                </div>
                <div class = "phonenumber">
                    <p>Số điện thoại</p>
                    <input type="text" name="phonenumber" placeholder="Nhập số điện thoại...">
                </div>
                <div class = "email">
                    <p>Email</p>
                    <input type="text" name="email" placeholder="Nhập email...">
                </div>
                <div class="password">
                    <p>Mật khẩu</p>
                    <input type="password" name="password" placeholder="Nhập mật khẩu...">
                </div>
                <div class = "confirm-password">
                    <p>Xác nhận mật khẩu</p>
                    <input type="password" name="confirm-password"  placeholder="Nhập mật khẩu xác thực...">
                </div>
                <button class="register-btn">Đăng ký</button>

                <div class="or-container">
                    <span>Hoặc</span>
                </div>
                <div class="register-method">
                    <button type="button" class="btn btn-outline-secondary w-100 my-1">
                        <div class="icon-container">
                            <span class="fab fa-facebook-f"></span>
                            Đăng ký với Facebook
                        </div>
                    </button>
                    <button type="button" class="btn btn-outline-secondary w-100 my-1">
                        <div class="icon-container">
                            <span class="fab fa-google"></span>
                            Đăng ký với Google
                        </div>
                    </button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>