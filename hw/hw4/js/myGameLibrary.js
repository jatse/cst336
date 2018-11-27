//VARIABLES
var player;
var walking = false;
var onGround = false;
var idle = false;
var goal;
var leftArrowDown = false;
var rightArrowDown = false;
var upArrowDown = false;
var downArrowDown = false;
var gameTimer;

const GRAVITY = 1;
var fallSpeed = 0;

var level = 0;

var lifebar;
var numLives = 0;

//LISTENERS
document.addEventListener('keydown', function(event){
	if(event.keyCode==37) leftArrowDown = true;
	if(event.keyCode==39) rightArrowDown = true;
	if(event.keyCode==38) upArrowDown = true;
	if(event.keyCode==40) downArrowDown = true;
});

document.addEventListener('keyup', function(event){
	if(event.keyCode==37) leftArrowDown = false;
	if(event.keyCode==39) rightArrowDown = false;
	if(event.keyCode==38) upArrowDown = false;
	if(event.keyCode==40) downArrowDown = true;
});

//FUNCTIONS
//initialize game
function init(){
	//initialize with 3 lives
	for(var i = 0; i < 3; i++){
		addLife();
	}
	
	//spawn player
	player = $("#player").get(0); //for easier passing to hit tests
	$("#player").css("width", "110px");
	$("#player").css("height", "185px");
	$("#player").attr("src","img/player_jump.gif");
	
	//spawn goal
	goal = $("#goal").get(0);
	$("#goal").css("width", "120px");
	$("#goal").css("height", "160px");
	$("#goal").attr("src","img/keyhole.gif");
	
	//set level
	nextLevel();
}

//main gameplay loop
function gameloop(){
	// HORIZONTAL MOVEMENT
	if(leftArrowDown){
		if(onGround && !walking){
			$("#player").attr("src", "img/player_walk.gif");
			walking = true;
			idle = false;
		}
		$("#player").addClass("mirror");
		$("#player").css("left", "-=" + 5 + "px");
		var sideHit = false;
		$(".platform").each(function(){
			var platform = $(this).get(0);
			if(hittest(player, platform)){
				sideHit = true;
			}
		});
		
		if(!sideHit){
			$(".platform").each(function(){
				$(this).css("left", "+=" + 5 + "px");
			});
			$("#goal").css("left", "+=" + 5 + "px");
			$("#player").css("left", "+=" + 5 + "px");
			parallaxShift(1);
		} else {
			$("#player").css("left", "+=" + 5 + "px");
		}
	}
	if(rightArrowDown){
		if(onGround && !walking){
			$("#player").attr("src", "img/player_walk.gif");
			walking = true;
			idle = false;
		}
		$("#player").removeClass("mirror");
		$("#player").css("left", "+=" + 5 + "px");
		var sideHit = false;
		$(".platform").each(function(){
			var platform = $(this).get(0);
			if(hittest(player, platform)){
				sideHit = true;
			}
		});
		
		if(!sideHit){
			$(".platform").each(function(){
				$(this).css("left", "-=" + 5 + "px");
			});
			$("#goal").css("left", "-=" + 5 + "px");
			$("#player").css("left", "-=" + 5 + "px");
			parallaxShift(-1);
		} else {
			$("#player").css("left", "-=" + 5 + "px");
		}
	}

	//VERTICAL MOVEMENT
	fallSpeed += GRAVITY;
	$("#player").css("top", "+="+fallSpeed);
	
	$(".platform").each(function(){
	var platform = $(this).get(0);
		if(hittest(player, platform)){
			if(fallSpeed < 0){
				//hit bottom of platform while jumping
				$("#player").css("top", parseInt(platform.style.top) + parseInt(platform.style.height) + "px");
				fallSpeed *= -1;
			}
			else{
				//hit top of platform
				$("#player").css("top", parseInt(platform.style.top) - parseInt(player.style.height + "px"));
				onGround = true;
				
				//if jumping
				if(upArrowDown){
					$("#player").attr("src", "img/player_jump.gif");
					fallSpeed = -20;
					onGround = false;
					walking = false;
					idle = false;
				} 
				//else on platform
				else{
					if(!(leftArrowDown || rightArrowDown) && idle == false){
						$("#player").attr("src", "img/player_idle.gif");
						walking = false;
						idle = true;
					}
					fallSpeed = 0;
				}
			}
		}
	});
	
	//END GAME CHECKS
	if(hittest(player, goal)){
		clearInterval(gameTimer);
		if(level == 3){
			gameWindow.innerHTML = "<br><br><br>You Win!";
			$("#gameWindow").addClass("msgGameOver");
		} else{
			nextLevel();
		}
	}
	else if(parseInt(player.style.top) > 400){
		clearInterval(gameTimer);
		removeLife();
	}
}

