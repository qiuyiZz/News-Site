<?php
session_start();

require 'database.php';
if(!hash_equals($_SESSION['token'], $_POST['token'])){
    echo "Wrong!";
    die("Request forgery detected");
    
}
if (empty($_POST['comment'])) {
    echo("Comment cannot be empty!<br>");
}
else{
    $comment_body = $_POST['comment'];
    $user = $_SESSION['user'];
    $story_id = $_POST["story_id"];
}

    $stmt = $mysqli->prepare("insert into comments (comment_body, story_id, username) values (?, ?, ?)");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    
    $stmt->bind_param('sis', $comment_body, $story_id, $user);
    
    $stmt->execute();
    
    $stmt->close();

    header("Location: viewing.php?story_id=$story_id");


?>
 
