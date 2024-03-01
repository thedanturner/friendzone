<?php
  require_once "../functions.php";

  db_connect();

  $sql = "UPDATE users SET status = ?, location = ?, mobile = ?, email = ? WHERE id = ?";
  $statement = $conn->prepare($sql);
  $statement->bind_param('ssssi', $_POST['status'], $_POST['location'], $_POST['mobile'], $_POST['email'], $_SESSION['user_id']);

  if ($statement->execute()) {
    redirect_to("../profile.php?username={$_SESSION['user_username']}");
  } else {
    echo "Error: " . $conn->error;
  }
