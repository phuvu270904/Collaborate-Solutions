<?php
require __DIR__ . "../includes/functions.php";

require __DIR__ . "../topics/topics.php";

require __DIR__ . "../messages/messages.php";


if (!isLoggedIn()) {
  header("Location: ./auth/login_register.php");
}

if (isset($_POST["submit_topic"])) {
  createTopic();
}

if (isset($_POST["submit_message"])) {
  sendMessage();
}

$topics = getTopics();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./css/index.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Fira+Sans:wght@400&display=swap" rel="stylesheet">
  <link rel="shortcut icon" href="./images/favicon_white.png" type="image/x-icon">
  <title>Collaborate Solutions | Dashboard</title>
</head>

<body>
  <nav class="main-menu">
    <ul>
      <a href="index.php">
        <img width="60%" src="./images/favicon_white.png" alt="logo">
      </a>
      <a href="index.php">
        <li class="menu-item">
          <i class="fa fa-home"></i>Home
        </li>
      </a>
      <a href="./profile/profile_user.php?user_id=<?php echo $_SESSION["login"]["user_id"]?>">
        <li class="menu-item">
          <i class="fa fa-user-circle-o"></i>Profile
        </li>
      </a>
      <?php if (isAdmin()): ?>
        <a href="./admin/admin.php">
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
      <a href="./auth/logout.php">
        <li class="menu-item">
          <i class="fa fa-sign-out"></i>Logout
        </li>
      </a>
    </ul>
  </nav>
  <div class="list">

    <div class="introduction">
      <div class="welcome">
        <h1>Welcome to Collaborate Solutions Forum, <i>
            <?php echo $_SESSION['login']['username'] ?>!
          </i></h1>
        <h3>Where questions find answers and conversations spark curiosity. Join us as we explore diverse topics and
          engage in insightful discussions together.</h3>
        <div class="welcome-contact">
          <a href="#news">
            <button class="welcome-btn">See recent news <i class="fa fa-long-arrow-down" aria-hidden="true"></i></button>
          </a>
          <button class="welcome-btn" id="open-popup-message">Message us for questions</button>
          <div class="popup" id="popup-message">
            <div class="overlay"></div>
            <form class="popup-content" action="index.php" method="post" autocomplete="off">
              <h2>Message us</h2>
              <div class="input-create-topic">
                <input class="edit-input" type="text" name="title_message" id="title_message" required placeholder="Title*">
                <input class="edit-input" type="text" name="content_message" id="content_message" required placeholder="Content*">
              </div>
              <div class="controls">
                <button class="close-btn">Close</button>
                <button type="submit" name="submit_message" class="submit-btn">Submit</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <section id="news">
      <div class="header-topics">
        <h3><i>Our Topics</i></h3>
      </div>
      <?php if (isAdmin()): ?>
        <div style="display: flex; justify-content: center;">
          <button class="welcome-btn" id="open-popup">Create New Topic</button>
          <div class="popup" id="popup">
            <div class="overlay"></div>
            <form class="popup-content" action="index.php" method="post" autocomplete="off" enctype="multipart/form-data">
              <h2>Create a new topic</h2>
              <div class="input-create-topic">
                <input class="edit-input" type="text" name="title_topic" id="title_topic" required placeholder="Title*">
                <input class="edit-input" type="text" name="note_topic" id="note_topic" placeholder="Note (not required)">
                <label for="thumbnail_topic" style="margin: 10px;">Thumbnail for topic*:</label>
                <input style="margin-left: 10px" type="file" name="thumbnail_topic" id="thumbnail_topic" required>
              </div>
              <div class="controls">
                <button class="close-btn">Close</button>
                <button type="submit" name="submit_topic" class="submit-btn">Submit</button>
              </div>
            </form>
          </div>
        </div>
      <?php endif; ?>
      <div class="card-container">
        <?php foreach ($topics as $topic): ?>
          <div class="card">
            <img src="<?php echo $topic["topic_thumbnail"]?>"
              alt="<?php echo $topic["topic_thumbnail"] ?>">
            <div class="card-content">
              <h3><i>
                  <?php echo $topic["topic_name"] ?>
                </i></h3>
              <p>
                <?php echo $topic["topic_content"] ?>
              </p>
              <a href="./topics/access_topic.php?topic_id=<?php echo $topic['topic_id']?>" class="btn">Ask questions</a>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

    </section>
  </div>

  <script src="./js/index.js"></script>
</body>

</html>