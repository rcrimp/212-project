<?php
session_start();
if(!isset($_SESSION['authenticatedUser'])){
  header("Location: index.php");
  exit;
} else {
  $user = $_SESSION['authenticatedUser'];
}

function getPostById($id, $xml){
   $parent = null;
   foreach ($xml->post as $post) {
      if ($post->id == $id){
         return $post;
      }
   }
   foreach ($xml->post as $post) {
      if ($post->post != null) {
         $tmp = getPostById($id, $post);
         if ($tmp != null) {
            $parent = $tmp;
         }
      }
   }
   return $parent;
}

$thread = $_POST['thread'];
$id = $_POST['id'];
$message = htmlspecialchars($_POST['message']);

$xml = simplexml_load_file("XML/".$thread);
$parent = getPostById($id, $xml);

$newpost = $parent->addChild('post');
$newpost->addChild('username', $user);

$datetime = getdate();
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

$xml->saveXML("XML/".$thread);

header("location: forum.php");
exit();
?>
