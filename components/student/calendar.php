<?php

session_start();

require('../../includes/config.php');
require('../../includes/db.php');
require('../../check-login.php');

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mhj | Calendar</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <link rel="stylesheet" href="../../assets/css/fontawesome-free/css/all.min.css">

    <link rel="stylesheet" href="../../assets/overlayScrollbars/css/OverlayScrollbars.min.css">

    <link rel="stylesheet" href="../../assets/css/adminlte.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css">

    <link rel="stylesheet"  href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">

    <link rel="stylesheet"  href="../../styles.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        
        <?php
        /* Navbar */
        include('../../includes/student-navbar.php');
        /* Sidebar */
        include('../../includes/student-sidebar.php');
        ?>

        ?>
         
         <?php

   if(isset($_POST['submit'])){

      $NameOfEvent = $_POST['NameOfevent'];
      $StartTime = $_POST['StartTime'];
      $StartAMPM = $_POST['StartAMPM'];
      $EndTime = $_POST['EndTime'];
      
      
      $insert = $db->prepare("INSERT INTO event( NameOfEvent, StartTime, EndTime) VALUES(?,?,?)");
      $insert->execute([$NameOfEvent, $StartTime, $EndTime]);
      
      if($insert){
        // Handle success or perform additional actions here
    } else {
        // Handle the case where the insertion failed
        echo "Error inserting data into the database.";
    }
}



?>
     <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-mid-9">
                        <div class="calendar" id="calendar-app">
  <div class="calendar--day-view" id="day-view">
    <span class="day-view-exit" id="day-view-exit">&times;</span>
    <span class="day-view-date" id="day-view-date">MAY 29 2016</span>
    <div class="day-view-content">
      <div class="day-highlight">
        You <span class="day-events" id="day-events">had no events for today</span>. &nbsp; <span tabindex="0" onkeyup="if(event.keyCode != 13) return; this.click();" class="day-events-link" id="add-event" data-date>Add a new event?</span>
      </div>
      <div class="day-add-event" id="add-day-event-box" data-active="false">
        <div class="row">
          <div class="half">  
            <label class="add-event-label">
               Name of event
              <input type="text" class="add-event-edit add-event-edit--long" placeholder="New event"name="NameOfEvent" id="input-add-event-name">
                </label>
          </div>
          <div class="qtr">
            <label class="add-event-label">
          Start Time
              <input type="text" class="add-event-edit" placeholder="8:15"name="StartTime"id="input-add-event-start-time" data-options="1,2,3,4,5,6,7,8,9,10,11,12" data-format="datetime">
              <input type="text" class="add-event-edit" placeholder="am"name="StartAMPM" id="input-add-event-start-ampm" data-options="a,p,am,pm">
            </label>
          </div>
          <div class="qtr">
            <label class="add-event-label">
          End Time
              <input type="text" class="add-event-edit" placeholder="9"name="EndTime" id="input-add-event-end-time" data-options="1,2,3,4,5,6,7,8,9,10,11,12" data-format="datetime">
              <input type="text" class="add-event-edit" placeholder="am"name="StartAMPM" id="input-add-event-end-ampm" data-options="a,p,am,pm">
            </label>
          </div>
          <div class="half">           
            <a onkeyup="if(event.keyCode != 13) return; this.click();" tabindex="0"name="Submit" id="add-event-save" class="event-btn--save event-btn">save</a>
            <a tabindex="0" id="add-event-cancel" class="event-btn--cancel event-btn">cancel</a>
          </div>
        </div>
        
      </div>
      <div id="day-events-list" class="day-events-list">
        
      </div>
      <div class="day-inspiration-quote" id="inspirational-quote">
        Every child is an artist.  The problem is how to remain an artist once he grows up. –Pablo Picasso
      </div>
    </div>
  </div>
  <div class="calendar--view" id="calendar-view">
    <div class="cview__month">
      <span class="cview__month-last" id="calendar-month-last">Apr</span>
      <span class="cview__month-current" id="calendar-month">May</span>
      <span class="cview__month-next" id="calendar-month-next">Jun</span>
    </div>
    <div class="cview__header">Sun</div>
    <div class="cview__header">Mon</div>
    <div class="cview__header">Tue</div>
    <div class="cview__header">Wed</div>
    <div class="cview__header">Thu</div>
    <div class="cview__header">Fri</div>
    <div class="cview__header">Sat</div>
    <div class="calendar--view" id="dates">
    </div>
  </div>
  <div class="footer">
    <span><span id="footer-date" class="footer__link">Today is May 30</span></span>    
  </div>
</div>
        <!-- /.content-wrapper -->
       
        <aside class="control-sidebar control-sidebar-dark">

        </aside>

    </div>

    <script src="../../assets/js/jquery/jquery.min.js"></script>

    <script src="../../assets/js/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="../../assets/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>

    <script src="../../assets/js/adminlte.min.js"></script>

    <script src="../../assets/js/activesidebar.js"></script>

    <script src="../../calendar.js"></script>
   
   

</body>
</html>
