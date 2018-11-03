<?php
include 'dbConnection.php';

$conn = getDatabaseConnection();
 
//Displays categories for drop down menu
function displayCategories(){
    global $conn;
    
    $sql = "SELECT catId, catName FROM om_category ORDER BY catName";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach($records as $record){
        echo "<option value='" . $record["catId"] . "' >" . $record["catName"] . "</option>";
    }
}
    
//Display results of search if submitted 
function displaySearchResults(){
    global $conn;
    if(isset($_GET['searchForm'])){
        echo "<h3>Products Found: </h3>";
        //Query below prevents SQL injections
        $namedParameters = array();
        
        $sql = "SELECT * FROM om_product WHERE 1";
        
        if(!empty($_GET["product"])){
            $sql .= " AND (productName LIKE :productName";
            $sql .= " OR productDescription LIKE :productName)";
            $namedParameters[":productName"] = "%" . $_GET["product"] . "%";
        }
        
        if(!empty($_GET["category"])){
            $sql .= " AND catId = :categoryId";
            $namedParameters[":categoryId"] = $_GET["category"];
        }
        
        if(!empty($_GET["priceFrom"])){
            $sql .= " AND price >= :priceFrom";
            $namedParameters[":priceFrom"] = $_GET["priceFrom"];
        }
        
        if(!empty($_GET["priceTo"])){
            $sql .= " AND price <= :priceTo";
            $namedParameters[":priceTo"] = $_GET["priceTo"];
        }
        
        if(isset($_GET["orderBy"])){
            if($_GET["orderBy"] == "price"){
                $sql .= " ORDER BY price";
            } else {
                $sql .= " ORDER BY productName";
            }
        }
        
        $stmt = $conn->prepare($sql);
        $stmt->execute($namedParameters);
        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach($records as $record){
            echo "<div class='productInfo'>";
            echo "<b>" . $record["productName"] . "</b><br />" . $record["productDescription"] . "<br /><b>$" . $record["price"] . "</b><br />";
            echo "<a href=\"purchaseHistory.php?productId=" . $record["productId"] . "\"> History</a> <br /><br />";
            echo "</div>";
        }
    }
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title>OtterMart Product Search</title>
        <link href="css/styles.css" rel="stylesheet" type="text/css" />
    </head>
    
    <body>
        <div id="searchBar">
            <h1>OtterMart Product Search</h1>
            
            <form>
                <div class="formItem">
                    Product: <input type="text" name="product"/>&nbsp&nbsp;
                </div>
                <div class="formItem">
                    Category: 
                    <select name="category">
                        <option value="">Select One</option>
                        <?=displayCategories()?>
                    </select>
                    &nbsp;
                    &nbsp;
                </div>
                <div class="formItem">
                Price: From <input type="text" name="priceFrom" size="7"/>
                       To   <input type="text" name="priceTo" size="7"/>
                </div>
                <br />
                Order result by:
                <input type="radio" name="orderBy" value="price" /> Price
                &nbsp;
                <input type="radio" name="orderBy" value="name" /> Name
                <br />
                <input type="submit" value="Search" name="searchForm" />
            </form>
            
            <br />
        </div>
        
        <hr>
        <div id="productDisplay">
            <?=displaySearchResults()?>
        </div>
    </body>
</html>