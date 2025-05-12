<?php 
      include("db_connect.php");
      include("header.php");
      session_start()  ;

      if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_status'])) {
        $order_id = intval($_POST['order_id']);
        $new_status = mysqli_real_escape_string($link, $_POST['new_status']);
    
        $update_query = "UPDATE orders SET order_state = '$new_status' WHERE id_order = $order_id";
        if (mysqli_query($link, $update_query)) {
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "<p style='color:red;'>Error updating order status.</p>";
        }
    }
                         ?>

<section id="header3">
    <h1 id="title">Orders</h1>
    <p>manager</p>
   </section> 


   <section id="display_orders" style="padding: 20px; display: flex; flex-wrap: wrap; justify-content: center;">

<?php

$query = "SELECT o.*, c.username, p.productName, p.image
          FROM orders o
          JOIN clients c ON o.id_client = c.id
          JOIN products p ON o.id_product = p.id";


$result = mysqli_query($link, $query);

if (mysqli_num_rows($result) > 0) {
    while ($order = mysqli_fetch_assoc($result)) {?>
        <div class="order">
         <img src="uploads/<?php echo htmlspecialchars($order['image']); ?>" alt="Product Image">
         <h3 style="color: rgba(215, 0, 0, 0.8);"><?php echo htmlspecialchars($order['productName']); ?></h3>
         <p><strong>Client:</strong> <?php echo htmlspecialchars($order['username']); ?></p>
         <p><strong>Date:</strong> <?php echo htmlspecialchars($order['order_date']); ?></p>
         <p><strong>Quantity:</strong> <?php echo htmlspecialchars($order['quantity']); ?></p>
         <p><strong>Total Price:</strong> $<?php echo htmlspecialchars(number_format($order['total_price'], 2)); ?></p>
     
         <form method="POST" action="">
             <input type="hidden" name="order_id" value="<?php echo $order['id_order']; ?>">
             <label for="status_<?php echo $order['id_order']; ?>"><strong>Status:</strong></label>
             <select name="new_status" id="status_<?php echo $order['id_order']; ?>">
                 <option value="PENDING" <?php if($order['order_state'] == 'PENDING') echo 'selected'; ?>>PENDING</option>
                 <option value="CONFIRMED" <?php if($order['order_state'] == 'CONFIRMED') echo 'selected'; ?>>CONFIRMED</option>
                 <option value="DELIVERED" <?php if($order['order_state'] == 'DELIVERED') echo 'selected'; ?>>DELIVERED</option>
                 <option value="CANCELED" <?php if($order['order_state'] == 'CANCELED') echo 'selected'; ?>>CANCELED</option>
             </select>
             <button type="submit" name="update_status" style="margin-top: 8px;">Update</button>
         </form>
     </div>
     <?php }
     
} else {
    echo '<p style="color:white; text-align:center;">No orders found.</p>';
}
?>

</section>




<script src="script_admin/script.js"></script>
</body>
</html>