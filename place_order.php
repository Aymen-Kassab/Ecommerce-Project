<?php
session_start();
include('db_connect.php');

header('Content-Type: application/json');

if(!isset($_SESSION['id'])){
    echo json_encode(["success" => false, "message" => "Please sign in to order items"]);
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
$price = $product['price'];
$total_price = $price * $quantity;

if (!$product) {
    echo json_encode(["success" => false, "message" => "Product not found."]);
    exit();
}

if($quantity > $product['stock']){
    echo json_encode(["success" => false, "message" => "Quantity exceeds available stock!"]);
    exit();
}
else{
    $sql = "INSERT INTO orders (order_date, quantity, order_state, id_client, id_product, total_price) VALUES (NOW(), $quantity, 'PENDING', $id_client, $id_product, $total_price)";
    $order_id = mysqli_insert_id($link);
}

if(mysqli_query($link, $sql)){
    echo json_encode(["success" => true, "message" => "Order is added!"]);
    $delete_cart = "DELETE FROM cart WHERE id_client = $id_client AND id_product = $id_product";
    mysqli_query($link, $delete_cart);
    exit();
} else {
    echo json_encode(["success" => false, "message" => "Database error: " . mysqli_error($link)]);
    exit();
}

$to_email = $_SESSION['email'];
$to_username = $_SESSION['username'];

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'src/PHPMailer.php';
require 'src/SMTP.php';
require 'src/Exception.php';

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'aymenelomari1975@gmail.com';
    $mail->Password   = 'fkeiqojgfqirniac';
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    $mail->setFrom('aymenelomari1975@gmail.com', 'GameVerse');
    $mail->addAddress("{$to_email}");

    $mail->isHTML(true);
    $mail->Subject = 'Welcome to GameVerse!';
    $mail->Body = '
    <h2>Hello, '. htmlspecialchars($to_username) .'!</h2>
    <p>Thank you for placing an order at <strong>GameVerse</strong>.</p>
    <p>To confirm your order and proceed with processing, please click Confirm.</p>
    <p>
        <a href="localhost/E-Comerce Project FS/confirm_order.php?id_order=' . $order_id . '&user_id=' . $id_client . '" style="display: inline-block; background-color:rgb(163, 0, 0); color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
            Confirm My Order
        </a>
    </p>
    <p>If you did not place this order, please ignore this email.</p>
    <br>
    <p>Best regards,<br>GameVerse Team</p>
    ';

    $mail->send();

    echo json_encode(['success' => true, 'message' => 'Order placed successfully! A confirmation email has been sent.', 'total_price' => $totalPrice]);
    header('Location: cart_items.php');
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error sending email: ' . $e->getMessage()]);
}
?>
?>