<?php

session_start();

require('includes/config.php');
require('includes/db.php');
require('check-login.php');

if($role != 2){
   unset($_SESSION);
   header('location: unauthorized.php');
}

if(isset($_POST['delete'])){

   $p_id = $_POST['post_id'];
   $p_id = filter_var($p_id, FILTER_SANITIZE_STRING);
   $delete_image = $db->prepare("SELECT * FROM `posts` WHERE post_id = ?");
   $delete_image->execute([$p_id]);
   $fetch_delete_image = $delete_image->fetch(PDO::FETCH_ASSOC);
   if($fetch_delete_image['image'] != ''){
      unlink('assets/profile_img/'.$fetch_delete_image['image']);
   }
   $delete_post = $db->prepare("DELETE FROM `posts` WHERE post_id = ?");
   $delete_post->execute([$p_id]);
   $delete_comments = $db->prepare("DELETE FROM `comments` WHERE post_id = ?");
   $delete_comments->execute([$p_id]);
   $message[] = 'post deleted successfully!';

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>mhj | View Journal Entry</title>

   <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <link rel="stylesheet" href="assets/css/fontawesome-free/css/all.min.css">

    <link rel="stylesheet" href="assets/css/adminlte.min.css">

    <link rel="stylesheet" href="assets/overlayScrollbars/css/OverlayScrollbars.min.css">

    <link rel="stylesheet" href="assets/css/adminlte.min.css">

</head>
<body class="hold-transition sidebar-mini layout-fixed">
   <div class="wrapper">
        
      <?php
      /* Navbar */
      include('includes/student-navbar.php');
      /* Sidebar */
      include('includes/student-sidebar.php');
      ?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
         <!-- Content Header (Page header) -->
         <section class="content-header">
            <div class="container-fluid">
               <div class="row mb-2">
                  <div class="col-sm-6">
                     <h1>View Journal Entry</h1>
                  </div>
               </div>
            </div><!-- /.container-fluid -->
         </section>
         <!-- Main content -->
         <section class="content">

            <!-- Default box -->
            <div class="card">
               <div class="card-header">
                  <h3 class="card-title">Entry Detail</h3>
               </div>
               <div class="card-body">
                  <div class="row">
                     <div class="col-md-12">
                        <?php
                        $journalID = $_GET['journalID'];
                        $sql = $db->query("SELECT * FROM posts JOIN Users ON posts.userID = Users.userID JOIN mood ON posts.moodID = mood.moodID WHERE journal_id = $journalID");
                        foreach($sql as $display){
                           ?>
                           <h3 class="text-primary text-center"><?php echo $display['title'];?></h3>
                           <br>
                           <div class="offset-sm-1 col-md-10">
                              <p class="text-muted">Content: <?php echo $display['content'];?></p>
                              <br>
                              <p class="text-muted">Mood: <?php echo $display['description'];?> <?php echo $display['mood'];?></p>
                              <br>
                              <p class="text-muted">Thoughts and Feelings: <?php echo $display['thought'];?></p>
                              <br>
                              <p class="text-muted">Status: <?php echo $display['status'];?></p>
                              <br>
                              <div class="text-center mt-5 mb-3">
                                 <a href="#" class="btn btn-sm btn-danger">Delete</a>
                                 <a href="#" class="btn btn-sm btn-warning">Share</a>
                              </div>
                           </div>
                        <?php
                        }
                        ?>
                     </div>
                  </div>
               </div>
               <!-- /.card-body -->
            </div>
            <!-- /.card -->

         </section>
         <!-- /.content -->

      
      </div>
      <!-- /.content-wrapper -->
    
      <aside class="control-sidebar control-sidebar-dark">

      </aside>

   </div>
   
   <script src="assets/js/jquery/jquery.min.js"></script>

   <script src="assets/js/bootstrap/js/bootstrap.bundle.min.js"></script>

   <script src="assets/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>

   <script src="assets/js/adminlte.min.js"></script>

   <script src="assets/js/activesidebar.js"></script>

</body>
</html>