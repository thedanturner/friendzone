<?php
require_once "../functions.php";

check_auth();
db_connect();

// Check if the 'id' parameter is set and is a valid integer
if(isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM posts WHERE id = ?";
    $statement = $conn->prepare($sql);
    $statement->bind_param('i', $id);

    if ($statement->execute()) {
        redirect_to("../profile.php?username={$_SESSION['user_username']}");
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "Invalid or missing post ID.";
}
?>
