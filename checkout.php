<?php 
session_start();
include 'config.php';

$productIds = [];
foreach(($_SESSION['cart']??[])as $cartId => $cartValue) {
    $productIds[] = $cartId;
}

$ids = 0;
if(count($productIds) > 0) {
    $ids = implode(', ', $productIds);
}

//product all
$query = mysqli_query($conn, "SELECT * FROM products WHERE id IN ($ids) ");
$rows = mysqli_num_rows($query);

?>

<!doctype html>
<html lang="en" data-bs-theme="auto">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Checkout</title>

    <link href="<?php echo htmlspecialchars($base_url); ?>/bootstrap-5.3.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo htmlspecialchars($base_url); ?>/path/to/your-styles.css" rel="stylesheet"> <!-- Link to your CSS -->
</head>

<style>
    /* Global styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Roboto', sans-serif;
    background-color: #fff;
    color: #333;
}

header {
    background-color: #ffe7cb; /* Light theme color for header */
    border-bottom: 1px solid #ddd;
    padding: 10px 0;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.container {
    width: 90%;
    max-width: 1200px;
    margin: 0 auto;
}

.logo {
    font-size: 24px;
    font-weight: bold;
    color: #333; /* Text color for logo */
}

nav a {
    font-size: 18px;
    color: #333; /* Text color for navigation links */
    text-decoration: none;
}

/* Main content with banner and icons */
.main-content {
    display: flex;
    padding: 50px 60px;
    background-color: #ffe7cb; /* Match theme color */
}

.banner {
    display: flex;
    padding: 20px 10%;
    padding-right: 20px;
}

.banner img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
}

.icons {
    flex: 0 0 40%;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.icon-box {
    flex: 1;
    text-align: center;
    padding: 20px;
    margin: 0 10px; /* Adds space between the boxes */
    border-radius: 8px;
    transition: background-color 0.3s ease; /* Smooth transition */
}

.icon-box:hover {
    background-color: #ffe7cb; /* Hover color to match theme */
}

.icon-box img {
    max-width: 80px;
    margin-bottom: 10px;
}

.icon-box h3 {
    margin-bottom: 10px;
    font-weight: bold;
}

.cta {
    background-color: #ffe7cb; /* Call to action background color */
    padding: 40px 0;
    text-align: center;
}

.cta p {
    margin-bottom: 20px;
}

.cta button {
    padding: 10px 20px;
    background-color: #333; /* Button color */
    color: #fff;
    border: none;
    cursor: pointer;
    border-radius: 5px;
    font-size: 16px;
}

footer {
    background-color: #f9f9f9; /* Light background for a clean look */
    padding: 10px 0; /* Reduced padding for minimalism */
    text-align: center;
    border-top: 1px solid #ddd; /* Subtle border for separation */
}

footer p {
    color: #666; /* Light gray text for subtlety */
    font-size: 14px; /* Smaller text for minimalism */
}

</style>

<body class="bg-body-tertiary" style='background-color: #ffe7cb;'>
<?php include 'config.php';?>
<header class="d-flex justify-content-center py-4 sticky-top border-bottom bg-light">
    <ul class="nav nav-pills">
        <li class="nav-item">
            <a href="<?php echo htmlspecialchars($base_url); ?>/home.php" class="nav-link px-4" style='color:black ; '>Home</a>
        </li>
        <li class="nav-item">
            <a href="<?php echo htmlspecialchars($base_url); ?>/product-list.php" class="nav-link px-4" style='color:black ; '>Product List</a>
        </li>
        <li class="nav-item">
            <a href="<?php echo htmlspecialchars($base_url); ?>/cart.php" class="nav-link px-4" style='color:black ; '>
                Cart (<?php echo count($_SESSION['cart'] ?? []); ?>)
            </a>
        </li>
    </ul>
</header>

    <div class="container" style="margin-top: 40px;  ">
        <?php if (!empty($_SESSION['message'])): ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($_SESSION['message']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>

        <h4 class="mb-3 display-6">Checkout</h4>
        <form action="<?php echo htmlspecialchars($base_url); ?>/cart.php" method="post">
            <div class="row g-5">
                <div class="col-md-8 col-lg-7">
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="fullname" class="form-control" required>
                        </div>

                        <div class="col-sm-6">
                            <label class="form-label">Tel</label>
                            <input type="text" name="tel" class="form-control" required>
                        </div>

                        <div class="col-sm-6">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                    </div>
                    <hr class="my-4">
                    <div class="text-end">
                        <a href="<?php echo htmlspecialchars($base_url); ?>/product-list.php" class="btn btn-secondary">Back to Product List</a>
                        <button class="btn btn-primary" type="submit">Continue to Checkout</button>
                    </div>
                </div>
                <div class="col-md-6 col-lg-5 order-md-last">
                    <h4 class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-primary">Your Cart</span>
                        <span class="badge bg-primary rounded-pill"><?php echo $rows; ?></span>
                    </h4>

                    <?php if ($rows > 0): ?>
                        <ul class="list-group mb-3">
                            <?php $grand_total = 0; ?>
                            <?php while ($product = mysqli_fetch_assoc($query)): ?>
                                <li class="list-group-item d-flex justify-content-between lh-sm">
                                    <div>
                                        <h6 class="my-0"><?php echo htmlspecialchars($product['product_name']); ?> (<?php echo htmlspecialchars($_SESSION['cart'][$product['id']]); ?>)</h6>
                                        <small class="text-body-secondary"><?php echo nl2br(htmlspecialchars($product['detail'])); ?></small>
                                        <input type="hidden" name="product[<?php echo $product['id']; ?>][price]" value="<?php echo htmlspecialchars($product['price']); ?>">
                                        <input type="hidden" name="product[<?php echo $product['id']; ?>][name]" value="<?php echo htmlspecialchars($product['product_name']); ?>">
                                    </div>
                                    <span class="text-body-secondary">฿<?php echo number_format($_SESSION['cart'][$product['id']] * $product['price'], 2); ?></span>
                                </li>
                                <?php $grand_total += $_SESSION['cart'][$product['id']] * $product['price']; ?>
                            <?php endwhile; ?>
                            <li class="list-group-item d-flex justify-content-between bg-body-tertiary">
                                <div class="text-success">
                                    <h6 class="my-0">Grand Total</h6>
                                    <small>Amount</small>
                                </div>
                                <span class="text-success"><strong>฿<?php echo number_format($grand_total, 2); ?></strong></span>
                            </li>
                        </ul>
                        <input type="hidden" name="grand_total" value="<?php echo htmlspecialchars($grand_total); ?>">
                    <?php endif; ?>
                </div>
            </div>
        </form>
    </div>

    <br>
    <footer>
        <p>© 2024 Your Company. All rights reserved.</p>
    </footer>
    <script src="<?php echo htmlspecialchars($base_url); ?>/assets/js/bootstrap.min.js"></script>
</body>
</html>