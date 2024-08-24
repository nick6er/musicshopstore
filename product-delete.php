<?php 
session_start();
include 'config.php';

if(!empty($_GET['id'])) {
    $query_product = mysqli_query($conn, "SELECT * FROM products WHERE id='{$_GET['id']}'");
    $result = mysqli_fetch_assoc($query_product);
    @unlink('upload_image/' . $result['image_product']);

    $query = mysqli_query($conn,"DELETE FROM products WHERE id='{$_GET['id']}'") or die ('query failed');
    mysqli_close($conn);

    if($query) {
        $_SESSION['message'] = 'Product Delete success!';
        header('location: ' . $base_url . '/add.php');
    } else {
        $_SESSION['message'] = 'Product could not be Delete!';
        header('location: ' . $base_url . '/add.php');
    }
}