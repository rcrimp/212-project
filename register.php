<?php
session_start();
include("mysqlpass.php");

function redirectExit(){
   header("Location: index.php");
   exit;
}
   
function isAlphaNumeric($str) {
  $pattern='/^[A-Za-z0-9_]+$/';
  return preg_match($pattern, $str);
}

function isAlphaWhitespace($str) {
  $pattern='/^[A-Za-z\\s-_]+$/';
  return preg_match($pattern, $str);
}

function isEmpty($str) {
  return strlen(trim($str)) == 0;
}

function isEmail($str) {
  return filter_var($str, FILTER_VALIDATE_EMAIL);
}

function checkLength($str, $len) {
  return strlen(trim($str)) === $len;
}

$conn = new mysqli('sapphire', 'rcrimp', $pass, 'rcrimp_dev'); 
if ($conn->connect_errno) { 
  $_SESSION["error"] = "<p>Database connection failed</p>";
  redirectExit();
} else {

  //Database Validation
  if (isset($_POST['user'])){
    $user = $conn->real_escape_string($_POST['user']);
  } else {
    $_SESSION["error"] = "<p>The username field appears to be blank, please type in a username</p>";
  }
  if (isset($_POST['fname'])){
    $fname = $conn->real_escape_string($_POST['fname']);
  } else {
    $_SESSION["error"] = "<p>The name field appears to be blank, please type in your name</p>";
  }
  if (isset($_POST['lname'])){
    $lname = $conn->real_escape_string($_POST['lname']);
  } else {
    $_SESSION["error"] = "<p>The surname field appears to be blank, please type in your surname</p>";
  }
  if (isset($_POST['gender'])){
    $gender = $conn->real_escape_string($_POST['gender']);
  } else {
    $_SESSION["error"] = "<p>The gender field appears to be blank, please type in your surname</p>";
  }
  if (isset($_POST['pass'])){
    $pass = $conn->real_escape_string($_POST['pass']);
  } else {
    $_SESSION["error"] = "<p>The pasword field appears to be blank, please type in your password</p>";
  }
  if (isset($_POST['email'])){
     $email = $conn->real_escape_string($_POST['email']);
  } else {
    $_SESSION["error"] = "<p>email field appears to be blank, please type in your email</p>";
  }

  if (isEmpty($user)||isEmpty($fname)||isEmpty($lname)||isEmpty($pass)||isEmpty($email)){
    $_SESSION["error"] = "<p>one or more registration fields appear to be blank</p>";
    redirectExit();
  }
  if (!isAlphaNumeric($user)){
    $_SESSION["error"] = "<p>Invalid username</p>";
    redirectExit();
  }
  if (!isAlphaNumeric($fname)){
    $_SESSION["error"] = "<p>Invalid name</p>";
    redirectExit();
  }
  if (!isAlphaNumeric($lname)){
    $_SESSION["error"] = "<p>Invalid surname";
    redirectExit();
  }
  if (strlen(trim($pass)) < 6) {
    $_SESSION["error"] = "<p>Password Must be longer than 6 characters</p>";
    redirectExit();
  }
  if (!($gender==="" || $gender==="Male" || $gender==="Female")) {
    $_SESSION["error"] = "<p>Invalid gender, please enable JavaScript or try Male or Female</p>";
    redirectExit();
  }
  if (!isEmail($email)){
    $_SESSION["error"] = "<p>Invalid email</p>";
    redirectExit();
  }
                                   
  //Check Database for suplicate usernames
  $query = "SELECT * FROM users WHERE username='$user'";
  $result = $conn->query($query);
  if ($result->num_rows !== 0){
    $_SESSION["error"] = "<p>username is already taken</p>";
    redirectExit();
  }

  //add to the database
  $query = "INSERT INTO users (username, password, name, surname, email, type) ".
  "VALUES ('$user', SHA('$pass'), '$fname', '$lname', '$email', '0')";
  $conn->query($query);
  if ($conn->error) {
    $_SESSION["error"] = "<p>Database error</p>";
    redirectExit();
  }
  $result->free();
  $conn->close();

  //Add user to the xml files
  $xml = simplexml_load_file("XML/users.xml");

  $newUser = $xml->addChild('user');
  $newUser->addChild('username', $user);
  $newUser->addChild('firstname', $fname);
  $newUser->addChild('lastname', $lname);
  $newUser->addChild('gender', $gender);
  $newUser->addChild('signature', '');
  $xml->saveXML("XML/users.xml");

  //auto login
  $_SESSION['authenticatedUser'] = $user;
  header("Location: forum.php");
}
?>