function addLife(){
	numLives++;
	$("#lifebar").append("<img src='img/heart.gif' class='life' />")
}

function removeLife(){
	if(numLives > 0){
		numLives--;
		$("#lifebar").children().last().remove();
		level--;
		nextLevel();
	} else{
		gameWindow.innerHTML = "<br><br><br>You Lose.";
		$("#gameWindow").addClass("msgGameOver");
	}
}

function addPlatform(x, y, w, h){
	var platform = "<div class='platform' style='left:" + x + "px;" +
												"top:" + y + "px;" +
												"width:" + w + "px;" +
												"height:" + h + "px;'></div>";
	
	$("#gameWindow").append($(platform));
}

function nextLevel(){
	level++;
	
	//reset controls
	fallSpeed: 0;
	leftArrowDown = false;
	rightArrowDown = false;
	upArrowDown = false;
	downArrowDown = false;
	
	//reposition player and background
	$("#player").css("left", "190px");
	$("#player").css("top", "50px");
	$(".movingBG").css("left", "0px");
	
	//clear platforms
	$(".platform").remove();
	
	//level based setup
	if(level == 1){
		$("#goal").css("left", "2400px");
		$("#goal").css("top", "340px");
		
		addPlatform(-100, 536, 600, 64);
		addPlatform(0, 350, 180, 64);
		addPlatform(300, 200, 400, 64);
		addPlatform(800, 200, 100, 64);
		addPlatform(1100, 400, 50, 256);
		addPlatform(1250, 400, 50, 256);
		addPlatform(1400, 400, 50, 256);
		addPlatform(1550, 250, 200, 64);
		addPlatform(1750, 122, 100, 512);
		addPlatform(700, 536, 300, 64);
		addPlatform(2120, 536, 500, 64);
	}
	
	else if(level == 2){
		$("#goal").css("left", "1000px");
		$("#goal").css("top", "340px");
		
		addPlatform(0, 536, 2000, 64);
	}
	
	else if(level == 3){
		$("#goal").css("left", "1000px");
		$("#goal").css("top", "340px");
		
		platforms = new Array();
		addPlatform(100, 536, 2000, 64);
	}
	
	gameTimer = setInterval(gameloop, 30);
}

//collision detector from tutorial.
function hittest(a, b){
	//reduce player's and goal's hit box size
	var aXMod = 0;
	var bXMod = 0;
	
	if(a.id == "player" || b.id == "player"){
		aXMod = 35;
		bXMod = 35;
	}
	if(a.id == "goal" || b.id == "goal"){
		aXMod = 65;
		bXMod = 65;
	}
	
	
	
	var aX1 = parseInt(a.style.left) + aXMod;
	var aY1 = parseInt(a.style.top);
	var aX2 = aX1 + parseInt(a.style.width)- 1 - aXMod;
	var aY2 = aY1;
	var aX3 = aX1;
	var aY3 = aY1 + parseInt(a.style.height)-1;
	var aX4 = aX2;
	var aY4 = aY3;

	var bX1 = parseInt(b.style.left) + bXMod;
	var bY1 = parseInt(b.style.top);
	var bX2 = bX1 + parseInt(b.style.width)-1 - bXMod;
	var bY2 = bY1;
	var bX3 = bX1;
	var bY3 = bY1 + parseInt(b.style.height)-1;
	var bX4 = bX2;
	var bY4 = bY3;

	var hOverlap = true;
	if(aX1<bX1 && aX2<bX1) hOverlap = false;
	if(aX1>bX2 && aX2>bX2) hOverlap = false;

	var vOverlap = true;
	if(aY1<bY1 && aY3<bY1) vOverlap = false;
	if(aY1>bY3 && aY3>bY3) vOverlap = false;

	if(hOverlap && vOverlap) return true;
	else return false;
}

//move background
function parallaxShift(direction){
	$("#bg1").css("left", "+=" + (direction * 5));
	$("#bg2").css("left", "+=" + (direction * 3));
	$("#bg3").css("left", "+=" + (direction * 1));
}
	