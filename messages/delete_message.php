<?php
require __DIR__ . "../../config/config.php";

$message_id = $_GET['message_id'];

$stmt = $conn->prepare("DELETE FROM messages WHERE message_id = :message_id");
$stmt->bindParam(':message_id', $message_id);
$stmt->execute();
header("Location: ../admin/admin.php");
