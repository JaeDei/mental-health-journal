<?php


session_start();

require('../../includes/config.php');
require('../../includes/db.php');
require('../../check-login.php');

if($role != 1){
   unset($_SESSION);
   header('location: ../../unauthorized.php');
}else{
    if(isset($_POST['save'])){

        $eventID = $_GET['eventID'];
        $title = $_POST['title'];
        $about = $_POST['about'];
        $startDate = $_POST['startDate'];
        $endDate = $_POST['endDate'];

        $update = $db->prepare("UPDATE events SET eventTitle = :title, about = :about, start_at = :startDate, end_at = :endDate WHERE eventID = :eventID");
        $update->bindParam(':title', $title, PDO::PARAM_STR);
        $update->bindParam(':about', $about, PDO::PARAM_STR);
        $update->bindParam(':startDate', $startDate, PDO::PARAM_STR);
        $update->bindParam(':endDate', $endDate, PDO::PARAM_STR);
        $update->bindParam(':eventID', $eventID, PDO::PARAM_INT);
        $update->execute();

        echo "
            <script type='text/javascript'>
                document.addEventListener('DOMContentLoaded', function(){
                    Swal.fire({
                        title: 'Save Changes?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Save'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                title: 'Saved!',
                                text: 'Event has been updated.',
                                icon: 'success'
                            }).then(() => {
                                window.location.href = 'view-event.php?eventID=$eventID';
                            });
                        }
                    });
                });
            </script>";

    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mhj | Admin-Edit Event</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <link rel="stylesheet" href="../../assets/css/fontawesome-free/css/all.min.css">

    <link rel="stylesheet" href="../../assets/overlayScrollbars/css/OverlayScrollbars.min.css">

    <link rel="stylesheet" href="../../assets/sweetalert2/dist/sweetalert2.min.css">

    <link rel="stylesheet" href="../../assets/css/adminlte.min.css">

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
                            <h1>Edit Event</h1>
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
                                <h3 class="card-title">Event Details</h3>
                            </div>
                            <div class="card-body">
                                <?php
                                $eventID = $_GET['eventID'];
                                $event = $db->prepare("SELECT * FROM events WHERE eventID = :eventID");
                                $event->bindParam(':eventID', $eventID, PDO::PARAM_INT);
                                $event->execute();
                                $fetchEvent = $event->fetch(PDO::FETCH_ASSOC);
                                ?>
                                <form action="" method="post">
                                    <div class="form-group">
                                        <label for="title">Event Title</label>
                                        <input type="text" id="title" name="title" class="form-control"  value="<?php echo $fetchEvent['eventTitle']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="about">About</label>
                                        <textarea id="about" name="about" class="form-control" rows="4"><?php echo $fetchEvent['about']; ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="startDate">Start at</label>
                                        <input type="datetime-local" id="startDate" name="startDate" class="form-control"  value="<?php echo $fetchEvent['start_at']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="endDate">End at</label>
                                        <input type="datetime-local" id="endDate" name="endDate" class="form-control"  value="<?php echo $fetchEvent['end_at']; ?>">
                                    </div>
                                    <div class="form-group row">
                                        <div class="offset-sm-0 col-sm-10">
                                            <input type="submit" name="save" value="Save your Journal" class="btn btn-success">
                                            <a href="view-event.php?eventID=<?php echo $eventID;?>" class="btn btn-success">go Back</a>
                                        </div>
                                    </div>
                                </form>
            
                            </div>
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