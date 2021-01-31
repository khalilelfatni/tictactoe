<?php  

require_once "config/db.php";
require_once "controller/gameController.php";

//Iniciar Sesion 
session_start();


$game = new GameController();

if((isset($_GET['c']) && ($_GET['c'] == "strat"))){
    $game->startGame();
}
elseif(isset($_GET['c']) && ($_GET['c'] == "completed")){
    $game->isGameCompleted();
}elseif(isset($_GET['c']) && ($_GET['c'] == "completedMachine")){
    $game->isGameCompletedMachine();
}
else{
    $game->index();
}


    




?>