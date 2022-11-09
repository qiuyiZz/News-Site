<?php
session_start();
;
require 'database.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet" type="text/css">
    <title>homePage</title>
</head>
<body>
<div>
   
<h2>Stories:</h2>
<?php
//Show all stories
$stmt = $mysqli->prepare("select story_id, title, body from stories");
if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}

$stmt->execute();

$stmt->bind_result($story_id, $title, $body);

while($stmt->fetch()){
    ?>
    <div class="story">
    <h2><?php echo htmlentities($title); ?></h2>
    <?php
    echo "<br>";
    echo htmlentities($body);
    echo "<br><br>";
    
    ?>

        <!--view the story-->
        <form action="viewing.php" class = "view" method="post" >
            <input type="hidden" name = 'story_id' value="<?php echo $story_id?>">
            <input type="submit" value="View">
        </form>
        <br>
        </div>
        <?php
    
}
$stmt->close();

?>
<!--post new story-->
<form action="postStories.php" method="post">
        <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" >
        <input type="submit" class="postButton" value="post new story" >
        
        
    </form>
    <br>
<!--back to userPage-->
<form action="userPage.php" >
        <input type="submit" class="backButton" value="back to userPage" >
    </form>
    <br>

</div>
</body>
</html>

