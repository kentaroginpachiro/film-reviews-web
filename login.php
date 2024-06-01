<?php
include 'components/connect.php';

if(isset($_POST['submit'])){
   $email = $_POST['email'];
   $email = filter_var($email);
   $pass = $_POST['pass'];
   $pass = filter_var($pass);

   $verify_email = $conn->prepare("SELECT * FROM `users` WHERE email = ? LIMIT 1");
   $verify_email->execute([$email]);
   
   if($verify_email->rowCount() > 0){
      $fetch = $verify_email->fetch(PDO::FETCH_ASSOC);
      $verfiy_pass = password_verify($pass, $fetch['password']);
      if($verfiy_pass == 1){
         setcookie('user_id', $fetch['id'], time() + 60*60*24*30, '/');
         header('location:all_posts.php');
      }else{
         $warning_msg[] = 'Incorrect password!';
      }
   }else{
      $warning_msg[] = 'Incorrect email!';
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login</title>
   <!-- Custom CSS file link -->
   <link rel="stylesheet" href="css/style.css">
</head>
<body>
   
<!-- Header section -->
<?php include 'components/header.php'; ?>

<!-- Login section -->
<section class="account-form">
   <form action="" method="post" enctype="multipart/form-data">
      <h3>Welcome back!</h3>
      <p class="placeholder">Your email <span>*</span></p>
      <input type="email" name="email" required maxlength="50" placeholder="Enter your email" class="box">
      <p class="placeholder">Your password <span>*</span></p>
      <input type="password" name="pass" required maxlength="50" placeholder="Enter your password" class="box">
      <p class="link">Don't have an account? <a href="register.php">Register now</a></p>
      <input type="submit" value="Login now" name="submit" class="btn">
      <p class="link">Admin? <a href="admin_login.php">Click here</a> to login as admin.</p>
   </form>
</section>

<!-- SweetAlert CDN link -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<!-- Custom JavaScript file link -->
<script src="js/script.js"></script>

<?php include 'components/alers.php'; ?>

</body>
</html>
