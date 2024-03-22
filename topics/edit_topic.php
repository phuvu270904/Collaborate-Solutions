<?php
require __DIR__ . "../../config/config.php";

function thumbnailTopic($file)
{

  $uploadToDirectory = "../images/topics/"; 
  $uploadFile = $uploadToDirectory . basename($file['name']);

  $check = getimagesize($file['tmp_name']);
  if ($check === false) {
    return null;
  }

  if ($file['size'] > 5000000) {
    echo "<script>alert('File is too large. Maximum is 5mb!');</script>";
    return null;
  }

  if (move_uploaded_file($file['tmp_name'], $uploadFile)) {
    return './images/topics/' . basename($file['name']);
  } else {
    echo "<script>alert('Failed to upload!');</script>";
    return null;
  }
}


$topic_id = $_GET['topic_id'];
$topic_name = $_POST['topic_name'];
$topic_content = $_POST['topic_content'];
if ($_FILES['topic_thumbnail']['size'] > 0) {
  $topic_thumbnail = thumbnailTopic($_FILES['topic_thumbnail']);
} else {
  $stmt = $conn->prepare('SELECT topic_thumbnail FROM topics WHERE topic_id = :topic_id');
  $stmt->bindParam(':topic_id', $topic_id);
  $stmt->execute();
  $old_thumbnail = $stmt->fetchColumn();
  $topic_thumbnail = $old_thumbnail;
}

$stmt = $conn->prepare('UPDATE topics 
                        SET topic_name = :topic_name, topic_content = :topic_content, topic_thumbnail = :topic_thumbnail
                        WHERE topic_id = :topic_id');
$stmt->bindParam(':topic_name', $topic_name);
$stmt->bindParam(':topic_content', $topic_content);
$stmt->bindParam(':topic_thumbnail', $topic_thumbnail, PDO::PARAM_STR);
$stmt->bindParam(':topic_id', $topic_id);
$stmt->execute();
header("Location: ../admin/admin.php");

exit();

