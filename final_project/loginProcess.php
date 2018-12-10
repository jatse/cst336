<?php
    
    session_start();
    include 'dbConnection.php';
    
    $conn = getDatabaseConnection();
    
    $_SESSION["customer"] = false;
    
    $username = $_POST['username'];
    $password = sha1($_POST['password']);
    
    $sql = "SELECT * FROM Admin
            WHERE username = :username
            AND password = :password";
    
    $np = array();
    $np[":username"] = $username;
    $np[":password"] = $password;
    
    $stmt = $conn->prepare($sql);
    $stmt->execute($np);
    $record = $stmt->fetch(PDO::FETCH_ASSOC);   // expecting one single Admin record
    
    $sql = "SELECT * FROM Customers
            WHERE email = :username
            AND password = :password";
    
    $np = array();
    $np[":username"] = $username;
    $np[":password"] = $password;
    
    $stmt = $conn->prepare($sql);
    $stmt->execute($np);
    $record2 = $stmt->fetch(PDO::FETCH_ASSOC);   // expecting one single Customer record
    
    if (empty($record) && empty($record2)) {    // Wrong credentials
        $_SESSION['incorrect'] = true;
        header("Location:login.php");
    } else if (!empty($record)) {       // Admin
        $_SESSION['incorrect'] = false;
        $_SESSION['adminName'] = $record['firstName'] . " " . $record['lastName'];
        header("Location:admin.php");
    } else {                            // Customer
        $_SESSION['incorrect'] = false;
        $_SESSION['adminName'] = $record2['firstName'] . " " . $record2['lastName'];
        $_SESSION["customer"] = true;
        header("Location:index.php");
    }
    
?>