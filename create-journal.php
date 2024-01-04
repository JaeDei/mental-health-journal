<?php

session_start();

require('includes/config.php');
require('includes/db.php');
require('check-login.php');

if($role != 2){
   unset($_SESSION);
   header('location: unauthorized.php');
}else{
   
   if(isset($_POST['submit'])){

      $userID = $_GET['userID'];
      $title = $_POST['title'];
      $content = $_POST['content'];
      $moodID = $_POST['mood'];
      $thought = $_POST['thought'];
      $status = 'private';
      
      $insert = $db->prepare("INSERT INTO `posts`(userID, title, content, moodID, thought, status) VALUES(?,?,?,?,?,?)");
      $insert->execute([$userID, $title, $content, $moodID, $thought, $status]);
      
      if($insert){

         ?>
                <script type='text/javascript'>
                    document.addEventListener("DOMContentLoaded", function(){
                        Swal.fire({
                            title: 'Register Completed!',
                            text: 'Go to Login',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result)=>{
                            if(result.isConfirmed){
                                window.location.href = '#';
                            }
                        });
                    });
                </script>";
                <?php

      }

   }

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mhj | Create Journal</title>

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
                            <h1>Create Daily Journal</h1>
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
                           <h3 class="card-title">Journal Entry</h3>
                        </div>
                        <div class="card-body">
                           <form action="" method="post">
                              <div class="form-group">
                                 <label for="title">Title</label>
                                 <input type="text" id="title" name="title" class="form-control" required/>
                              </div>
                              <div class="form-group">
                                 <label for="content">Content</label>
                                 <textarea id="content" name="content" class="form-control" rows="4" required></textarea>
                              </div>
                              <div class="form-group">
                                 <label for="mood">Mood</label>
                                 <select id="mood" name="mood" class="form-control custom-select" required>
                                    <option value="" selected disabled>Select Mood</option>
                                    <?php
                                    $queries = $db->query("SELECT * FROM mood");
                                    foreach($queries as $query){
                                       ?>
                                       <option value="<?php echo $query['moodID'];?>"><?php echo $query['description'];?> <?php echo $query['mood'];?></option>
                                       <?php
                                    }
                                    ?>
                                 </select>
                              </div>
                              <div class="form-group">
                                 <label for="thought">What are your thoughts or feelings?</label>
                                 <textarea id="thought" name="thought" class="form-control" rows="4" required></textarea>
                              </div>
                              <div class="form-group row">
                                 <div class="offset-sm-0 col-sm-10">
                                    <input type="submit" name="submit" value="Create new Journal" class="btn btn-success">
                                 </div>
                              </div>
                           </form>
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

    <script src="assets/js/jquery/jquery.min.js"></script>

    <script src="assets/js/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="assets/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>

    <script src="assets/js/adminlte.min.js"></script>

    <script src="assets/js/activesidebar.js"></script>

    <script src="assets/sweetalert2/dist/sweetalert2.all.min.js"></script>

</body>
</html>