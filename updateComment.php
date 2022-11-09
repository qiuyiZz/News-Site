<?php
session_start();

require 'database.php';
if(!hash_equals($_SESSION['token'], $_POST['token'])){
    echo "Wrong!";
    die("Request forgery detected");
    
}
$comment_body = $_POST['comment_body'];
$comment_id = $_POST['comment_id'];
$story_id = $_POST['story_id'];
$username = $_POST['username'];

$stmt = $mysqli->prepare("update comments set comment_body=? where comment_id=? and username=?");

if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->bind_param('sis', $comment_body, $comment_id, $username);

$stmt->execute();

$stmt->close();

header("Location: viewing.php?story_id=$story_id");
?>