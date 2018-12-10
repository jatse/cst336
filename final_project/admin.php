<?php
session_start();

if(!isset( $_SESSION['adminName']))
{
  header("Location:login.php");
}
else if ($_SESSION['customer'] == true)
{
    header("Location:index.php");
}
include 'dbConnection.php';
$conn = getDatabaseConnection();

//Displays user/admin name
function displayLoginStatus(){
    //---CHECKING ADMIN LOGIN---------------------
    if(isset($_SESSION["adminName"]) && $_SESSION["adminName"] != false){
        echo "<div class='nav-item px-3'>";
        echo "<span class='text-light'>Hello ";
        if(!$_SESSION["customer"]){
            echo "<a class='text-light' href='admin.php'>";
        }
        echo $_SESSION["adminName"];
        if(!$_SESSION["customer"]){
            echo "</a>";
        }
        echo "! (</span>";
        echo "<a class='nav-link d-inline p-0' href='logout.php'>Logout</a>";
        echo "<span class='text-light'>)</span></div>";
        
    }
    else{
        echo "<a class='nav-item nav-link px-3' href='login.php'>Login</a>";
    }
}

function displayAllProducts(){
    global $conn;
    $sql="SELECT * FROM Products";
    $statement = $conn->prepare($sql);
    $statement->execute();
    $records = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $records;
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title> Admin Page </title>
        
    <script
      src="https://code.jquery.com/jquery-3.3.1.min.js"
      integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
      crossorigin="anonymous">
    </script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">    </head>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script>
            
            function confirmDelete() {
                
                return confirm("Are you sure you want to delete it?");
                
            }
            
        </script>
        
    </head>
    <body class="pb-4 text-center">
        <!--NAVIGATION BAR-->
        <div class="navbar navbar-expand-lg navbar-dark bg-primary">
            <a class="navbar-brand" href="index.php"><b>Pelican Cloud Solutions</b></a>
            
            <div class="navbar-nav navbar-collapse d-flex justify-content-end">
                <?= displayLoginStatus(); ?>
            </div>
        </div><br>
         <h1> Admin Page </h1>        

        <form class="d-inline" action="addProduct.php">
            <input class="btn" type="submit" name="addproduct" value="Add Product"/>
        </form>
        
        <form class="d-inline" action="report.php">
            <input class="btn" type="submit" name="report" value="Reports"/>
        </form>        
        <br /> <br />
        
        <?php $records=displayAllProducts();
        echo "<table class = 'table'>";
        echo "<tr><th></th><th></th><th class='text-center'>Products</th><th>Storage</th><th>Bandwidth</th><th>Memory</th><th>Price</th></tr>";
            foreach($records as $record) {
                echo "<tr><td>";
                echo "[<a href='updateProduct.php?productId=".$record['productId']."'>Update</a>]";
                echo "</td>";
                echo"<td>";
                echo "<form action='deleteProduct.php' onsubmit='return confirmDelete()'>";
                echo "<input type='hidden' name='productId' value= " . $record['productId'] . " />";
                echo "<input class='btn' type='submit' value='Remove'>";
                echo "</td>";
                
                echo "<td>";
                echo $record['productDescription'];
                echo "</td>";

                echo "<td>";
                echo $record['storage'];
                echo "</td>";
                
                echo "<td>";
                echo $record['bandwidth'];
                echo "</td>";
                
                echo "<td>";
                echo $record['memory'];
                echo "</td>";
                
                echo "<td>";
                echo $record['price'];
                echo "</td>";
                
                echo "</tr>";
            }
            echo "</table>";
        
        ?>
        
        <!--FOOTER-->
        <footer class="bg-primary text-light text-center py-2 fixed-bottom small">
            This site is fictional and made for educational purposes only.
        </footer>
    </body>
</html>