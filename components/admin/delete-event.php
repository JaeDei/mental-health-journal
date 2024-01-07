<?php

require('../../includes/config.php');
require('../../includes/db.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['eventID'])) {
    $eventID = $_GET['eventID'];

    $delete_event = $db->prepare("DELETE FROM events WHERE eventID = :eventID");
    $delete_event->bindParam(':eventID', $eventID, PDO::PARAM_INT);
    $deleted = $delete_event->execute();

    header('Location: events.php');
    exit();

}

?>
