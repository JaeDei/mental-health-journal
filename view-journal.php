<?php

session_start();

require('includes/config.php');
require('includes/db.php');
require('check-login.php');

if($role != 2){
   unset($_SESSION);
   header('location: unauthorized.php');
}else{

   $journalID = $_GET['journalID'];

   if(isset($_POST['status'])){
      $status = 'Public';
      ?>
      <script type='text/javascript'>
         document.addEventListener("DOMContentLoaded", function(){
            Swal.fire({
               title: "Share this Entry to Public?",
               icon: "question",
               showCancelButton: true,
               confirmButtonColor: "#3085d6",
               cancelButtonColor: "#d33",
               confirmButtonText: "Yes!"
            }).then((result) => {
               if (result.isConfirmed) {
                  Swal.fire({
                     title: "Shared!",
                     text: "Your Entry set to Public!",
                     icon: "success"
                  });
                  <?php
                  $update = $db->prepare("UPDATE journal SET status = ? WHERE journal_id = ?");
                  $update->execute([$status, $journalID]);
                  ?>
               }
            });
         });
      </script>
      <?php
   }

   if(isset($_POST['delete'])){

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

    <link rel="stylesheet" href="assets/sweetalert2/dist/sweetalert2.min.css">

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
                        <form action="" method="post">
                           <?php
                           $journalID = $_GET['journalID'];
                           $sql = $db->query("SELECT * FROM journal JOIN Users ON journal.userID = Users.userID JOIN mood ON journal.moodID = mood.moodID WHERE journal_id = $journalID");
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
                                 <div class="text-center mt-7 mb-3">
                                    <a href="edit-journal.php?journalID=<?php echo $display['journal_id'];?>" class="btn btn-sm btn-success" name="edit">Edit</a>
                                    <button type="submit" class="btn btn-sm btn-danger" name="delete">Delete</button>
                                    <button type="submit" class="btn btn-sm btn-warning" name="status">Status</button>
                                 </div>
                              </div>
                           <?php
                           }
                           ?>
                        </form>
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

   <script src="assets/sweetalert2/dist/sweetalert2.all.min.js"></script>

   <script src="assets/js/activesidebar.js"></script>

</body>
</html>