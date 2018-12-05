<?php
 include 'dbConnection.php';
    
 $connection = getDatabaseConnection("FinalProject");
    
 $sql = "DELETE FROM Products WHERE productId =  " . $_GET['productId'];
 $statement = $connection->prepare($sql);
 $statement->execute();
 
 header("Location: admin.php");
?>