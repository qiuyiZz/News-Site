<?php
session_start();

require 'database.php';
if(!hash_equals($_SESSION['token'], $_POST['token'])){
    echo "Wrong!";
    die("Request forgery detected");
    
}
if(isset($_POST['story_id']))
{
    $story_id = $_POST['story_id'];
}
if (empty($_POST['title'])) {
    echo("Title cannot be empty!<br>");
}
else{
    $title = $_POST['title'];
}

if (!empty($_POST['link']) && !(filter_var($_POST['link'], FILTER_VALIDATE_URL))) {
    echo("URL is invalid!<br>");
}
else{
    $link = $_POST['link'];
    $link = filter_var($link, FILTER_SANITIZE_URL);
    $body = $_POST['body'];
}
$username = $_POST['username'];

$stmt = $mysqli->prepare("update stories set title=?, body=?, link=? where story_id=? and username=?");

if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->bind_param('sssis', $title, $body, $link, $story_id, $username);

$stmt->execute();

$stmt->close();

header("Location: viewing.php?story_id=$story_id");
?>