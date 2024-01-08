<?php

session_start();

require('../../includes/config.php');
require('../../includes/db.php');
require('../../check-login.php');

if (isset($_SESSION['userID'])) {
   $user_id = $_SESSION['userID'];
} else {
   $user_id = '';
}
;


$get_id = isset($_GET['journalID']) ? $_GET['journalID'] : null;

// Add a check
if ($get_id !== null) {

if ($journalID !== null) {
   if (isset($_POST['add_comment'])) {

      $user_id = $_POST['userID'];
      $user_id = filter_var($user_id, FILTER_SANITIZE_STRING);
      $user_name = $_POST['username'];
      $user_name = filter_var($user_name, FILTER_SANITIZE_STRING);
      $comment = $_POST['comment'];
      $comment = filter_var($comment, FILTER_SANITIZE_STRING);

      $verify_comment = $db->prepare("SELECT * FROM `comments` WHERE comment = ? AND comment_id = ?");
      $verify_comment->execute([$get_id, $user_id, $user_name, $comment]);

      if ($verify_comment->rowCount() > 0) {
         $message[] = 'comment already added!';
      } else {
         $insert_comment = $db->prepare("INSERT INTO `comments`(journal_id, userID, username, comment) VALUES(?,?,?,?)");
         $insert_comment->execute([$get_id, $user_id, $user_name, $comment]);
         $message[] = 'new comment added!';
      }

   }

   if (isset($_POST['edit_comment'])) {
      $edit_comment_id = $_POST['edit_comment_id'];
      $edit_comment_id = filter_var($edit_comment_id, FILTER_SANITIZE_STRING);
      $comment_edit_box = $_POST['comment_edit_box'];
      $comment_edit_box = filter_var($comment_edit_box, FILTER_SANITIZE_STRING);

      $verify_comment = $db->prepare("SELECT * FROM `comments` WHERE comment = ? AND comment_id = ?");
      $verify_comment->execute([$comment_edit_box, $edit_comment_id]);

      if ($verify_comment->rowCount() > 0) {
         $message[] = 'comment already added!';
      } else {
         $update_comment = $db->prepare("UPDATE `comments` SET comment = ? WHERE community_id = ?");
         $update_comment->execute([$comment_edit_box, $edit_comment_id]);
         $message[] = 'your comment edited successfully!';
      }
   }

   if (isset($_POST['delete_comment'])) {
      $delete_comment_id = $_POST['comment_id'];
      $delete_comment_id = filter_var($delete_comment_id, FILTER_SANITIZE_STRING);
      $delete_comment = $db->prepare("DELETE FROM `comments` WHERE comment_id = ?");
      $delete_comment->execute([$delete_comment_id]);
      $message[] = 'comment deleted successfully!';
   }
}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>mhj | Create Journal</title>

   <link rel="stylesheet"
      href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

   <link rel="stylesheet" href="../../assets/css/fontawesome-free/css/all.min.css">

   <link rel="stylesheet" href="../../assets/overlayScrollbars/css/OverlayScrollbars.min.css">

   <link rel="stylesheet" href="../../assets/sweetalert2/dist/sweetalert2.min.css">

   <link rel="stylesheet" href="../../assets/css/adminlte.min.css">

</head>

<body class="hold-transition sidebar-mini layout-fixed">
   <div class="wrapper">

      <?php
      /* Navbar */
      include('../../includes/student-navbar.php');
      /* Sidebar */
      include('../../includes/student-sidebar.php');
      ?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
         <!-- Content Header (Page header) -->
         <section class="content-header">
            <div class="container-fluid">
               <div class="row mb-2">
                  <div class="col-sm-6">
                     <h1>Community Forum</h1>
                  </div>
               </div>
            </div><!-- /.container-fluid -->
         </section>
         <!-- Main content -->
         <section class="content">
            <div class="card-body">
               <div class="col-md-9">
                  <div class="card card-primary">
                     <div class="card-header">
                        <h3 class="card-title">Journal Post</h3>
                     </div>
                     <?php
                     $select_journal = $db->prepare("SELECT * FROM `journal` JOIN mood ON journal.moodID = mood.moodID  WHERE status = ? LIMIT 1 ");
                     $select_journal->execute(['Public']);
                     if ($select_journal->rowCount() > 0) {
                        while ($fetch_journal = $select_journal->fetch(PDO::FETCH_ASSOC)) {
                           $post_id = $fetch_journal['journal_id'];
                           ?>
                           <div class="card-body">
                              <form action="" method="post">
                                 <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" id="title" name="title" class="form-control"
                                       value="<?php echo htmlspecialchars($fetch_journal['title']); ?>" />
                                 </div>
                                 <div class="form-group">
                                    <label for="content">Content</label>
                                    <textarea id="content" name="content" class="form-control"
                                       rows="4"><?php echo htmlspecialchars($fetch_journal['content']); ?></textarea>
                                 </div>
                                 <div class="form-group">
                                    <label for="mood">Mood</label>
                                    <span>
                                       <?= $fetch_journal['mood']; ?>
                                    </span>
                                 </div>

                                 <div class="form-group">
                                    <label for="comment">Comment</label>
                                    <textarea id="comment" name="thought" class="form-control" rows="4"></textarea>
                                 </div>
                                 <div class="form-group row">
                                    <div class="offset-sm-0 col-sm-10">
                                       <input type="submit" value="add comment" class="inline-btn" name="add_comment">
                                    </div>

                                 </div>
                                 <p class="comment-title">post comments</p>
                                 <div class="user-comments-container">
                                    <?php
                                    $select_comments = $db->prepare("SELECT * FROM `comments` WHERE journal_id = ?");
                                    $select_comments->execute([$get_id]);
                                    if ($select_comments->rowCount() > 0) {
                                       while ($fetch_comments = $select_comments->fetch(PDO::FETCH_ASSOC)) {
                                          ?>
                                          <div class="show-comments"
                                             style="<?php if ($fetch_comments['userID'] == $user_id) {
                                                echo 'order:-1;';
                                             } ?>">
                                             <div class="comment-user">
                                                <i class="fas fa-user"></i>
                                                <div>
                                                   <span>
                                                      <?= $fetch_comments['username']; ?>
                                                   </span>
                                                   <div>
                                                      <?= $fetch_comments['date']; ?>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="comment-box"
                                                style="<?php if ($fetch_comments['userID'] == $user_id) {
                                                   echo 'color:var(--white); background:var(--black);';
                                                } ?>">
                                                <?= $fetch_comments['comment']; ?>
                                             </div>
                                             <?php
                                             if ($fetch_comments['userID'] == $user_id) {
                                                ?>
                                                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                              <input type="hidden" name="comment_id" value="<?= $fetch_comments['comment_id']; ?>">
                                                   <button type="submit" class="inline-option-btn" name="open_edit_box">edit
                                                      comment</button>
                                                   <button type="submit" class="inline-delete-btn" name="delete_comment"
                                                      onclick="return confirm('delete this comment?');">delete comment</button>
                                                </form>
                                                <?php
                                             }
                                             ?>
                                          </div>
                                          <?php
                                       }
                                    } else {
                                       echo '<p class="empty">no comments added yet!</p>';
                                    }
                                    ?>
                                 </div>
                                 <?php
                        }
                     } else {
                        echo '<p class="empty">no posts added yet!</p>';
                     }
                     ?>
                        </form>

                     </div>
                     <!-- /.card -->
                  </div>
               </div>
            </div>
         </section>
         <!-- /.content -->
      </div>
      <!-- /.content-wrapper -->

      <aside class="control-sidebar control-sidebar-dark">

      </aside>

   </div>

   <script src="../../assets/js/jquery/jquery.min.js"></script>

   <script src="../../assets/js/bootstrap/js/bootstrap.bundle.min.js"></script>

   <script src="../../assets/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>

   <script src="../../assets/js/adminlte.min.js"></script>

   <script src="../../assets/js/activesidebar.js"></script>

   <script src="../../assets/sweetalert2/dist/sweetalert2.all.min.js"></script>

</body>

</html>