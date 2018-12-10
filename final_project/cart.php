<?php
session_start();
include 'dbConnection.php';
$conn = getDatabaseConnection();

if (isset($_GET["removeId"]))
	for ($i=0; $i < count($_SESSION["cart"]); $i++)
		if ($_GET["removeId"]==$_SESSION["cart"][$i])
			unset($_SESSION["cart"][$i]);
	print_r ($_SESSION["cart"][$i]);
if (isset($_GET["clearCart"])) {
    $_SESSION["cart"] = array();
}

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
    
    //Displays amount of items in cart
    function displayCartCount(){
        if(count($_SESSION["cart"]) > 0){
            echo "<span class='badge badge-light'>";
            echo count($_SESSION["cart"]);
            echo "</span>";
        }
    }


function displayCart() {
//	print_r ($_SESSION["cart"]);
	echo "<table class = 'table'>";
	echo "<tr><th>Description</th><th>Price</th><th></th></tr>";
	foreach ($_SESSION["cart"] as $productId) {
    	global $conn;
    	$sql="SELECT productDescription, price FROM Products
    		WHERE productId = :id";
		$statement = $conn->prepare($sql);
    	$statement->execute(array(":id" => $productId));
    	$records = $statement->fetchAll(PDO::FETCH_ASSOC);
    //	print_r ($records);
		
    	$id = $productId;
		$desc = $records[0]["productDescription"];
		$price = $records[0]["price"];
		$total_price = $total_price+$price;
		
		
    	echo"<tr><td>".$desc."</td>";
      	echo"<td>$".$price."</td>";
    	echo "<td><form method='get' id='removeForm".$id."'><input type='hidden' value='".$id."' name='removeId'>" .
		"<button class = 'btn btn-primary' type='submit'>Remove</button></form></td>";
		
	}
		$tax = number_format($total_price*(0.075), 2);
		echo "</tr>";
		echo"<tr><td>Shipping</td><td>\$0</td><td></td>";
		echo "</tr>";
		echo "</tr>";
		echo"<tr><td>Tax</td><td>$" . $tax . "</td><td></td>";
		echo "</tr>";
		echo "</tr>";
		echo"<tr><td>Total</td><td>$" . ($total_price + $tax) . "</td><td><button class='btn btn-primary' disabled>Checkout</button</td>";
		echo "</tr>";


	echo "</table><hr>";
}

?>

<!DOCTYPE html>
<html>
<head>
	<title> Shopping Cart </title>
	
	<script
          src="https://code.jquery.com/jquery-3.3.1.min.js"
          integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
          crossorigin="anonymous">
        </script>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">    </head>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
        
	
</head>
<body class="pb-4">
	
	<div class="navbar navbar-expand-lg navbar-dark bg-primary">
            <a class="navbar-brand" href="index.php"><b>Pelican Cloud Solutions</b></a>
            
            <div class="navbar-nav navbar-collapse d-flex justify-content-end">
                <?= displayLoginStatus(); ?>
            </div>
        </div><br>
	
	<h2 class="text-center"> Shopping Cart </h2>
    <?php
    if (count($_SESSION["cart"]) > 0) {
    ?>
    <form method="get" class="text-center">
        <input class = 'btn btn-primary'type="submit" name="clearCart" value="Clear cart">
    </form>
    <br><br>
	<?php displayCart(); ?>
    <?php } else { ?>
    <h3> Your shopping cart is empty </h3>
    <?php } ?>
    
    <!--FOOTER-->
    <footer class="bg-primary text-light text-center py-2 fixed-bottom small">
        This site is fictional and made for educational purposes only.
    </footer>
</body>
</html>