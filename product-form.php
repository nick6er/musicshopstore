<?php 
session_start();
include 'config.php';

$product_name = trim($_POST['product_name']);
$price = trim($_POST['price']);
$detail = trim($_POST['detail']);
$color = trim($_POST['color']);
$image_name = $_FILES['image_product']['name'];

$image_tmp = $_FILES['image_product']['tmp_name'];
$folder = 'upload_image/';
$image_location = $folder . $image_name;

if(empty($_POST['id'])) {
    $query = mysqli_query($conn,"INSERT INTO products (product_name,price,image_product,detail,color) VALUES ('{$product_name}','{$price}','{$image_name}','{$detail}','{$color}')") or die ('query failed');
} else {
    $query_product = mysqli_query($conn, "SELECT * FROM products WHERE id='{$_POST['id']}'");
    $result = mysqli_fetch_assoc($query_product);

    if(empty($image_name)) {
        $image_name = $result['image_product'];
    } else {
        @unlink($folder . $result['image_product']);
    }

    $query = mysqli_query($conn,"UPDATE products SET product_name='{$product_name}',price='{$price}',image_product='{$image_name}',detail='{$detail}',color='{$color}'") or die ('query failed');
}

mysqli_close($conn);
if($query) {
    move_uploaded_file($image_tmp , $image_location);
    $_SESSION['message'] = 'Product saved success!';
    header('location: ' . $base_url . '/add.php');
} else {
    $_SESSION['message'] = 'Product could not be saved!';
    header('location: ' . $base_url . '/add.php');
}