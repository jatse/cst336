<?php
session_start();
if(!isset( $_SESSION['adminName']))
{
  header("Location:login.php");
}
include "dbConnection.php";
$conn = getDatabaseConnection("FinalProject");
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
    $productImage = $_GET['productImage'];
    $productPrice = $_GET['price'];
    $catId = $_GET['catId'];
    $storage = $_GET['storage'];
    $bandwidth = $_GET['bandwidth'];
    $memory = $_GET['memory'];


    
    $sql = "INSERT INTO om_product
            (`productDescription`, `productImage`, `price`, `catId`, `storage`, `bandwidth`, `memory`) 
             VALUES ( :productName, :productDescription, :productImage, :price, :catId, :storage, :bandwidth, :memory)";
    
    $namedParameters = array();
    $namedParameters[':productDescription'] = $productDescription;
    $namedParameters[':productImage'] = $productImage;
    $namedParameters[':price'] = $productPrice;
    $namedParameters[':catId'] = $catId;
    $namedParameters[':storage'] = $storage;
    $namedParameters[':bandwidth'] = $bandwidth;
    $namedParameters[':memory'] = $memory;
     $statement = $conn->prepare($sql);
    $statement->execute($namedParameters);
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title> Add product </title>
    </head>
    <style>
        @import url("style.css");
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <body>
        <h1> Add product</h1>
        <form>
            <strong>Storage:</strong> <input type="text" name="storage"><br>
            <strong>Bandwidth:</strong> <input type="text" name="bandwidth"><br>
            <strong>Memory:</strong> <input type="text" name="memory"><br>
            <strong>Description:</strong> <textarea name="description" cols = 50 rows = 4></textarea><br>
            <strong>Price:</strong> <input type="text" name="price"><br>
            <strong>Category:</strong> <select name="catId">
                <option value="">Select One</option>
                <?php getCategories(); ?>
            </select> <br />
            Set Image Url: <input type = "text" name = "productImage"><br>
            <input type="submit" name="submitProduct" value="Add Product">
            
        </form>
    </body>
</html>