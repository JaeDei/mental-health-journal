<?php

session_start();

require('includes/config.php');
require('includes/db.php');
require('check-login.php');

if($role != 2){
    unset($_SESSION);
    header('location: unauthorized.php');
}else{
    
    $select = $db->prepare("SELECT * FROM loginAchievement WHERE userID = ?");
    $select->execute([$fetch['userID']]);
    $login_achievement = $select->fetch(PDO::FETCH_ASSOC);

    if($select->rowCount() < 1){
        $achievement = $db->prepare("INSERT INTO loginAchievement(userID) VALUES(?)");
        $achievement->execute([$fetch['userID']]);

        ?>
        <script type='text/javascript'>
            document.addEventListener("DOMContentLoaded", function(){
                Swal.fire({
                    title: 'Congratulation!',
                    text: 'Achievement Unlocked: First Login!',
                    imageUrl: 'assets/images/achievements/first_login.png',
                    imageWidth: 200,
                    imageHeight: 200,
                    imageAlt: 'Custom image'
                });
            });
        </script>
        <?php
    }else{
        if (!isset($_SESSION['user']) || $_SESSION['user'] !== true) {
            ?>
            <script type='text/javascript'>
                document.addEventListener("DOMContentLoaded", function(){
                    Swal.fire('Welcome Back!, Student <?php echo $fetch['firstname'];?>');
                });
            </script>
            <?php
            $_SESSION['user'] = true;
        }
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
                            <h1>Dashboard</h1>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>
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