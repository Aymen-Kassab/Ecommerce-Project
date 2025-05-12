<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>admin page</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        <link rel="stylesheet" href="css_admin/styles.css">
    </head>
<body>
<video autoplay muted loop id="bg-video">
    <source src="video_admin/background_video2.mp4" type="video/mp4">
  </video>
    <section id="header">
     <a href="home_admin.php"><img id="logo" src="image_admin/Title.png" height="50"></a>
        <a id="logoutbtn" href="adminlogin.php" >Log out</a>
        
       <div id="mobile"> <i id="bar" class="fas fa-outdent"> </i></div>
       
    </section>
    <section id="header2">
       <ul id="navbar">
        <a href="#" id="closebar"><i class="fa fa-times" aria-hidden="true"></i></a>
        <li><a href="home_admin.php">Dashboard</a></li>
        <li><a href="products.php">Products</a></li>
        <li><a href="users.php">Users</a></li>
        <li><a href="orders_admin.php">Orders</a></li>
        <li><a id="resp_logoutbtn" href="adminlogin.php" >Log out</a></li>
       </ul>
       
    </section>