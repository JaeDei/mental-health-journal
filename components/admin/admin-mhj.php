<?php

session_start();

require('../../includes/config.php');
require('../../includes/db.php');
require('../../check-login.php');

if($role != 1){
    unset($_SESSION);
    header('location: ../../unauthorized.php');
}else{
    
    if (!isset($_SESSION['user']) || $_SESSION['user'] !== true) {

        $firstname = $fetch['firstname'];
            
            echo"
                <script type='text/javascript'>
                    document.addEventListener('DOMContentLoaded', function(){
                        Swal.fire('Welcome Back!, Admin $firstname');
                    });
                </script>";

            $_SESSION['user'] = true;
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mhj | Admin</title>

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
                            <h1>Dashboard</h1>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <?php
                        $sql1 = $db->prepare("SELECT * FROM journal");
                        $sql1->execute();
                        $sql_query1 = $sql1->fetch(PDO::FETCH_ASSOC);
                        $sqlCount1 = $sql1->rowCount();
                        ?>
                        <div class="col-md-3 col-sm-6 col-12">
                            <div class="info-box" type="button" onclick="window.location.href = 'journal-entries.php'">
                                <span class="info-box-icon bg-info"><i class="far fa-envelope"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Total Journal Entries</span>
                                    <span class="info-box-number"><?php echo $sqlCount1;?></span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <!-- /.col -->
                        <?php
                        $sql2 = $db->prepare("SELECT * FROM journal WHERE DATE(date) = CURDATE()");
                        $sql2->execute();
                        $sql_query2 = $sql2->fetch(PDO::FETCH_ASSOC);
                        $sqlCount2 = $sql2->rowCount();
                        ?>
                        <div class="col-md-3 col-sm-6 col-12">
                            <div class="info-box" type="button" onclick="window.location.href = 'journal-entries.php'">
                                <span class="info-box-icon bg-success"><i class="far fa-envelope"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Daily Journal Entry</span>
                                    <span class="info-box-number"><?php echo $sqlCount2;?></span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <!-- /.col -->
                        <?php
                        $sql3 = $db->prepare("SELECT * FROM Users WHERE role = 'Student'");
                        $sql3->execute();
                        $sql_query3 = $sql3->fetch(PDO::FETCH_ASSOC);
                        $sqlCount3 = $sql3->rowCount();
                        ?>
                        <div class="col-md-3 col-sm-6 col-12">
                            <div class="info-box"type="button" onclick="window.location.href = 'student-lists.php'">
                                <span class="info-box-icon bg-warning"><i class="far fa-user"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Total Student Registered</span>
                                    <span class="info-box-number"><?php echo $sqlCount3;?></span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <!-- /.col -->
                        <?php
                        $sql4 = $db->prepare("SELECT * FROM Users WHERE role = 'Student' AND DATE(dateRegistered) = CURDATE()");
                        $sql4->execute();
                        $sql_query4 = $sql4->fetch(PDO::FETCH_ASSOC);
                        $sqlCount4 = $sql4->rowCount();
                        ?>
                        <div class="col-md-3 col-sm-6 col-12">
                            <div class="info-box" type="button" onclick="window.location.href = 'student-lists.php'">
                                <span class="info-box-icon bg-danger"><i class="far fa-user"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Daily Student Registers</span>
                                    <span class="info-box-number"><?php echo $sqlCount4;?></span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <!-- /.col -->


                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </section>
            <!-- /.content -->

        
        
        </div>
        <!-- /.content-wrapper -->
    
        <aside class="control-sidebar control-sidebar-dark sidebar-mini layout-fixed">
            <h5>Customize Web</h5>
        </aside>

    </div>

    <script src="../../assets/js/jquery/jquery.min.js"></script>

    <script src="../../assets/js/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="../../assets/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>

    <script src="../../assets/js/adminlte.min.js"></script>

    <script src="../../assets/sweetalert2/dist/sweetalert2.all.min.js"></script>

    <script src="../../assets/js/demo.js"></script>

    <script src="../../assets/js/activesidebar.js"></script>

</body>
</html>