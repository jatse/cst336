<?php
if($_POST["num"] == null){
    $numPass = 0;
} else {
    $numPass = $_POST["num"] + $_POST["move"];
}
echo $numPass;
?>

<form action="index.php" method="post">
<input type="hidden" name="num" value="<?php echo $numPass; ?>">
<input type="hidden" name="move" value="1">
<input type="submit" value="Increment">
</form>

<form action="index.php" method="post">
<input type="hidden" name="num" value="<?php echo $numPass; ?>">
<input type="hidden" name="move" value="-1">
<input type="submit" value="Decrement">
</form>