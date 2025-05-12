<?php
session_start();
if(isset($_SESSION['username'])){
    $user = $_SESSION['username'];
    $id_client = $_SESSION['id'];
}
else $user = "Guest";

include('db_connect.php');

if (isset($_GET['id'])){
    
    $productID = $_GET['id'];

    $sql = "SELECT * FROM products WHERE id = $productID";

    $result = mysqli_query($link, $sql);

    if ($result){
        $product = mysqli_fetch_array($result);
    }
}
if(isset($_SESSION['id'])){
    $isInCart = false;
    $cartCheck = "SELECT * FROM cart WHERE id_client = $id_client AND id_product = $productID";
    $cartCheckRes = mysqli_query($link, $cartCheck);
    if(mysqli_num_rows($cartCheckRes) > 0){
        $isInCart = true;
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css_client/achatpage.css">
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
                    <li><a href="discover.php">Discover</a></li>
                </ul>
            </nav>
        </header>
        <main>
            <div align="center" id="product-container">
                <div id="img-container">
                    <img src="uploads/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['productName']); ?>">
                </div>
                <div id="product-infos">
                    <div id="notification">message</div>
                    <h2 id="product-name">
                        <?php echo strtoupper(htmlspecialchars($product['productName'])); ?>
                    </h2>
                    <h3 id="price">
                        <?php echo "Price: $".htmlspecialchars($product['price']) ?>
                    </h3>
                    <h3 id="stock">
                        <?php echo "Stock: ".htmlspecialchars($product['stock']) ?>
                    </h3>
                    <button id="order-now-btn" data-product-id="<?php echo $product['id'];?>" type="submit">Order now</button>
                    <?php if(isset($_SESSION['id'])):?>
                    <?php if($isInCart):?>
                        <div style="display: flex; align-items: center; justify-content:center; gap: 10px;">
                            <label for="quantity">quantity:</label>
                            <input type="number" id="quantity" name="quantity" value="1" min="1" max="<?php echo htmlspecialchars($product['stock']); ?>" disabled>
                        </div>
                        <button id="add-to-cart-btn" disabled>Added to Cart ✅</button>
                    <?php else: ?>
                        <div style="display: flex; align-items: center; justify-content:center; gap: 10px;">
                            <label for="quantity">quantity:</label>
                            <input type="number" id="quantity" name="quantity" value="1" min="1" max="<?php echo htmlspecialchars($product['stock']); ?>">
                        </div>
                        <button id="add-to-cart-btn" data-product-id="<?php echo $product['id']; ?>">Add to cart</button>
                    <?php endif; ?>
                    <?php elseif(!isset($_SESSION['id'])):?>
                        <button id="add-to-cart-btn">Add to cart</button>
                    <?php endif;?>
                </div>
            </div>
        </main>
        <footer></footer>
        <?php include('signin.php') ?>
        <?php include('signup.php') ?>
        <script src="scripts/popup.js"></script>
        <script src="scripts/errors.js"></script>
        <script>
            window.onload = function() {
                const loggedIn = <?php echo json_encode(isset($_SESSION['id'])); ?>;
                const loginBtn = document.getElementById('login-btn');
                const logoutForm = document.getElementById('logout-form');

                if (loginBtn) loginBtn.style.display = loggedIn ? 'none' : 'block';
                if (logoutForm) logoutForm.style.display = loggedIn ? 'block' : 'none';

                const addToCartBtn = document.getElementById("add-to-cart-btn");
                const orderNowBtn = document.getElementById("order-now-btn");
                
                //ADD TO CART LOGIC----------------------------------------------------------------
                
                if(!loggedIn && addToCartBtn){
                    addToCartBtn.addEventListener("click", () => {
                        const notification = document.getElementById("notification");
                        notification.style.visibility = "visible";
                        notification.textContent = "Please sign in to add items to cart";
                        setTimeout(() => {
                                    notification.style.visibility = "hidden";
                                }, 4000);
                    })
                }

                if(loggedIn && addToCartBtn){
                    const isInCart = <?php echo isset($isInCart) && $isInCart ? 'true' : 'false'; ?>;
                    if(!isInCart){
                        addToCartBtn.addEventListener("click", () => {
                            const productId = addToCartBtn.dataset.productId;
                            const quantity = document.getElementById("quantity").value;
                            addToCartBtn.disabled = true;

                            fetch("add_to_cart.php", {
                                method: "POST",
                                headers: {
                                    "Content-Type": "application/x-www-form-urlencoded"
                                },
                                body: "product_id=" + encodeURIComponent(productId) + "&quantity=" + encodeURIComponent(quantity)
                            })
                            .then(res => res.json())
                            .then(data => {
                                const notification = document.getElementById("notification");
                                notification.textContent = data.message;
                                notification.style.visibility = "visible";
                                notification.style.backgroundColor = data.success ? "#4CAF50" : "#f44336";
                                console.log(data.message);

                                setTimeout(() => {
                                    notification.style.visibility = "hidden";
                                }, 4000);

                                if (data.success) {
                                    addToCartBtn.textContent = "Added to Cart ✅";
                                } else {
                                addToCartBtn.textContent = "Add to cart";
                                addToCartBtn.disabled = false;
                                }
                            })
                            .catch(error => {
                                addToCartBtn.textContent = "ADD TO CART";
                                console.error("Error:", error);
                                document.getElementById("notification").textContent = "An error occurred. Please try again.";
                                document.getElementById("notification").style.visibility = "visible";
                            });
                        });
                    }
                }

                //ORDER ITEMS LOGIC----------------------------------------------------------------

                if(!loggedIn && orderNowBtn){
                    orderNowBtn.addEventListener("click", () => {
                        document.getElementById("notification").style.visibility = "visible";
                        document.getElementById("notification").textContent = "Please sign in to order items";
                        setTimeout(() => {
                                    document.getElementById("notification").style.visibility = "hidden";
                                }, 4000);
                    })
                }

                if(loggedIn && orderNowBtn){
                    orderNowBtn.addEventListener("click", () => {
                        const productId = orderNowBtn.dataset.productId;
                        const quantity = document.getElementById("quantity").value;
                        
                        fetch("place_order.php", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/x-www-form-urlencoded"
                            },
                                body: "product_id=" + encodeURIComponent(productId) + "&quantity=" + encodeURIComponent(quantity)
                        })
                        .then(res => res.json())
                        .then(data => {
                            const notification = document.getElementById("notification");
                            notification.textContent = data.message;
                            notification.style.visibility = "visible";
                            notification.style.backgroundColor = data.success ? "#4CAF50" : "#f44336";
                            console.log(data.message);

                            setTimeout(() => {
                                notification.style.visibility = "hidden";
                            }, 4000);

                            if (data.success) {
                                orderNowBtn.textContent = "Order now";
                                } else {
                                orderNowBtn.textContent = "Order now";
                                }
                            })
                            .catch(error => {
                                console.error("Error:", error);
                                document.getElementById("notification").textContent = "An error occurred. Please try again.";
                                document.getElementById("notification").style.visibility = "visible";
                            });
                    }); 
                }
            }
        </script>
    </body>
</html>