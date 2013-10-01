<?php
session_start();
include("mysqlpass.php");

$conn = new mysqli('sapphire', 'rcrimp', $pass, 'rcrimp_dev'); 
if ($conn->connect_errno) { 
  $_SESSION["error"] = "<p>Database connection failed</p>";
  header("Location: index.php");
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
  $_SESSION["error"] = "<p>Incorrect username or password</p>";
  header("Location: index.php");
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
