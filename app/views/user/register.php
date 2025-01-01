<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../../assets/css/register.css">
    <title>Register</title>
</head>
<body>
    <div class="container">
        <div class="image">
            <img src="../../../assets/images/anh_login_logout.png" alt="Registration Image">
        </div>

        <form class="register-form" action="/User/register" method="POST">
            <h1>Create Your Account</h1>
            <div class="information">
                <div class="first-name">
                    <p>First Name</p>
                    <input type="text" name="username" placeholder="Enter your name..." required>
                </div>
                <div class="phonenumber">
                    <p>Phone</p>
                    <input type="text" name="phone" placeholder="Enter phone number..." required>
                </div>
                <div class="email">
                    <p>Email</p>
                    <input type="email" name="email" placeholder="Enter email..." required>
                </div>
                <div class="password">
                    <p>Password</p>
                    <input type="password" name="password" placeholder="Enter password..." required>
                </div>
                <div class="confirm-password">
                    <p>Confirm password</p>
                    <input type="password" name="confirmpassword" placeholder="Enter confirm password..." required>
                </div>
                <button class="register-btn" type="submit">Register</button>
            </div>
        </form>
    </div>
</body>
</html>
