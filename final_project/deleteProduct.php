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
 
 $sql = "SELECT productId FROM Orders GROUP BY productId";
 $statement = $connection->prepare($sql);
 $statement->execute();
 $records = $statement->fetchAll(PDO::FETCH_ASSOC);
 
 //check if in an existing order
 $inOrder = false;
 foreach($records as $record){
   if($_GET['productId'] == $record["productId"]){
     $inOrder = true;
   }
 }

 if($inOrder){
  echo '<div class="alert alert-danger m-0 text-center" role="alert">CANNOT DELETE: Item is in an order. Redirecting in 3 seconds.</div>';
 }
 else{
  $sql = "DELETE FROM Products WHERE productId =  " . $_GET['productId'];
  $statement = $connection->prepare($sql);
  $statement->execute();
  header("Location: admin.php");
 }
?>
<!DOCTYPE html>
<html>
 <head>
  <script
      src="https://code.jquery.com/jquery-3.3.1.min.js"
      integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
      crossorigin="anonymous">
    </script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">    </head>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
 </head>
 <body>
  <script>
   //redirects to admin after 3 seconds
   setTimeout(function(){
    $(location).attr('href', 'admin.php')
   }, 3000);
  </script>
  
 </body>
</html>