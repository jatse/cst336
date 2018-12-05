<?php
session_start();
if(!isset( $_SESSION['adminName']))
{
  header("Location:login.php");
}
include 'dbConnection.php';
$conn = getDatabaseConnection("FinalProject");
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
        
            <style>
        @import url("style.css");
        form {
                display: inline;
            }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        
        <script>
            
            function confirmDelete() {
                
                return confirm("Are you sure you want to delete it?");
                
            }
            
        </script>
        
    </head>
    <body>


        
        <h1> Admin Page </h1>        
        <br />
        <form action="addProduct.php">
            <input type="submit" name="addproduct" value="Add Product"/>
        </form>
        
        <form action="logout.php">
            <input type="submit"  value="Logout"/>
        </form>
        
        <br /> <br />
        <strong> Products: </strong> <br />
        
        <?php $records=displayAllProducts();
        echo "<table class = 'table'>";
            foreach($records as $record) {
                echo "<td>";
                echo "[<a href='updateProduct.php?productId=".$record['productId']."'>Update</a>]";
                echo "</td>";
                echo"<td>";
                echo "<form action='deleteProduct.php' onsubmit='return confirmDelete()'>";
                echo "<input type='hidden' name='productId' value= " . $record['productId'] . " />";
                echo "<input type='submit' value='Remove'>";
                
                echo "</form>";
                echo "</td>";
                echo "<td>";
                
                echo $record['storage'];
                echo $record['bandwidth'];
                echo $record['memory'];
                echo '<br>';
                echo "</td>";
                echo "</tr>";
            }
            echo "</table>";
        
        ?>
    </body>
</html>