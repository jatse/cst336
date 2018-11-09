<?php    
    session_start();
    include "dbConnection.php";
    $conn = getDatabaseConnection("ottermart");
    
    if(!isset($_SESSION["adminName"])){
        header("Location:login.php");
    }
    
    if(isset($_GET["submitProduct"])){
        $productName = $_GET["productName"];
        $productDescription = $_GET["description"];
        $productImage = $_GET["productImage"];
        $productPrice = $_GET["price"];
        $catId = $_GET["catId"];
        
        $sql = "INSERT INTO om_product (productName, productDescription, productImage, price, catId)
                VALUES (:productName, :productDescription, :productImage, :price, :catId)";
                
        $np = array();
        $np[":productName"] = $productName;
        $np[":productDescription"] = $productDescription;
        $np[":productImage"] = $productImage;
        $np[":price"] = $productPrice;
        $np[":catId"] = $catId;
        
        $stmt = $conn->prepare($sql);
        $stmt-> execute($np);
        
        echo "<p class='alert alert-success' id='message'>Product successfully added!</p>";
    }

    function getCategories(){
        global $conn;
        $sql = "SELECT catId, catName FROM om_category ORDER BY catName";
        $stmt = $conn->prepare($sql);
        $stmt-> execute();
        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach($records as $record){
            echo "<option value='" . $record["catId"] . "'>" . $record["catName"] . " </option>";
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" href="css/style.css" type="text/css" />
        <title>Add Product Page</title>
    </head>
    <body>
        <div class="default-form">
            <form>
                <strong>Product name</strong><input type="text" class="form-control" name="productName" /><br>
                <strong>Description</strong><textarea class="form-control" name="description" col=50 rows=4></textarea><br>
                <strong>Price</strong><input type="text" class="form-control" name="price"/><br>
                <strong>Category</strong><select class="form-control" name="catId"/>
                    <option value=""></option>
                    <?= getCategories(); ?>
                </select><br>
                <strong>Set Image Url</strong><input type="text" class="form-control" name="productImage"><br>
                <input type="submit" name="submitProduct" class="btn btn-primary" value="Add Product">
            </form>
            <form action="admin.php" class="inlineButton">
                <input type="submit" class="btn btn-secondary" value="Back" />
            </form>
        </div>
    </body>
</html>