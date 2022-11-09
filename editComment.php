<?php
session_start();

require 'database.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet" type="text/css">
    <title>Edit Comment</title>
</head>
<body>
<h2>Edit the Comment</h2>
<?php

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
    
$stmt = $mysqli->prepare("select comment_body, username from comments where comment_id=?");

if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}

$stmt->bind_param('i', $comment_id);
$stmt->execute();

$stmt->bind_result($comment_body, $username);

?>
<!--text box for edit comment-->
<form action="updateComment.php" method="POST">
<p>
    <label for="comment">Comment:</label>
    <textarea id="comment_body" name="comment_body" rows="5" cols="50"><?php if($stmt->fetch()) {
    echo $comment_body;}?></textarea>
</p>
<input type="hidden" name = 'comment_id' value="<?php echo $comment_id;?>">
<input type="hidden" name = 'story_id' value="<?php echo $story_id;?>">
<input type="hidden" name = 'username' value="<?php echo $username;?>">
<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" >
<input type="submit" class="submitcommentButton" value="post comment" >

</form>
<br>
<!--back to userPage-->
<form action="userPage.php" ">
    <input type="submit" class="backButton" value="back to userPage" >
</form>
</body>
</html>
