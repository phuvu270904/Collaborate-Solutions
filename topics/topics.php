<?php
require __DIR__ . "../../config/config.php";

function thumbnailTopic($file) {

  $uploadToDirectory = "./images/topics/"; // Directory where uploaded files will be stored
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
}

function createTopic() {
  global $conn;

  $title_topic = $_POST["title_topic"];
  $note_topic = $_POST["note_topic"];
  $thumbnail_topic = thumbnailTopic($_FILES["thumbnail_topic"]);

  try {
    $stmt = $conn->prepare("SELECT * FROM topics WHERE topic_name = :topic_title");
    $stmt->bindParam(':topic_title', $title_topic);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
      echo "<script>alert('Topic title has already taken');</script>";
    } else {
        $stmt = $conn->prepare("INSERT INTO topics (topic_name, topic_content, topic_creator, topic_creator_id, topic_thumbnail, created_at) VALUES (:topic_name, :topic_content, :topic_creator, :topic_creator_id, :topic_thumbnail, NOW())");
        $stmt->bindParam(':topic_name', $title_topic);
        $stmt->bindParam(':topic_content', $note_topic);
        $stmt->bindParam(':topic_creator', $_SESSION["login"]["username"]);
        $stmt->bindParam(':topic_creator_id', $_SESSION["login"]["user_id"]);
        $stmt->bindParam(':topic_thumbnail', $thumbnail_topic, PDO::PARAM_STR);
        $stmt->execute();

        echo "<script>alert('Add new topic Successully');</script>";
    }
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
}

function getTopics() {
  global $conn;

  try {
    $stmt = $conn->prepare("SELECT * FROM topics");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
}

function countTopics($topic_creator_id) {
  global $conn;

  try {
    $stmt = $conn->prepare("SELECT COUNT(topic_id) FROM topics GROUP BY topic_creator_id HAVING topic_creator_id = :topic_creator_id");
    $stmt->bindParam(':topic_creator_id', $topic_creator_id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);

  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
}

function getSingleTopic($topic_id) {
  global $conn;

  try {
    $stmt = $conn->prepare("SELECT * FROM topics WHERE topic_id = :topic_id");
    $stmt->bindParam(':topic_id', $topic_id);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);

  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
}
