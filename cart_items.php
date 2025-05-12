<?php

session_start();
if(isset($_SESSION['username'])){
    $user = $_SESSION['username'];
    $id_client = $_SESSION['id'];
}
else $user = "Guest";

include('db_connect.php');

$sql = "SELECT SUM(products.price * cart.quantity) AS total_price
        FROM cart 
        JOIN products ON cart.id_product = products.id 
        WHERE cart.id_client = $id_client";

$result = mysqli_query($link, $sql);

$row = mysqli_fetch_assoc($result);

$total_price = $row['total_price'];

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css_client/cart_items.css">
        <link rel="stylesheet" href="css_client/login-pop-up.css">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded"/>
    </head>
    <body>
        <header>
            <div id="header">
                <h1><a href="home.php">GameVerse</a></h1>
                <button class="login-btn" id="login-btn">Sign in</button>
                <form id="logout-form" action="logout.php" method="post" enctype="multipart/form-data" style="display: none;">
                    <a href="orders.php"><i class='bx bx-package'></i></a>
                    <h3><?php echo htmlspecialchars($user);?></h3>
                    <button class="logout-btn" type="submit">Log Out</button>
                </form>
            </div>
            <nav id="navbar">
                <ul>
                    <li><a href="home.php">Browse</a></li>
                    <li><a href="discover.php">Discover</a></li>
                </ul>
            </nav>
        </header>
        <main>
            <h2 class="title">MY CART</h2>
            <div class="cart-container">
                <div id="products"></div>
                <div class="action-container">
                    <div id="notification">message</div>
                    <h4>Games Summary</h4>
                    <?php if(isset($total_price)): ?>
                        <p id="total-price">Total price: <?php echo "$".htmlspecialchars($total_price); ?></p>
                    <?php endif; ?>
                    <form id="send" action="checkout.php" method="post">
                        <button id="check-out-btn" type="submit">Check Out</button>
                    </form>
                </div>
            </div>
        </main>
        <footer></footer>
        <?php include('signin.php'); ?>
        <?php include('signup.php'); ?>
        <script src="scripts/popup.js"></script>
        <script src="scripts/cart_render.js"></script>
        <script>
            window.onload = function() {
                const loggedIn =<?php echo isset($_SESSION['id']) ? 'true' : 'false'; ?>

                document.getElementById('login-btn').style.display = loggedIn ? 'none' : 'block';
                document.getElementById('logout-form').style.display = loggedIn ? 'block' : 'none';

                const checkOutBtn = document.getElementById("check-out-btn");

                if (loggedIn){
                    checkOutBtn.addEventListener("click", () => {
                        fetch('checkout.php?nocashe=' + new Date().getTime(), {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/x-www-form-urlencoded"
                            }
                        })
                        .then(res => res.json())
                        .then(data => {
                            if(data.success){
                                const notification = document.getElementById("notification");
                                notification.textContent = data.message;
                                notification.style.visibility = "visible";
                                notification.style.backgroundColor = data.success ? "#4CAF50" : "#f44336";

                                setTimeout(() => {
                                    notification.style.visibility = "hidden";
                                }, 4000);

                                fetch('get_items_cart.php?nocache=' + new Date().getTime(), {
                                    method: 'POST',
                                    headers: {
                                          "Content-Type": "application/x-www-form-urlencoded"
                                    },
                                })
                                .then(res => res.json())
                                .then(productsData => {
                                productManaging = new ProductManaging(productsData);
                                productManaging.renderProducts();

                                const total_price = document.getElementById("total-price");
                                total_price.textContent = "Total price: $0";
                                });
                            }
                            else{
                                const notification = document.getElementById("notification");
                                notification.textContent = data.message;
                                notification.style.visibility = "visible";
                                notification.style.backgroundColor = data.success ? "#4CAF50" : "#f44336";
                            }
                        })
                        .catch(err => {
                            console.error(err);
                        })
                    })
                }
            }
        </script>
    </body>
</html>