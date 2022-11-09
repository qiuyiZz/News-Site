<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet" type="text/css">
    <title>Viewing</title>
</head>
<body>

<?php
require 'database.php';
?>
<?php
if(isset($_POST['story_id']))
{
    $story_id = $_POST['story_id'];
}
else
{
    $story_id = $_GET['story_id'];
}
$stmt = $mysqli->prepare("select story_id, title, body, link, story_time, username from stories where story_id=?");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }

    $stmt->bind_param('i', $story_id);

    $stmt->execute();

    $stmt->bind_result($story_id, $title, $body, $link, $story_time, $username);

    while($stmt->fetch()){
        ?>
        <div class='story'>
        <h1><?php echo htmlentities($title); ?></h1>
        <?php
        
        echo "Author: " . htmlentities($username);
        echo "<br>";
        echo "Post at: " . htmlentities($story_time);
        echo "<br>";
        echo htmlentities($body);
        echo "<br><br>";
        
        if($link != NULL)
        {
            echo "Link: "; ?> <a href=<?php echo $link;?>><?php echo $link; ?></a>
            <?php
            echo "<br><br>";
        }
        
    }
    $stmt->close();

    echo "<br><br>";

    if($_SESSION['registered']&& $_SESSION['user']==$username)//log_in
    {
        
        ?>
        <!--edit button-->
        <form action="editStories.php" class = "inline" method="post" >
            <input type="hidden" name = 'story_id' value="<?php echo $story_id?>">
            <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" >
            <input type="submit" value="Edit">
        </form>
        <br>
        <br>
    
        <!--delete button--> 
        <form action="deleteStories.php" class = "inline" method="post" >
            <input type="hidden" name = 'story_id' value="<?php echo $story_id?>">
            <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" >
            <input type="submit" value="Delete">
        </form>
    
        <?php
        
    }
    ?>
    <h2>Comments: </h2>

<?php
if($_SESSION['registered'])
{
?>
    <form action="postComment.php" class = "postComment" method="post">
        <label for="comment">Comment:</label>
        <textarea id="comment" name="comment" rows="1" cols="50"></textarea>
        <input type="hidden" name = 'story_id' value="<?php echo $story_id?>">
        <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" >
        <input type="submit" value="Post Comment">
    </form>
<?php
}
?>
<?php
$stmt = $mysqli->prepare("select comment_id, comment_body, username, comment_time from comments where story_id=? order by comment_id");
if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}

$stmt->bind_param('i', $story_id);

$stmt->execute();

$stmt->bind_result($comment_id, $comment_body, $username, $comment_time);


echo "<ul>\n";
while($stmt->fetch()){
    echo htmlentities($comment_body) . " by " . htmlentities($username);
    echo "<br>";
    echo "Comment at: " . htmlentities($comment_time);

    if($_SESSION['registered'] && $_SESSION['user']==$username)//log_in
        {
        ?>
        <!--edit button-->
        <form action="editComment.php" class = "inline" method="post" >
            <input type="hidden" name = 'comment_id' value="<?php echo $comment_id?>">
            <input type="hidden" name = 'story_id' value="<?php echo $story_id;?>">
            <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" >
            <input type="submit" value="Edit">
        </form>
        <br>
        
        <!--delete button--> 
        <form action="deleteComment.php" class = "inline" method="post" >
            <input type="hidden" name = 'comment_id' value="<?php echo $comment_id?>">
            <input type="hidden" name = 'story_id' value="<?php echo $story_id;?>">
            <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" >
            <input type="submit" value="Delete">
        </form>
        <?php
        }
    
    ?>
    <br>
    <br>
       
    <?php
    
    
}
echo "</ul>\n";

$stmt->close();


if($_SESSION['registered'])//log_in
        {
        ?>
<!--back to userPage-->
<form action="userPage.php" >
    <input type="submit" class="backButton" value="back to userPage">
</form>
</div>
<?php  
}
else{
    ?>
    <!--back to index Page-->
<form action="index.php" >
    <input type="submit" class="backButton" value="back to index page" >
</form>

<?php  
}
?>
</body>
</html>
