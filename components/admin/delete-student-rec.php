<?php

require('../../includes/config.php');
require('../../includes/db.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['studentID'])) {
    $studentID = $_GET['studentID'];

    $delete_role = $db->prepare("DELETE FROM role_perm WHERE userID = $studentID");
    $delete_role->execute();

    $delete_loginAch = $db->prepare("DELETE FROM loginAchievement WHERE userID = $studentID");
    $delete_loginAch->execute();

    $delete_journal = $db->prepare("DELETE FROM journal WHERE userID = $studentID");
    $delete_journal->execute();

    $delete_user = $db->prepare("DELETE FROM Users WHERE userID = $studentID");
    $delete_user->execute();

    header('Location: student-lists.php');
    exit();
}

?>