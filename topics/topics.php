<?php
require __DIR__ . "../../config/config.php";

function createTopic() {
  global $conn;

  $title_topic = $_POST["title_topic"];
  $note_topic = $_POST["note_topic"];
  $thumbnail_topic = $_POST["thumbnail_topic"];

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
        $stmt->bindParam(':topic_thumbnail', $thumbnail_topic);
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
