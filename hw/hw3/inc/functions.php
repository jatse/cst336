<?php
    //initializes array with default html container
    function init(){
        $divEntry = array();
        $divEntry["id"] = "html";
        $divEntry["color"] = "FF0000";
        $divEntry["height"] = "100";
        $divEntry["heightUnit"] = "percent";
        $divEntry["width"] = "100";
        $divEntry["widthUnit"] = "percent";
        $divEntry["position"] = "static";
        array_push($_SESSION["divs"], $divEntry);
        
        //test divs
        $divEntry["id"] = "test";
        $divEntry["parent"] = "html";
        $divEntry["color"] = "00FF00";
        $divEntry["height"] = "50";
        $divEntry["heightUnit"] = "px";
        $divEntry["width"] = "50";
        $divEntry["widthUnit"] = "px";
        $divEntry["position"] = "absolute";
        $divEntry["coordinates"] = array("top", "left", "bottom", "right");
        $divEntry["top"] = 10;
        $divEntry["left"] = 20;
        $divEntry["bottom"] = 30;
        $divEntry["right"] = 40;
        $divEntry["topUnit"] = percent;
        $divEntry["leftUnit"] = px;
        $divEntry["bottomUnit"] = percent;
        $divEntry["rightUnit"] = px;
        $divEntry["float"] = "left";
        $divEntry["clear"] = "right";
        
        array_push($_SESSION["divs"], $divEntry);
    }
    
    //display controls relative to current div
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
        echo "<input type='text' class='threeqtr-width-form' name='divID' placeholder=' div ID'/>";
        echo "<input type='submit' class='qtr-width-form' name='submit' value='Add'/><br>";
        
        //DIV DELETER
        echo "<input type='submit' class='full-width-form' name='submit' value='Delete'";
        if($div["id"] = "html"){
            echo " disabled";
        }
        echo "/>";
        echo "</form>";
    }
    
    function displayPositionPanel(){
        //Find current div by id
        foreach($_SESSION["divs"] as $div){
            if($div["id"] == $_SESSION["currentDiv"]){
                $currentDiv = $div;
            }
        }
        
        //COLOR PROPERTY
        echo "<label for='color'>Color</label>";
        echo "<input type='color' class='threeqtr-width-form' name='color' id='color' value='#";
        echo $currentDiv["color"] . "'><br>";
        
        //HEIGHT PROPERTY
        echo "<label for='height'>Height</label>";
        echo "<input type='number' class='half-width-form' id='height' name='height' ";
        echo "value='" . $currentDiv["height"] . "' />";
        echo "<select name='heightUnit' class='qtr-width-form'>";
        foreach(array("px", "percent") as $unit){
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
        foreach(array("px", "percent") as $unit){
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
            echo "<option value=" . $position . "'";
            if($currentDiv == $position){
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
            foreach(array("px", "percent") as $unit){
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
            foreach(array("px", "percent") as $unit){
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
            foreach(array("px", "percent") as $unit){
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
            foreach(array("px", "percent") as $unit){
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
            foreach(array("px", "percent") as $unit){
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
            foreach(array("px", "percent") as $unit){
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
            foreach(array("px", "percent") as $unit){
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
            foreach(array("px", "percent") as $unit){
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
        if($currentDiv["id"] == "html"){
            echo "disabled";
        }
        echo "/>";
    }
?>