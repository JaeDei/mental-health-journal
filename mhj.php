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

    $firstname = $fetch['firstname'];

    if($select->rowCount() < 1){
        $achievement = $db->prepare("INSERT INTO loginAchievement(userID) VALUES(?)");
        $achievement->execute([$fetch['userID']]);

        echo"
            <script type='text/javascript'>
                document.addEventListener('DOMContentLoaded', function(){
                    Swal.fire({
                        title: 'Congratulation!, Student $firstname',
                        text: 'Achievement Unlocked: First Login!',
                        imageUrl: 'assets/images/achievements/first_login.png',
                        imageWidth: 200,
                        imageHeight: 200,
                        imageAlt: 'Custom image'
                    });
                });
            </script>";
    }else{
        if (!isset($_SESSION['user']) || $_SESSION['user'] !== true) {

            echo"
                <script type='text/javascript'>
                    document.addEventListener('DOMContentLoaded', function(){
                        Swal.fire('Welcome Back!, Student $firstname');
                    });
                </script>";
            
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
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <!-- PIE CHART -->
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Mood Chart</h3>
                                </div>
                                <div class="card-body">
                                    <canvas id="pieChart" style="min-height: 250px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>
                                    <?php
                                    $pie = $db->prepare("SELECT mood, description FROM mood JOIN journal ON mood.moodID = journal.moodID WHERE userID = $userID");
                                    $pie->execute();
                                    $data = $pie->fetchAll(PDO::FETCH_ASSOC);

                                    $moods = array_count_values(array_column($data, 'mood'));
                                    $descriptions = array_column($data, 'description');
                                    $totalCount = array_sum($moods);

                                    $mood = array_map('html_entity_decode', array_keys($moods));
                                    $description = array_values($descriptions);
                                    
                                    $count = array_values($moods);

                                    $percentage = array_map(function ($count) use ($totalCount) {
                                        $percent = round(($count / $totalCount) * 100, 2);
                                        return $percent;
                                    }, $count);

                                    $data = [
                                        'labels' => $mood,
                                        'datasets' => [
                                            [
                                            'data' => $percentage,
                                            'backgroundColor' => ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#e4d6de', '#d2d6de'],
                                            ],
                                        ],
                                    ];
                                    
                                    $pieData = json_encode($data);

                                    ?>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                </div>
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

    <script src="assets/js/chart.js/Chart.min.js"></script>

    <script src="assets/js/activesidebar.js"></script>

    <script>
        $(function () {
            var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
            var pieData        = <?= $pieData ?>;
            var pieOptions = {
                maintainAspectRatio : false,
                responsive : true,
                tooltips: {
                    callbacks: {
                        label: function (tooltipItem, data) {
                            var dataset = data.datasets[tooltipItem.datasetIndex];
                            var percent = dataset.data[tooltipItem.index];
                            var label = data.labels[tooltipItem.index];
                            return label + ' : ' + percent + '%';
                        }
                    }
                },
            }
            new Chart(pieChartCanvas, {
                type: 'pie',
                data: pieData,
                options: pieOptions
            });
        });
    </script>

</body>
</html>