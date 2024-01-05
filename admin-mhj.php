<?php

session_start();

require('includes/config.php');
require('includes/db.php');
require('check-login.php');

if($role != 1){
    unset($_SESSION);
    header('location: unauthorized.php');
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
    <title>mhj</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <link rel="stylesheet" href="assets/css/fontawesome-free/css/all.min.css">

    <link rel="stylesheet" href="assets/overlayScrollbars/css/OverlayScrollbars.min.css">

    <link rel="stylesheet" href="assets/sweetalert2/dist/sweetalert2.min.css">

    <link rel="stylesheet" href="assets/css/adminlte.min.css">

</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        
        <?php
        /* Navbar */
        include('includes/admin-navbar.php');
        /* Sidebar */
        include('includes/admin-sidebar.php');
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
        </div>
        <!-- /.content-wrapper -->
    
        <aside class="control-sidebar control-sidebar-dark sidebar-mini layout-fixed">
            <h5>Customize Web</h5>
        </aside>

    </div>

    <script src="assets/js/jquery/jquery.min.js"></script>

    <script src="assets/js/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="assets/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>

    <script src="assets/js/adminlte.min.js"></script>

    <script src="assets/sweetalert2/dist/sweetalert2.all.min.js"></script>

    <script src="assets/js/demo.js"></script>

    <script src="assets/js/activesidebar.js"></script>

</body>
</html>