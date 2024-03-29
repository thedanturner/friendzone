<?php
  require_once "../functions.php";

  db_connect();

  // Check if the username already exists
  $checkSql = "SELECT COUNT(*) FROM users WHERE username = ?";
  $checkStatement = $conn->prepare($checkSql);
  $checkStatement->bind_param('s', $_POST['username']);
  $checkStatement->execute();
  $checkStatement->bind_result($count);
  $checkStatement->fetch();
  $checkStatement->close();

  if ($count > 0) {
    redirect_to("../index.php?username_error=true");
    exit; // Exit if username exists
  }

  // Insert the new user
  $insertSql = "INSERT INTO users (name, username, password) VALUES (?, ?, ?)";
  $insertStatement = $conn->prepare($insertSql);
  $insertStatement->bind_param('sss', $_POST['name'], $_POST['username'], password_hash($_POST['password'], PASSWORD_DEFAULT));

  if ($insertStatement->execute()) {
    redirect_to("../index.php?registered=true");
  } else {
    echo "Error: " . $conn->error;
  }

  $insertStatement->close();
  $conn->close();
?>
