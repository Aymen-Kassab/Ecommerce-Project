<?php
session_start();
include('db_connect.php');

//header('Content-Type: application/json');

if (isset($_SESSION['username'])) {
    $user = $_SESSION['username'];
} else {
    $user = "Guest";
}

// HANDLE LOGIN POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['signin'])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    //PREPARE SQL TO AVOID SQL INJECTION
    $stmt = $link->prepare("SELECT * FROM clients WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        if (password_verify($password, $row['password'])) {
            session_regenerate_id(true); //THIS HELPS PREVENT SESSION FIXATION ATTACKS
            $_SESSION['id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['email'] = $row['email'];
            echo json_encode(["success" => true, "redirect" => "home.php"]);
            exit();
        } else {
            echo json_encode(["success" => false, "message" => "Invalid Username or Password"]);
            exit();
        }
    } else {
        echo json_encode(["success" => false, "message" => "User not found"]);
        exit();
    }
}

// HANDLE SIGNUP POST

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username']) && isset($_POST['email']) &&isset($_POST['password']) && isset($_POST['signup'])){
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    $error = "";

    $stmt_username = $link->prepare("SELECT * FROM clients WHERE username = ?");
    $stmt_username->bind_param("s", $username);
    $stmt_username->execute();
    $result_username_check = $stmt_username->get_result();

    $stmt_email = $link->prepare("SELECT * FROM clients WHERE email = ?");
    $stmt_email->bind_param("s", $email);
    $stmt_email->execute();
    $result_email_check = $stmt_email->get_result();

    $domain = substr(strrchr($email, "@"), 1);

    if(mysqli_num_rows($result_username_check) > 0){
        echo json_encode(["success" => false, "message" => "Username Already exists"]);
        exit();
    }
    else if(mysqli_num_rows($result_email_check) > 0) {
        echo json_encode(["success" => false, "message" => "Email already exists"]);
        exit();
    }
    else if (!checkdnsrr($domain, "MX")){
        echo json_encode(["success" => false, "message" => "Email is not valid"]);
        exit();
    }
    else {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt_insert = $link->prepare("INSERT INTO clients (username, email, password) VALUES (?, ?, ?)");
        $stmt_insert->bind_param("sss", $username, $email, $hash);
        if ($stmt_insert->execute()){
            $_SESSION['id'] = $stmt_insert->insert_id;
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;
            echo json_encode(["success" => true, "redirect" => "home.php"]);
            exit();
        } 
        else {
            echo json_encode(["success" => false, "message" => "Error during registration!"]);
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>GameVerse</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css_client/home.css">
        <link rel="stylesheet" href="css_client/login-pop-up.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded"/>
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    </head>
    </head>
    <body>
        <header>
            <div id="header">
                <h1><a href="home.php">GameVerse</a></h1>
                <?php if (isset($_SESSION['id'])): ?>
                    <form id="logout-form" action="logout.php" method="post" enctype="multipart/form-data">
                        <a href="orders.php"><i class='bx bx-package'></i></a>
                        <a href="cart_items.php"><i class='bx bxs-cart-alt'></i></a>
                        <h3><?php echo htmlspecialchars($user); ?></h3>
                        <button class="logout-btn" type="submit">Log Out</button>
                    </form>
                <?php else: ?>
                    <button class="login-btn" id="login-btn">Sign in</button>
                <?php endif; ?>
            </div>
            <nav id="navbar">
                <ul>
                    <li><a href="#" id="in">Browse</a></li>
                    <li><a href="discover.php">Discover</a></li>
                </ul>
            </nav>
        </header>
        <main>
            <section class="container">
                <div class="slider-wrapper">
                    <div class="slider">
                        <img class="slide" src="https://thegamepost.com/wp-content/uploads/2025/01/nintendo-switch-2-leak-pricing-details-launch-titles-limited-edition-bundle-4.webp" alt="ns2">
                        <img class="slide" src="https://miro.medium.com/v2/resize:fit:1400/1*MX-Ltgqwr_2eWylidUmOJg.jpeg" alt="psvx">
                        <img class="slide" src="https://variety.com/wp-content/uploads/2024/09/Sony-PlayStation-Pro-5.png?w=1000&h=667&crop=1" alt="ps5">
                    </div>
                </div>
            </section>
        </main>
        <footer></footer>
        <?php include('signin.php');?>
        <?php include('signup.php');?>
        <script src="scripts/errors.js"></script>
        <script src="scripts/popup.js"></script>
        <script src="scripts/img_slider.js"></script>
    </body>
</html>