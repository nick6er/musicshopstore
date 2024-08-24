<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Music Shop</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="bootstrap-5.3.3/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <?php include 'config.php'?>
<header class="d-flex justify-content-center py-4 sticky-top border-bottom bg-light shadow-sm">
    <ul class="nav nav-pills">
        <li class="nav-item">
            <a href="<?php echo htmlspecialchars($base_url); ?>/home.php" class="nav-link px-4" style='color:black ; '>Home</a>
        </li>
        <li class="nav-item">
            <a href="<?php echo htmlspecialchars($base_url); ?>/product-list.php" class="nav-link px-4" style='color:black ; '>Product List</a>
        </li>
        <li class="nav-item">
            <a href="<?php echo htmlspecialchars($base_url); ?>/cart.php" class="nav-link px-4" style='color:black ; '>
                Cart
            </a>
        </li>
    </ul>
</header>

    <section class="main-content">
        <div class="banner">
            <img src="assets/main.png" alt="Music Instruments">
        </div>

        <div class="icons">
            <div class="icon-box">
                <img src="assets/icon/guitar.svg" alt="Guitar Icon">
                <h3>Guitar</h3>
                <p>Lorem ipsum dolor sit amet consectetur.</p>
            </div>
            <div class="icon-box">
                <img src="assets/icon/piano.svg" alt="Piano Icon">
                <h3>Piano</h3>
                <p>Lorem ipsum dolor sit amet consectetur.</p>
            </div>
            <div class="icon-box">
                <img src="assets/icon/drum.svg" alt="Drum Icon">
                <h3>Drum</h3>
                <p>Lorem ipsum dolor sit amet consectetur.</p>
            </div>
        </div>
    </section>

    <section class="cta">
        <div class="container">
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
            <button>Join us now!</button>
        </div>
    </section>

    <footer>
        <p>Love coding, copyright 2024</p>
    </footer>
</body>
</html>
