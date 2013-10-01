<!DOCTYPE html>
<?php
   session_start();
   if(!isset($_SESSION['authenticatedUser'])){
     header("Location: index.php");
     exit;
   } else {
     $user = $_SESSION['authenticatedUser'];
   }
   ?>
<html>
  <head>
    <title>Board Index</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style/default.css">
    <link rel="stylesheet" href="style/thread.css">
    <link rel="stylesheet" href="style/users.css">

    <link rel="icon" href="images/favicon.png">
    <script src="scripts/jquery.js"></script>
    <script src="scripts/cookie.js"></script>
    <script src="scripts/changeTheme.js"></script>
    <script src="scripts/showHide.js"></script>
    <script src="scripts/users.js"></script>
    <script src="scripts/thread.js"></script>
    <script src="scripts/forum.js"></script>
    <script src="scripts/validatePost.js"></script>
  </head>
  <body>
    <header><img id="logo" src="images/logo_b.png" alt="Forum logo">
      <h1>Walrus Forum</h1>
    </header>
    <div id="wrapper">
      <nav>
        <h2>Hello <?php echo $user ?></h2>
        <div id="clearButton" class="button"><h3>Threads</h3></div>    
        <div id="userButton" class="button"><h3>Users</h3></div>
        <div id="themeButton" class="button"><h3>Theme</h3></div>
        <div id="themeButtons">
          <img src="images/colour_b.png" width="19" height="19" alt="change theme to blue" onclick="changeTheme.set(0);">
	  <img src="images/colour_g.png" width="19" height="19" alt="change theme to green" onclick="changeTheme.set(1)">
	  <img src="images/colour_o.png" width="19" height="19" alt="change theme to orange" onclick="changeTheme.set(2)">
	  <img src="images/colour_r.png" width="19" height="19" alt="change theme to red" onclick="changeTheme.set(3)">
	  <img src="images/colour_p.png" width="19" height="19" alt="change theme to purple" onclick="changeTheme.set(4)">
        </div>
        <div id="logoutButton" class="button"><h3>Logout</h3></div>
        <div id="discussionNav">
        </div>
      </nav>
      <?php
         if (isset($_SESSION['error'])){
         echo "<div id='error'>".$_SESSION['error']."</div>";
         unset($_SESSION['error']);
         }
         ?>
      <div id="content">
        <p>Loading...</p>
        <noscript class="reply">
          <p>For full functionality of this website please
            <a href="http://www.enable-javascript.com/">enable javascript</a></p>
        </noscript>
      </div>
      <div id="loading"></div>
    </div>
    <footer><p>Reuben Crimp © 2013</p></footer>
  </body>
</html>
