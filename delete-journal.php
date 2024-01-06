<?php

require('includes/config.php');
require('includes/db.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['journalID']) && isset($_GET['role'])) {
    $journalID = $_GET['journalID'];
    $role = $_GET['role'];

    $delete_post = $db->prepare("DELETE FROM journal WHERE journal_id = ?");
    $deleted = $delete_post->execute([$journalID]);

    if($deleted){
        if($role == 1){
            header('Location: components/admin/journal-entries.php');
            exit();
        }else{
            header('Location: components/student/journal.php');
            exit();
        }
    }else{
        echo "Failed to delete!";
    }
}

?>