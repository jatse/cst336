<?php
//Moves player and return updated player data.
function movePlayer($playerArray, $move){
    switch($move){
        case "left":    if($playerArray[1] >= 50){$playerArray[1] -= 50;}
                        break;
        case "right":   if($playerArray[1] <= 500){$playerArray[1] += 50;}
                        break;
        case "up":      if($playerArray[2] >= 50){$playerArray[2] -= 50;}
                        break;
        case "down":    if($playerArray[2] <= 500){$playerArray[2] += 50;}
                        break;
        default:        break;
    }
    
    //Check if landmarks reached.
    if($playerArray[1] == 500 && $playerArray[2] == 50 && $playerArray[3] == true){
        $playerArray[0] += 1;
        $playerArray[3] = false;
    }
    if($playerArray[1] == 50 && $playerArray[2] == 500 && $playerArray[3] == false){
        $playerArray[0] += 1;
        $playerArray[3] = true;
    }
    
    return $playerArray;
}

//Moves each ghost if random direction is valid. Ghost can move diagonally or stand still.
function moveGhosts($ghostArray){
    for($i = 0; $i < count($ghostArray); $i++){
        $newCoord = array();
        $newCoord[] = $ghostArray[$i][0] + (rand(-1,1) * 50);
        $newCoord[] = $ghostArray[$i][1] + (rand(-1,1) * 50);
        
        //assign new coordinates if...
        //1. is in bounds
        if(($newCoord[0] >= 0 && $newCoord[0] <= 550) && ($newCoord[1] >= 0 && $newCoord[1] <= 550)){
            //2. does not collide with home and well
            if(!in_array($newCoord, array(array(500,50),array(50,500)))){
                //3. does not collide with other ghosts
                if(!(in_array($newCoord, $ghostArray))){
                    $ghostArray[$i] = $newCoord;
                }
            }
        }
    }
    return $ghostArray;
}

//Spawns starting amount of ghost.
function initializeGhosts($playerArray){
    $ghostArray = array();
    $START_GHOST = 1; // <---SET INITIAL NUMBER OF GHOST
    
    for($i = 0; $i < $START_GHOST; $i++){
        $ghostArray[] = spawnGhost($ghostArray, $playerArray);
    }
    
    return $ghostArray;
}

//Spawns single ghost, if maximum ghosts not reached.
function spawnGhost($ghostArray, $playerArray){
    if(maxGhosts($ghostArray) == false){
        $ghostCoord = array();
    
        //spawn 
        while(true){
            //get random coord
            $ghostCoord[0] = rand(0,11) * 50;
            $ghostCoord[1] = rand(0,11) * 50;
            
            //assign coordinates if ...
            //1. not on the house and well
            if(!in_array($ghostCoord, array(array(500,50),array(50,500)))){
                //2. not on the player
                if(!($ghostX == $playerArray[1] && $ghostY == $playerArray[2])){
                    //3. other ghosts
                    if(!(in_array($ghostCoord, $ghostArray))){
                        return $ghostCoord;
                    }
                }
            }
        }
    }
}

//Returns true if maximum number of ghost is spawned.
function maxGhosts($ghostArray){
    $MAX_GHOSTS = 100; // <--- SET MAX NUMBER OF GHOSTS
    if(count($ghostArray) >= $MAX_GHOSTS){
        return true;
    }
    return false;
}

//Returns true if collision detected.
function checkCollide($playerArray, $ghostArray){
    $playerCoord = array($playerArray[1], $playerArray[2]);
    
    if(in_array($playerCoord, $ghostArray)){
        return true;
    }
    return false;
}

?>