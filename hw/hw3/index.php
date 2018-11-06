<?php
    session_start();
    include 'inc/functions.php';
    
    //initialize layout if new session
    if(!isset($_SESSION['divs'])){
        $_SESSION['divs'] = array();
        $_SESSION['currentDiv'] = "body";
        init();
    }
    
    //change current div if selected
    if($_POST["submit"] == "Select"){
        $_SESSION["currentDiv"] = $_POST["divName"];
    }
    
    //Add div if valid name
    if($_POST["submit"] == "Add"){
        if(empty($_POST["divID"]) || !ctype_alpha($_POST["divID"][0])){
            echo "<div class='error'>ID must start with a letter! Cannot be blank.</div><br>";
        } elseif(in_array($_POST["divID"], array("html","body", "controlArea","divPanel", "positionPanel", "outputPanel", "color", "height", "width", "position", "top", "left", "bottom", "right", "float", "clear"))){
            echo "<div class='error'>ID is reserved. Pick a different ID.</div><br>";
        } else {
            $ids = array();
            foreach($_SESSION["divs"] as $div){
                $ids[] = $div["id"];
            }
            if(in_array($_POST["divID"], $ids)){
                echo "<div class='error'>Duplicate ID. Pick a different ID.</div><br>";
            } else {
                //initialize div with default values
                $divEntry["id"] = $_POST["divID"];
                $divEntry["parent"] = $_POST["divName"];
                $divEntry["color"] = "#000000";
                $divEntry["height"] = "100";
                $divEntry["heightUnit"] = "px";
                $divEntry["width"] = "100";
                $divEntry["widthUnit"] = "px";
                $divEntry["position"] = "static";
                array_push($_SESSION["divs"], $divEntry);
                $_SESSION["currentDiv"] = $_POST["divID"];
            }
        }
    }
    
    //delete a div. resets to body
    if($_POST["submit"] == "Delete"){
        for($i = 0; $i < count($_SESSION["divs"]); $i++){
            if($_SESSION["divs"][$i]["id"] == $_POST["divName"]){
                unset($_SESSION["divs"][$i]);
            }
        }
        $_SESSION["currentDiv"] = "body";
    }
    
    //updates a div if valid
    if($_POST["submit"] == "Update"){
        for($i = 0; $i < count($_SESSION["divs"]); $i++){
            //finds current div ...
            if($_SESSION["divs"][$i]["id"] == $_SESSION["currentDiv"]){
                
                //Set color
                $_SESSION["divs"][$i]["color"] = $_POST["color"];
                
                //Set height
                if($_POST["height"] >= 1){
                    $_SESSION["divs"][$i]["height"] = $_POST["height"];
                } else {
                    echo "<div class='error'>Height must be greater than 1!</div><br>";
                }
                $_SESSION["divs"][$i]["heightUnit"] = $_POST["heightUnit"];
                
                //Set width
                if($_POST["width"] >= 1){
                    $_SESSION["divs"][$i]["width"] = $_POST["width"];
                } else {
                    echo "<div class='error'>Width must be greater than 1!</div><br>";
                }
                $_SESSION["divs"][$i]["widthUnit"] = $_POST["widthUnit"];
                
                //Set position
                $_SESSION["divs"][$i]["position"] = $_POST["position"];
                
                //If there are coodinates checked ...
                if(isset($_POST["coordinates"])){
                    //copy coordinates to session ...
                    $_SESSION["divs"][$i]["coordinates"] = $_POST["coordinates"];
                    //for each coordinate position ...
                    foreach(array("top", "left", "bottom", "right") as $coord){
                        //if checked ...
                        if(in_array($coord, $_SESSION["divs"][$i]["coordinates"])){
                            //and value is set ...
                            if(isset($_POST[$coord]) && $_POST[$coord]!== ""){
                                //copy values to session ...
                                $_SESSION["divs"][$i][$coord] = $_POST[$coord];
                                $_SESSION["divs"][$i][$coord . "Unit"] = $_POST[$coord . "Unit"];
                            } else {
                                //else unset checkbox if no value detected
                                echo "<div class='error'>" . $coord . " needs a numerical value!</div><br>";
                                $_SESSION["divs"][$i]["coordinates"] = array_diff($_SESSION["divs"][$i]["coordinates"], array($coord));
                            }
                        }
                    }
                } else if(isset($_SESSION["divs"][$i]["coordinates"])){
                    //get rid of empty array if no valid values.
                    unset($_SESSION["divs"][$i]["coordinates"]);
                }
                    
                if(isset($_POST["float"])){
                    $_SESSION["divs"][$i]["float"] = $_POST["float"];
                }
                
                if(isset($_POST["clear"])){
                    $_SESSION["divs"][$i]["clear"] = $_POST["clear"];
                }
            }
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Jason Tse: Homework 3</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css/style.css" type="text/css" />
        <?php 
            echo "<style>";
            generateStyle(200);
            echo "</style>";
        ?>
    </head>
    <body>
        <div id="controlArea">
            <h1>
                WIREFRAME<br/>
                TOOL 1.0α
            </h1>
            
            <form method="post" id="divPanel">
                <?= displayDivPanel() ?>
            </form>
            
            <hr />
            
            <form method="post" id="positionPanel">
                <?= displayPositionPanel() ?>
            </form>
            
            <hr /><br>
            
            <form action="output.php" target="_blank" method="post" id="outputPanel">
                <input type="submit" class="full-width-form" name="submit" value="Generate Code" />
                <p>Generated code will render in new tab. Save resulting webpage to get code. Final result may differ from what is currently on screen. Output regularly to check.</p>
            </form>
            
        </div>
        <div id="displayArea">
            <?= generateDiv() ?>
        </div>
    </body>
</html>