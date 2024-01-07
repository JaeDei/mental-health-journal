<?php
session_start();

require('../../includes/config.php');
require('../../includes/db.php');
require('../../check-login.php');

if ($role != 1) {
    unset($_SESSION);
    header('location: ../../unauthorized.php');
}else{
   
    $journalID = isset($_GET['journalID']) ? $_GET['journalID'] : null;

    if ($journalID !== null) {
    
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
                            } else {
                                window.location.href = 'view-entry.php?journalID=$journalID';
                            }
                        });
                    });
                </script>";
        }else{
         echo "Error on delete!";
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
   <title>mhj | Admin-View Journal Entry</title>

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
      include('../../includes/admin-navbar.php');
      /* Sidebar */
      include('../../includes/admin-sidebar.php');
      ?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
         <!-- Content Header (Page header) -->
         <section class="content-header">
            <div class="container-fluid">
               <div class="row mb-2">
                  <div class="col-sm-6">
                     <h1>View Student Journal Entry</h1>
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
                              <h3>From: <?php echo $display['username'];?></h3>
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
                                    <button type="submit" class="btn btn-sm btn-danger" name="delete">Delete</button>
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