<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Detail</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../../assets/css/detail.css">
</head>
<body>
    <div class="container product-detail">
        <div class="row">
            <div class="col-md-6">
                <img src="https://via.placeholder.com/400" class="img-fluid product-image" alt="Product Image">
            </div>
            
            <div class="col-md-6 product-info">
                <h1><strong>Dimond Ring</strong></h1>
                <h2>Cartier</h3>                
                <h3>5,000,000 VND</h3>
                <div class="gem-colors">
                    <span>Blue</span>
                    <span>Red</span>
                    <span>White</span>
                </div>
                <div class="mb-3">
                <input type="number" id="quantity" class="form-control" value="1" min="1" style="width: 100px;">
                </div>
                <button class="add-to-cart-btn">Add to cart</button>
            </div>
        </div>

        <div class="comments-section">
            <h3>All comments</h3>
            <div class="comment">
                <input type="text" class="review-input" placeholder="Write your review...">
            </div>
            
            <div class="comment">
                <div class="comment-content">
                    <strong>Duc Thien</strong>
                    <p>The ring shop is both beautiful and luxurious!!</p>
                </div>
            </div>
            <div class="comment">
                <div class="comment-content">
                    <strong>Makima</strong>
                    <p>The ring shop is both beautiful and luxurious!!</p>
                </div>
            </div>
        </div>

        <div class="related-products my-5">
            <h3 class="text-center">Related Products</h3>
            <div class="row">
                <div class="col-md-3">
                    <div class="card mb-3">
                        <img src="https://via.placeholder.com/200" class="card-img-top" alt="Related Product">
                        <div class="card-body">
                            <h5 class="card-title">Related Product 1</h5>
                            <p>1,000,000 VND</p>
                            <a href="#" class="btn btn-primary btn-sm">View</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card mb-3">
                        <img src="https://via.placeholder.com/200" class="card-img-top" alt="Related Product">
                        <div class="card-body">
                            <h5 class="card-title">Related Product 2</h5>
                            <p>1,200,000 VND</p>
                            <a href="#" class="btn btn-primary btn-sm">View</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card mb-3">
                        <img src="https://via.placeholder.com/200" class="card-img-top" alt="Related Product">
                        <div class="card-body">
                            <h5 class="card-title">Related Product 3</h5>
                            <p>1,500,000 VND</p>
                            <a href="#" class="btn btn-primary btn-sm">View</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card mb-3">
                        <img src="https://via.placeholder.com/200" class="card-img-top" alt="Related Product">
                        <div class="card-body">
                            <h5 class="card-title">Related Product 4</h5>
                            <p>1,800,000 VND</p>
                            <a href="#" class="btn btn-primary btn-sm">View</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
