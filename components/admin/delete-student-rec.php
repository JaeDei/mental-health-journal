<?php

require('includes/config.php');
require('includes/db.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['studentID'])) {
    $studentID = $_GET['studentID'];

    $delete_rec = $db->prepare("DELETE FROM Users WHERE userID = ?");
    $delete_rec->execute([$studentID]);

    header('Location: students-list.php');
    exit();
}

?>