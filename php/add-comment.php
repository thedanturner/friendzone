<?php
  require_once "../functions.php";

  db_connect();

// Get the post ID and comment from the request
$postId = $_POST['post_id'];
$comment = $_POST['comment'];

// Prepare the SQL statement
$sql = "INSERT INTO comments (post_id, comment) VALUES (?, ?)";
$statement = $conn->prepare($sql);
$statement->bind_param('is', $postId, $comment);

// // Bind the parameters
// $statement->bindParam(1, $postId);
// $statement->bindParam(2, $comment);

// Execute the statement
  if ($statement->execute()) {
    redirect_to("../home.php");
  } else {
    echo "Error: " . $conn->error;
  }

// Close the database connection

?>
