<?php
require __DIR__ . "../../includes/functions.php";
require __DIR__ . "../../topics/topics.php";
require __DIR__ . "../../messages/messages.php";

if (!isLoggedIn()) {
  header("Location: ../auth/login_register.php");
}



if (isset ($_POST["submit_message"])) {
  sendMessage();
}

$user_id = $_GET['user_id'];
$user_info = getUserInfo($user_id);

$topics = getTopics();
$countTopics = countTopics($user_id);

if ($countTopics === false) {
  $count_topics = 0;
} else {
  $count_topics = $countTopics["COUNT(topic_id)"];
}

$countMessages = countMessages($user_id);

if ($countMessages === false) {
  $count_messages = 0;
} else {
  $count_messages = $countMessages["COUNT(message_id)"];
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
  <title>Collaborate Solutions | Profile</title>
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
      <a href="profile_user.php?user_id=<?php echo $_SESSION["login"]["user_id"]?>">
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

  <div class="wrapper">
    <div class="left">
        <img src="<?php echo $user_info["avatar"]?>" 
        alt="user" width="100">
        <h4><?php echo $user_info["username"]?></h4>
        <p>(<?php echo $user_info["role"] ?>)</p>
        <a href="./edit_user.php?user_id=<?php echo $_SESSION["login"]["user_id"] ?>">
          <button class="edit-btn">Edit Profile</button>
        </a>
    </div>
    <div class="right">
      <div class="info">
          <h3>Information</h3>
          <div class="info_data">
              <div class="data">
                  <h4>Email</h4>
                  <p><?php echo $user_info["email"] ?></p>
              </div>
              <div class="data">
                <h4>Phone</h4>
                <p><?php echo $user_info["phone"] == null ? "No phone number" : $user_info["phone"] ?></p>
            </div>
          </div>
      </div>
      
      <div class="projects">
        <h3>Activities</h3>
        <div class="projects_data">
          <div class="data">
              <h4>Posts</h4>
              <p><?php echo $count_topics ?></p>
          </div>
            <div class="data">
              <h4>Feedback for Forum</h4>
              <p><?php echo $count_messages?></p>
            </div>
        </div>
      </div>
      
    </div>
  </div>


  <script src="../js/profile.js"></script>
</body>

</html>