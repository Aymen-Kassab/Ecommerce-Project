<?php
include("db_connect.php");
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
  <div class="container2">
    <h1>Sign up</h1>
    <form method="post" action="<?php $_SERVER["PHP_SELF"]?>">
  <label for="Fname">First Name:</label><br>
  <input type="text" id="Fname" name="Fname" required><br><br>
  <label for="Lname">Last Name:</label><br>
  <input type="text" id="Lname" name="Lname" required><br><br>
  <label for="email">Email:</label><br>
  <input type="email" id="email" name="email" required><br><br>
  <label for="password">Password:</label><br>
  <input type="password" id="password" name="password" required><br><br>
  <label for="Cpassword">Confirm your password:</label><br>
  <input type="password" id="Cpassword" name="Cpassword" required><br><br><br>
  <input type="submit" class="signup" name="signup" value="sign up">
    </form>
  </div>

  <?php
   if ($_SERVER["REQUEST_METHOD"] == "POST"){
   
     $Fname = filter_input(INPUT_POST,"Fname",FILTER_SANITIZE_SPECIAL_CHARS);
     $Lname = filter_input(INPUT_POST,"Lname",FILTER_SANITIZE_SPECIAL_CHARS);
     $email = filter_input(INPUT_POST,"email",FILTER_VALIDATE_EMAIL);
     $password = filter_input(INPUT_POST,"password",FILTER_SANITIZE_SPECIAL_CHARS);
     $Cpassword = filter_input(INPUT_POST,"Cpassword",FILTER_SANITIZE_SPECIAL_CHARS);

if ($password == $Cpassword){
     $hash = password_hash($password, PASSWORD_DEFAULT);

  $collect_data = "INSERT INTO admins(email, F_name, L_name, password)
                    VALUES('$email', '$Fname', '$Lname', '$hash')";
   
   try{ mysqli_query($link, $collect_data);
    header("location: adminlogin.php");}

   catch(mysqli_sql_exception){
    echo "<script>window.alert('this email has been already used')</script>";
   }
    }
    else{ echo "<script>window.alert('Confirmed password incorrect')</script>";}
  }
?>
    </body>
</html>