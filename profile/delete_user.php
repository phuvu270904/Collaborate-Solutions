<?php
require __DIR__ . "../../config/config.php";

$user_id = $_GET['user_id'];

$stmt = $conn->prepare("DELETE FROM users WHERE user_id = :user_id");
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
header("Location: ../admin/admin.php");
