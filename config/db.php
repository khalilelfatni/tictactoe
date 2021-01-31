<?php 


class Connect{

    public static function connection()
    {
        $connection = new mysqli('localhost', 'root', 'koko123', 'tictactoe');
        return $connection;
    }

}


?>