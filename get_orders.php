<?php
session_start();
if(isset($_SESSION['username'])){
    $user = $_SESSION['username'];
    $id_client = $_SESSION['id'];
}
else $user = "Guest";

include('db_connect.php');

header('Content-Type: application/json');

$sql = "SELECT orders.id_order, orders.order_date, orders.quantity, orders.order_state, products.productName, orders.total_price, products.image
              FROM orders
              JOIN products ON orders.id_product = products.id 
              WHERE orders.id_client = $id_client AND orders.order_state = 'PENDING'";

$result = mysqli_query($link, $sql);

if(!$result){
    echo json_encode([]);
    exit;
}

$orders = [];

while($row = mysqli_fetch_assoc($result)){
    $orders[] = $row;
}

echo json_encode($orders);