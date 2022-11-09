<?php
session_start();
;
require 'database.php';


if(!hash_equals($_SESSION['token'], $_POST['token'])){
    die("Request forgery detected");
}
if(isset($_POST['story_id']))
{
    $story_id = $_POST['story_id'];
}

if($_SESSION['registered'] ){
    $username = $_SESSION['user'];   
} else {
    die("Please log in!");
}

//delete comments of this story first
$stmt = $mysqli->prepare("delete from comments where story_id=?");

if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}

$stmt->bind_param('i', $story_id);

$stmt->execute();

$stmt->close();

$stmt  = $mysqli->prepare("delete from stories where story_id=? and username=?");

if (!$stmt) {
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}
$stmt->bind_param('is', $story_id, $username);
$stmt->execute();
$stmt->close();
header("Location: homePage.php");
?>