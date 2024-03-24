<?php
require __DIR__ . "../../config/config.php";

function sendMessage()
{
  global $conn;

  $title_message = $_POST["title_message"];
  $content_message = $_POST["content_message"];

  try {
    $stmt = $conn->prepare("INSERT INTO messages (message_title, message_content, message_creator, message_creator_id, created_at) VALUES (:message_title, :message_content, :message_creator, :message_creator_id, NOW())");
    $stmt->bindParam(':message_title', $title_message);
    $stmt->bindParam(':message_content', $content_message);
    $stmt->bindParam(':message_creator', $_SESSION["login"]["username"]);
    $stmt->bindParam(':message_creator_id', $_SESSION["login"]["user_id"]);
    $stmt->execute();

    echo "<script>alert('Send message successully');</script>";
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
}

function renderMessages()
{
  global $conn;

  try {
    $stmt = $conn->prepare("SELECT * FROM messages");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
}

function countMessages() {
  global $conn;

  try {
    $stmt = $conn->prepare("SELECT COUNT(*) FROM messages");
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);

  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
}
