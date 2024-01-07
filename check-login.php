<?php

if(isset($_SESSION['username']) || isset($_SESSION['email'])){
  $userID = $_SESSION['userID'];
  $username = $_SESSION['username'];
  $email = $_SESSION['email'];
  
  $sql = $db->prepare("SELECT * FROM Users WHERE email = :email OR username = :username OR userID = :userID");
  $sql->bindParam(':email', $email, PDO::PARAM_STR);
  $sql->bindParam(':username', $username, PDO::PARAM_STR);
  $sql->bindParam(':userID', $userID, PDO::PARAM_INT);
  $sql->execute();
  $fetch = $sql->fetch(PDO::FETCH_ASSOC);

  $role_perm = $db->prepare("SELECT roleID FROM role_perm WHERE userID = :userID");
  $role_perm->bindParam(':userID', $userID, PDO::PARAM_INT);
  $role_perm->execute();
  $role = $role_perm->fetchColumn();
}else{

  header('location: index.php');
  exit();

}

?>