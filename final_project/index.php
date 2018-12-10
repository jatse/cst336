<?php
    //get session variables and db connection
    session_start();
    include "dbConnection.php";
    $conn = getDatabaseConnection();
    
    //initialize cart
    if(!isset($_SESSION["cart"])){
        $_SESSION["cart"] = array();
    }
    
    //add item to cart if not already in cart
    if(isset($_GET["productId"])){
        if(!in_array($_GET["productId"], $_SESSION["cart"])){
            array_push($_SESSION["cart"], $_GET["productId"]);
        }
    }
    
    //NAVBAR FUNCTIONS
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
    
    //SEARCH BAR FUNCTIONS
    //populate Category filter select and check if selected
    //check selected active filter
    function checkFilledKeyword(){
        if(isset($_GET["keyword"])){
            echo "value='" . $_GET["keyword"] . "'";
        }
    }
    
    function getCategories(){
        global $conn;
        echo "<option>All</option>";
        
        $sql = "SELECT * FROM ProductCategories";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach($categories as $category){
            echo "<option value='" . $category["catId"] . "'";
            if($_GET["category"] == $category["catId"]){
                echo " selected";
            }
            echo ">" . $category["catDescription"] . "</option>";
        }
    }
    
    //check selected active filter
    function checkSelectedFilter($value){
        if($_GET["sort"] == $value){
            echo " selected";
        }
    }
    
    //PRODUCT LIST
    function getProductList(){
        global $conn;
        $param = array();
        
        $sql = "SELECT *";
        if($_GET["sort"] == "popular"){
            $sql .= ", COUNT(orderId)";
        }
        $sql .= " FROM Products";
        if($_GET["sort"] == "popular"){
            $sql .= " LEFT JOIN Orders USING (productId)";
        }
        if(isset($_GET["category"]) && is_numeric($_GET["category"])){
            $sql .= " WHERE catId = :category";
            $param[":category"] = $_GET["category"];
        }
        if($_GET["sort"] == "popular"){
            $sql .= " GROUP BY productId ORDER BY COUNT(orderId) DESC";
        }
        if(isset($_GET["sort"]) && $_GET["sort"] == "id"){
            $sql .= " ORDER BY productId";
        }
        if(isset($_GET["sort"]) && $_GET["sort"] == "valueASC"){
            $sql .= " ORDER BY price ASC";
        }
        if(isset($_GET["sort"]) && $_GET["sort"] == "valueDESC"){
            $sql .= " ORDER BY price DESC";
        }
       
        $stmt = $conn->prepare($sql);
        $stmt->execute($param);
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach($products as $product){
            $inCart = false;
            if(in_array($product["productId"], $_SESSION["cart"])){
                $inCart = true;
            }
            
            //Product container
            echo "<div id='product" . $product["productId"] . "' class='col col-lg-4 col-md-6 mb-1'>";
            //Inner spacing
            echo "<div class='row align-items-end p-2 m-1 rounded h-100";
            if($inCart){echo " bg-success";}
            else{echo " border border-primary";}
            //Image
            echo "'><span class='col-9 col-md-4 text-center my-auto'>";
            echo "<img src='img/" . $product["catId"] . ".png'>";
            //Button
            echo "<button form='mainForm' type='submit' class='mt-1 w-100 btn btn-sm small";
            if($inCart){echo " btn-outline light disabled'>Added";}
            else{echo " btn-primary' name='productId' value='" . $product["productId"] . "'>Add";}
            echo "</button></span>";
            //Product Description
            echo "<div class='col'><span class='small";
            if($inCart){echo " text-light";}
            echo "'>" . $product["productDescription"] . "</span>";
            //Price Tag
            echo "<br><br><span class='";
            if($inCart){echo " text-light";}
            else{echo " text-primary";}
            echo "'>Starting at <h6 class='d-inline'>$" . $product["price"] . "</h6>/month</span>";
            echo "</div></div></div>";
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
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">    </head>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
        
        <!--CSS STYLES-->
        <style type="text/css">
            body{
                min-width:845px;
            }
            .jumbotron{
                background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.7)),url("img/officeLaptops2.jpg");
                background-size: cover;
                height: 550px;
            }
            .jumbotron h1{
                text-shadow: 0px 1px 6px #000;
            }
            
            .form-control {
                border: 0;
            }
            #submitBtn{
                margin-top: -4px;
            }
        </style>
        
        <!--JAVASCRIPT/JQUERY SCRIPT-->
        <script>
            //AJAX call to filter products on screen
            function filterProductList(){
                //hide all products
                $("#productList").children().addClass("d-none");
                
                //show all products in filter list if available
                $.ajax({
                    type: "GET",
                    url: "api/getProductFilterList.php",
                    dataType: "json",
                    data: {"keyword": $("#keywordSearch").val()},
                    success: function(data, status){
                        for(var i = 0; i < data.length; i++){
                            var searchID = "product" + data[i].productId;
                            if($("#" + searchID).length > 0){
                                $("#" + searchID).removeClass("d-none");
                            }
                        }
                        //display error message if no product displayed
                        if($("#productList").children().length == $("#productList").children(".d-none").length){
                            $("#searchErrorMsg").removeClass("d-none");
                        }
                        else if(!$("searchErrorMsg").hasClass("d-none")){
                            $("#searchErrorMsg").addClass("d-none");
                        }
                    },
                    complete: function(data,status){
                        //FOR DEBUGGING
                        //console.log(status);
                    }
                });
            }
        </script>
    </head>
    
    <body class="pb-4">
        <!--NAVIGATION BAR-->
        <div class="navbar navbar-expand-lg navbar-dark bg-primary">
            <a class="navbar-brand" href="#"><b>Pelican Cloud Solutions</b></a>
            
            <div class="navbar-nav navbar-collapse d-flex justify-content-end">
                <?= displayLoginStatus(); ?>
                <a class="nav-item nav-link px-3" href="cart.php">
                    Cart&nbsp
                    <?= displayCartCount(); ?>
                </a>
            </div>
        </div>
        
        <!--JUMBOTRON-->
        <div class="jumbotron jumbotron-fluid text-light text-center mb-0">
            <h1 class="display-3 mt-5 pt-5">Sustainable solutions for scalable needs</h1>
            <h1 class="lead text-white">Sign up today and get 1gb of free storage</h1>
            <a class="btn btn-primary btn-lg mt-5 px-5" href="#productSearchBar" role="button">Get Started</a>
        </div>
        
        <!--SEARCH BAR-->
        <div id='productSearchBar' class="bg-primary text-light text-center py-3">
            <form id='mainForm' class='form-control form-inline d-inline bg-primary text-light' action='#productSearchBar'>
                <label class='d-inline' for='keywordSearch'>Search</label>
                <input class='pr-5 mr-5' type='text' id='keywordSearch' name='keyword' placeholder=' Keyword' onkeyup="filterProductList()" <?= checkFilledKeyword(); ?> />
                &nbsp;
                <label class='d-inline' for='categoryFilter'>Category </label>
                <select id='categoryFilter' name='category'>
                    <?= getCategories(); ?>
                </select>
                &nbsp;
                <label class='d-inline' for='sortFilter'>Sort by </label>
                <select id='sortFilter' name='sort'>
                    <option value='id' <?= checkSelectedFilter("id") ?>>Default</option>
                    <option value='popular'<?= checkSelectedFilter("popular") ?>>Most Popular</option>
                    <option value='valueASC' <?= checkSelectedFilter("valueASC") ?>>Price: Low to High</option>
                    <option value='valueDESC' <?= checkSelectedFilter("valueDESC") ?>>Price: High to Low</option>
                </select>
                &nbsp;
                <input type='submit' id='submitBtn' class='btn btn-outline-light' value='Apply'/>
            </form>
        </div>
        
        <div id="searchErrorMsg" class="alert alert-danger text-center d-none">
            No matching products found.
        </div>
        
        <!--PRODUCT LIST-->
        <!--AJAX FILTER-->
        <!--Default: show all products-->
        <div id="productList" class="row m-3">
            <?= getProductList(); ?>
            <script>
                filterProductList();
            </script>
        </div>
        
        <!--FOOTER-->
        <footer class="bg-primary text-light text-center py-2 fixed-bottom small">
            This site is fictional and made for educational purposes only.
        </footer>
        
    </body>
</html>