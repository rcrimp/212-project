<?php
   session_start();
   if(isset($_SESSION['authenticatedUser'])){
      unset($_SESSION['authenticatedUser']);
   }
   header("Location: index.php");
?>
