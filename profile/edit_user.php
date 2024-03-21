<?php
require __DIR__ . "../../includes/functions.php";
require __DIR__ . "../../messages/messages.php";

if (!isLoggedIn()) {
  header("Location: ../auth/login_register.php");
}


if (isset ($_POST["submit_message"])) {
  sendMessage();
}

$user_id = $_GET['user_id'];
$user_info = getUserInfo($user_id);

if (!($_SESSION['login']['user_id'] == $user_id) && !isAdmin()) {
  echo "<script>alert('You can not access this page!');</script>";
  header("Location: ../index.php");
}

function updateAvatar($file)
{
  global $user_info;

  if (isset ($file) && $file['error'] === UPLOAD_ERR_OK) {
    $uploadToDirectory = "../images/avatars/"; // Directory where uploaded files will be stored
    $uploadFile = $uploadToDirectory . basename($file['name']); // Full path to the uploaded file

    $check = getimagesize($file['tmp_name']);
    if ($check === false) {
      return null;
    }

    if ($file['size'] > 5000000) {
      echo "<script>alert('File is too large. Maximum is 5mb!');</script>";
      return null;
    }

    // Move the uploaded file to the target directory
    if (move_uploaded_file($file['tmp_name'], $uploadFile)) {
      return $uploadFile;
    } else {
      echo "<script>alert('Failed to upload!');</script>";
      return null;
    }
  } else {
    return $user_info['avatar'];
  }
}

if (isset ($_POST['update_profile'])) {
  $username = $_POST['username'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $avatar = updateAvatar($_FILES['avatar']);
  if (isset($_POST['role'])){
    $role = $_POST['role'];
  } else {
    $role = 'user';
  }

  $stmt = $conn->prepare('UPDATE users 
                        SET username = :username, email = :email, phone = :phone, avatar = :avatar, role = :role
                        WHERE user_id = :user_id');
  $stmt->bindParam(':username', $username);
  $stmt->bindParam(':email', $email);
  $stmt->bindParam(':phone', $phone);
  $stmt->bindParam(':avatar', $avatar, PDO::PARAM_STR);
  $stmt->bindParam(':role', $role);
  $stmt->bindParam(':user_id', $user_id);
  $stmt->execute();

  // Redirect to the profile page
  header('Location: ./profile_user.php?user_id=' . $user_id);
  exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/edit_user.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Fira+Sans:wght@400&display=swap" rel="stylesheet">
  <link rel="shortcut icon" href="../images/favicon_white.png" type="image/x-icon">
  <title>Collaborate Solutions | Edit Profile</title>
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

  <div class="wrapper">
    <div class="left">
      <img src="<?php echo $user_info["avatar"] ?>" alt="user" width="100">
    </div>
    <div class="right">
      <div class="info">
        <h3>Information</h3>
        <form method="post" enctype="multipart/form-data" class="info_data">
          <div class="data">
            <h4>Username</h4>
            <p>
              <input type="text" name="username" value="<?php echo $user_info["username"] ?>">
            </p>
          </div>
          <div class="data">
            <h4>Email</h4>
            <input type="text" name="email" value="<?php echo $user_info["email"] ?>">
          </div>
          <div class="data">
            <h4>Phone Number</h4>
            <p>
              <input type="text" name="phone" value="<?php echo $user_info["phone"] ?>">
            </p>
          </div>
          <div class="data">
            <h4>Update your avatar</h4>
            <p>
              <input type="file" name="avatar">
            </p>
          </div>
          <?php if (isAdmin()): ?>
            <div class="data">
              <h4>Role</h4>
              <p>
                <input type="text" name="role" value="<?php echo $user_info["role"] ?>">
              </p>
            </div>
          <?php endif; ?>
          <button type="submit" name="update_profile" class="edit-btn">Update Profile</button>
        </form>
      </div>
    </div>
  </div>


  <script src="../js/profile.js"></script>
</body>

</html>