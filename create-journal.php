<?php

include 'includes/db.php';

session_start();

$userID = $_SESSION['userID'];

if(!isset($userID)){
   header('location:login.php');
}

if(isset($_POST['publish'])){

   $title = $_POST['title'];
   $title = filter_var($title, FILTER_SANITIZE_STRING);
   $content = $_POST['content'];
   $content = filter_var($content, FILTER_SANITIZE_STRING);
   $category = $_POST['mood'];
   $category = filter_var($category, FILTER_SANITIZE_STRING);
   $status = 'shared';
   
   $image = $_FILES['image']['name'];
   $image = filter_var($image, FILTER_SANITIZE_STRING);
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'assets/profile_img/'.$image;

   $select_image = $db->prepare("SELECT * FROM posts WHERE image = ? AND userID = ? ");
   $select_image->execute([$image, $userID]);

   if(isset($image)){
      if($select_image->rowCount() > 0 AND $image != ''){
         $message[] = 'image name repeated!';
      }elseif($image_size > 2000000){
         $message[] = 'images size is too large!';
      }else{
         move_uploaded_file($image_tmp_name, $image_folder);
      }
   }else{
      $image = '';
   }

   if($select_image->rowCount() > 0 AND $image != ''){
      $message[] = 'please rename your image!';
   }else{
      $insert_post = $db->prepare("INSERT INTO posts (userID, title, content, mood, image, status) VALUES(?,?,?,?,?,?)");
      $insert_post->execute([$userID, $title, $content, $category, $image, $status]);
      $message[] = 'post published!';
   }
   
}

if(isset($_POST['draft'])){


   $title = $_POST['title'];
   $title = filter_var($title, FILTER_SANITIZE_STRING);
   $content = $_POST['content'];
   $content = filter_var($content, FILTER_SANITIZE_STRING);
   $category = $_POST['mood'];
   $category = filter_var($category, FILTER_SANITIZE_STRING);
   $status = 'private';
   
   $image = $_FILES['image']['name'];
   $image = filter_var($image, FILTER_SANITIZE_STRING);
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'assets/profile_img/'.$image;

   $select_image = $db->prepare("SELECT * FROM `posts` WHERE image = ? AND userID = ?");
   $select_image->execute([$image, $userID]); 

   if(isset($image)){
      if($select_image->rowCount() > 0 AND $image != ''){
         $message[] = 'image name repeated!';
      }elseif($image_size > 2000000){
         $message[] = 'images size is too large!';
      }else{
         move_uploaded_file($image_tmp_name, $image_folder);
      }
   }else{
      $image = '';
   }

   if($select_image->rowCount() > 0 AND $image != ''){
      $message[] = 'please rename your image!';
   }else{
      $insert_post = $db->prepare("INSERT INTO `posts`(userID, title, content, mood, image, status) VALUES(?,?,?,?,?,?)");
      $insert_post->execute([$userID, $title, $content, $category, $image, $status]);
      $message[] = 'draft saved!';
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
                            <h1>Daily Journal </h1>
<form action="" method="post" enctype="multipart/form-data">
      <p>Journal title <span>*</span></p>
      <input type="text" name="title" maxlength="100" required placeholder="add post title" class="box">
      <p>post content <span>*</span></p>
      <textarea name="content" class="box" required maxlength="10000" placeholder="write your content..." cols="30" rows="10"></textarea>
      <p>post Mood <span>*</span></p>
      <select name="mood" class="box" required>
         <option value="" selected disabled>-- select Mood* </option>
         <option value="excited">excited &#128513;;</option>
         <option value="sad">sad  &#129402;</option>
         <option value="angry">angry &#128544;</option>
         <option value="sick">sick &#128567;</option>
         <option value="suprised">suprised  &#128558;</option>
         <option value="happy">happy  &#128522;</option>
         <option value="Bored">Bored  &#129393;</option>
      </select>
      <p>post image</p>
      <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png, image/webp">
      <div class="flex-btn">
         <input type="submit" value="Shared" name="publish" class="option-btn">
         <input type="submit" value="Private" name="draft" class="option-btn">
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

    <script src="assets/js/activesidebar.js"></script>

    <script src="assets/sweetalert2/dist/sweetalert2.all.min.js"></script>

</body>
</html>