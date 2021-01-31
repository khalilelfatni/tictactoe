

//Variable para determinar  el jugador actual 
var nextPlayer = 1


function paint(obj){
    
    var p = $(obj).data('id');
    if(!$("#p-" + p).html()){
        
        var letter = 'x';
        var position = p;
        var url = 'index.php?c=completed';
        var currentPlayer;

        if(nextPlayer%2 == 0){
            $("#p-" + p).html('O');
            $("#p-" + p).addClass("color-o");
            $("#player-turn").html("Jugador en turno: " + $(obj).data('x'));
            letter = 'o';
            currentPlayer = $(obj).data('o');
        }
        else{
            $("#p-" + p).html('X');
            $("#p-" + p).addClass("color-x");
            $("#player-turn").html("Jugador en turno: " + $(obj).data('o'));
            letter = 'x';
            currentPlayer = $(obj).data('x');
        }

        $.ajax({
            url:url,
            type: 'post',
            data: {
                position:position,
                letter:letter
            },
            dataType: 'json',

            beforeSend: function(){

            },
            success: function(data){
                if(data.gameFinished == 'si'){
                    $("#winning-player").html(currentPlayer);
                    $('#result-game').modal('show');
                }else if(data.gameFinished == 'draw'){
                    $("#winning-player").html("Empate");
                    $('#result-game').modal('show');
                }
                
            },
            error: function(){

            }


        });

        //siguiente jugador;
        nextPlayer++;
    }
    
}

//función para jugar contra el ordenador 
function paintMachine(obj){
    
    var p = $(obj).data('id');

    if(!$("#p-" + p).html()){

        $("#p-" + p).html('X');
        $("#p-" + p).addClass("color-x");
        var position = p;
        var url = 'index.php?c=completedMachine';
        $.ajax({
            url:url,
            type: 'post',
            data: {
                position:position,
            },
            dataType: 'json',

            beforeSend: function(){
                
            },
            success: function(data){
                $("#p-" + data.position).html('O');
                $("#p-" + data.position).addClass("color-o");
                if(data.gameFinished == 'si'){
                    $("#winning-player").html(data.playerName);
                    $('#result-game').modal('show');
                }else if(data.gameFinished == 'draw'){
                    $("#winning-player").html("Empate");
                    $('#result-game').modal('show');
                }
        
            },
            error: function(){

            }


        });
    }
}
