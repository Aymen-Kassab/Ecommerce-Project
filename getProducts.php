<?php
include('db_connect.php');

$sql = "SELECT * FROM products";

$result = mysqli_query($link, $sql);

$products = [];

while($row = mysqli_fetch_assoc($result)){
    $products[] = $row;
}

echo json_encode($products);
?>