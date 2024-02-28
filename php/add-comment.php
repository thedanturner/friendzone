<?php
    require_once "../functions.php";

    db_connect();

    // Get the post ID, comment, and user ID from the request
    $postId = $_POST['post_id'];
    $comment = $_POST['comment'];
    $userId = $_SESSION['user_id']; // Assuming you have the user ID stored in the session

    // Prepare the SQL statement
    $sql = "INSERT INTO comments (post_id, comment, user_id) VALUES (?, ?, ?)";
    $statement = $conn->prepare($sql);
    $statement->bind_param('isi', $postId, $comment, $userId);

    // Execute the statement
    if ($statement->execute()) {
        redirect_to("../home.php");
    } else {
        echo "Error: " . $conn->error;
    }

    // Close the database connection
?>
