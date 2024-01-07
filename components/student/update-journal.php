<?php

require('../../includes/config.php');
require('../../includes/db.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['journalID'])) {
    
    $journalID = $_GET['journalID'];
    $status = $_GET['status'];

    $update = $db->prepare("UPDATE journal SET status = :status WHERE journal_id = :journalID");
    $update->bindParam(':status', $status, PDO::PARAM_STR);
    $update->bindParam(':journalID', $journalID, PDO::PARAM_STR);
    $update->execute();


    header('Location: view-journal.php?journalID='.$journalID);
    exit();
}

?>
