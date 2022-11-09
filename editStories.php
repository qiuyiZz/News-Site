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
    <title>Edit Story</title>
</head>
<body>
<h2>Edit the Story</h2>
<?php

if(!hash_equals($_SESSION['token'], $_POST['token'])){
    die("Request forgery detected");
}
if(isset($_POST['story_id']))
{
    $story_id = $_POST['story_id'];
}

if($_SESSION['registered']){
    $username = $_SESSION['user'];   
} else {
    die("Please log in!");
}
$stmt = $mysqli->prepare("select title, body, link, username from stories where story_id=?");

if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}

$stmt->bind_param('i', $story_id);
$stmt->execute();

$stmt->bind_result($title, $body, $link, $username);

?>
<!--text box for edit story-->
<form action="updateStories.php" method="POST">
<p>
    <label for="title">Title:</label>
    <textarea id="title" name="title" rows="1" cols="50"><?php if($stmt->fetch()) {
    echo $title;}?></textarea>
</p>
<p>
    <label for="body">Body:</label>
    <textarea id="body" name="body" rows="5" cols="50"><?php echo $body;?></textarea>
</p>
<p>
    <label for="link">Link:</label>
    <textarea id="link" name="link" rows="2" cols="50"><?php echo $link;?></textarea>
</p>
<input type="hidden" name = 'story_id' value="<?php echo $story_id;?>">
<input type="hidden" name = 'username' value="<?php echo $username;?>">
<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" >
<input type="submit" class="submitcommentButton" value="update the story" >

</form>
<br>
<!--back to userPage-->
<form action="userPage.php" ">
    <input type="submit" class="backButton" value="back to userPage" >
</form>
</body>
</html>