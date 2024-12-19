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

        <form class="register-form" action="../../controllers/RegisterController.php" method="POST">
            <h1>Create Your Account</h1>
            <div class = "cta">
                <p>Already have an account?</p>
                <p class="login"><a href="login.php">Login</a></p>
            </div>
            <div class = "information">
                <div class = "first-name">
                    <p>First Name</p>
                    <input type="text" name="username" placeholder="Enter your name...">
                </div>
                <div class = "phonenumber">
                    <p>Phone</p>
                    <input type="text" name="phonenumber" placeholder="Enter phone number...">
                </div>
                <div class = "email">
                    <p>Email</p>
                    <input type="text" name="email" placeholder="Enter email...">
                </div>
                <div class="password">
                    <p>Password</p>
                    <input type="password" name="password" placeholder="Enter password...">
                </div>
                <div class = "confirm-password">
                    <p>Confirm password</p>
                    <input type="password" name="confirm-password"  placeholder="Enter authentication password...">
                </div>
               <a href="login.php"> <button class="register-btn">Register</button></a>
                
                <div class="or-container">
                    <span>OR</span>
                </div>
                <div class="register-method">
                    <button type="button" class="btn btn-outline-secondary w-100 my-1">
                        <div class="icon-container">
                            <span class="fab fa-facebook-f"></span>
                            Continue with Facebook
                        </div>
                    </button>
                    <button type="button" class="btn btn-outline-secondary w-100 my-1">
                        <div class="icon-container">
                            <span class="fab fa-google"></span>
                            Continue with Google
                        </div>
                    </button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>