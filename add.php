<?php 
session_start();
include 'config.php';

//product all
$query = mysqli_query($conn, "SELECT * FROM products");
$rows = mysqli_num_rows($query);


//product form
$result = [
	'id' => '',
	'product_name' => '',
	'price' => '',
	'image_product' => '',
	'detail' => '',
	'color' => '',
];
//product select edit
if(!empty($_GET['id'])) {
    $query_product = mysqli_query($conn, "SELECT * FROM products WHERE id='{$_GET['id']}'");
	$row_product = mysqli_num_rows($query_product);

	if($row_product == 0) {
		header('location: ' . $base_url . '/index.php');
	}

	$result = mysqli_fetch_assoc($query_product);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Product</title>
    <link href="<?php echo $base_url;?>\bootstrap-5.3.3\css\bootstrap.min.css" rel="stylesheet">
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
            <a href="<?php echo htmlspecialchars($base_url); ?>/add.php" class="nav-link px-4" style='color:black ; '>Home</a>
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
        <h4>Home - Manage Product</h4>
        <div class="row g-5">
            <div class="col-md-8 col-sm-12">
                <form action="<?php echo $base_url; ?>/product-form.php" method="post" enctype="multipart/form-data">
					<input type="hidden" name="id" value="<?php echo $result['id'];?>">
                    <div class="row g-3 sm-3">
                        <div class="col-sm-6">
                            <label class="form-label">Product name</label>
                            <input type="text" name="product_name" class="form-control" value="<?php echo $result['product_name'];?>">
                        </div>

                        <div class="col-sm-3">
                            <label class="form-label">Price</label>
                            <input type="number" name="price" class="form-control" value="<?php echo $result['price'];?>">
                        </div>

                        <div class="col-sm-2">
                            <label class="form-label">Color</label>
                            <input type="color" name="color" class="form-control" value="<?php echo $result['color'];?>">
                        </div>

                        <div class="col-sm-6">
							<?php if(!empty($result['image_product'])): ?>
								<div>
									<img src="<?php echo $base_url; ?>/upload_image/<?php echo $result['image_product'];?>" width="200" alt="Product Image">
								</div>
							<?php endif; ?>
                            <label for="formFile" class="form-label">Image</label>
                            <input type="file" name="image_product" class="form-control" accept="image/png , image/jpg, image/jpeg">
                        </div>

                        <div class="col-sm-12">
                            <label class="form-label">Detail</label>
                            <textarea name="detail" class="form-control" rows="3"><?php echo $result['detail'];?></textarea>
                        </div>
                    </div>

					<?php if(empty($result['id'])):?>
                    	<button class="btn btn-primary" type="submit" style="margin-top: 20px;">Create</button>
					<?php else: ?>
						<button class="btn btn-primary" type="submit" style="margin-top: 20px;">Update</button>
					<?php endif; ?>
					<a role="button" class="btn btn-secondary" href="<?php echo $base_url; ?>" type="button" style="margin-top: 20px;">Cancel</a>
                    <hr class="my-4">
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th style="width: 100px;">Image</th>
                            <th>Product name</th>
                            <th style="width: 200px;">Price</th>
                            <th style="width: 200px;">Action</th>
                            <th style="width: 200px;">Color</th>
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
                            <td>
                                <a role="button" href="<?php echo $base_url; ?>/add.php?id=<?php echo $product['id'];?>" class="btn btn-outline-dark">Edit</a>
                                <a onclick="return confirm('Are you sure you want to Delete?');" role="button" href="<?php echo $base_url; ?>/product-delete.php?id=<?php echo $product['id'];?>" class="btn btn-outline-danger">Delete</a>
                            </td>
                            <td><div style="width:20px; height:20px; background:<?php echo $product['color'];?>; border-radius:5px;"></div></td>
                        </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                        <tr>
                            <td colspan="5"><h4 class="text-center text-danger">ไม่มีรายการสินค้า</h4></td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="<?php echo $base_url; ?>/bootstrap-5.3.3/js/bootstrap.min.js"></script>
</body>
</html>
