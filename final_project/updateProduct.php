<?php
    include 'dbConnection.php';
    
    $connection = getDatabaseConnection("FinalProject");
    
    function getCategories($catId) {
    global $connection;
    
    $sql = "SELECT catId, catDescription from ProductCategories ORDER BY catDescription";
    
    $statement = $connection->prepare($sql);
    $statement->execute();
    $records = $statement->fetchAll(PDO::FETCH_ASSOC);
    foreach ($records as $record) {
        echo "<option  ";
        echo ($record["catId"] == $catId)? "selected": ""; 
        echo " value='".$record["catId"] ."'>". $record['catDescription'] ." </option>";
    }
}
    
    function getProductInfo()
    {
        global $connection;
        $sql = "SELECT * FROM Products WHERE productId = " . $_GET['productId'];        
        $statement = $connection->prepare($sql);
        $statement->execute();
        $record = $statement->fetch(PDO::FETCH_ASSOC);
        
        return $record;
    }
    
    
    if (isset($_GET['updateProduct'])) {
                
        $sql = "UPDATE om_product
                SET storage = :storage,
                    bandwidth = :bandwidth,
                    memory = :memory,
                    productDescription = :productDescription,
                    productImage = :productImage,
                    price = :price,
                    catId = :catId
                WHERE productId = :productId";
        $np = array();
        $np[":storage"] = $_GET['storage'];
        $np[":bandwidth"] = $_GET['bandwidth'];
        $np[":memory"] = $_GET['memory'];
        $np[":productDescription"] = $_GET['description'];
        $np[":productImage"] = $_GET['productImage'];
        $np[":price"] = $_GET['price'];
        $np[":catId"] = $_GET['catId'];
        $np[":productId"] = $_GET['productId'];
                
        $statement = $connection->prepare($sql);
        $statement->execute($np);        
        
    }
    
    
    if(isset ($_GET['productId']))
    {
        $product = getProductInfo();
    }    
    
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Update Product </title>
        
    </head>
    <style>
        @import url("style.css");
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <body>
        <h1>Update Product</h1>
        
        <form>
            <input type="hidden" name="productId" value= "<?=$product['productId']?>"/>
            <strong>Storage:</strong> <input type="text" value = "<?=$product['storage']?>" name="storage"><br>
            <strong>Bandwidth:</strong> <input type="text" value = "<?=$product['bandwidth']?>" name="bandwidth"><br>
            <strong>Memory:</strong> <input type="text" value = "<?=$product['memory']?>" name="memory"><br>
            <strong>Description:</strong> <textarea name="description" cols = 50 rows = 4><?=$product['productDescription']?></textarea><br>
            <strong>Price:</strong> <input type="text" name="price" value = "<?=$product['price']?>"><br>
    
            <strong>Category:</strong> <select name="catId">
                <option>Select One</option>
                <?php getCategories( $product['catId'] ); ?>
            </select> <br />
            Set Image Url: <input type = "text" name = "productImage" value = "<?=$product['productImage']?>"><br>
            <input type="submit" name="updateProduct" value="Update Product">
            
        </form>
    </body>
</html>