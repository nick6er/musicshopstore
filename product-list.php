<?php 
session_start();
include 'config.php';

//product all
$query = mysqli_query($conn, "SELECT * FROM products");
$rows = mysqli_num_rows($query);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product</title>
    <link href="<?php echo $base_url; ?>/bootstrap-5.3.3/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #ffe7cb;
        }
        .btn-primary {
            background-color: #ffaf7a;
            border-color: #ffaf7a;
        }
        .btn-primary:hover {
            background-color: #ff9c5d;
            border-color: #ff9c5d;
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #fff3e6;
        }
        .alert-warning {
            background-color: #ffdfb9;
            border-color: #ffc68a;
        }
    </style>
</head>
<body>
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
    <div class="container" style="margin-top: 40px;">
        <?php if(!empty($_SESSION['message'])):?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['message']; ?>
            <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['message']); ?>
        <?php endif; ?>
        <h4>Product - List</h4>
        <div class="row">
            <?php if($rows > 0):?>
                <?php while($product = mysqli_fetch_assoc($query)):?>
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                   <div class="card">
                        <?php if(!empty($product['image_product'])):?>
                            <img src="<?php echo $base_url; ?>/upload_image/<?php echo $product['image_product'];?>" class="card-img-top" style="height: 15rem;" alt="Product Image">
                        <?php else: ?>
                            <img src="<?php echo $base_url; ?>" class="card-img-top" style="height: 15rem;" alt="Product Image">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $product['product_name'];?></h5>
                            <p class="card-text text-success fw-bold mb-3"><?php echo number_format($product['price'], 2); ?> Bath</p>
                            <p class="card-text text-muted"><?php echo nl2br($product['detail']);?></p>
                            <p>Color:</p>
                            <div class="card-text" style="width:20px; height:20px; background:<?php echo $product['color'];?>; border-radius:5px;"></div>
                            <a href="<?php echo $base_url; ?>/cart-add.php?id=<?php echo $product['id'];?>" class="btn btn-primary w-100 mt-3">Add to Cart</a>
                        </div>
                   </div>
                </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12">
                    <h4 class="text-danger text-center">ไม่มีรายการสินค้าในตะกร้า</h4>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <script src="<?php echo $base_url; ?>/bootstrap-5.3.3/js/bootstrap.min.js"></script>
</body>
</html>
