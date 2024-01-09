<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>navbar</title>
</head>
<Body>
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search Journal" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>

      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <?php
          $check = $db->prepare("SELECT * FROM events WHERE CURDATE() BETWEEN DATE(start_at) AND DATE(end_at)");
          $check->execute();
          $count = $check->rowCount();
          if($count > 0){
            ?>
            <span class="badge badge-warning navbar-badge"><?php echo $count;?></span>
            <?php
          }else{
          }
          ?>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header"><?php echo $count;?> Notifications</span>
          <div class="dropdown-divider"></div>
          <?php
          if($count == 0){
            ?>
            <a href="#" class="dropdown-item">
              <span> No Event today</span>
            </a>
            <?php
          }else{
            ?>
            <a href="#" class="dropdown-item">
              <i class="fas fa-table mr-2"></i> <?php echo $count;?> Event today
            </a>
            <?php
          }
          ?>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
              <aside class="control-sidebar control-sidebar-dark">
  <!-- Content inside the control sidebar goes here -->
  <div class="p-3">
    <h5>Settings</h5>
    <h3 id="DarkModetext">Darkmode is OFF</h3>
    <button onclick="darkMode()"class="mode-button">Darkmode</button>
    <button onclick="lightMode()"class="mode-button">LightMode</button>
    <style>

    .mode-button{
      color: #ffffff;
	    margin: 20px auto;
      background: rgb(107, 104, 104);
      position: right;
    }
    h5{
      text-align: center;
    }
    h3{
      text-align: center;
      font-size: 20px;
    }
    .p{
      font-size: 15px;
    }
    </style>

<p class="indented-text">Alt+Tab to switch between the open windows</p>
<p class="indented-text">Alt + E Edits options in the current program.</p>
<p class="indented-text">Alt + F Shows file menu options in the current program.</p>
<p class="indented-text">Alt + F4This closes the current window.</p>
<p class="indented-text">Alt + Page Up It scrolls up the Entire Screen.</p>
<p class="indented-text">Alt + Page Down	It scrolls down the Entire Screen.</p>
<p class="indented-text">Alt + Left Arrow	It shows the previous history if it is present in Bowser.</p>
<p class="indented-text">Alt + Right Arrow	Go forward in the browser window.</p>
<p class="indented-text">Alt + Enter	It shows the property of the selected item.</p>
<p class="indented-text">Alt + Page Down	It scrolls down the Entire Screen.</p>
<p class="indented-text">Ctrl + X	It cuts the selected item.</p>
      </div>
</aside>
        </a>
      </li>
    </ul>
  </nav>
<script src="settings.js"></script>
        </body>
    </html>
