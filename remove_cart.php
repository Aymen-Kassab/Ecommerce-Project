<?php
session_start();
include('db_connect.php');

if(isset($_GET['id'])){
    $id_product = intval($_GET['id']);
    $id_client = $_SESSION['id'];

    $sql = "SELECT quantity FROM cart WHERE id_product = $id_product AND id_client = $id_client";
    $result = mysqli_query($link, $sql);

    $cartItems = mysqli_fetch_assoc($result);

    if($cartItems){
        
        $sql_remove = "DELETE FROM cart WHERE id_product = $id_product AND id_client = $id_client";
        
        if(mysqli_query($link, $sql_remove)){
            echo "success";
        }
        else echo "error";
    }
    else echo "not found";
}
else echo "no id";
?>