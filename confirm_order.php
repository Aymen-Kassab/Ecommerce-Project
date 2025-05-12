<?php
session_start();

if (!isset($_SESSION['id'])) {
    $response['message'] = "You need to log in to confirm an order.";
    echo json_encode($response);
    exit();
}

$order_id = isset($_GET['id_order']) ? $_GET['id_order'] : null;
$user_id = $_SESSION['id'];

if ($order_id) {
    include('db_connect.php');
    
    $stmt = $link->prepare("UPDATE orders SET order_state = 'CONFIRMED' WHERE id_order = ? AND id_client = ?");
    $stmt->bind_param("ii", $order_id, $user_id);
    
    if ($stmt->execute()) {
        $response = "Your order has been confirmed!";
    } else {
        $response = "Failed to confirm your order. Please try again.";
    }
    $stmt->close();
} else {
    $response = "Invalid order.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Order</title>
    <link rel="stylesheet" href="css_client/confirm_order.css">
</head>
<body>
    <div id="confirmation-section">
        <div id="message-container" class="message">
        </div>
        <?php if(isset($_SESSION['id'])):?>
            <h1><?php echo htmlspecialchars($response); ?></h1>
        <?php endif; ?>
    </div>
</body>
</html>
