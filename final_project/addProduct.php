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
include "dbConnection.php";
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

function getCategories() {
    global $conn;
    
    $sql = "SELECT catId, catDescription from ProductCategories ORDER BY catDescription";
    
    $statement = $conn->prepare($sql);
    $statement->execute();
    $records = $statement->fetchAll(PDO::FETCH_ASSOC);
    foreach ($records as $record) {
        echo "<option value='".$record["catId"] ."'>". $record['catDescription'] ." </option>";
    }
}
if (isset($_GET['submitProduct'])) {
    $productDescription = $_GET['description'];
    $productPrice = $_GET['price'];
    $catId = $_GET['catId'];
    $storage = $_GET['storage'];
    $bandwidth = $_GET['bandwidth'];
    $memory = $_GET['memory'];

    if(strlen(trim($productDescription)) > 0){
        $sql = "INSERT INTO Products
                (`productDescription`, `price`, `catId`, `storage`, `bandwidth`, `memory`) 
                 VALUES (:productDescription, :price, :catId, :storage, :bandwidth, :memory)";
        
        $namedParameters = array();
        $namedParameters[':productDescription'] = $productDescription;
        $namedParameters[':price'] = $productPrice;
        $namedParameters[':catId'] = $catId;
        $namedParameters[':storage'] = $storage;
        $namedParameters[':bandwidth'] = $bandwidth;
        $namedParameters[':memory'] = $memory;
        $statement = $conn->prepare($sql);
        $statement->execute($namedParameters);
        header('Location: admin.php');
    }
    else{
        echo '<div class="alert alert-danger m-0" role="alert">Product Description cannot be blank</div>';
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title> Add product </title>
    </head>
    <script
      src="https://code.jquery.com/jquery-3.3.1.min.js"
      integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
      crossorigin="anonymous">
    </script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">    </head>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <body class="pb-4">
        
        <!--NAVIGATION BAR-->
        <div class="navbar navbar-expand-lg navbar-dark bg-primary">
            <a class="navbar-brand" href="index.php"><b>Pelican Cloud Solutions</b></a>
            
            <div class="navbar-nav navbar-collapse d-flex justify-content-end">
                <?= displayLoginStatus(); ?>
            </div>
        </div>
        <br>
        <h1 class="text-center"> Add product</h1>
        <form class="text-left w-50 px-5 mx-auto">
            <strong>Storage:</strong><br><input type="text" name="storage"><br>
            <strong>Bandwidth:</strong><br><input type="text" name="bandwidth"><br>
            <strong>Memory:</strong><br><input type="text" name="memory"><br>
            <strong>Description:</strong><br><textarea name="description" cols = 50 rows = 4></textarea><br>
            <strong>Price:</strong><br><input type="text" name="price"><br>
            <strong>Category:</strong><br>
            <select name="catId">
                <?php getCategories(); ?>
            </select> <br /><br>
            <input class="btn"  type="submit" name="submitProduct" value="Add Product">
            
        </form>
        
        <!--FOOTER-->
        <footer class="bg-primary text-light text-center py-2 fixed-bottom small">
            This site is fictional and made for educational purposes only.
        </footer>
    </body>
</html>