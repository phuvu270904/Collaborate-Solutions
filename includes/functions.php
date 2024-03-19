<?php 
require __DIR__ . '../../config/config.php';
session_start();
$WEB_URL = "http://localhost/cw_forum";

function isLoggedIn() {
  return(isset($_SESSION['login']));
}

function isAdmin() {
  return isset($_SESSION['login']) && $_SESSION['login']['role'] == 'admin';
}

//Register
function register() {
  global $conn;

  $username_register = $_POST["username_register"];
  $email_register = $_POST["email_register"];
  $password_register = $_POST["password_register"];
  $confirmpassword_register = $_POST["confirmpassword_register"];
  $role = "user";
  $avatar = "avatar_default.jpg";

  if (strlen($password_register) < 6) {
    echo "<script>alert('Password should be at least 6 characters long');</script>";
    return;
  }

  // Hash the password
  $hashed_password = password_hash($password_register, PASSWORD_DEFAULT);

  try {
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username OR email = :email");
    $stmt->bindParam(':username', $username_register);
    $stmt->bindParam(':email', $email_register);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
      echo "<script>alert('Username or Email has already taken');</script>";
    } else {
      if ($password_register == $confirmpassword_register) {
        $stmt = $conn->prepare("INSERT INTO users (username, email, password, created_at, role, avatar) VALUES (:username, :email, :password, NOW(), :role, :avatar)");
        $stmt->bindParam(':username', $username_register);
        $stmt->bindParam(':email', $email_register);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':avatar', $avatar);
        $stmt->execute();

        echo "<script>alert('Registration Successful');</script>";
      } else {
        echo "<script>alert('Username or Password does not match');</script>";
      }
    }
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
}

//Login
function login() {
  global $conn;

  $usernameemail_login = $_POST["usernameemail_login"];
  $password_login = $_POST["password_login"];

  try {
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username OR email = :email");
    $stmt->bindParam(':username', $usernameemail_login);
    $stmt->bindParam(':email', $usernameemail_login);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
      if (password_verify($password_login, $row['password'])) {
        session_start();
        $_SESSION["login"] = $row;
        $_SESSION["id"] = $row["id"];
        header("Location: ../index.php");
        exit();
      } else {
        echo "<script>alert('Username or Password does not match');</script>";
      }
    } else {
      echo "<script>alert('User Not Registered');</script>";
    }
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
}


//Logout
function logout() {
  $_SESSION = [];
  session_unset();
  session_destroy();
  unset($_SESSION['login']);
  header("Location: ../auth/login_register.php");
}

function getAllUsers() {
  global $conn;

  try {
    $stmt = $conn->prepare("SELECT * FROM users");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
}

function getUserInfo($user_id) {
  global $conn;
  try {
    $stmt = $conn->prepare("SELECT * FROM users WHERE user_id = :user_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);

  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
}