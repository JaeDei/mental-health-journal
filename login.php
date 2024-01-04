<?php

session_start();

require('includes/config.php');
require('includes/db.php');

if(isset($_POST['submit'])){

    $user = $_POST['user'];
    $user = filter_var($user, FILTER_SANITIZE_STRING);
    $password = $_POST['password'];

    $select = $db->prepare("SELECT * FROM Users WHERE email = ? OR username = ?");
    $select->execute([$user, $user]);
    $user_rec = $select->fetch(PDO::FETCH_ASSOC);

    if($user_rec && password_verify($password, $user_rec['password'])){

        $_SESSION['userID'] = $user_rec['userID'];
        $_SESSION['username'] = $user_rec['username'];
        $_SESSION['email'] = $user_rec['email'];

        if($_SESSION['userID'] && $_SESSION['username'] && $_SESSION['email']){
            $select_perm = $db->prepare("SELECT roleID FROM role_perm WHERE userID = ?");
            $select_perm->execute([$user_rec['userID']]);
            $role_perm = $select_perm->fetchColumn();

            if($role_perm == 1){
                header('location: admin-mhj.php');
                exit();
            }elseif($role_perm == 2){
                header('location: mhj.php');
                exit();
            }else{
                $message[] = 'Role not found!';
            }
        }else{
            $message[] = 'User not found!';
        }
    }else{
        $message[] = 'Incorrect Email or Username or Password!';
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <link rel="stylesheet" href="assets/css/fontawesome-free/css/all.min.css">

    <link rel="stylesheet" href="assets/css/icheck-bootstrap/icheck-bootstrap.min.css">

    <link rel="stylesheet" href="assets/css/adminlte.min.css">

</head>
<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a><b>mhj.com</b></a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Login to start</p>

                <?php
                if(isset($message)){
                    foreach($message as $message){
                        echo '<div class="message"><span>'.$message.'</span></div>';
                    }
                }
                ?>

                <form action="#" method="post">
                    <div class="input-group mb-3">
                        <input type="text" name="user" class="form-control" placeholder="Email or Username" required/>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
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
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember">
                                <label for="remember">
                                    Remember Me
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" name="submit" class="btn btn-primary btn-block">Login</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <div class="social-auth-links text-center mb-3">
                    <p>- OR -</p>
                    <a href="#" class="btn btn-block btn-primary">
                        <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
                    </a>
                    <a href="#" class="btn btn-block btn-danger">
                        <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
                    </a>
                </div>
                <!-- /.social-auth-links -->

                <p class="mb-1">
                    <a href="#">I forgot my password</a>
                </p>
                <p class="mb-0">
                    <a href="register.php" class="text-center">Register a new account</a>
                </p>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>

    <script src="assets/js/jquery/jquery.min.js"></script>

    <script src="assets/js/bootstrap/js//bootstrap.bundle.min.js"></script>

    <script src="assets/js/adminlte.min.js"></script>
    
</body>
</html>