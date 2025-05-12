<?php 
      include("db_connect.php");
      include("header.php");
      session_start()  ;

      $Users_Total = mysqli_fetch_array(mysqli_query($link, "SELECT COUNT(*) FROM `clients`" ));
      $Admins_Total = mysqli_fetch_array(mysqli_query($link, "SELECT COUNT(*) FROM `admins`" ));
      $P_orders = mysqli_fetch_array(mysqli_query($link, "SELECT COUNT(*) FROM `orders` WHERE order_state = 'CONFIRMED' " ));
      $Products_Total = mysqli_fetch_array(mysqli_query($link, "SELECT COUNT(*) FROM `products`" ));
      $S_orders  = mysqli_fetch_array(mysqli_query($link, "SELECT COUNT(*) FROM `orders` WHERE order_state = 'DELIVERED' " ));
                         ?>
                         
    <section id="header3">  
    <h1 id="title">Admin Dashboard</h1>
    <p>statistics</p>
   </section> 
   <section>
        <div id="dashboard">
          <?php 
          $TotalEarnings = mysqli_fetch_array(mysqli_query($link, "SELECT SUM(total_price) AS total_earnings FROM orders WHERE order_state = 'DELIVERED';
" ));
          ?>
      <div class="infoD"><?php echo "<h1>\${$TotalEarnings[0]}</h1>" ?>
      <p>Total earnings</p></div>
      <div class="infoD"><?php echo"<h1>{$Users_Total[0]}</h1>" ?>
      <p>Total Clients</p></div>
      <div class="infoD"><?php echo"<h1>{$Admins_Total[0]}</h1>" ?>
      <p>Total Admins</p></div>
      <div class="infoD"><?php echo"<h1>{$P_orders[0]}</h1>" ?>
      <p>Confirmed Orders</p></div>
      <div class="infoD"><?php echo"<h1>{$Products_Total[0]}</h1>" ?>
      <p>Total Products</p></div>
      <div class="infoD"><?php echo"<h1>{$S_orders[0]}</h1>" ?>
      <p>Orders Delivered</p></div>
  </div>  </section>
  <script src="script_admin/script.js"></script>  
</body>
</html>