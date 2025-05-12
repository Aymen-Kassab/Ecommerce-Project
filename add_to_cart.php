<?php
session_start();
include('db_connect.php');

header('Content-Type: application/json');

if(!isset($_SESSION['id'])){
    echo json_encode(["success" => false, "message" => "Please sign in to add items to cart"]);
    exit();
}
if(!isset($_POST['product_id'])){
    echo json_encode(["success" => false, "message" => "Not product id"]);
    exit();
}

$id_client = intval($_SESSION['id']);
$id_product = intval($_POST['product_id']);
$quantity = intval($_POST['quantity']);

$product_check = "SELECT * FROM products WHERE id = $id_product";
$product_res = mysqli_query($link, $product_check);
$product = mysqli_fetch_assoc($product_res);

if($quantity > $product['stock']){
    echo json_encode(["success" => false, "message" => "Quantity exceeds available stock!"]);
    exit();
}

$check = "SELECT * FROM cart WHERE id_client = $id_client AND id_product = $id_product";
$res = mysqli_query($link, $check);

if(mysqli_num_rows($res) > 0){
    $sql = "UPDATE cart SET quantity = $quantity WHERE id_client = $id_client AND id_product = $id_product";
}
else $sql = "INSERT INTO cart (id_client, id_product, quantity) VALUES ($id_client, $id_product, $quantity)";

mysqli_query($link, $sql);

echo json_encode(["success" => true, "message" => "Added to cart!"]);
?>