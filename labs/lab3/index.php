<?php
	$backgroundImage = "img/sea.jpg";
	
	if(!empty($_GET['category'])){
		include 'api/pixabayAPI.php';
		$keyword = $_GET['category'];
		$imageURLs = getImageURLs($keyword, $_GET['layout']);
		$backgroundImage = $imageURLs[array_rand($imageURLs)];
	}else if(!empty($_GET['keyword'])){
		include 'api/pixabayAPI.php';
		$keyword = $_GET['keyword'];
		$imageURLs = getImageURLs($keyword, $_GET['layout']);
		$backgroundImage = $imageURLs[array_rand($imageURLs)];
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Image Carousel</title>
		<meta charset="utf-8">
		<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		<style> 
			@import url("css/styles.css"); 
			body{
				background-image: url('<?=$backgroundImage ?>');
			}
		</style>
	</head>
	
	<body>
		<br>
		<!--Controls-->
		<form>
			<input type="text" name="keyword" placeholder="Keyword" value="<?=$keyword?>"/>
			<div id="layoutDiv">
				<input type="radio" id="lhorizontal" name="layout" value="horizontal">
				<label for="Horizontal"></label><label for="lhorizontal">Horizontal</label>
				<input type="radio" id="lvertical" name="layout" value="vertical">
				<label for="Vertical"></label><label for="lvertical">Vertical</label>
			</div>

			<select name="category">
				<option value="">Select One</option>
				<option value="ocean">Sea</option>
				<option value="forest">Forest</option>
				<option value="mountain">Mountain</option>
				<option value="snow">Snow</option>
				<option value="desert">Desert</option>
			</select>
			<input type="submit" class="btn btn-default btn-sm" value="Submit"/>
		</form>
		
		<br>
		<!--Carousel-->
		<?php
			if(!isset($imageURLs)){
				echo "<h2>Type a keyword to display a slideshow <br /> with random images from Pixabay.com </h2>";
			} else { //BEGIN ELSE
		?>
		
		<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
			<ol class="carousel-indicators">
				<?php
					for($i = 0; $i < 7; $i++){
						echo "<li data-target='#carouselExampleIndicators' data-slide-to='$i'";
						echo ($i==0)?"class='active'":"";
						echo "></li>";
					}
				?>
			</ol>
			
			<div class="carousel-inner" role="listbox">
				<?php
					for($i = 0; $i < 7; $i++){
					   do{
						   $randomIndex = rand(0, count($imageURLs));
					   } while(!isset($imageURLs[$randomIndex]));
					   
					   echo'<div class="carousel-item ';
					   echo ($i==0)?"active":"";
					   echo '">';
					   echo '<img src="' . $imageURLs[$randomIndex] . '">';
					   echo '</div>';
					   unset($imageURLs[$randomIndex]);
					}
				?>
			</div>
			
			<a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
				<span class="carousel-control-prev-icon" aria-hidden="true"></span>
				<span class="sr-only">Previous</span>
			</a>
			<a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
				<span class="carousel-control-next-icon" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			</a>
		</div>
		
		<?php
			} //END ELSE
		?>
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.bundle.min.js" integrity="sha384-pjaaA8dDz/5BgdFUPX6M/9SUZv4d12SUPF0axWc+VRZkx5xU3daN+lYb49+Ax+Tl" crossorigin="anonymous"></script>        
	</body>
</html>