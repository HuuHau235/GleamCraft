<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css"
        integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../../../assets/css/login.css">
</head>

<body>
    <div class="container py-5">
        <form action="../../models/login_data.php" method="POST">
            <div class="row justify-content-center align-items-center" style="height: 100%;">
                <div class="col-md-5 text-center image-container">
                    <img src="../../../assets/images/anh_login_logout.png" alt="Image" class="img-fluid">
                </div>
                <div class="col-md-5">
                    <div class="form-container">
                        <h3 class="mb-4">Login</h3>
                        <p>Don't have an account? <a href="./register.php" style="color: #FE8B4B ;">Create Now</a></p>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                placeholder="Enter your email">
                        </div>
                        <div class="mb-3 position-relative">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Enter your password">
                            <i class="fas fa-eye position-absolute" id="togglePassword"
                                style="top: 38px; right: 10px; cursor: pointer;"></i>
                        </div>

                        <button type="submit" name="login" class="btn register w-100">Login</button>
                        <p><a href="">Forgot a password?</a></p>
                        <div class="or-container">
                            <span>OR</span>
                        </div>
                        <div class="text-center mt-3">
                            <button type="button" class="btn btn-outline-secondary w-100 my-1">
                                <div class="icon-container">
                                    <span class="fab fa-facebook-f"></span>
                                    Sign up with Facebook
                                </div>
                            </button>
                            <button type="button" class="btn btn-outline-secondary w-100 my-1">
                                <div class="icon-container">
                                    <span class="fab fa-google"></span>
                                    Sign up with Google
                                </div>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>