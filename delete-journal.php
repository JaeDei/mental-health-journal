<?php

require('includes/config.php');
require('includes/db.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['journalID'])) {
    $journalID = $_GET['journalID'];

    $delete_post = $db->prepare("DELETE FROM journal WHERE journal_id = ?");
    $delete_post->execute([$journalID]);


    header('Location: journal.php');
    exit();
}

?>
