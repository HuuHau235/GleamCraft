<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css"
        integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../../assets/css/shoping_cart.css">
</head>
<body>
    <section class="cart-section">
        <div class="container">
            <div class="title_cart d-flex align-items-center gap-2 mb-3">
                <i class="fa-solid fa-angle-left"></i>
                <h4 class="mb-0 title">Shopping Continue</h4>
            </div>
            <div class="cart">
            <!-- <div class="contain_cart p-4">
                <div class="row g-0 align-items-center">
                    <div class="col-md-2">
                        <img src="https://via.placeholder.com/300" class="img-fluid rounded-start" alt="Product Image">
                    </div>
                    <div class="col-md-3 text-center">
                        <div class="card-body">
                            <h5 class="card-title">Dimond Ring</h5>
                            <p class="card-text text-muted">Describe</p>
                        </div>
                    </div>
                    <div class="col-md-3 text-center">
                        <div class="d-flex justify-content-center align-items-center">
                            <button class="btn btn-outline-secondary btn-sm">-</button>
                            <input type="text" value="1" class="form-control mx-2 text-center" style="width: 50px;">
                            <button class="btn btn-outline-secondary btn-sm">+</button>
                        </div>
                    </div>
                    <div class="col-md-4 d-flex justify-content-between align-items-center">
                        <p class="price mb-0">5.000.000 VND</p>
                        <button class="btn btn-sm">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div> -->
            <!-- <div class="contain_cart p-4">
                <div class="row g-0 align-items-center">
                    <div class="col-md-2">
                        <img src="https://via.placeholder.com/300" class="img-fluid rounded-start" alt="Product Image">
                    </div>
                    <div class="col-md-3 text-center">
                        <div class="card-body">
                            <h5 class="card-title">Dimond Ring</h5>
                            <p class="card-text text-muted">Describe</p>
                        </div>
                    </div>
                    <div class="col-md-3 text-center">
                        <div class="d-flex justify-content-center align-items-center">
                            <button class="btn btn-outline-secondary btn-sm">-</button>
                            <input type="text" value="1" class="form-control mx-2 text-center" style="width: 50px;">
                            <button class="btn btn-outline-secondary btn-sm">+</button>
                        </div>
                    </div>
                    <div class="col-md-4 d-flex justify-content-between align-items-center">
                        <p class="price mb-0">5.000.000 VND</p>
                        <button class="btn btn-sm">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div> -->
            <div class="contain_cart p-4">
                <div class="row g-0 align-items-center">
                    <div class="col-md-2">
                        <img src="https://via.placeholder.com/300" class="img-fluid rounded-start" alt="Product Image">
                    </div>
                    <div class="col-md-3 text-center">
                        <div class="card-body">
                            <h5 class="card-title">Dimond Ring</h5>
                            <p class="card-text text-muted">Describe</p>
                        </div>
                    </div>
                    <div class="col-md-3 text-center">
                        <div class="d-flex justify-content-center align-items-center">
                            <button class="btn btn-outline-secondary btn-sm" id="reduce">-</button>
                            <input type="text" value="1" class="form-control mx-2 text-center" id="quantity" style="width: 50px;">
                            <button class="btn btn-outline-secondary btn-sm" id="increase">+</button>
                        </div>
                    </div>
                    <div class="col-md-4 d-flex justify-content-between align-items-center">
                        <p class="price mb-0" id=">5.000.000 VND</p>
                        <button class="btn btn-sm">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
            </div>
        </div>
        <div class="button">
            <button type="button" class="btn btn-dark payment">Payment</button>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../../assets/js/shoping_cart.js"></script>
</body>

</html>