<?php 
    include 'inc/functions.php'; 
    //playerArray Format:[score][playerX][playerY][gotWater]
    //playerData Format: score;playerX;playerY;gotWater
    //ghostArray Format:[[g0-X][g0-Y]][[g1-X][g1-Y]] ... multidimensional array.
    //ghostData Format: g0-X,g0-Y;g1-X,g1-Y ... coordinate pairs.
    //gameOver: true if game is over
    //move: determine where player moves
    
    //initialize or get data state
    if($_POST["playerData"] == null){
        $playerArray = array(0, 500, 50, false);
        $move = "none";
        $gameOver = false;
        $ghostArray = initializeGhosts($playerArray);
    } else {
        $playerArray = explode(";", $_POST["playerData"]);
        $move = $_POST["move"];
        $gameOver = $_POST["gameOver"];
        $ghostArray = explode(";", $_POST["ghostData"]);
        for($i = 0; $i < count($ghostArray); $i++){
            $ghostArray[$i] = explode(",", $ghostArray[$i]);
        }
    }
    
    //update data.
    $gameOver = checkCollide($playerArray, $ghostArray); //prevent refresh cheat
    
    if(!$gameOver){
        $playerArray = movePlayer($playerArray, $move);
        $gameOver = checkCollide($playerArray, $ghostArray);
    }
    
    if(!$gameOver){
        $ghostArray = moveGhosts($ghostArray);
        //10% chance to spawn ghost.
        $chance = rand(0,9);
        if($chance == 0){
            $ghostArray[] = spawnGhost($ghostArray, $playerArray);
        }
        $gameOver = checkCollide($playerArray, $ghostArray);
    }
    
    //1% chance to spawn ghost.
    $chance = rand(0,99);
    if($chance == 0){
        $ghostArray[] = spawnGhost($ghostArray, $playerArray);
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Jason Tse: Homework 2</title>
        <link rel="icon" type="image/png" href="img/ghost.png">
        <link rel="stylesheet" href="css/style.css" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Poiret+One" rel="stylesheet">
    </head>
    
    <body>
        <h1>POSSESSED</h1>
        <!--The game display -->
        <div id="field">
            <?php
                echo "<img id='player' src='img/character.png' alt='the player' style='position:absolute;top:" . $playerArray[2] . "px;left:" . $playerArray[1] . "px;' />\n";
                foreach($ghostArray as $ghost){
                    echo "<img id='ghost' src='img/ghost.png' alt='a ghost' style='position:absolute;top:" . $ghost[1] . "px;left:" . $ghost[0] . "px;' />\n"; 
                }
            ?>
        </div>
        <br />
        
        <!--The player controls -->
        <div id="controls">
            <?php
                //repackage array data for next play
                $playerData = implode(";", $playerArray);
                for($i = 0; $i < count($ghostArray); $i++){
                        $ghostArray[$i] = implode(",", $ghostArray[$i]);
                    }
                $ghostData = implode(";", $ghostArray);
                $directions = array("left","up","down","right");
                
                //attach state data to each form
                if($gameOver == false){
                    foreach($directions as $dir){
                        echo "<form action='index.php' method='post'>\n";
                        echo "\t\t\t\t<input type='hidden' name='playerData' value='" . $playerData . "'>\n";
                        echo "\t\t\t\t<input type='hidden' name='move' value='" . $dir . "'>\n";
                        echo "\t\t\t\t<input type='hidden' name='gameOver' value='" . $gameOver . "'>\n";
                        echo "\t\t\t\t<input type='hidden' name='ghostData' value='" . $ghostData . "'>\n";
                        echo "\t\t\t\t<input type='image' alt='move button' name='submit' src='img/" . $dir . ".png'>\n";
                        echo "\t\t\t</form>\n\n\t\t\t";
                    }
                } else {
                    echo "<form action='index.php' method='post'>\n";
                    echo "<input type='image' alt='replay button' name='submit' src='img/gameover.png'>\n";
                    echo "</form>";
                }
            ?>
        </div>
        
        <!--The score display -->
        <div id="score">
            SCORE: <?php echo $playerArray[0] . "\n"; ?>
        </div>
        
        <div id="footer">Disclaimer: This site is for educational purposes only.</div>
    </body>
</html>