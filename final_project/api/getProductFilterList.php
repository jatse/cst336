<?php
    include "../dbConnection.php";
    $conn = getDatabaseConnection();
    
    $sql = "SELECT productId FROM Products WHERE productDescription LIKE :keyword";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute(array("keyword"=>"%".$_GET["keyword"]."%"));
    $filterList = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($filterList);
?>