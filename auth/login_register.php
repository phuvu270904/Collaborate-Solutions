<?php
require __DIR__ . '../../includes/functions.php';

// Register
if (isset($_POST["submit_register"])) {
  register();
}

// Login
if (isset($_POST["submit_login"])) {
  login();
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/login_register.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <link rel="shortcut icon" href="../images/favicon_white.png" type="image/x-icon">
  <title>Collaborate Solutions | Login</title>
</head>

<body>
  <div class="container" id="container">
    <div class="form-container sign-up">
      <form action="login_register.php" method="post" autocomplete="off">
        <h1>Create Account</h1>
        <input type="text" name="username_register" id="username_resgister" required placeholder="Username">
        <input type="email" name="email_register" id="email_resgister" required placeholder="Email">
        <input type="password" name="password_register" id="password_resgister" required placeholder="Password">
        <input type="password" name="confirmpassword_register" id="confirmpassword_resgister" required placeholder="Confirm password">
        <button type="submit" name="submit_register">Sign Up</button>
      </form>
    </div>
    <div class="form-container sign-in">
      <form action="login_register.php" method="post" autocomplete="off">
        <img width="100%" src="../images/logo.png" alt="logo" style="margin-bottom: 20px;">
        <h1>Sign In</h1>
        <input type="text" name="usernameemail_login" id="usernameemail_login" required placeholder="Username or Email">
        <input type="password" name="password_login" id="password_login" required placeholder="Password">
        <button type="submit" name="submit_login">Sign In</button>
      </form>
    </div>
    <div class="toggle-container">
      <div class="toggle">
        <div class="toggle-panel toggle-left">
          <h1>Sign Up!</h1>
          <p>Enter your personal details to use all of site features</p>
          <button class="hidden" id="login">Sign In</button>
        </div>
        <div class="toggle-panel toggle-right">
          <h1>Don't have an account yet?</h1>
          <p>Register with your personal details to use all of site features</p>
          <button class="hidden" id="register">Sign Up</button>
        </div>
      </div>
    </div>
  </div>
  <script src="../js/login_register.js"></script>
</body>

</html>