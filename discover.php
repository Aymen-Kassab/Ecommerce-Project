<?php 
session_start();
if(isset($_SESSION['username'])){
    $user = $_SESSION['username'];
}
else $user = "Guest";
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css_client/discover.css">
        <link rel="stylesheet" href="css_client/login-pop-up.css">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded"/>
    </head>
    <body>
        <header>
            <div id="header">
                <h1><a href="home.php">GameVerse</a></h1>
                <button class="login-btn" id="login-btn">Sign in</button>
                <?php if (isset($_SESSION['id'])): ?>
                <form id="logout-form" action="logout.php" method="post" enctype="multipart/form-data" style="display: none;">
                    <a href="orders.php"><i class='bx bx-package'></i></a>
                    <a href="cart_items.php"><i class='bx bxs-cart-alt'></i></a>
                    <h3><?php echo htmlspecialchars($user);?></h3>
                    <button class="logout-btn" type="submit">Log Out</button>
                </form>
                <?php endif; ?>
            </div>
            <nav id="navbar">
                <ul>
                    <li><a href="home.php">Browse</a></li>
                    <li><a href="#" id="in">Discover</a></li>
                </ul>
            </nav>
        </header>
        <main>
            <div class="wrapper">
                <div id="search-container">
                    <input type="search" id="search-input" placeholder="Search store">
                    <button id="search">Search</button>
                </div>
            </div>
            <div class="side-bar">
                <ul>
                    <li class="category">
                        <div class="category-title" onclick="dropdown('genre-dropdown')">GENRE</div>
                        <ul class="dropdown" id="genre-dropdown">
                            <li><button class="filter-btn" onclick="filterCat('Action')">Action</button></li>
                            <li><button class="filter-btn" onclick="filterCat('Adventure')">Adventure</button></li>
                            <li><button class="filter-btn" onclick="filterCat('RPG')">RPG</button></li>
                            <li><button class="filter-btn" onclick="filterCat('Horror')">Horror</button></li>
                            <li><button class="filter-btn" onclick="filterCat('Fantasy')">Fantasy</button></li>
                            <li><button class="filter-btn" onclick="filterCat('Fighting')">Fighting</button></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div id="products"></div>
        </main>
        <footer></footer>
        <?php include('signin.php') ?>
        <?php include('signup.php') ?>
        <script src="scripts/popup.js"></script>
        <script src="scripts/sidebar.js"></script>
        <script src="scripts/search_filter_opp.js"></script>
        <script src="scripts/errors.js"></script>
        <script>
            window.onload = function() {
                const loggedIn =<?php echo isset($_SESSION['id']) ? 'true' : 'false'; ?>

                document.getElementById('login-btn').style.display = loggedIn ? 'none' : 'block';
                document.getElementById('logout-form').style.display = loggedIn ? 'block' : 'none';
            }
        </script>
    </body>
</html>