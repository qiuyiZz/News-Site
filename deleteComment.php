<?php
session_start();
echo $_SESSION['user'];

require 'database.php';



if(!hash_equals($_SESSION['token'], $_POST['token'])){
    die("Request forgery detected");
}
if(isset($_POST['story_id']))
{
    $story_id = $_POST['story_id'];
}
if(isset($_POST['comment_id']))
{
    $comment_id = $_POST['comment_id'];
}

if($_SESSION['registered']){
    $username = $_SESSION['user'];   
} else {
    die("Please log in!");
}

$stmt  = $mysqli->prepare("delete from comments where comment_id=? and username=?");

if (!$stmt) {
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}
$stmt->bind_param('is', $comment_id, $username);
$stmt->execute();
$stmt->close();
header("Location: viewing.php?story_id=$story_id");
?>