<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Banner</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box; 
        }

        body {
            font-family: Arial, sans-serif;
        }

        .banner {
            position: relative;
            width: 100%;
            height: 400px;
            overflow: hidden;
            margin-top: 0;
        }

        .banner img {
            width: 100%;
            height: 400px;
            object-fit: cover;
        }

        .banner-text {  
            position: absolute;
            bottom: -50px;
            left: 50%;
            transform: translateX(-50%);
            color: black;
            padding: 10px 20px;
            font-size: 4rem;
            font-weight: bold;
            border-radius: 5px;
            text-align: center;
            animation: moveUp 2s ease-out forwards;
        }

        @keyframes moveUp {
            from {
                bottom: -50px;
                opacity: 0;
            }
            to {
                bottom: 50px;
                opacity: 1;
            }
        }
    </style>
</head>
<body>

<div class="banner">
    <img src="../assets/images/brands/Day-chuyen-1.jpg" alt="Banner Image">
    <div class="banner-text">Welcome to GleamCraft </div>
</div> <br> 

</body>
</html>
