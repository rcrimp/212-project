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
$end = "</div><footer><p>Reuben Crimp © 2013</p></footer></body></html>";
   
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

$conn = new mysqli('sapphire', 'rcrimp', 'rwtcd1994', 'rcrimp_dev'); 
if ($conn->connect_errno) { 
  echo "<p>Database connection failed</p>";
} else {

  //DATABASE VALIDATION
  if (isset($_POST['user'])){
    $user = $conn->real_escape_string($_POST['user']);
  } else {
    echo "<p>The username field appears to be blank, please type in a username</p>";
  }
  if (isset($_POST['fname'])){
    $fname = $conn->real_escape_string($_POST['fname']);
  } else {
    echo "<p>The name field appears to be blank, please type in your name</p>";
  }
  if (isset($_POST['lname'])){
    $lname = $conn->real_escape_string($_POST['lname']);
  } else {
    echo "<p>The surname field appears to be blank, please type in your surname</p>";
  }
  if (isset($_POST['gender'])){
  $gender = $conn->real_escape_string($_POST['gender']);
  } else {
  echo "<p>The gender field appears to be blank, please type in your surname</p>";
  }
  if (isset($_POST['pass'])){
    $pass = $conn->real_escape_string($_POST['pass']);
  } else {
    echo "<p>The pasword field appears to be blank, please type in your password</p>";
  }
  if (isset($_POST['email'])){
     $email = $conn->real_escape_string($_POST['email']);
  } else {
    echo "<p>email field appears to be blank, please type in your email</p>";
  }

  if (isEmpty($user)||isEmpty($fname)||isEmpty($lname)||isEmpty($pass)||isEmpty($email)){
    echo "<p>one or more registration fields appear to be blank, please <a href='index.php'>try again.</a></p>$end";
    exit;
  }
  //regex validate, size validate all input
  if (!($gender==="" || $gender==="Male" || $gender==="Female")) {
    echo "<p>Invalid gender option, please enable JavaScript or try 'Male' or 'Female', <a href='index.php'>Go Back</a></p>$end";
    exit;
  }

  //CHECK DATABASE FOR DUPLICATE
  $query = "SELECT * FROM users WHERE username='$user'";
  $result = $conn->query($query);
  if ($result->num_rows !== 0){
    echo "<p>username is already taken, <a href='index.php'>Go Back</a></p>$end";
    exit;
  }

  //ADD TO DATABASE
  $query = "INSERT INTO users (username, password, name, surname, email, type) ".
  "VALUES ('$user', SHA('$pass'), '$fname', '$lname', '$email', '0')";
  $conn->query($query);
  if ($conn->error) {
    echo "<p>Database error</p>$end";
    exit;
  }
  $result->free();

  //ADD TO XML
  $xml = simplexml_load_file("XML/users.xml");
  $newUser = $xml->addChild('user');
  $newUser->addChild('username', $user);
  $newUser->addChild('firstname', $fname);
  $newUser->addChild('lastname', $lname);
  $newUser->addChild('gender', $gender);
  $newUser->addChild('signature', '');
  $xml->saveXML("XML/users.xml");

}
$conn->close();
//REDIRECT TO INDEX.PHP
?>
