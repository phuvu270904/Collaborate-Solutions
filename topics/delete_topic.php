<?php
require __DIR__ . "../../config/config.php";

$topic_id = $_GET['topic_id'];

$stmt = $conn->prepare("DELETE FROM topics WHERE topic_id = :topic_id");
$stmt->bindParam(':topic_id', $topic_id);
$stmt->execute();
header("Location: ../admin/admin.php");
