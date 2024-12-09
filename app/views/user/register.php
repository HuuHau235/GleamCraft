<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            display: flex;
            justify-content: center; 
            align-items: center;    
            height: 100vh;          
            margin: 0;
            font-family: 'Source Sans Pro', sans-serif;
            }

        .container {
            display: flex;
            width: 900px;
            height: 700px;
            gap: 100px;
            box-shadow: 10px 10px 20px rgba(0, 0, 0, 0.2);
            border-radius: 10px;           
        }

        .image {
            display: flex;
            justify-content: center;
            align-items: center;
            padding-left: 100px;
            padding-top: 150px;
            width: 300px;
            height: 300px;            
        }
        .image img {
            width: 100%;
            height: 100%;
            border-radius: 20px;
        }

        .register-form {
            border-radius: 10px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.2);
            margin: 50px 0;
            width: 300px;
            height: 600px;
        }
        .register-form h1 {
            font-size: 30px;
            margin-bottom: 0;
            padding-left: 10px;
            color: #0E4A67;
        }
        .cta {
            display: flex;
            gap: 5px;
            font-size: 14px;
            padding-left: 7px;
        }
        .cta p {
            margin: 5px;
            color: #207198;
        }
        .cta .login a {
            color: #FE8B4B ;
            text-decoration: none;
        }
        .information {
            padding: 0px 5px 0px 10px;
        }
        .information div p {
            font-size: 14px;
            margin-bottom: 0;
            color: #207198;
        }
        .information input {
            width: 90%;
            border-radius: 5px;
            border: 1px solid #6FCF97;
            padding: 10px;
            color: #207198;

        }
        .register-btn {
            width: 98%;
            padding: 14px;
            margin-top: 20px ;
            font-size: 20px;
            color: aliceblue;
            background: linear-gradient(to right, #FE904B, #FB724C);
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: transform 0.3s ease;

        }
        .register-btn:hover {
            transition: all 0.3s ease;
            transform: scale(1.1);
            background: linear-gradient(to right, #FB724C, #FFD700);
        }
    </style>
</head>
<body>
    <div class = "container">
        <div class = "image">
            <img src="../../../assets/images/products/ring.jpg" alt="">
        </div>

        <div class = "register-form">
            <h1>Tạo tài khoản của bạn</h1>
            <div class = "cta">
                <p>Bạn đã có tài khoản?</p>
                <p class="login"><a href="#">Đăng nhập</a></p>
            </div>
            <div class = "information">
                <div class = "first-name">
                    <p>Họ Tên</p>
                    <input type="text" placeholder="Nhập họ tên...">
                </div>
                <div class = "phonenumber">
                    <p>Số điện thoại</p>
                    <input type="text" placeholder="Nhập số điện thoại...">
                </div>
                <div class = "email">
                    <p>Email</p>
                    <input type="text" placeholder="Nhập email...">
                </div>
                <div class="password">
                    <p>Mật khẩu</p>
                    <input type="password" placeholder="Nhập mật khẩu...">
                </div>
                <div class = "confirm-password">
                    <p>Xác nhận mật khẩu</p>
                    <input type="password"  placeholder="Nhập mật khẩu xác thực...">
                </div>
                <button class="register-btn">Đăng ký</button>
            </div>
        </div>
    </div>
</body>
</html>