<?php

include 'includes/db.php';
session_start();
$userID = $_SESSION['userID'];

if(!isset($userID)){
   header('location:login.php');
}

if(isset($_POST['delete'])){

   $p_id = $_POST['post_id'];
   $p_id = filter_var($p_id, FILTER_SANITIZE_STRING);
   $delete_image = $db->prepare("SELECT * FROM `posts` WHERE post_id = ?");
   $delete_image->execute([$p_id]);
   $fetch_delete_image = $delete_image->fetch(PDO::FETCH_ASSOC);
   if($fetch_delete_image['image'] != ''){
      unlink('assets/profile_img/'.$fetch_delete_image['image']);
   }
   $delete_post = $db->prepare("DELETE FROM `posts` WHERE post_id = ?");
   $delete_post->execute([$p_id]);
   $delete_comments = $db->prepare("DELETE FROM `comments` WHERE post_id = ?");
   $delete_comments->execute([$p_id]);
   $message[] = 'post deleted successfully!';

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
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>


<section class="show-posts">

   <h1 class="heading">your Journal</h1>

   <div class="box-container">

      <?php
         $select_posts = $db->prepare("SELECT * FROM `posts` WHERE userID = ?");
         $select_posts->execute([$userID]);
         if($select_posts->rowCount() > 0){
            while($fetch_posts = $select_posts->fetch(PDO::FETCH_ASSOC)){
               $post_id = $fetch_posts['post_id'];

               $count_post_comments = $db->prepare("SELECT * FROM `comments` WHERE post_id = ?");
               $count_post_comments->execute([$post_id]);
               $total_post_comments = $count_post_comments->rowCount();


      ?>
      <form method="post" class="box">
         <input type="hidden" name="post_id" value="<?= $post_id; ?>">
         <?php if($fetch_posts['image'] != ''){ ?>
            <img src="assets/profile_img/<?= $fetch_posts['image']; ?>" class="image" alt="">
         <?php } ?>
         <div class="status" style="background-color:<?php if($fetch_posts['status'] == 'active'){echo 'limegreen'; }else{echo 'coral';}; ?>;"><?= $fetch_posts['status']; ?></div>
            <div class="title"><?= $fetch_posts['title']; ?></div>
         <div class="posts-content"><?= $fetch_posts['content']; ?></div>
         <div class="icons">

            <div class="comments"><i class="fas fa-comment"></i><span><?= $total_post_comments; ?></span></div>
         </div>
         <div class="flex-btn">
            <a href="edit-journal.php?id=<?= $post_id; ?>" class="option-btn">edit</a>
            <button type="submit" name="delete" class="delete-btn" onclick="return confirm('delete this post?');">delete</button>
         </div>
         <a href="read_post.php?post_id=<?= $post_id; ?>" class="btn">view post</a>
      </form>
      <?php
            }
         }else{
            echo '<p class="empty">no posts added yet! <a href="create-journal.php" class="btn" style="margin-top:1.5rem;">add post</a></p>';
         }
      ?>

   </div>


</section>










</body>
</html>