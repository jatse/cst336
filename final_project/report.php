<?php
    session_start();
            
    if (!isset($_SESSION['incorrect']) || $_SESSION['incorrect'] == true || $_SESSION['customer'] == true)
    {
        header("Location:login.php");
    }
    
    include 'dbConnection.php';
    $conn = getDatabaseConnection();

    //Displays user/admin name
    function displayLoginStatus(){
        //---CHECKING ADMIN LOGIN---------------------
        if(isset($_SESSION["adminName"]) && $_SESSION["adminName"] != false){
            echo "<div class='nav-item px-3'>";
            echo "<span class='text-light'>Hello ";
            if(!$_SESSION["customer"]){
                echo "<a class='text-light' href='admin.php'>";
            }
            echo $_SESSION["adminName"];
            if(!$_SESSION["customer"]){
                echo "</a>";
            }
            echo "! (</span>";
            echo "<a class='nav-link d-inline p-0' href='logout.php'>Logout</a>";
            echo "<span class='text-light'>)</span></div>";
            
        }
        else{
            echo "<a class='nav-item nav-link px-3' href='login.php'>Login</a>";
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Pelican Cloud Solutions</title>
        <script
          src="https://code.jquery.com/jquery-3.3.1.min.js"
          integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
          crossorigin="anonymous">
        </script>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
        <!--CSS STYLES-->
        <style type="text/css">
            form {
                font-size: 20px;
            }
            table {
                margin: 0 auto;
            }
            th, td {
                padding: 5px 10px;
            }
            h2 {
                text-align: center;
            }
        </style>
    </head>
    
    <body class="pb-4">
        <!--NAVIGATION BAR-->
        <div class="navbar navbar-expand-lg navbar-dark bg-primary">
            <a class="navbar-brand" href="index.php"><b>Pelican Cloud Solutions</b></a>
            
            <div class="navbar-nav navbar-collapse d-flex justify-content-end">
                <?= displayLoginStatus(); ?>
            </div>
        </div>
        
        <br><h2>Generate Reports</h2><br>
        
        <form method="post" class = 'text-center'>
            <select name="reports" size="4" class="px-3">
                <option value="AvgPrice">Average Product Price</option>
                <option value="NoOrders">Customers without Orders</option>
                <option value="Top10Cust">Top 10 Customers by Value</option>
                <option value="Top10Prod">Top 10 Products by Purchases</option>
            </select>
            <br><br>
            <input type="submit" class="btn btn-primary" value="Generate">
            <br><br>
        </form>
        
        <?php
            
            $avgPrice = "SELECT COUNT(productId) AS 'Number of Products', CONCAT('$', ROUND(AVG(price), 2)) AS 'Average Price' FROM Products;";
            $noOrders = "SELECT c.custId, firstName, lastName, email
                         FROM Customers c
                         LEFT JOIN Orders o ON c.custId = o.custId
                         WHERE o.custId IS NULL;";
            $top10Cust = "SELECT c.custId, firstName, lastName, email, SUM(o.total) AS 'Total'
                          FROM Customers c
                          JOIN Orders o ON c.custId = o.custId
                          GROUP BY o.custId
                          ORDER BY SUM(total) DESC
                          LIMIT 10;";
            $top10Prod = "SELECT o.productId, pc.catDescription Category, p.productDescription Product, p.price, COUNT(o.productId) Purchases
                          FROM Orders o
                          JOIN Products p ON p.productId = o.productId
                          JOIN ProductCategories pc ON p.catId = pc.catId
                          GROUP BY productId
                          ORDER BY Purchases DESC, p.price DESC
                          LIMIT 10;";
                          
            if(isset($_POST['reports'])){
            
                $report = $_POST['reports'];
                
                switch ($report) {
                    case 'AvgPrice':
                        $sql = $avgPrice;
                        $caption = 'Average Product Price';
                        break;
                    case 'NoOrders':
                        $sql = $noOrders;
                        $caption = 'Customers without Orders';
                        break;
                    case 'Top10Cust':
                        $sql = $top10Cust;
                        $caption = 'Top 10 Customers by Value';
                        break;
                    case 'Top10Prod':
                        $sql = $top10Prod;
                        $caption = 'Top 10 Products by Purchases';
                        break;
                    default : return;
                }
                
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                $keys = array_keys($records[0]);    // Selected Columns from DB
                echo '<h5 class="text-center">' . $caption . '</h5>';
                echo '<table class="table-striped">';
                echo '<tr>';
                foreach($keys as $key)
                {
                    echo '<th>' . $key . '</th>';   // Column Names
                }
                echo '</tr>';
                
                foreach ($records as $record)
                {
                    echo '<tr>';
                    foreach($keys as $key)
                    {
                        echo '<td>' . $record[$key] . '</td>';  // Records
                    }
                    echo '</tr>';
                }
                echo '</table>';
            }
        ?>
        <br>
        <footer class="bg-primary text-light text-center py-2 fixed-bottom small">
            This site is fictional and made for educational purposes only.
        </footer>
    </body>
</html>