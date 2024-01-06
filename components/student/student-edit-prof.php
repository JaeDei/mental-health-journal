<?php

session_start();

require('../../includes/config.php');
require('../../includes/db.php');
require('../../check-login.php');

if($role != 2){
    unset($_SESSION);
    header('location: ../../unauthorized.php');
}else{
    if(isset($_POST['submit'])){
        $userID = $_GET['userID'];
        $firstname = $_POST['firstname'];
        $firstname = filter_var($firstname, FILTER_SANITIZE_STRING);
        $lastname = $_POST['lastname'];
        $lastname = filter_var($lastname, FILTER_SANITIZE_STRING);
        $username = $_POST['username'];
        $email = $_POST['email'];
        $phone_no = $_POST['phone_no'];
        $phone_no = filter_var($phone_no, FILTER_SANITIZE_STRING);

        $old_prof_pic = $_POST['old_prof_pic'];
        $new_prof_pic = $_FILES['new_prof_pic']['name'];
        $new_prof_pic = filter_var($new_prof_pic, FILTER_SANITIZE_STRING);
        $new_prof_size = $_FILES['new_prof_pic']['size'];
        $new_prof_tmp_name = $_FILES['new_prof_pic']['tmp_name'];
        $new_prof_folder = '../../assets/profile_img/'.$new_prof_pic;

        if(!preg_match("/^[a-zA-Z ]+$/", $firstname)){

            $message[] = 'First Name must contain only alphabets and space!';

        }elseif(!preg_match("/^[a-zA-Z ]+$/", $lastname)){

            $message[] = 'Last Name must contain only alphabets and space!';

        }elseif($new_prof_size > 2000000000){

            $message[] = 'Image size too large!';

        }else{

            $update_prof = $db->prepare("UPDATE Users SET firstname = :firstname, lastname = :lastname, username = :username, email = :email, phone_no = :phone_no, profile_pic = :new_prof_pic WHERE userID = :userID");
            $update_prof->bindParam(':firstname', $firstname, PDO::PARAM_STR);
            $update_prof->bindParam(':lastname', $lastname, PDO::PARAM_STR);
            $update_prof->bindParam(':username', $username, PDO::PARAM_STR);
            $update_prof->bindParam(':email', $email, PDO::PARAM_STR);
            $update_prof->bindParam(':phone_no', $phone_no, PDO::PARAM_INT);
            $update_prof->bindParam(':new_prof_pic', $new_prof_pic, PDO::PARAM_STR);
            $update_prof->bindParam(':userID', $userID, PDO::PARAM_INT);
            $update_prof->execute();

            move_uploaded_file($new_prof_tmp_name, $new_prof_folder);
            
            $old_prof_folder = '../../assets/profile_img/'.$old_prof_pic;
            if(file_exists($old_prof_folder)){
                unlink($old_prof_folder);
            }
            
            echo"
                <script type='text/javascript'>
                    document.addEventListener('DOMContentLoaded', function(){
                        Swal.fire({
                            title: 'Update Profile Completed!',
                            text: 'Go back to Profile',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result)=>{
                            if(result.isConfirmed){
                                window.location.href = 'student-profile.php';
                            }
                        });
                    });
                </script>";

        }

    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mhj | Edit Profile</title>

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
                            <h1>Edit Profile</h1>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="card">
                                <div class="card-body">
                                    <div class="tab-content">
                                        <?php
                                        if(isset($message)){
                                            foreach($message as $message){
                                                echo '<div class="message"><span>'.$message.'</span></div>';
                                            }
                                        }
                                        ?>
                                        <form class="form-horizontal" method="post" enctype="multipart/form-data">
                                            <div class="form-group row">
                                                <label for="firstname" class="col-sm-2 col-form-label">First Name</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="firstname" name="firstname" value="<?php echo $fetch['firstname'];?>">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="lastname" class="col-sm-2 col-form-label">Last Name</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo $fetch['lastname'];?>">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="username" class="col-sm-2 col-form-label">Username</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="username" name="username" value="<?php echo $fetch['username'];?>">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="email" class="col-sm-2 col-form-label">Email</label>
                                                <div class="col-sm-10">
                                                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $fetch['email'];?>">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="phone_no" class="col-sm-2 col-form-label">Phone Number</label>
                                                <div class="col-sm-10">
                                                    <input type="number" class="form-control" id="phone_no" name="phone_no" value="<?php echo $fetch['phone_no'];?>">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="new_prof_pic" class="col-sm-2 col-form-label">New Profile Picture</label>
                                                <div class="col-sm-10">
                                                <input type="file" id="new_prof_pic" name="new_prof_pic" accept="image/jpg, image/jpeg, image/png, image/webp" class="box">
                                                <input type="hidden" name="old_prof_pic" value="<?php echo $fetch['profile_pic'];?>">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="offset-sm-2 col-sm-10">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox"> I agree to the <a href="#">terms and conditions</a>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="offset-sm-2 col-sm-10">
                                                    <button type="submit" name="submit" class="btn btn-danger">Submit</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- /.tab-pane -->
                                </div>
                                <!-- /.tab-content -->
                            </div><!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
            </section>
        
        </div>
    </div>

    <script src="../../assets/js/jquery/jquery.min.js"></script>

    <script src="../../assets/js/bootstrap/js//bootstrap.bundle.min.js"></script>

    <script src="../../assets/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>

    <script src="../../assets/sweetalert2/dist/sweetalert2.all.min.js"></script>

    <script src="../../assets/js/adminlte.min.js"></script>
    
</body>
</html>