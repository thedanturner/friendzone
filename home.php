<?php require_once "functions.php"; ?>
<?php include "header.php"; ?>

<?php
  check_auth();
  db_connect();
?>

<!-- main -->
<main class="container">
  <!-- messages -->
  <?php if(isset($_GET['request_sent'])): ?>
    <div class="alert alert-success">
      <p>Friend request sent!</p>
    </div>
  <?php endif; ?>
  <!-- ./messages -->

  <div class="row">
    <div class="col-md-3">
      <!-- friend requests -->
      <div class="panel panel-default">
        <div class="panel-body">
          <h4>friend requests</h4>
          <?php 
            $sql = "SELECT * FROM friend_requests WHERE friend_id = {$_SESSION['user_id']}";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
              ?><ul><?php
              while($f_request = $result->fetch_assoc()) {
                ?>
                <li>
                  <?php
                    $u_sql = "SELECT * FROM users WHERE id = {$f_request['user_id']} LIMIT 1";
                    $u_result = $conn->query($u_sql);
                    $fr_user = $u_result->fetch_assoc();
                  ?>
                  <a href="profile.php?username=<?php echo $fr_user['username']; ?>"><?php echo $fr_user['name']; ?></a> 
                  <a class="text-success" href="php/accept-request.php?uid=<?php echo $fr_user['id']; ?>">[accept]</a> 
                  <a class="text-danger" href="php/remove-request.php?uid=<?php echo $fr_user['id']; ?>">[decline]</a>
                </li>
                <?php
              } ?></ul><?php
            } else {
              ?>
                <p class="text-center">No friend requests!</p>
              <?php
            }
          ?>
        </div>
      </div>
      <!-- ./friend requests -->
    </div>
    <div class="col-md-6">
      <!-- post form -->
      <form method="post" action="php/create-post.php">
        <div class="input-group">
          <input class="form-control" type="text" name="content" placeholder="Make a post..." required>
          <span class="input-group-btn">
            <button class="btn btn-success" type="submit" name="post">Post</button>
          </span>
        </div>
      </form><hr>
      <!-- ./post form -->

      <!-- feed -->
      <div>
        <!-- post -->
        <?php 
          $sql = "SELECT * FROM posts ORDER BY created_at DESC";
          $result = $conn->query($sql);

          if ($result->num_rows > 0) {
            while($post = $result->fetch_assoc()) {
              ?>
                <div class="panel panel-default">
                  <div class="panel-body">
                    <p><?php echo $post['content']; ?></p>
                  </div>
                  <div class="panel-footer">
                    <?php
                      $sql = "SELECT name FROM users WHERE id = ? LIMIT 1";
                      $statement = $conn->prepare($sql);
                      $statement->bind_param('i', $post['user_id']);
                      $statement->execute();
                      $statement->store_result();
                      $statement->bind_result($post_author);
                      $statement->fetch();
                    ?>

                    <span>posted <?php echo $post['created_at']; ?> by <b><?php echo $post_author; ?> </b></a></span>
                  </div>
                  <div class="panel-footer">
                    <!-- comment form -->
                    <form method="post" action="php/add-comment.php">
                      <div class="input-group">
                        <input class="form-control" type="text" name="comment" placeholder="Add a comment..." required>
                        <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
                        <span class="input-group-btn">
                          <button class="btn btn-primary" type="submit" name="add_comment">Comment</button>
                        </span>
                      </div>
                    </form><br/>
                    <!-- ./comment form -->

                    <!-- comments -->
                    <?php
                    $comment_sql = "SELECT c.*, u.name, c.comment_date FROM comments c JOIN users u ON c.user_id = u.id WHERE c.post_id = {$post['id']}";
                    $comment_result = $conn->query($comment_sql);

                    if ($comment_result->num_rows > 0) {
                      while($comment = $comment_result->fetch_assoc()) {
                        ?>
                        <div class="comment">
                          <p><?php echo $comment['comment']; ?></p>
                          <p><small><?php echo $comment['name']; ?></small> - <small><?php echo $comment['comment_date']; ?></small></p>
                        </div>
                        <?php
                      }
                    } else {
                      ?>
                      <p class="text-center">No comments yet!</p>
                      <?php
                    }
                    ?>
                    <!-- ./comments -->
                  </div>
                </div>
              <?php
            }
          } else {
            ?>
            <p class="text-center">No posts yet!</p>
            <?php
          }
        ?>
        <!-- ./post -->
      </div>
      <!-- ./feed -->
    </div>
    <div class="col-md-3">
    <!-- add friend -->
      <div class="panel panel-default">
        <div class="panel-body">
          <h4>add friend</h4>
          <?php 
            $sql = "SELECT id, username, name, (SELECT COUNT(*) FROM friends WHERE friends.user_id = users.id AND friends.friend_id = {$_SESSION['user_id']}) AS is_friend FROM users WHERE id != {$_SESSION['user_id']} HAVING is_friend = 0";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
              ?><ul><?php
              while($fc_user = $result->fetch_assoc()) {
                ?>
                <li>
                  <a href="profile.php?username=<?php echo $fc_user['username']; ?>">
                    <?php echo $fc_user['name']; ?>
                  </a> 
                  <a href="php/add-friend.php?uid=<?php echo $fc_user['id']; ?>">[add]</a>
                </li>
                <?php
              }
              ?></ul><?php
            } else {
              ?>
              <p class="text-center">No users to add!</p>
              <?php
            }
          
            // code block without the closing curly brace
          ?>
        </div>
      </div>
      <!-- ./add friend -->
    </div>
  </div>
</main>
<!-- ./main -->

<?php include "footer.php"; ?>