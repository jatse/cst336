<?php
    session_start();
    include "dbConnection.php";
    
    if(!isset($_SESSION["adminName"])){
        header("Location:login.php");
    }
    
    function displayAllProducts(){
        $conn = getDatabaseConnection("ottermart");
        $sql = "SELECT * FROM om_product ORDER BY productId";
        $stmt = $conn->prepare($sql);
        $stmt-> execute();
        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $records;
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
        <title>Admin Page</title>
        <script>
            function confirmDelete(){
                return confirm("Are you sure you want to delete the product?")
            }
        </script>
    </head>
    <body>
        <div class="buttonBar">
            <form action="logout.php">
                <input type="submit" class="btn btn-secondary" id="logoutButton" value="Logout" />
            </form>
            <form action="addProduct.php">
                <input type="submit" class="btn btn-primary" id="addButton" name="addproduct" value="Add Product" />
            </form>
        </div>
        <?php
            $records = displayAllProducts();
            echo "<table class='table table-hover'>";
            echo "<thead>
                    <tr>
                        <th scope='col'>ID</th>
                        <th scope='col'>Name</th>
                        <th scope='col'>Description</th>
                        <th scope='col'>Price</th>
                        <th scope='col'>Update</th>
                        <th scope='col'>Remove</th>
                    </tr>
                </thead>";
                
            echo "<tbody>";
            foreach($records as $record){
                echo "<tr>";
                echo "<td>" . $record["productId"] . "</td>";
                echo "<td>" . $record["productName"] . "</td>";
                echo "<td>" . $record["productDescription"] . "</td>";
                echo "<td>$" . $record["price"] . "</td>";
                echo "<td><a class='btn btn-primary' href='updateProduct.php?productId=" . $record['productId'] . "'>Update</a></td>";
                echo "<form action='deleteProduct.php' onsubmit='return confirmDelete()'>";
                echo "<input type='hidden' name='productId' value=" . $record['productId'] . " />";
                echo "<td><input type='submit' class='btn btn-danger' value='Remove'></td>";
                echo "</form></tr>";
            }
            echo "</tbody>";
            echo "</table>"
        ?>
    </body>
</html>