<?php


session_start();

require('../../includes/config.php');
require('../../includes/db.php');
require('../../check-login.php');

if($role != 2){
   unset($_SESSION);
   header('location: ../../unauthorized.php');
}else{
if(isset($_POST['save'])){

   $journal_id = $_GET['journalID'];
   $title = $_POST['title'];
   $content = $_POST['content'];
   $moodID = $_POST['mood'];
   $thought = $_POST['thought'];
   $status = 'Private';

   $update_journal = $db->prepare("UPDATE journal SET title = :title, content = :content, thought = :thought, status = :status, moodID = :moodID WHERE journal_id = :journal_id");
   $update_journal->bindParam(':title', $title, PDO::PARAM_STR);
   $update_journal->bindParam(':content', $content, PDO::PARAM_STR);
   $update_journal->bindParam(':thought', $thought, PDO::PARAM_STR);
   $update_journal->bindParam(':status', $status, PDO::PARAM_STR);
   $update_journal->bindParam(':moodID', $moodID, PDO::PARAM_INT);
   $update_journal->bindParam(':journal_id', $journal_id, PDO::PARAM_INT);
   $update_journal->execute();

   echo "
        <script type='text/javascript'>
            document.addEventListener('DOMContentLoaded', function(){
                Swal.fire({
                    title: 'Save Changes?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Save'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Saved!',
                            text: 'Entry has been updated.',
                            icon: 'success'
                        }).then(() => {
                            window.location.href = 'view-journal.php?journalID=$journal_id';
                        });
                    }
                });
            });
        </script>";

}
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mhj | Edit Journal</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <link rel="stylesheet" href="../../assets/css/fontawesome-free/css/all.min.css">

    <link rel="stylesheet" href="../../assets/overlayScrollbars/css/OverlayScrollbars.min.css">

    <link rel="stylesheet" href="../../assets/sweetalert2/dist/sweetalert2.min.css">

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
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Edit Daily Journal</h1>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>
            <!-- Main content -->
            <section class="content">
               <div class="card-body">
                  <div class="col-md-9">
                     <div class="card card-primary">
                        <div class="card-header">
                           <h3 class="card-title">Journal Entry</h3>
                        </div>
                 <div class="card-body">
                 <?php
                 $journal_id = $_GET['journalID'];
                 $select_journal = $db->prepare("SELECT * FROM journal JOIN Users ON journal.userID = Users.userID JOIN mood ON journal.moodID = mood.moodID WHERE journal_id = :journal_id");
                 $select_journal->bindParam(':journal_id', $journal_id, PDO::PARAM_INT);
                 $select_journal->execute();
                 $fetch_journal = $select_journal->fetch(PDO::FETCH_ASSOC);
                  ?>
                  <form action="" method="post">
                         <div class="form-group">
                             <label for="title">Title</label>
                             <input type="text" id="title" name="title" class="form-control"  value="<?php echo htmlspecialchars($fetch_journal['title']); ?>" />
                         </div>
                         <div class="form-group">
                             <label for="content">Content</label>
                             <textarea id="content" name="content" class="form-control" rows="4" ><?php echo htmlspecialchars($fetch_journal['content']); ?></textarea>
                         </div>
                         <div class="form-group">
                             <label for="mood">Mood</label>
                             <select id="mood" name="mood" class="form-control custom-select" >
                                 <?php
                                 $queries = $db->prepare("SELECT * FROM mood");
                                 $queries->execute();
                                 foreach ($queries as $query) {
                                 ?>
                                     <option value="<?php echo $query['moodID']; ?>" <?php echo ($query['mood'] == $fetch_journal['mood']) ? 'selected' : ''; ?>><?php echo $query['description']; ?> <?php echo $query['mood']; ?></option>
                                 <?php
                                 }
                                 ?>
                             </select>
                         </div>
                         <div class="form-group">
                             <label for="thought">What are your thoughts and feelings?</label>
                             <textarea id="thought" name="thought" class="form-control" rows="4" required><?php echo htmlspecialchars($fetch_journal['thought']); ?></textarea>
                         </div>
                         <div class="form-group row">
                             <div class="offset-sm-0 col-sm-10">
                             <input type="submit" name="save" value="Save your Journal" class="btn btn-success">
                             <a href="view-journal.php?journalID=<?php echo $fetch_journal['journal_id'];?>" class="btn btn-success">go Back</a>
                           
                              </div>
                         </div>
                     </form>
            
                 </div>
     
   
                        </div>
                        <!-- /.card -->
                     </div>
                  </div>
               </div>

            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
    
        <aside class="control-sidebar control-sidebar-dark">

        </aside>

    </div>

    <script src="../../assets/js/jquery/jquery.min.js"></script>

    <script src="../../assets/js/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="../../assets/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>

    <script src="../../assets/js/adminlte.min.js"></script>

    <script src="../../assets/js/activesidebar.js"></script>

    <script src="../../assets/sweetalert2/dist/sweetalert2.all.min.js"></script>

</body>
</html>