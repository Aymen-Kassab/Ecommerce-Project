<?php
include("db_connect.php")
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css_admin/styles2.css">
    <title>login</title>
</head>
<body>
  <video autoplay muted loop id="bg-video">
    <source src="background_video2.mp4" type="video/mp4">
  </video>
<div class="container1">
    <h1>Login</h1>
    <form method="post" action="<?php $_SERVER["PHP_SELF"]?>">
  <label for="email">Email:</label><br>
  <input type="email" id="email" name="email" required><br><br>
  <label for="password">Password:</label><br>
  <input type="password" id="password" name="password" required><br>
  <a href="adminsignup.php" class="askforsignup">signup?</a><br><br>
   <input type="submit" class="login" name="login" value="login">

</form>
</div>

<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){

      $email = $_POST["email"];
      $password = $_POST["password"];
      
    
        $check = "SELECT * FROM `admins` WHERE email = '$email'";
         
      try{ 
     $info =  mysqli_query($link, $check);
     
     if(mysqli_num_rows($info)>0){ 
        $user_info = mysqli_fetch_assoc($info);

        if(password_verify($password, $user_info["password"] )){
            
                session_start();
                $_SESSION["username"] = $user_info["Fname"];
                
                header("location: home_admin.php");}
                     
           else{ echo "<script>window.alert('wrong password')</script>"; } }
              
     else{
           echo "<script>window.alert('email not found')</script>";
    } 
 }
 
 catch(mysqli_sql_exception){
    echo "";
                        }
    } 
            
            

             
            
      
    


?>

</body>
</html>