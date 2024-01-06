<?php

require('includes/config.php');
require('includes/db.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['journalID'])) {
    
    $journalID = $_GET['journalID'];
    $status = $_GET['status'];

    $update = $db->prepare("UPDATE journal SET status = ? WHERE journal_id = ?");
    $update->execute([$status, $journalID]);


    header('Location: view-journal.php?journalID='.$journalID);
    exit();
}

?>
