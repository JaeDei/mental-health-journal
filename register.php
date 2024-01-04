<?php

session_start();

require('includes/config.php');
require('includes/db.php');

if(isset($_POST['submit'])){
    $firstname = $_POST['firstname'];
    $firstname = filter_var($firstname, FILTER_SANITIZE_STRING);
    $lastname = $_POST['lastname'];
    $lastname = filter_var($lastname, FILTER_SANITIZE_STRING);
    $username = $_POST['username'];
    $username = filter_var($username, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $phone_no = $_POST['phone_no'];
    $phone_no = filter_var($phone_no, FILTER_SANITIZE_STRING);
    $password = $_POST['password'];
    $retype_pass = $_POST['retype_pass'];
    $role = $_POST['role'];
    $roleID = $_POST['roleID'];

    $profile_img = $_FILES['profile_img']['name'];
    $profile_img = filter_var($profile_img, FILTER_SANITIZE_STRING);
    $image_size = $_FILES['profile_img']['size'];
    $image_tmp_name = $_FILES['profile_img']['tmp_name'];
    $image_folder = 'assets/profile_img/'.$profile_img;

    $select_username = $db->prepare("SELECT * FROM Users WHERE username = ?");
    $select_username->execute([$username]);
    
    $select_email = $db->prepare("SELECT * FROM Users WHERE email = ?");
    $select_email->execute([$email]);

    if($select_username->rowCount() > 0){
        
        $message[] = 'Username already exist!';
    
    }elseif($select_email->rowCount() > 0){
        
        $message[] = 'Email already exist!';
    
    }elseif(!preg_match("/^[a-zA-Z ]+$/", $firstname)){

        $message[] = 'First Name must contain only alphabets and space!';

    }elseif(!preg_match("/^[a-zA-Z ]+$/", $lastname)){

        $message[] = 'Last Name must contain only alphabets and space!';

    }elseif($image_size > 2000000000){

        $message[] = 'Image size too large!';

    }else{
        
        if($password != $retype_pass){
            
            $message[] = 'Password not match!';
        
        }elseif(strlen($_POST['password']) < 8){

            $message[] = 'Password must be 8 characters!';
    
        }else{

            $hashpass = password_hash($password, PASSWORD_BCRYPT);

            $insert = $db->prepare("INSERT INTO Users(firstname, lastname, username, email, phone_no, password, profile_pic, role) VALUES(?,?,?,?,?,?,?,?)");
            $insert->execute([$firstname, $lastname, $username, $email, $phone_no, $hashpass, $profile_img, $role]);
            
            if($insert){

                move_uploaded_file($image_tmp_name, $image_folder);

                $userID = $db->lastInsertId();
                $insert_role_perm = $db->prepare("INSERT INTO role_perm(userID, roleID) VALUES(?, ?)");
                $insert_role_perm->execute([$userID, $roleID]);
                
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
                                window.location.href = 'login.php';
                            }
                        });
                    });
                </script>";
                <?php
            
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <link rel="stylesheet" href="assets/css/fontawesome-free/css/all.min.css">

    <link rel="stylesheet" href="assets/css/icheck-bootstrap/icheck-bootstrap.min.css">

    <link rel="stylesheet" href="assets/sweetalert2/dist/sweetalert2.min.css">

    <link rel="stylesheet" href="assets/css/adminlte.min.css">
    
</head>
<body class="hold-transition register-page">

    <div class="register-box">
        <div class="register-logo">
            <a><b>mhj.com</b></a>
        </div>

        <div class="card">
            <div class="card-body register-card-body">
                <p class="login-box-msg">Register a new account</p>

                <?php
                if(isset($message)){
                    foreach($message as $message){
                        echo '<div class="message"><span>'.$message.'</span></div>';
                    }
                }
                ?>

                <form action="" method="post" enctype="multipart/form-data">
                    <div class="input-group mb-3">
                        <input type="text" name="firstname" class="form-control" placeholder="First Name" required/>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" name="lastname" class="form-control" placeholder="Last Name" required/>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" name="username" class="form-control" placeholder="Username" required/>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Email" required/>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="number" name="phone_no" class="form-control" placeholder="Phone Number" required/>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-phone"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password" required/>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="retype_pass" class="form-control" placeholder="Retype password" required/>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <label for="profile_img">Profile Picture</label>
                        <input type="file" id="profile_img" name="profile_img" accept="image/jpg, image/jpeg, image/png, image/webp" class="box" required>
                    </div>
                    <div class="input-group mb-3">
                        <select id="roletype" name="roletype" required>
                            <option selected disabled>Select User Role</option>
                            <?php
                            $ret = $db->query("SELECT * FROM Roles");
                            foreach($ret as $row){
                                ?>
                                <option value="<?php echo $row['roleID'];?>" name="roleID"><?php echo $row['role'];?></option>
                            <?php
                            }
                            ?>
                        </select>
                        <input type="hidden" name="roleID" id="roleID" value="">
                        <input type="hidden" name="role" id="role" value="">
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="agreeTerms" name="terms" value="agree">
                                <label for="agreeTerms">
                                    I agree to the <a href="#">terms</a>
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" name="submit" class="btn btn-primary btn-block">Register</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <div class="social-auth-links text-center">
                    <p>- OR -</p>
                    <a href="#" class="btn btn-block btn-primary">
                        <i class="fab fa-facebook mr-2"></i>
                        Sign up using Facebook
                    </a>
                    <a href="#" class="btn btn-block btn-danger">
                        <i class="fab fa-google-plus mr-2"></i>
                        Sign up using Google+
                    </a>
                </div>

                <a href="login.php" class="text-center">I already have an account</a>
            </div>
            <!-- /.form-box -->
        </div><!-- /.card -->
    </div>

    <script src="assets/js/jquery/jquery.min.js"></script>

    <script src="assets/js/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="assets/sweetalert2/dist/sweetalert2.all.min.js"></script>

    <script src="assets/js/adminlte.min.js"></script>

    <script type="text/javascript">
        document.getElementById('roletype').addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];
            document.getElementById('roleID').value = selectedOption.value;
            document.getElementById('role').value = selectedOption.text;
        });
    </script>
    
</body>
</html>