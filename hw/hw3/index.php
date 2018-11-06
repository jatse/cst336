<?php
    session_start();
    include 'inc/functions.php';
    
    //initialize layout if new session
    if(!isset($_SESSION['divs'])){
        $_SESSION['divs'] = array();
        $_SESSION['currentDiv'] = "html";
        init();
    }
    
    //change current div if selected
    if($_POST["submit"] == "Select"){
        $_SESSION["currentDiv"] = $_POST["divName"];
    }

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Jason Tse: Homework 3</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css/style.css" type="text/css" />
    </head>
    <body>
        <div id="controlArea">
            <h1>
                HTML & CSS<br/>
                WIREFRAME
            </h1>
            
            <form method="post" id="divPanel">
                <?= displayDivPanel() ?>
            </form>
            
            <hr />
            
            <form method="post" id="positionPanel">
                <?= displayPositionPanel() ?>
            </form>
            
            <hr />
            
            <form action="output.php" target="_blank" method="post" id="outputPanel">
                <input type="submit" class="full-width-form" name="submit" value="Generate Code" />
            </form>
            
        </div>
        <div id="displayArea">
            
        </div>
    </body>
</html>