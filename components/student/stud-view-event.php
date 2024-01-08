<?php
session_start();

require('../../includes/config.php');
require('../../includes/db.php');
require('../../check-login.php');

if ($role != 2) {
    unset($_SESSION);
    header('location: ../../unauthorized.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>mhj | View Event</title>

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
                     <h1>View Event</h1>
                  </div>
               </div>
            </div><!-- /.container-fluid -->
         </section>
         <!-- Main content -->
         <section class="content">

            <!-- Default box -->
            <div class="card">
               <div class="card-header">
                  <h3 class="card-title">Event Detail</h3>
               </div>
               <div class="card-body">
                  <div class="row">
                     <div class="col-md-12">
                        <form action="" method="post">
                           <?php
                           $eventID = $_GET['eventID'];
                           $sql = $db->prepare("SELECT * FROM events WHERE eventID = :eventID");
                           $sql->bindParam(':eventID', $eventID, PDO::PARAM_INT);
                           $sql->execute();
                           foreach($sql as $display){
                              ?>
                              <h3 class="text-primary text-center"><?php echo $display['eventTitle'];?></h3>
                              <br>
                              <div class="offset-sm-1 col-md-10">
                                 <p class="text-muted">About: <?php echo $display['about'];?></p>
                                 <br>
                                 <p class="text-muted">Start at: <?php echo $display['start_at'];?></p>
                                 <br>
                                 <p class="text-muted">End at: <?php echo $display['end_at'];?></p>
                                 <br>
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