<!DOCTYPE html>
<html>
<head>
<title>Walrus Forum Portal</title>
<meta charset="UTF-8">
<link rel="stylesheet" href="style/default.css">

<link rel="icon" href="images/favicon.png">

<script src="scripts/jquery.js"></script>
<script src="scripts/cookie.js"></script>
</head>
<body>
<header><img id="logo" src="images/logo_b.png" alt="Forum logo">
<h1>Walrus Forum Portal</h1>
</header>
<div id="main">
<?php
   session_start();
   $end = "</div><footer><p>Reuben Crimp © 2013</p></footer></body></html>";
   $conn = new mysqli('sapphire', 'rcrimp', 'rwtcd1994', 'rcrimp_dev'); 
   if ($conn->connect_errno) { 
      echo "<p>DB connection failed</p>$end";
      exit;
   } else {
      if (isset($_POST['user'])){
         $user = $conn->real_escape_string($_POST['user']);
      }
      if (isset($_POST['pass'])){
         $pass = $conn->real_escape_string($_POST['pass']);
      }
   }

   $query = "SELECT * FROM users WHERE username='$user' AND password=SHA('$pass')";
   $result = $conn->query($query);
   if ($result->num_rows !== 1){
      echo "<p>Incorrect username or password</p>$end";
      exit;
   } else {
      echo "<p>login successful, welcome $user";
      $_SESSION['authenticatedUser'] = $user;
      header("Location: forum.php");
      exit;
   }
   $result->free();
   $conn->close();
?>
