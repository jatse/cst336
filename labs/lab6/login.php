<?php
    session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" href="css/style.css" type="text/css" />
        <title>Login Page</title>
    </head>
    <body>
        <div class="default-form">
            <div class="panel-body">
                <form method="POST" action="loginProcess.php">
                    Username <input type="text" class="form-control" name="username"/><br>
                    Password <input type="password" class="form-control" name="password"/><br>
                    <input type="submit" class="btn btn-primary" name="submitForm" value="Login" />
                    <br><br>
                    
                    <?php
                        if($_SESSION["incorrect"]){
                            echo "<p class='alert alert-danger' id='message'>";
                            echo "<strong>Incorrect Username or Password!</strong></p>";
                        }
                    ?>
                </form>
            </div>
        </div>
    </body>
</html>