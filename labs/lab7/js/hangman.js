//VARIABLES
var alphabet = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M',
'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
var selectedWord = "";
var selectedHint = "";
var board = [];
var remainingGuesses = 6;
var words = [{word: "snake", hint:"It's a reptile"},
             {word: "monkey", hint:"It's a mammal"},
             {word: "beetle", hint:"It's an insect"},];


//LISTENERS
window.onload = startGame();

$(".letter").click(function(){
    checkLetter($(this).attr("id"));
    disableButton($(this));
});

$(".replayBtn").on("click", function(){
    location.reload();
});

$("#hintBtn").on("click", function(){
    $(this).hide();
    $("#hint").append("<span class='hint'>Hint: " + selectedHint + "</span>");
    
    remainingGuesses -= 1;
    updateMan()
    
    //Check end game
    if(remainingGuesses <= 0){
        endGame(false);
    }
});

//FUNCTIONS
function startGame(){
    pickWord();
    initBoard();
    updateBoard();
    createLetters();
}

//Picks random word from words
function pickWord(){
    var randomInt = Math.floor(Math.random() * words.length);
    selectedWord = words[randomInt].word.toUpperCase();
    selectedHint = words[randomInt].hint;
}

//Fill board with underscores
function initBoard(){
    for(var letter in selectedWord){
        board.push("_")
    }
}

//Updates on screen progress
function updateBoard(){
    $("#word").empty();
    
    for(var letter of board){
        document.getElementById("word").innerHTML += letter + " ";
    }
    
    document.getElementById("word").innerHTML += "<br>";
}

//Creates the letter buttons in the letters div
function createLetters(){
    for(var letter of alphabet){
        $("#letters").append("<button class='letter btn btn-success' id='" + letter + "'>" + letter + "</button>");
    }
}

//Checks to see if selected letter is in selectedWord
function checkLetter(letter){
    var positions = new Array();
    
    //Put all the positions the letter exists in an array
    for(var i = 0; i < selectedWord.length; i++){
        if(letter == selectedWord[i]){
            positions.push(i);
        }
    }
    
    if(positions.length > 0){
        updateWord(positions, letter);
        
        //Check Win
        if(!board.includes("_")){
            endGame(true);
        }
    } else{
        remainingGuesses -= 1;
        updateMan();
    }
    
    //Check Lost
    if(remainingGuesses <= 0){
        endGame(false);
    }
}

//Update the current word then updates board
function updateWord(positions, letter){
    for(var pos of positions){
        board[pos] = letter;
    }
    
    updateBoard();
}

//Calulates and updates stick man iamge
function updateMan(){
    $("#hangImg").attr("src", "img/stick_" + (6-remainingGuesses) + ".png");
}

//Ends game by hiding letters and displaying win or loss
function endGame(win){
    $("#letters").hide();
    $("#hintBtn").hide();
    $("#hint").hide();
    
    if(win){
        $("#won").show();
    } else{
        $("#lost").show(); 
    }
}

//Disables button and changes style
function disableButton(btn){
    btn.prop("disabled", true);
    btn.attr("class", "btn btn-danger");
}