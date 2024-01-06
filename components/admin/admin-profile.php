<?php

session_start();

require('../../includes/config.php');
require('../../includes/db.php');
require('../../check-login.php');

if($role != 1){
    unset($_SESSION);
    header('location: unauthorized.php');
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mhj | Admin Profile</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <link rel="stylesheet" href="../../assets/css/fontawesome-free/css/all.min.css">

    <link rel="stylesheet" href="../../assets/overlayScrollbars/css/OverlayScrollbars.min.css">

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
                            <h1>Profile</h1>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-5">
                            <!-- Profile Image -->
                            <div class="card card-primary card-outline">
                                <div class="card-body box-profile">
                                    <div class="text-center">
                                        <img class="profile-user-img img-fluid img-circle"
                                            src="../../assets/profile_img/<?php echo $fetch['profile_pic'];?>"
                                            alt="User profile picture">
                                    </div>

                                    <h3 class="profile-username text-center"><?php echo $fetch['firstname'];?> <?php echo $fetch['lastname'];?></h3>

                                    <p class="text-muted text-center">Administrator</p>

                                    <a href="admin-edit-prof.php?userID=<?php echo $fetch['userID'];?>" class="btn btn-primary btn-block"><b>Edit Profile</b></a>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                                
                        
                        <div class="col-md-7">
                            <!-- About Me Box -->
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">About Me</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <strong><i class="fas fa-user"></i> Username</strong>

                                    <p class="text-muted"><?php echo $fetch['username'];?></p>

                                    <hr>

                                    <strong><i class="fas fa-envelope"></i> Email</strong>

                                    <p class="text-muted"><?php echo $fetch['email'];?></p>

                                    <hr>

                                    <strong><i class="fas fa-phone"></i> Phone Number</strong>

                                    <p class="text-muted"><?php echo $fetch['phone_no'];?></p>

                                    <hr>

                                    <strong><i class="far fa-calendar"></i> Date Registered</strong>

                                    <p class="text-muted"><?php echo $fetch['dateRegistered'];?></p>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                </div>
            </section>
        
        </div>

        <aside class="control-sidebar control-sidebar-dark sidebar-mini layout-fixed">

        </aside>
        
    </div>

    <script src="../../assets/js/jquery/jquery.min.js"></script>

    <script src="../../assets/js/bootstrap/js//bootstrap.bundle.min.js"></script>

    <script src="../../assets/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>

    <script src="../../assets/js/adminlte.min.js"></script>

    <script src="../../assets/js/demo.js"></script>
    
</body>
</html>