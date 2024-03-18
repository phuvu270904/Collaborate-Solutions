<?php
require __DIR__ . "../../includes/functions.php";
require __DIR__ . "../../messages/messages.php";

if (!isLoggedIn()) {
  header("Location: ../auth/login_register.php");
}


if (isset ($_POST["submit_message"])) {
  sendMessage();
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/profile_user.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Fira+Sans:wght@400&display=swap" rel="stylesheet">
  <link rel="shortcut icon" href="../images/favicon_white.png" type="image/x-icon">
  <title>Collaborate Solutions | Admin Space</title>
</head>

<body>
  <nav class="main-menu">
    <ul>
      <a href="../index.php">
        <img width="60%" src="../images/favicon_white.png" alt="logo">
      </a>
      <a href="../index.php">
        <li class="menu-item">
          <i class="fa fa-home"></i>Home
        </li>
      </a>
      <a href="#">
        <li class="menu-item">
          <i class="fa fa-user-circle-o"></i>Profile
        </li>
      </a>
      <?php if (isAdmin()): ?>
        <a href="../admin/admin.php">
          <li class="menu-item">
            <i class="fa fa-shield fa-lg"></i>Admin Space
          </li>
        </a>
      <?php endif; ?>
    </ul>
    <ul class="logout">
      <a id="open-popup-message-sidebar">
        <li class="menu-item">
          <i class="fa fa-question-circle-o"></i>Help
        </li>
      </a>
      <a href="../auth/logout.php">
        <li class="menu-item">
          <i class="fa fa-sign-out"></i>Logout
        </li>
      </a>
    </ul>
  </nav>

  <div class="popup" id="popup-message">
    <div class="overlay"></div>
    <form class="popup-content" action="admin.php" method="post" autocomplete="off">
      <h2>Message us</h2>
      <div class="input-create-topic">
        <input class="edit-input" type="text" name="title_message" id="title_message" required placeholder="Title*">
        <input class="edit-input" type="text" name="content_message" id="content_message" required
          placeholder="Content*">
      </div>
      <div class="controls">
        <button class="close-btn">Close</button>
        <button type="submit" name="submit_message" class="submit-btn">Submit</button>
      </div>
    </form>
  </div>


  <script src="../js/profile.js"></script>
</body>

</html>