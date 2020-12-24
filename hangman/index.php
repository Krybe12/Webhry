<?php
session_start();
?>
<?php
require '../gameconn/conn.php';

$page = $_SERVER['REQUEST_URI'];
if (!isset($_SESSION["user"]) || $_SESSION["verified"] != 1){
    header("Location: ../index.php?id=login&re=nt&page=$page");
}
?>
<style>
@media (min-width:768px){
    .grid {
    display: grid;
    height: 100%;

    grid-template-rows: 0.1fr 1.1fr;
    grid-template-columns: 1fr 2.8fr 1fr;
    grid-template-areas: 
    "t t t"
    "m1 m2 m3";
    }
}
@media (max-width: 768px){
    .grid {
    display: grid;
    grid-template-rows: repeat(auto-fill, minmax(140px,1fr));
    grid-template-columns: 1fr;
    grid-template-areas: 
    "t"
    "m2"
    "m1"
    "m3";
    }
    .m1{
        grid-area: m1;
        border-bottom: 4px solid #ffc107;
    }
    .m2{
        grid-area: m2;
        border-bottom: 4px solid #ffc107;
    }
    .m3{
        grid-area: m3;
        overflow-y: auto;
        max-height: 50vh;
    }
}

.t{
    grid-area: t;
    border-bottom: 4px solid #ffc107;
}
.m1{
    grid-area: m1;
}
.m2{
    grid-area: m2;
}
.m3{
    grid-area: m3;
    overflow-y: auto;
}
.alerty {
    position: absolute;
    right: 10;
    bottom: 10;
}
.btn-lg{
    width: 50px;
}
</style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <title>Hangman</title>
</head>
<body>
<div class="grid">
    <div class="t bg-dark text-light d-flex flex-column flex-md-row justify-content-between align-items-center">
        <div class="container-fluid bg-dark text-light p-3 flex-shrink-1">
            <div class="row align-items-center">
                <div class="col-md d-flex justify-content-center justify-content-md-start">
                    <h5 class="m-md-0">Logged in as <?php echo "<h5 class='mx-2' style='color: {$_SESSION['color']}'>{$_SESSION['user']}</h5>"?></h5>
                </div>
                <div class="col-md d-flex justify-content-center">
                    <h4 class="m-md-0">Hangman</h4>
                </div>
                <div style="white-space: nowrap;" class="col-md d-flex justify-content-center justify-content-md-end">
                    <a href="../profile" class="btn btn-primary mx-2">Profile</a>
                    <a href=".." class="btn btn-primary mx-2">Back to hub</a>
                    <a href="../login/logout.php" class="btn btn-danger mx-2">Logout</a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="m1 bg-dark text-center text-light p-2 p-md-3">
        <div class="">
            <h4>Leaderboard</h4>
        </div>
        <hr>
        <div id="leaderBoard">

        </div>
        
    </div>
    <div class="m2 text-center bg-secondary pt-2 pt-md-3">
        <div id="wrap" class="">
            <div>
                <img id="hangIMG" src="../img/hang1.png" alt="">
            </div>
            <div id="word" class="pt-md-2">
                
            </div>
            <div class="container-fluid d-flex flex-column justify-content-center align-items-center pt-md-1">   
                <div class="p-1">
                    <button class="btn btn-lg btn-dark">Q</button>
                    <button class="btn btn-lg btn-dark">W</button>
                    <button class="btn btn-lg btn-dark">E</button>
                    <button class="btn btn-lg btn-dark">R</button>
                    <button class="btn btn-lg btn-dark">T</button>
                    <button class="btn btn-lg btn-dark">Z</button>
                    <button class="btn btn-lg btn-dark">U</button>
                    <button class="btn btn-lg btn-dark">I</button>
                    <button class="btn btn-lg btn-dark">O</button>
                    <button class="btn btn-lg btn-dark">P</button>
                </div>
                <div class="p-1">
                    <button class="btn btn-lg btn-dark">A</button>
                    <button class="btn btn-lg btn-dark">S</button>
                    <button class="btn btn-lg btn-dark">D</button>
                    <button class="btn btn-lg btn-dark">F</button>
                    <button class="btn btn-lg btn-dark">G</button>
                    <button class="btn btn-lg btn-dark">H</button>
                    <button class="btn btn-lg btn-dark">J</button>
                    <button class="btn btn-lg btn-dark">K</button>
                    <button class="btn btn-lg btn-dark">L</button>
                </div>
                <div class="p-1">
                    <button class="btn btn-lg btn-dark">Y</button>
                    <button class="btn btn-lg btn-dark">X</button>
                    <button class="btn btn-lg btn-dark">C</button>
                    <button class="btn btn-lg btn-dark">V</button>
                    <button class="btn btn-lg btn-dark">B</button>
                    <button class="btn btn-lg btn-dark">N</button>
                    <button class="btn btn-lg btn-dark">M</button>
                </div>
            </div>
            <hr class="bg-light">
            <div class="row mt-4 text-white">
                <div class="col">
                    <h5>Session Score:</h5>
                    <p id="score" class="lead m-0">0</p>
                </div>
                <div class="col">
                    <h5>In Row Correct:</h5>
                    <p id="inRowNum" class="lead m-0"></p>
                </div>
                <div class="col">
                    <h5>Total Score:</h5>
                    <p id="totalScoreNum" class="lead m-0"></p>
                </div>
            </div>
        </div>

    </div>
    <div class="m3 bg-dark text-light text-center p-md-3 pt-md-0">
        <div style="position: sticky;top: 0;z-index: 2;" class="bg-dark py-md-3">
            <h4>Achievements</h4>
            <hr class="mb-0">
        </div>
        
        <div id="ach">
            
        </div>
    </div>
</div>
<div class="alerty">
</div>

</body>
</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
$( document ).ready(function() {
    game.newWord();
});
class Game{
    constructor(start, score){
        this.state = start;
        this.score = score;
    }
    wrong(m){
        this.state = this.state + 1;
        if (this.state > 7){
            this.state = 7;
        }
        $("#hangIMG").attr("src", `../img/hang${this.state}.png`);
        console.log("hp " + this.state);
        //get obrazek podle hp
        $("#wrap").addClass("bg-danger")
        setTimeout(function(){
            $("#wrap").removeClass("bg-danger")
        }, m);
    }
    correct(n){
        $("#wrap").addClass("bg-success")
        setTimeout(function(){
            $("#wrap").removeClass("bg-success")
        }, n);
    }
    newWord(){
        this.state = 1;
        $("#score").text(this.score);
        $("#hangIMG").attr("src", `../img/hang${this.state}.png`);
        $(".btn-dark").attr( "disabled", false);
        $("#word").load("newword.php")
    }
    check(ltr){
        $.post("check.php", {
        letter: ltr
        }, function(data){
            if (data == "0"){
                game.wrong(800);
            } else if (data.length > 50){ // horší kod sem nikdy nevyčaroval
                $("#word").html(data);
            } else {
                game.correct(800);
                $("#word").html(data);
            }
        });
    }
}
var game = new Game(1, 0);
$(".btn-dark").click(function(){
    $(this).attr( "disabled", true );
    game.check($(this).text());
});
</script>