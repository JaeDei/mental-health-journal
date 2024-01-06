<?php

session_start();

require('../../includes/config.php');
require('../../includes/db.php');
require('../../check-login.php');

if($role != 1){
    unset($_SESSION);
    header('location: ../../unauthorized.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mhj | Admin-Students List</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <link rel="stylesheet" href="../../assets/css/fontawesome-free/css/all.min.css">

    <link rel="stylesheet" href="../../assets/css/adminlte.min.css">

    <link rel="stylesheet" href="../../assets/overlayScrollbars/css/OverlayScrollbars.min.css">

    <link href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" rel="stylesheet" />

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
                            <h1>Students List</h1>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <section class="content">
                <div class="container-fluid">
                  <div class="row">
                    <div class="col-12">
                      <div class="card text-center">
                        <div class="card-header">
                          <h3 class="card-title">List</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                          <table id="dataTable" class="table table-bordered table-hover text-center">
                            <thead>
                              <tr>
                                <th>User ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Username</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                              $queries = $db->query("SELECT * FROM Users WHERE role = 'Student'");
                              foreach($queries as $query){
                                ?>
                                <tr class="clickable-row" data-href="view-journal.php?journalID=<?php echo $query['userID'];?>">
                                  <td><?php echo $query['userID'];?></td>
                                  <td><?php echo $query['firstname'];?></td>
                                  <td><?php echo $query['lastname'];?></td>
                                  <td><?php echo $query['username'];?></td>
                                </tr>
                                <?php
                              }
                              ?>
                            </tbody>
                          </table>
                        </div>
                        <!-- /.card-body -->
                      </div>
                      </div>
                    <!-- /.col -->
                  </div>
                  <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
              </section>
            </div>
            <!-- /.content-wrapper -->
    
            <aside class="control-sidebar control-sidebar-dark">

            </aside>

    </div>

    <script src="../../assets/js/jquery/jquery.min.js"></script>

    <script src="../../assets/js/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="../../assets/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>

    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="../../assets/js/datatable.js"></script>

    <script src="../../assets/js/adminlte.min.js"></script>

    <script src="../../assets/js/activesidebar.js"></script>

</body>
</html>