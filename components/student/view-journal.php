<?php
session_start();

require('../../includes/config.php');
require('../../includes/db.php');
require('../../check-login.php');

if ($role != 2) {
    unset($_SESSION);
    header('location: ../../unauthorized.php');
}else{

   $userID = $fetch['userID'];

   if ($userID !== null) {

      $check = $db->prepare("SELECT * FROM journal WHERE userID = :userID");
      $check->bindParam(':userID', $userID, PDO::PARAM_INT);
      $check->execute();
      $row = $check->fetchAll(PDO::FETCH_ASSOC);
      $count = count($row);

      $text = array();
      $image = array();
      if($count == 1){
         $text[] = 'First Entry!';
         $image[] = 'first_entry.png';
      }elseif($count == 10){
         $text[] = '10th Entry!';
         $image[] = '10th_entry.png';
      }elseif($count == 20){
         $text[] = '20th Entry!';
         $image[] = '20th_entry.png';
      }elseif($count == 30){
         $text[] = '30th Entry!';
         $image[] = '30th_entry.png';
      }elseif($count == 40){
         $text[] = '40th Entry!';
         $image[] = '40th_entry.png';
      }elseif($count == 50){
         $text[] = '50th Entry!';
         $image[] = '50th_entry.png';
      }elseif($count == 60){
         $text[] = '60th Entry!';
         $image[] = '60th_entry.png';
      }else{
         $text[] = 'Highest!';
         $image[] = 'highest.png';
      }

      $getText = implode('', $text);
      $getImage = implode('', $image);

      echo"
            <script type='text/javascript'>
                document.addEventListener('DOMContentLoaded', function(){
                    Swal.fire({
                        title: 'Congratulation!',
                        text: 'Achievement Unlocked: {$getText}',
                        imageUrl: '../../assets/images/achievements/{$getImage}',
                        imageWidth: 200,
                        imageHeight: 200,
                        imageAlt: 'Custom image'
                    });
                });
            </script>";


   }
   
   $journalID = isset($_GET['journalID']) ? $_GET['journalID'] : null;

   if ($journalID !== null) {

      if (isset($_POST['status'])) {
         
         $select = $db->prepare("SELECT status FROM journal WHERE journal_id = :journalID");
         $select->bindParam(':journalID', $journalID, PDO::PARAM_INT);
         $select->execute();
         $check_status = $select->fetch(PDO::FETCH_ASSOC);

         if($check_status['status'] == 'Public'){
            $status = 'Private';

            echo "
               <script type='text/javascript'>
                  document.addEventListener('DOMContentLoaded', function(){
                     Swal.fire({
                        title: 'Private this Entry?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, private it!'
                     }).then((result) => {
                        if (result.isConfirmed) {
                           Swal.fire({
                              title: 'Done!',
                              text: 'Entry set to private.',
                              icon: 'success'
                           }).then(() => {
                              window.location.href = 'update-journal.php?journalID=$journalID&status=$status';
                           });
                        }
                     });
                  });
               </script>";

         }else{
            $status = 'Public';

            echo "
               <script type='text/javascript'>
                  document.addEventListener('DOMContentLoaded', function(){
                     Swal.fire({
                        title: 'Public this Entry?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, public it!'
                     }).then((result) => {
                        if (result.isConfirmed) {
                           Swal.fire({
                              title: 'Done!',
                              text: 'Entry set to public.',
                              icon: 'success'
                           }).then(() => {
                              window.location.href = 'update-journal.php?journalID=$journalID&status=$status';
                           });
                        }
                     });
                  });
               </script>";

         }
      
      }else{
         if (isset($_POST['delete'])) {
         
            echo "
               <script type='text/javascript'>
                  document.addEventListener('DOMContentLoaded', function(){
                     Swal.fire({
                        title: 'Are you sure?',
                        text: 'You won\'t be able to recover this entry!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete it!'
                     }).then((result) => {
                        if (result.isConfirmed) {
                           Swal.fire({
                              title: 'Deleted!',
                              text: 'Entry has been deleted.',
                              icon: 'success'
                           }).then(() => {
                              window.location.href = '../../delete-journal.php?journalID=$journalID&role=$role';
                           });
                        }
                     });
                  });
               </script>";
     
         }else{
            echo "Error on delete!";
         }
   
      }

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

    <link rel="stylesheet" href="../../assets/css/fontawesome-free/css/all.min.css">

    <link rel="stylesheet" href="../../assets/css/adminlte.min.css">

    <link rel="stylesheet" href="../../assets/overlayScrollbars/css/OverlayScrollbars.min.css">

    <link rel="stylesheet" href="../../assets/sweetalert2/dist/sweetalert2.min.css">

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
                           $sql = $db->prepare("SELECT * FROM journal JOIN Users ON journal.userID = Users.userID JOIN mood ON journal.moodID = mood.moodID WHERE journal_id = :journalID");
                           $sql->bindParam(':journalID', $journalID, PDO::PARAM_INT);
                           $sql->execute();
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
                                    <button type="submit" class="btn btn-sm btn-warning" name="status">Change Status</button>
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
   
   <script src="../../assets/js/jquery/jquery.min.js"></script>

   <script src="../../assets/js/bootstrap/js/bootstrap.bundle.min.js"></script>

   <script src="../../assets/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>

   <script src="../../assets/js/adminlte.min.js"></script>

   <script src="../../assets/sweetalert2/dist/sweetalert2.all.min.js"></script>

   <script src="../../assets/js/activesidebar.js"></script>

</body>
</html>