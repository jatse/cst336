<?php
    include "inc/header.php";
    
    include "dbConnection.php";
        $conn = getDatabaseConnection("pets");
        
        $sql = "SELECT pictureURL FROM pets";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $record = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

    
<div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
  <div class="carousel-inner">
      <?php
        for($i = 0; $i < count($record); $i++){
            echo "<div class='carousel-item";
            if($i == 0){
                echo " active";
            }
            echo "'><img class='d-block' src='img/" . $record[$i]["pictureURL"] . "'>";
            echo "</div>";
        }
      ?>
  </div>
</div>
    
    
<br>
<a class="btn btn-outline-primary" href="pets.php" role="button">Adopt Now! </a>
<br><br>
<hr>

<?php
    include "inc/footer.php";
?>