<?php
session_start();
if(isset($_SESSION['username'])){
    $user = $_SESSION['username'];
    $id_client = $_SESSION['id'];
}
else $user = "Guest";

include('db_connect.php');
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css_client/orders.css">
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
                    <a href="cart_items.php"><i class='bx bxs-cart-alt'></i></a>
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
            <h2 class="title">MY ORDERS</h2>
            <div id="orders-container">
                <div id="products"></div>
            </div>
        </main>
        <footer></footer>
        <?php include('signin.php'); ?>
        <?php include('signup.php'); ?>
        <script src="scripts/popup.js"></script>
        <script src="scripts/orders_render.js"></script>
        <script>
            window.onload = function() {
                const loggedIn =<?php echo isset($_SESSION['id']) ? 'true' : 'false'; ?>

                document.getElementById('login-btn').style.display = loggedIn ? 'none' : 'block';
                document.getElementById('logout-form').style.display = loggedIn ? 'block' : 'none';
            }
        </script>
    </body>
</html>