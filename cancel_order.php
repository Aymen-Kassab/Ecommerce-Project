<?php
session_start();
include('db_connect.php');

header('Content-Type: application/json');

if (!isset($_SESSION['id'])) {
    echo json_encode(['success' => false, 'message' => 'You must be logged in.']);
    exit();
}

$id_client = $_SESSION['id'];

if (!isset($_POST['id_order'])) {
    echo json_encode(['success' => false, 'message' => 'Missing order ID.']);
    exit();
}

$id_order = intval($_POST['id_order']);

$checkQuery = "SELECT * FROM orders WHERE id_order = $id_order AND id_client = $id_client";
$checkResult = mysqli_query($link, $checkQuery);

if (!$checkResult || mysqli_num_rows($checkResult) === 0) {
    echo json_encode(['success' => false, 'message' => 'Order not found or not yours.']);
    exit();
}

$updateQuery = "UPDATE orders SET order_state = 'CANCELED' WHERE id_order = $id_order";
if (mysqli_query($link, $updateQuery)) {
    echo json_encode(['success' => true, 'message' => 'Order cancelled successfully.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to cancel order.']);
}
?>