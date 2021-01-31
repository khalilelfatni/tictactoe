<?php 

class ModelGameState{

    private $db;
    private $gameState;
    
    public function __construct(){
        $this->db  = Connect::connection();
        $this->gameState = array();
    }

    // crear el estado del juego 
    public function CreateState($name_player1, $name_player2)
    {
        $sql = "INSERT INTO game_state (name_player1, name_player2) VALUES ('$name_player1', '$name_player2')";
        $result =  $this->db->query($sql);
        $_SESSION['idGame'] = $this->db->insert_id;
        return $result;
    }

    //funcion para devolver el estado del juego 
    public function getGameState($id)
    {
        $sql = "SELECT * FROM game_state WHERE id = $id";

        $result = $this->db->query($sql);
        foreach ($result as $value) {
           $this->gameState = $value;
        }
        return $this->gameState;
    }

    // funcion para añadir posicion al tablero 
    public function addPosition($id, $position, $letter)
    {
        $sql = "UPDATE game_state SET p_$position = '$letter' WHERE id = $id";
        $result = $this->db->query($sql);
        return $result;
    }

    //función para comprobar se la línea horizontal termninda
    public function horizontalLine($id)
    {
        $table = $this->getGameState($id);
        $victory = false;
        if($table['p_1'] != NULL && $table['p_1'] == $table['p_2'] && $table['p_1'] == $table['p_3']){
            $victory = true;
        }
        if($table['p_4'] != NULL && $table['p_4'] == $table['p_5'] && $table['p_4'] == $table['p_6']){
            $victory = true;
        }
        if($table['p_7'] != NULL && $table['p_7'] == $table['p_8'] && $table['p_7'] == $table['p_9']){
            $victory = true;
        }
        
        return $victory;
    }

    //función para comprobar se la línea vertical termninda
    public function verticalLine($id)
    {
        $table = $this->getGameState($id);
        $victory = false;
        if($table['p_1'] != NULL && $table['p_1'] == $table['p_4'] && $table['p_1'] == $table['p_7']){
            $victory = true;
        }
        if($table['p_2'] != NULL && $table['p_2'] == $table['p_5'] && $table['p_2'] == $table['p_8']){
            $victory = true;
        }
        if($table['p_3'] != NULL && $table['p_3'] == $table['p_6'] && $table['p_3'] == $table['p_9']){
            $victory = true;
        }
        
        return $victory;   
    }

    //función para comprobar se la línea diagonal termninda
    public function diagonalLine($id)
    {
        $table = $this->getGameState($id);
        $victory = false;
        if($table['p_1'] != NULL && $table['p_1'] == $table['p_5'] && $table['p_1'] == $table['p_9']){
            $victory = true;
        }
        if($table['p_3'] != NULL && $table['p_3'] == $table['p_5'] && $table['p_3'] == $table['p_7']){
            $victory = true;
        }

        return $victory;
    }

    // función para comprobar si el juego esta completado 
    public function isGameCompleted($id)
    {
        return $this->horizontalLine($id) || $this->diagonalLine($id) || $this->verticalLine($id) ;
    }

    // función para comprobar si todas las casillas del tablero esta lleno 
    public function isFullTable($id)
    {
        $table = $this->getGameState($id);
        $draw = true;
        for ($i=1; $i <10 ; $i++) { 
            if($table['p_'. $i] == NULL){
               $draw = false;
               break; 
            }
        }
        return $draw;    
    }

    //Función para añadir una casilla automáticamente 
    //Elegir una casilla aleatoria (Sin utilizar ningun heurística de juego como (minmax y alfabeta))
    public function addPositionMachine($id)
    {
        $table = $this->getGameState($id);
        $arrayNumbers = Array();
        for ($i=1; $i <10 ; $i++) { 
            if($table['p_'. $i] == NULL){
                $arrayNumbers[] = $i; 
            }
        }
        
        $p = $arrayNumbers[array_rand($arrayNumbers)];
        $this->addPosition($id,$p, 'o');

        return $p;
    }



}











?>