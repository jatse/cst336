<!DOCTYPE html>
<html>
    <head>
        <title>Pelican Cloud Solutions</title>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
        <!--CSS STYLES-->
        <style type="text/css">
            form {
                margin: 0 auto;
                font-size: 20px;
            }
            input {
                margin-top: 5px;
            }
        </style>
    </head>
    
    <body class="pb-4">
        <!--NAVIGATION BAR-->
        <div class="navbar navbar-expand-lg navbar-dark bg-primary">
            <a class="navbar-brand" href="index.php"><b>Pelican Cloud Solutions</b></a>
        </div>
        
        <br>
        <form class = 'text-center' method="POST" action="loginProcess.php">
            <input type="text" name="username" placeholder="Username" autofocus/><br>
            <input type="password" name="password" placeholder="Password"/><br>
            <br>
            <input type="submit" class="btn btn-primary" name="submitForm" value="Login"/>
            <br><br>
            <?php
                session_start();
                if ($_SESSION['incorrect']) {
                    echo "<p class='lead' id='error' style='color:red'>";
                    echo "<strong>Incorrect Username or Password!<br>Verify your credentials and try again.</strong></p>";
                }
                unset($_SESSION['incorrect']);
            ?>
        </form>
        
        <!--FOOTER-->
        <footer class="bg-primary text-light text-center py-2 fixed-bottom small">
            This site is fictional and made for educational purposes only.
        </footer>
    </body>