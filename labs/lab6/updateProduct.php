<?php    
    session_start();
    include "dbConnection.php";
    $conn = getDatabaseConnection("ottermart");
    
    if(!isset($_SESSION["adminName"])){
        header("Location:login.php");
    }
    
    if(isset($_GET["updateProduct"])){
        $sql = "UPDATE om_product 
                SET productName = :productName, 
                    productDescription = :productDescription, 
                    productImage = :productImage, 
                    price = :price, 
                    catId = :catId 
                WHERE productId = :productId";
        
        $np = array();
        $np[":productName"] = $_GET["productName"];
        $np[":productDescription"] = $_GET["description"];
        $np[":productImage"] = $_GET["productImage"];
        $np[":price"] = $_GET["price"];
        $np[":catId"] = $_GET["catId"];
        $np[":productId"] = $_GET['productId'];
        
        $stmt = $conn->prepare($sql);
        $stmt->execute($np);
        
        echo "<p class='alert alert-success' id='message'>Product successfully updated!</p>";
    }
    
    if(isset($_GET["productId"])){
        $product = getProductInfo();
    }
    
    function getProductInfo(){
        global $conn;
        $sql = "SELECT * FROM om_product WHERE productId = " . $_GET["productId"];
        
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $record = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $record;
    }

    function getCategories($catId){
        global $conn;
        $sql = "SELECT catId, catName FROM om_category ORDER BY catName";
        
        $stmt = $conn->prepare($sql);
        $stmt-> execute();
        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach($records as $record){
            echo "<option ";
            echo ($record["catId"] == $catId)? "selected" : "";
            echo " value='" . $record["catId"] . "'>" . $record["catName"] . " </option>";
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
        <title>Update Product Page</title>
    </head>
    <body>
        <div class="default-form">
            <form>
                <input type="hidden" name="productId" value="<?=$product['productId']?>" />
                <strong>Product name</strong><input type="text" class="form-control" name="productName" value="<?=$product['productName']?>" /><br>
                <strong>Description</strong><textarea class="form-control" name="description" col=50 rows=4><?=$product['productDescription']?></textarea><br>
                <strong>Price</strong><input type="text" class="form-control" name="price" value="<?=$product['price']?>" /><br>
                <strong>Category</strong><select class="form-control" name="catId"/>
                    <option value=""></option>
                    <?= getCategories($product['catId']); ?>
                </select><br>
                <strong>Set Image Url</strong><input type="text" class="form-control" name="productImage" value="<?=$product['productImage']?>"><br>
                <input type="submit" name="updateProduct" class="btn btn-primary" value="Update Product">
            </form>
            <form action="admin.php" class="inlineButton">
                <input type="submit" class="btn btn-secondary" value="Back" />
            </form>
        </div>
    </body>
</html>