<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link rel="stylesheet" href="css/style.css">
    <title>Juego de 3 raya</title>
</head>
<body>
<h1 class="bg-dark text-white text-center p-2">Juego de 3 en Raya</h1>   
<div class="container mt-3">
    <div class="row d-flex align-items-center p-4">
        <div class="col-md-6 col-sm-6 col-12 p-2">
            <form action="index.php?c=strat" method="POST">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <input type="text" name="player1" class="form-control" placeholder = "Nombre Jugador 1" autofocus required >
                        </div>
                        <div class="form-group">
                            <input type="text" name="player2" class="form-control" placeholder = "Nombre jugador 2" required>
                        </div>

                        <button type="submit" class="btn btn-success btn-block">Iniciar Juego Manual</button>
                    </div>
                </div> 
            </form>   
        </div>
        <div class="col-md-6 col-sm-6 col-12 p-2">
            <form action="index.php?c=strat" method="POST">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <input type="text" name="player1" class="form-control" placeholder = "Nombre Jugador" autofocus required >
                        </div>
                        <div class="form-group">
                            <input type="text" name="machine" class="form-control" value="máquina"  hidden>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Iniciar Juego Máquina</button>
                    </div>
                </div> 
            </form>   
        </div>
    </div>
    <?php if($_SESSION['start'] == true) : ?>
        <div class="container">
            <h1 class="text-center"> Inicio del Juego</h1>
            <div class="row">
                <div class="col-md-6 col-sm-6 col-6 text-center">
                    <h3 class="color-x"> Jugador 1 :  <?= ucwords($data['player1']) . " (X)"?></h3>
                </div>
                <div class="col-md-6 col-sm-6 col-6 text-center">
                    <h3 class="color-o"> Jugador 2 :  <?= ucwords($data['player2']) .  " (O)"?></h3>
                </div>
            </div>
            <?php if(!$_SESSION['machine']) :?>
                <h5 class="text-center text-success" id="player-turn">Jugador en turno: <?= ucwords($data['player1'])?></h5>
            <?php endif; ?>    
        </div>

        <div class="row mt-3 mb-3">
            <div class="col-md-12 pr-5 pl-5">
                <?php for ($i=1; $i <10 ; $i=$i+3) : ?>
                    <div class="row  text-center <?= ($i != 7)?  'border-bottom border-danger':  '' ?> " id="cursor-pointer">
                        <div class="col-md-4 col-sm-4 col-4 border-right border-danger"  onclick=" <?= ($_SESSION['machine'])? 'paintMachine(this)' : 'paint(this)' ?>" data-id=<?= $i ?> data-x="<?= ucwords($data['player1'])?>" data-o="<?= ucwords($data['player2'])?>">
                            <h1 class="tam-icon" id="<?php echo 'p-' . $i  ?>"></h1>
                        </div>
                        <div class="col-md-4 col-sm-4 col-4 border-right border-danger " onclick=" <?= ($_SESSION['machine'])? 'paintMachine(this)' : 'paint(this)' ?>" data-id=<?= $i + 1?> data-x="<?= ucwords($data['player1'])?>" data-o="<?= ucwords($data['player2'])?>">
                            <h1 class="tam-icon" id="<?php echo 'p-' . ($i+1) ?>" ></h1>
                        </div>
                        <div class="col-md-4 col-sm-4 col-4 " onclick=" <?= ($_SESSION['machine'])? 'paintMachine(this)' : 'paint(this)' ?>" data-id=<?= $i + 2?> data-x="<?= ucwords($data['player1'])?>" data-o="<?= ucwords($data['player2'])?>">
                            <h1 class="tam-icon" id="<?php echo 'p-' . ($i+2) ?>"></h1>
                        </div>
                    </div>
                <?php endfor; ?>
            </div>
        </div>
        <div class="text-center mb-2">
            <a href="index.php" type="button" class="btn btn-danger btn-lg btn-block">Terminar el juego</a>
        </div>
        
    <?php endif;?>

<div>



<div class="modal" tabindex="-1" role="dialog" id="result-game"  data-toggle="modal" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5>El gandor es:</h5>
      </div>
      <div class="modal-body">
        <h1 id="winning-player" class="text-center text-success"> </h1>
      </div>
      <div class="modal-footer">
        <a href="index.php" type="button" class="btn btn-info">Empieza de nuevo</a>
      </div>
    </div>
  </div>
</div>

<script src="js/main.js">  </script>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>