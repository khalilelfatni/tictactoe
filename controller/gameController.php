<?php 

class GameController{


    public function index()
    {
        $_SESSION['start'] = false;
        $_SESSION['machine'] = false;
        require_once "view/game/game.php";
    }

    //función para iniciar el juego 
    public function startGame()
    {
        require_once "model/gameState.php";
        if(isset($_POST['player1']) && isset($_POST['player2'])){
            $player1 = $_POST['player1'];
            $player2 = $_POST['player2'];
        }elseif(isset($_POST['player1']) && isset($_POST['machine'])){
            $player1 = $_POST['player1'];
            $player2 = $_POST['machine'];
            $_SESSION['machine'] = true;
        }
        $modelGameState = new ModelGameState();
        if($modelGameState->CreateState($player1, $player2)){
            $_SESSION['start'] = true;
            $data['player1'] = $player1;
            $data['player2'] = $player2;
        }
        
        require_once "view/game/game.php";
    }

    public function isGameCompleted()
    {
        require_once "model/gameState.php";
        if(isset($_POST['position']) && isset($_POST['letter'])){
            $position = $_POST['position'];
            $letter = $_POST['letter'];
            $id = $_SESSION['idGame'];
            $modelGameState = new ModelGameState();
            if($modelGameState->addPosition($id, $position, $letter)){
                if($modelGameState->isGameCompleted($id)){
                    echo json_encode(array('gameFinished' => 'si'));   
                }
                elseif($modelGameState->isFullTable($id)){
                    echo json_encode(array('gameFinished' => 'draw')); 
                }else{
                    echo json_encode(array('gameFinished' => 'no'));
                }  
            }
        }
    }

    public function isGameCompletedMachine()
    {
        require_once "model/gameState.php";
        if(isset($_POST['position'])){
            $position = $_POST['position'];
            $id = $_SESSION['idGame'];
            $modelGameState = new ModelGameState();
            $gameState = $modelGameState->getGameState($id);
            if($modelGameState->addPosition($id, $position, 'x')){
                if($modelGameState->isGameCompleted($id)){
                    echo json_encode(array('gameFinished' => 'si', 'playerName'=>ucwords($gameState['name_player1'])));   
                }
                elseif($modelGameState->isFullTable($id)){
                    echo json_encode(array('gameFinished' => 'draw')); 
                }else{
                    $p=$modelGameState->addPositionMachine($id);
                    if($modelGameState->isGameCompleted($id)){
                        echo json_encode(array('gameFinished' => 'si', 'position' => $p, 
                        'playerName'=>ucwords($gameState['name_player2'])));   
                    }elseif($modelGameState->isFullTable($id)){
                        echo json_encode(array('gameFinished' => 'draw', 'position' => $p)); 
                    }else{
                        echo json_encode(array('position' => $p));
                    }
                }  
            }
        }
    }




}



?> 