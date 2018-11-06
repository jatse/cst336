<!DOCTYPE html>
<html>
    <head>
        <?php 
            session_start();
            include 'inc/functions.php';
            echo "<style>";
            echo "head, body{margin: 0px;padding: 0px;height: 100%;width: 100%;border: 3px solid red;}";    
            generateStyle();
            echo ".generatedDiv{box-sizing: border-box;}";
            echo "</style>";
        ?>
    </head>
    <body>
        <?= generateDiv("body") ?>
    </body>
</html>