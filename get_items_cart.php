<?php
session_start();
if(isset($_SESSION['username'])){
    $user = $_SESSION['username'];
    $id_client = $_SESSION['id'];
}
else $user = "Guest";

include('db_connect.php');

header('Content-Type: application/json');

$sql = "SELECT products.id, products.productName, products.category, products.price, products.image, cart.quantity 
        FROM cart 
        JOIN products ON cart.id_product = products.id 
        WHERE cart.id_client = $id_client";

$result = mysqli_query($link, $sql);

if(!isset($result)){
    echo json_encode([]);
    exit;
}

$products = [];

while($row = mysqli_fetch_assoc($result)){
    $id_product = $row['id'];
    $checkOrderSql = "SELECT order_state FROM orders WHERE id_product = $id_product 
                      AND id_client = $id_client 
                      ORDER BY order_date DESC 
                      LIMIT 1";
    $orderResult = mysqli_query($link, $checkOrderSql);
    $orderData = mysqli_fetch_assoc($orderResult);

    $row['ordered'] = ($orderData && $orderData['order_state'] == 'PENDING');
    $products[] = $row;
}

echo json_encode($products);
?>