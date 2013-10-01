<?php
session_start();
if(!isset($_SESSION['authenticatedUser'])){
  header("Location: index.php");
  exit;
} else {
  $user = $_SESSION['authenticatedUser'];
}

if(!isset($_POST['title']) || !isset($_POST['message'])){
  $_SESSION["error"] = "<p>Please provide a title and a message when posting a new thread</p>";
  header("location: forum.php");
  exit;
}

if ($_POST['title'] === "" || $_POST['message'] === ""){
  $_SESSION["error"] = "<p>Please provide a title and a message when posting a new thread</p>";
  header("location: forum.php");
  exit;
}

$title = htmlspecialchars($_POST['title']);
$message = htmlspecialchars($_POST['message']);
$postsxml = uniqid().".xml";

$xml = simplexml_load_file("XML/forum.xml");

$newThread = $xml->addChild('thread');
$newThread->addChild('title', $title);
$newThread->addChild('posts', $postsxml);
$newThread->addChild('OP', $user);

$datetime = getdate();
$date = $newThread->addChild('date');
$date->addChild('day', $datetime['mday']);
$date->addChild('month', $datetime['month']);
$date->addChild('year', $datetime['year']);
$time = $newThread->addChild('time');
$time->addChild('hour', $datetime['hours']);
$time->addChild('minute', $datetime['minutes']);
$time->addChild('seconds', $datetime['seconds']);
$newThread->addChild('postcount', '1');

$xml->saveXML("XML/forum.xml");

$newXML = new SimpleXMLElement("<posts></posts>");

$newpost = $newXML->addChild('post');
$newpost->addChild('username', $user);

$date = $newpost->addChild('date');
$date->addChild('day', $datetime['mday']);
$date->addChild('month', $datetime['month']);
$date->addChild('year', $datetime['year']);
$time = $newpost->addChild('time');
$time->addChild('hour', $datetime['hours']);
$time->addChild('minute', $datetime['minutes']);
$time->addChild('seconds', $datetime['seconds']);

$newpost->addChild('text', $message);
$newpost->addChild('id', uniqid());

$newXML->saveXML("XML/".$postsxml);

header("location: forum.php");
exit();
?>
