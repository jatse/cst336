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
 $connection = getDatabaseConnection();

 $sql = "DELETE FROM Products WHERE productId =  " . $_GET['productId'];
 $statement = $connection->prepare($sql);
 $statement->execute();
 
 header("Location: admin.php");
?>