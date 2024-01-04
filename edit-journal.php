<?php

include 'includes/db.php';

session_start();

$userID = $_SESSION['userID'];

if(!isset($userID)){
   header('location:login.php');
}

if(isset($_POST['save'])){

   $post_id = $_GET['id'];
   $title = $_POST['title'];
   $title = filter_var($title, FILTER_SANITIZE_STRING);
   $content = $_POST['content'];
   $content = filter_var($content, FILTER_SANITIZE_STRING);
   $category = $_POST['mood'];
   $category = filter_var($category, FILTER_SANITIZE_STRING);
   $status = $_POST['status'];
   $status = filter_var($status, FILTER_SANITIZE_STRING);

   $update_post = $db->prepare("UPDATE posts SET title = ?, content = ?, mood = ?, status = ? WHERE post_id = ?");
   $update_post->execute([$title, $content, $category, $status, $post_id]);

   $message[] = 'post updated!';
   
   $old_image = $_POST['old_image'];
   $image = $_FILES['image']['name'];
   $image = filter_var($image, FILTER_SANITIZE_STRING);
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'assets/profile_img/'.$image;

   $select_image = $db->prepare("SELECT * FROM `posts` WHERE image = ? AND userID = ?");
   $select_image->execute([$image, $userID]);

   if(!empty($image)){
      if($image_size > 2000000){
         $message[] = 'images size is too large!';
      }elseif($select_image->rowCount() > 0 AND $image != ''){
         $message[] = 'please rename your image!';
      }else{
         $update_image = $db->prepare("UPDATE `posts` SET image = ? WHERE post_id = ?");
         move_uploaded_file($image_tmp_name, $image_folder);
         $update_image->execute([$image, $post_id]);
         if($old_image != $image AND $old_image != ''){
            unlink('assets/profile_img/'.$old_image);
         } 
         $message[] = 'image updated!';
      }
   }

   
}

if(isset($_POST['delete_post'])){

   $post_id = $_POST['post_id'];
   $post_id = filter_var($post_id, FILTER_SANITIZE_STRING);
   $delete_image = $db->prepare("SELECT * FROM posts WHERE post_id = ?");
   $delete_image->execute([$post_id]);
   $fetch_delete_image = $delete_image->fetch(PDO::FETCH_ASSOC);
   if($fetch_delete_image['image'] != ''){
      unlink('assets/profile_img/'.$fetch_delete_image['image']);
   }
   $delete_post = $db->prepare("DELETE FROM `posts` WHERE post_id = ?");
   $delete_post->execute([$post_id]);
   $delete_comments = $db->prepare("DELETE FROM `comments` WHERE post_id = ?");
   $delete_comments->execute([$post_id]);
   $message[] = 'post deleted successfully!';

}

if(isset($_POST['delete_image'])){

   $empty_image = '';
   $post_id = $_POST['post_id'];
   $post_id = filter_var($post_id, FILTER_SANITIZE_STRING);
   $delete_image = $db->prepare("SELECT * FROM `posts` WHERE post_id = ?");
   $delete_image->execute([$post_id]);
   $fetch_delete_image = $delete_image->fetch(PDO::FETCH_ASSOC);
   if($fetch_delete_image['image'] != ''){
      unlink('assets/profile_img/'.$fetch_delete_image['image']);
   }
   $unset_image = $db->prepare("UPDATE `posts` SET image = ? WHERE post_id = ?");
   $unset_image->execute([$empty_image, $post_id]);
   $message[] = 'image deleted successfully!';

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>posts</title>

   <!-- font awesome cdn link  -->

</head>
<body>


<section class="post-editor">

   <h1 class="heading">edit your Journal</h1>

   <?php
      $post_id = $_GET['id'];
      $select_posts = $db->prepare("SELECT * FROM posts WHERE post_id = ?");
      $select_posts->execute([$post_id]);
      if($select_posts->rowCount() > 0){
         while($fetch_posts = $select_posts->fetch(PDO::FETCH_ASSOC)){
   ?>
   <form action="" method="post" enctype="multipart/form-data">
      <input type="hidden" name="old_image" value="<?= $fetch_posts['image']; ?>">
      <input type="hidden" name="post_id" value="<?= $fetch_posts['post_id']; ?>">
      <p>post status <span>*</span></p>
      <select name="status" class="box" required>
         <option value="<?= $fetch_posts['status']; ?>" selected><?= $fetch_posts['status']; ?></option>
         <option value="shared">shared</option>
         <option value="private">private</option>
      </select>
      <p>post title <span>*</span></p>
      <input type="text" name="title" maxlength="100" required placeholder="add post title" class="box" value="<?= $fetch_posts['title']; ?>">
      <p>post content <span>*</span></p>
      <textarea name="content" class="box" required maxlength="10000" placeholder="write your content..." cols="30" rows="10"><?= $fetch_posts['content']; ?></textarea>
      <p>your mood <span>*</span></p>
      <select name="mood" class="box" required>
         <option value="<?= $fetch_posts['mood']; ?>" selected><?= $fetch_posts['mood']; ?></option>
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
      <?php if($fetch_posts['image'] != ''){ ?>
         <img src="assets/profile_img/<?= $fetch_posts['image']; ?>" class="image" alt="">
         <input type="submit" value="delete image" class="inline-delete-btn" name="delete_image">
      <?php } ?>
      <div class="flex-btn">
         <input type="submit" value="save post" name="save" class="btn">
         <a href="view-journal.php" class="option-btn">go back</a>
         <input type="submit" value="delete post" class="delete-btn" name="delete_post">
      </div>
   </form>

   <?php
         }
      }else{
         echo '<p class="empty">no posts found!</p>';
   ?>
   <div class="flex-btn">
      <a href="view-journal.php" class="option-btn">view Journal</a>
      <a href="create-journal.php" class="option-btn">add Journal</a>
   </div>
   <?php
      }
   ?>

</section>












</body>
</html>