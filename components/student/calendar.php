<?php

session_start();

require('../../includes/config.php');
require('../../includes/db.php');
require('../../check-login.php');

if($role != 2){
  unset($_SESSION);
  header('location: ../../unauthorized.php');
}

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

</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        
      <?php
      /* Navbar */
      include('../../includes/student-navbar.php');
      /* Sidebar */
      include('../../includes/student-sidebar.php');
      ?>
     <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <section class="content-header">
              <div class="container-fluid">
                  <?php
                  $userID = $fetch['userID'];
                  $view_journal = $db->prepare("SELECT journal_id FROM journal WHERE userID = $userID");
                  $view_journal->execute();
                  $view = $view_journal->fetch(PDO::FETCH_ASSOC);
                  ?>
                  <div id="calendar"></div>
              </div>
          </section>
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

    <script src="../../assets/fullcalendar-6.1.10/fullcalendar-6.1.10/dist/index.global.js"></script>

    <script>
      document.addEventListener('DOMContentLoaded', function(){
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
          headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
          },
          initialDate: '2023-01-12',
          navLinks: true, // can click day/week names to navigate views
          selectable: true,
          selectMirror: true,
          eventClick: function(arg) {
            if (confirm('View journal entry?')) {
              window.location.href = 'view-journal.php?journalID=<?php echo $view['journal_id'];?>';
            }
          },
          editable: true,
          dayMaxEvents: true, // allow "more" link when too many events
          events: [
            {
              title: 'All Day Event',
              start: '2023-01-01'
            }
          ]
        });
        calendar.render();
      });
    </script>
   
   

</body>
</html>
