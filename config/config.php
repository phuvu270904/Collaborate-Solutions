<?php
try {
  $conn = new PDO("mysql:host=localhost;dbname=cw_forum_database", "root", "");
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  if ($conn == false) {
    echo "error!";
  }

} catch (PDOException $Exception) {
  echo $Exception->getMessage();
}