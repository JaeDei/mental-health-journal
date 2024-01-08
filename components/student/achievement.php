<?php

session_start();

require('../../includes/config.php');
require('../../includes/db.php');
require('../../check-login.php');

if($role != 2){
    unset($_SESSION);
    header('location: ../../unauthorized.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mhj | Achievements</title>

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
                            <h1>Achievements</h1>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <?php
                        $userID = $fetch['userID'];
                        $check1 = $db->prepare("SELECT * FROM loginAchievement WHERE userID = :userID");
                        $check1->bindParam(':userID', $userID, PDO::PARAM_INT);
                        $check1->execute();
                        ?>
                        <div class="col-md-12">
                            <div class="card-header">
                                <h3 class="card-title">Login</h3>
                            </div>
                            <?php
                            if($check1->rowCount() > 0){
                                ?>
                                <div class="col-md-2">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <div class="card-body text-center">
                                                <img src="../../assets/images/achievements/first_login.png" alt="Product Image" class="img-size-50">
                                            </div>
                                            <p>First Login</p>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                        </div>

                        <?php
                        $check2 = $db->prepare("SELECT * FROM journal WHERE userID = :userID");
                        $check2->bindParam(':userID', $userID, PDO::PARAM_INT);
                        $check2->execute();
                        $row = $check2->fetchAll(PDO::FETCH_ASSOC);
                        $countJournal = count($row);
                        ?>
                        <div class="col-md-12">
                            <div class="card-header">
                                <h3 class="card-title">Journal Entry</h3>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <?php
                                            if($countJournal > 1){
                                                if($countJournal < 0){
                                                    ?>
                                                    <div class="card-body text-center">
                                                        <img src="../../assets/images/achievements/locked.png" alt="Achievement Image" class="img-size-50">
                                                    </div>
                                                    <?php
                                                }else{
                                                    ?>
                                                    <div class="card-body text-center">
                                                        <img src="../../assets/images/achievements/first_entry.png" alt="Achievement Image" class="img-size-50">
                                                    </div>
                                                    <?php
                                                }
                                            }
                                            ?>
                                            <p>First Entry</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <?php
                                            if($countJournal < 10){
                                                ?>
                                                <div class="card-body text-center">
                                                    <img src="../../assets/images/achievements/locked.png" alt="Achievement Image" class="img-size-50">
                                                </div>
                                                <?php
                                            }else{
                                                ?>
                                                <div class="card-body text-center">
                                                    <img src="../../assets/images/achievements/10th_entry.png" alt="Achievement Image" class="img-size-50">
                                                </div>
                                                <?php
                                            }
                                            ?>
                                            <p>10th Entry</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <?php
                                            if($countJournal <=20){
                                                ?>
                                                <div class="card-body text-center">
                                                    <img src="../../assets/images/achievements/locked.png" alt="Achievement Image" class="img-size-50">
                                                </div>
                                                <?php
                                            }else{
                                                ?>
                                                <div class="card-body text-center">
                                                    <img src="../../assets/images/achievements/20th_entry.png" alt="Achievement Image" class="img-size-50">
                                                </div>
                                                <?php
                                            }
                                            ?>
                                            <p>20th Entry</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <?php
                                            if($countJournal <= 30){
                                                ?>
                                                <div class="card-body text-center">
                                                    <img src="../../assets/images/achievements/locked.png" alt="Achievement Image" class="img-size-50">
                                                </div>
                                                <?php
                                            }else{
                                                ?>
                                                <div class="card-body text-center">
                                                    <img src="../../assets/images/achievements/30th_entry.png" alt="Achievement Image" class="img-size-50">
                                                </div>
                                                <?php
                                            }
                                            ?>
                                            <p>30th Entry</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <?php
                                            if($countJournal <= 40){
                                                ?>
                                                <div class="card-body text-center">
                                                    <img src="../../assets/images/achievements/locked.png" alt="Achievement Image" class="img-size-50">
                                                </div>
                                                <?php
                                            }else{
                                                ?>
                                                <div class="card-body text-center">
                                                    <img src="../../assets/images/achievements/40th_entry.png" alt="Achievement Image" class="img-size-50">
                                                </div>
                                                <?php
                                            }
                                            ?>
                                            <p>40th Entry</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <?php
                                            if($countJournal <= 50){
                                                ?>
                                                <div class="card-body text-center">
                                                    <img src="../../assets/images/achievements/locked.png" alt="Achievement Image" class="img-size-50">
                                                </div>
                                                <?php
                                            }else{
                                                ?>
                                                <div class="card-body text-center">
                                                    <img src="../../assets/images/achievements/50th_entry.png" alt="Achievement Image" class="img-size-50">
                                                </div>
                                                <?php
                                            }
                                            ?>
                                            <p>50th Entry</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <?php
                                            if($countJournal <= 60){
                                                ?>
                                                <div class="card-body text-center">
                                                    <img src="../../assets/images/achievements/locked.png" alt="Achievement Image" class="img-size-50">
                                                </div>
                                                <?php
                                            }else{
                                                ?>
                                                <div class="card-body text-center">
                                                    <img src="../../assets/images/achievements/60th_entry.png" alt="Achievement Image" class="img-size-50">
                                                </div>
                                                <?php
                                            }
                                            ?>
                                            <p>60th Entry</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <?php
                                            if($countJournal < 70){
                                                ?>
                                                <div class="card-body text-center">
                                                    <img src="../../assets/images/achievements/locked.png" alt="Achievement Image" class="img-size-50">
                                                </div>
                                                <?php
                                            }else{
                                                ?>
                                                <div class="card-body text-center">
                                                    <img src="../../assets/images/achievements/70th_entry.png" alt="Achievement Image" class="img-size-50">
                                                </div>
                                                <?php
                                            }
                                            ?>
                                            <p>Highest</p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- /.col-12 -->

                    </div>
                    <!-- /.row -->
                </div>
            </section>

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