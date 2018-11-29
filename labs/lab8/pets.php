<?php
    include "inc/header.php";

    //grabs list of pets from DB
    function getPetList(){
        include "dbConnection.php";
        $conn = getDatabaseConnection("pets");
        
        $sql = "SELECT * FROM pets";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $record = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $record;
    }
?>

<script>
    //AJAX call. Send id, output info.
    $(document).ready(function(){
        $(".petLink").click(function(){
            
            //alert($(this).attr("id"));
            //Display modal
            $("#petInfoModal").modal("show");
            $("#petInfo").html("<img src='img/loading.gif'>");
            
            $.ajax({
                type: "GET",
                url: "api/getPetInfo.php",
                dataType: "json",
                data: {"id": $(this).attr("id")},
                success: function(data, status){
                    //console.log(data);
                    $("#petInfo").html(" <img src='img/" + data.pictureURL + "'><br>" +
                                       " Age: " + data.age + "<br>" +
                                       " Breed: " + data.breed + "<br>" +
                                       data.description);
                }, //success function
                complete: function(data,status){
                    //DEBUG: output query status in alert
                    //alert(status)
                } //complete function
            }); //ajax
        }); //petLink click
    }); //document.ready
</script>


<?php
    //output list of pets in DB
    $pets = getPetList();
    foreach($pets as $pet){
        echo "<div class='petList'>";
        echo "Name: ";
        echo "<a href='#' class='petLink' id='" . $pet["id"] . "' >" . $pet["name"] . "</a><br>";
        echo "Type: " . $pet["type"] . "<br>";
        echo "<button id='" . $pet["id"] . "' type='button' class='btn btn-primary petLink'>Adopt Me!</button>";
        echo "<br><br></div>";
    }
?>


<!-- Modal -->
<div class="modal fade" id="petInfoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="petNameModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="petInfo"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"> Close</button>
            </div>
        </div>
    </div>
</div>