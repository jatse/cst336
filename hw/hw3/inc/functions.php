<?php
    //initializes array with default body container
    function init(){
        $divEntry = array();
        $divEntry["id"] = "body";
        $divEntry["parent"] = "html";
        $divEntry["color"] = "#FF0000";
        $divEntry["height"] = "100";
        $divEntry["heightUnit"] = "%";
        $divEntry["width"] = "100";
        $divEntry["widthUnit"] = "%";
        $divEntry["position"] = "static";
        array_push($_SESSION["divs"], $divEntry);
    }
    
    //display div manager
    function displayDivPanel(){
        //DIV SELECTOR
        echo "<select name='divName' class='half-width-form'>";
        foreach($_SESSION['divs'] as $div){
            echo "<option value='" . $div["id"] . "'";
            if($div["id"] == $_SESSION["currentDiv"]){
                echo " selected='selected'";
            }
            echo ">" . $div["id"] . "</option>";
        }
        echo "</select>";
        echo "<input type='submit' class='half-width-form' name='submit' value='Select'/><br>";
        
        //DIV ADDER
        echo "<input type='text' class='threeqtr-width-form' name='divID' placeholder=' enter div ID to embed'/>";
        echo "<input type='submit' class='qtr-width-form' name='submit' value='Add'/><br>";
        
        //DIV DELETER
        echo "<input type='submit' class='full-width-form' name='submit' value='Delete'";
        if($_SESSION["currentDiv"] == "body"){
            echo " disabled";
        }
        echo "/>";
        echo "</form>";
    }
    
    //display attributes manager
    function displayPositionPanel(){
        //Find current div by id
        foreach($_SESSION["divs"] as $div){
            if($div["id"] == $_SESSION["currentDiv"]){
                $currentDiv = $div;
            }
        }
        
        //COLOR PROPERTY
        echo "<label for='color'>Color</label>";
        echo "<input type='color' class='threeqtr-width-form' name='color' id='color' value='";
        echo $currentDiv["color"] . "'><br>";
        
        //HEIGHT PROPERTY
        echo "<label for='height'>Height</label>";
        echo "<input type='number' class='half-width-form' id='height' name='height' ";
        echo "value='" . $currentDiv["height"] . "' />";
        echo "<select name='heightUnit' class='qtr-width-form'>";
        foreach(array("px", "%") as $unit){
            echo "<option value='" . $unit . "'";
            if($currentDiv["heightUnit"] == $unit){
                echo " selected='selected'";
            }
            echo ">" . $unit . "</option>";
        }
        echo "</select><br>"; 
        
        //WIDTH PROPERTY
        echo "<label for='width'>Width</label>";
        echo "<input type='number' class='half-width-form' id='width' name='width' ";
        echo "value='" . $currentDiv["width"] . "' />";
        echo "<select name='widthUnit' class='qtr-width-form'>";
        foreach(array("px", "%") as $unit){
            echo "<option value='" . $unit . "'";
            if($currentDiv["widthUnit"] == $unit){
                echo " selected='selected'";
            }
            echo ">" . $unit . "</option>";
        }
        echo "</select><br>";     
                
        //POSITION PROPERTY       
        echo "<label for='position'>Position</label>";
        echo "<select name='position' class='threeqtr-width-form' id='position'>";
        foreach(array("static", "relative", "absolute", "fixed") as $position){
            echo "<option value='" . $position . "'";
            if($currentDiv["position"] == $position){
                echo " selected='selected'";
            }
            echo ">" . $position . "</option>";
        }
        echo "</select><br>";
        
        //TOP PROPERTY
        echo "<input type='checkbox' name='coordinates[]' value='top' ";
        if(isset($currentDiv["coordinates"]) && in_array("top", $currentDiv["coordinates"])){
            //if checked, load values
            echo "checked";
            echo "><label for='top'> Top</label>";
            echo "<input type='number' class='qtr-width-form' name='top' id='top' ";
            echo "value='" . $currentDiv["top"] . "' />";
            echo "<select name='topUnit' class='qtr-width-form'>";
            foreach(array("px", "%") as $unit){
                echo "<option value='" . $unit . "'";
                if($currentDiv["topUnit"] == $unit){
                    echo " selected='selected'";
                }
                echo ">" . $unit . "</option>";
            }
        } else { //If not checkboxed, set empty version
            echo "><label for='top'> Top</label>";
            echo "<input type='number' class='qtr-width-form' name='top' id='top' />";
            echo "<select name='topUnit' class='qtr-width-form'>";
            foreach(array("px", "%") as $unit){
                echo "<option value='" . $unit . "'>" . $unit . "</option>";
            }
        }
        echo "</select><br>"; 
        
        //LEFT PROPERTY
        echo "<input type='checkbox' name='coordinates[]' value='left' ";
        if(isset($currentDiv["coordinates"]) && in_array("left", $currentDiv["coordinates"])){
            //if checked, load values
            echo "checked";
            echo "><label for='left'> Left</label>";
            echo "<input type='number' class='qtr-width-form' name='left' id='left' ";
            echo "value='" . $currentDiv["left"] . "' />";
            echo "<select name='leftUnit' class='qtr-width-form'>";
            foreach(array("px", "%") as $unit){
                echo "<option value='" . $unit . "'";
                if($currentDiv["leftUnit"] == $unit){
                    echo " selected='selected'";
                }
                echo ">" . $unit . "</option>";
            }
        } else { //If not checkboxed, set empty version
            echo "><label for='left'> Left</label>";
            echo "<input type='number' class='qtr-width-form' name='left' id='left' />";
            echo "<select name='leftUnit' class='qtr-width-form'>";
            foreach(array("px", "%") as $unit){
                echo "<option value='" . $unit . "'>" . $unit . "</option>";
            }
        }
        echo "</select><br>"; 
        
        //BOTTOM PROPERTY
        echo "<input type='checkbox' name='coordinates[]' value='bottom' ";
        if(isset($currentDiv["coordinates"]) && in_array("bottom", $currentDiv["coordinates"])){
            //if checked, load values
            echo "checked";
            echo "><label for='bottom'> Bottom</label>";
            echo "<input type='number' class='qtr-width-form' name='bottom' id='bottom' ";
            echo "value='" . $currentDiv["bottom"] . "' />";
            echo "<select name='bottomUnit' class='qtr-width-form'>";
            foreach(array("px", "%") as $unit){
                echo "<option value='" . $unit . "'";
                if($currentDiv["bottomUnit"] == $unit){
                    echo " selected='selected'";
                }
                echo ">" . $unit . "</option>";
            }
        } else { //If not checkboxed, set empty version
            echo "><label for='bottom'> Bottom</label>";
            echo "<input type='number' class='qtr-width-form' name='bottom' id='bottom' />";
            echo "<select name='bottomUnit' class='qtr-width-form'>";
            foreach(array("px", "%") as $unit){
                echo "<option value='" . $unit . "'>" . $unit . "</option>";
            }
        }
        echo "</select><br>"; 
        
        //RIGHT PROPERTY
        echo "<input type='checkbox' name='coordinates[]' value='right' ";
        if(isset($currentDiv["coordinates"]) && in_array("right", $currentDiv["coordinates"])){
            //if checked, load values
            echo "checked";
            echo "><label for='right'> Right</label>";
            echo "<input type='number' class='qtr-width-form' name='right' id='right' ";
            echo "value='" . $currentDiv["right"] . "' />";
            echo "<select name='rightUnit' class='qtr-width-form'>";
            foreach(array("px", "%") as $unit){
                echo "<option value='" . $unit . "'";
                if($currentDiv["rightUnit"] == $unit){
                    echo " selected='selected'";
                }
                echo ">" . $unit . "</option>";
            }
        } else { //If not checkboxed, set empty version
            echo "><label for='right'> Right</label>";
            echo "<input type='number' class='qtr-width-form' name='right' id='right' />";
            echo "<select name='rightUnit' class='qtr-width-form'>";
            foreach(array("px", "%") as $unit){
                echo "<option value='" . $unit . "'>" . $unit . "</option>";
            }
        }
        echo "</select><br>"; 
        
        //FLOAT PROPERTY
        echo "<label for='float'>Float: </label>";
        foreach(array("none", "left", "right") as $position){
            echo "<input type='radio' name='float' value='" . $position . "'";
            if(isset($currentDiv["float"]) && $currentDiv["float"] == $position){
                echo " checked";
            }
            echo "> " . $position;
        }
        echo "<br>";
        
        //CLEAR PROPERTY
        echo "<label for='clear'>Clear: </label>";
        foreach(array("none", "left", "right", "both") as $position){
            echo "<input type='radio' name='clear' value='" . $position . "'";
            if(isset($currentDiv["clear"]) && $currentDiv["clear"] == $position){
                echo " checked";
            }
            echo "> " . $position;
        }
        echo "<br>";
                
        //UPDATE BUTTON
        echo "<input type='submit' class='full-width-form' name='submit' value='Update' ";
        if($currentDiv["id"] == "body"){
            echo "disabled";
        }
        echo "/>";
    }
    
    //generate css styles. offset in pixels for control panel
    function generateStyle($offset = 0){
        foreach($_SESSION["divs"] as $div){
            echo "#" . $div["id"] . "{";
            echo "border: 3px solid " . $div["color"] . ";";
            echo "height: " . $div["height"] . $div["heightUnit"] . ";";
            echo "width: " . $div["width"] . $div["widthUnit"] . ";";
            echo "position: " . $div["position"] . ";";
            if(isset($div["coordinates"])){
                foreach($div["coordinates"] as $coord){
                    echo $coord . ": " . $div[$coord] . $div[$coord . "Unit"] . ";";
                }
            }
            
            //account for fixed positioning overlap with controls
            if($div["position"] == fixed && in_array("left", $div["coordinates"]) && $offset > 0){
                echo "left: calc(" . $offset . "px + " . $div["left"] . $div["leftUnit"] . ") !important;";
            }
            
            if(isset($div["float"])){
               echo "float: " . $div["float"] . ";"; 
            }
            if(isset($div["clear"])){
               echo "clear: " . $div["clear"] . ";"; 
            }
            echo "}";
        }
    }
    
    //generate divs recursively
    function generateDiv($parent = "html"){
        foreach($_SESSION["divs"] as $div){
            if($div["parent"] == $parent){
                echo "<div class='generatedDiv' id='" . $div["id"] . "'>";
                //insert child divs
                generateDiv($div["id"]);
                echo "</div>";
            }
        }
    }
?>