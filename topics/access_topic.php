<?php
require __DIR__ . "../../includes/functions.php";
require __DIR__ . "../../messages/messages.php";
require __DIR__ . "../topics.php";

if (!isLoggedIn()) {
  header("Location: ../auth/login_register.php");
}


if (isset($_POST["submit_message"])) {
  sendMessage();
}

$topic_id = $_GET['topic_id'];
$topic_info = getSingleTopic($topic_id);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/access_topic.css">
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
      <a href="profile_user.php?user_id=<?php echo $_SESSION["login"]["user_id"] ?>">
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

  <div class="home">
    <div class="container">
      <div class="home-weapper">

        <!-- home center start here -->

        <div class="home-center">
          <div class="home-center-wrapper">
            <div class="stories">
              <h3 class="mini-headign">
                <?php echo $topic_info['topic_name'] ?>
              </h3>
            </div>


            <div class="createPost">

              <h3 class="mini-headign">Create Post</h3>
              <div class="post-text">
                <img src="<?php echo $_SESSION['login']['avatar'] ?>" alt="user">
                <input type="text-area"
                  placeholder="What's on your mind, <?php echo $_SESSION['login']['username'] ?>?">
                <button>Post</button>
              </div>

              <div class="post-icon">
                <a href="#" style="background: #ffebed;">
                  <i style="background: #ff4154;" class="fa fa-picture-o"></i>
                  Gallery
                </a>
              </div>

            </div>

            <div class="fb-post1-header">
              <ul>
                <li class="active">popular</li>
                <li>recent</li>
                <li>most view</li>
              </ul>
            </div>

            <div class="fb-post1">
              <div class="fb-post1-container">
                <div class="fb-p1-main">
                  <div class="post-title">
                    <img src="images/user2.jpg" alt="user picture">
                    <ul>
                      <li>
                        <h3>Arham Kabir <span> . 2 hours ago</span></h3>
                      </li>
                      <li><span>02 march at 12:55 PM</span></li>
                    </ul>
                    <p>Hello Everyone Thanks for Watching Please SUBSCRIBE My Channel - Like Comments and Share
                      <a
                        href="https://www.youtube.com/channel/UCHhGX-DD7A8jq7J_NPGN6gA">https://www.youtube.com/channel/UCHhGX-DD7A8jq7J_NPGN6gA</a>
                    </p>
                  </div>

                  <div class="post-images">
                    <div class="post-images1">
                      <img src="images/pp.jpg" alt="post images 01">
                      <img src="images/pp2.jpg" alt="post images 02">
                      <img src="images/pp3.jpg" alt="post images 03">
                    </div>
                    <div class="post-images2">
                      <img src="images/pp4.jpg" alt="post images 04">
                    </div>
                  </div>

                  <div class="like-comment">
                    <ul>
                      <li>
                        <img src="images/love.png" alt="love">
                        <img src="images/like.png" alt="like">
                        <span>22k like</span>
                      </li>
                      <li><i class="fa-regular fa-comment-dots"></i> <span>555 comments</span></li>
                      <li><i class="fa-solid fa-share-from-square"></i> <span>254 share</span></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>

            <div class="fb-post1">
              <div class="fb-post1-container">
                <div class="fb-p1-main">
                  <div class="post-title">
                    <img src="images/user2.jpg" alt="user picture">
                    <ul>
                      <li>
                        <h3>Arham Kabir <span> . 2 hours ago</span></h3>
                      </li>
                      <li><span>02 march at 12:55 PM</span></li>
                    </ul>
                    <p>Hello Everyone Thanks for Watching Please SUBSCRIBE My Channel - Like Comments and Share
                      <a
                        href="https://www.youtube.com/channel/UCHhGX-DD7A8jq7J_NPGN6gA">https://www.youtube.com/channel/UCHhGX-DD7A8jq7J_NPGN6gA</a>
                    </p>
                  </div>

                  <div class="post-images">
                    <div class="post-images1">
                      <img src="images/pp.jpg" alt="post images 01">
                      <img src="images/pp2.jpg" alt="post images 02">
                      <img src="images/pp3.jpg" alt="post images 03">
                    </div>
                    <div class="post-images2">
                      <img src="images/pp4.jpg" alt="post images 04">
                    </div>
                  </div>

                  <div class="like-comment">
                    <ul>
                      <li>
                        <img src="images/love.png" alt="love">
                        <img src="images/like.png" alt="like">
                        <span>22k like</span>
                      </li>
                      <li><i class="fa-regular fa-comment-dots"></i> <span>555 comments</span></li>
                      <li><i class="fa-solid fa-share-from-square"></i> <span>254 share</span></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
            

          </div> <!-- home center wrapper end -->
        </div> <!-- home center end -->
      </div>
    </div>
  </div>


  <script src="../js/profile.js"></script>
</body>

</html>