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
    <title>Index Page</title>
</head>
<body>
<div class="userStories">
        
        <h1>News Site</h1>
        <!--login button-->
        <form action="login.php">
            <input type="submit" class="loginButton" value="login" >
        </form>
        <?php
        $_SESSION['registered'] = false;
        //show all stories
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
        <h3><?php echo htmlentities($title); ?></h3>
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
            </div>
            <?php
        
    }
    $stmt->close();

    ?>

</div>
</body>
</html>