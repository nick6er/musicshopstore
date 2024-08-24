<?php 
session_start();
include 'config.php';


$productIds = [];
foreach(($_SESSION['cart'] ?? []) as $cartId => $cartQty) {
    $productIds[] = $cartId;
}

$ids = 0;
if(count($productIds) > 0) {
    $ids = implode(',', $productIds);
}
//product all
$query = mysqli_query($conn, "SELECT * FROM products WHERE id IN ($ids)");
$rows = mysqli_num_rows($query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
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
        <h4>Cart</h4>
        <div class="row">
            <div class="col-12">
                <form action="<?php echo $base_url; ?>/cart-update.php" method="post" enctype="multipart/form-data">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th style="width: 100px;">Image</th>
                                <th>Product name</th>
                                <th style="width: 50px;">Price</th>
                                <th style="width: 50px;">Quantity</th>
                                <th style="width: 100px;">Total</th>
                                <th style="width: 50px;">Color</th>
                                <th style="width: 200px;">Action</th>
                    
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($rows > 0):?>
                                <?php while($product = mysqli_fetch_assoc($query)):?>
                            <tr>
                                <td>
                                    <?php if(!empty($product['image_product'])):?>
                                        <img src="<?php echo $base_url; ?>/upload_image/<?php echo $product['image_product'];?>" width="200" alt="Product Image">
                                    <?php else: ?>
                                        <img src="<?php echo $base_url; ?>" width="200" alt="Product Image">
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php echo $product['product_name'];?>
                                    <div>
                                        <small class="text-muted"><?php echo nl2br($product['detail']);?></small>
                                    </div>
                                </td>
                                <td><?php echo number_format($product['price'], 2); ?></td>
                                <td><input type="number" name="product[<?php echo $product['id']; ?>][quantity]" class="form-control" value="<?php echo $_SESSION['cart'][$product['id']]; ?>"></td>
                                <td><?php echo number_format($product['price'] *  $_SESSION['cart'][$product['id']], 2); ?></td>
                                <td><div style="width:20px; height:20px; background:<?php echo $product['color'];?>; border-radius:5px;"></div></td>
                                <td>
                                    <a onclick="return confirm('Are you sure you want to Delete?');" role="button" href="<?php echo $base_url; ?>/product-delete.php?id=<?php echo $product['id'];?>" class="btn btn-outline-danger">Delete</a>
                                </td>
                                
                            </tr>
                                <?php endwhile; ?>
                                <tr>
                                    <td colspan="7" class="text-end">
                                        <button class="btn btn-lg btn-success" type="submit">Update Cart</button>
                                        <a href="<?php echo $base_url; ?>/checkout.php" class="btn btn-lg btn-primary">Continue to Checkout</a>
                                    </td>
                                </tr>
                            <?php else: ?>
                            <tr>
                                <td colspan="7"><h4 class="text-center text-danger">ไม่มีรายการสินค้า</h4></td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
    <script src="<?php echo $base_url; ?>/bootstrap-5.3.3/js/bootstrap.min.js"></script>
</body>
</html>
