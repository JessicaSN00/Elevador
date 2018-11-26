<?php
include "main.elevator.php";

$initial_state = $_POST['initial_state'];
$floor_maintenance = $_POST['floor_maintenance'];
//$users = [6 => "Juan", 5 => "Pedro", 3 => "Pancho", 1 => "Ramon"];
//$floor_target = [6 => 1, 5 => 7, 3 => 1, 1 => 7];
$users = [];
$floor_target = [];

printf("POST: "); print_r($_POST); printf("<br/>");
for($x=1; $x <= count($_POST)/2-2; $x++) {
    $floor = $_POST['actual_floor_'.$x];
    $usuario = $_POST['user_'.$x]; 
    $destiny = $_POST['floor_target_'.$x];
    $users[$floor] = $usuario;
    $floor_target[$floor] =$destiny;
}

print("<h1>El resusltado es:");
print_r($floor_target);
print("<br>Users<br>");
print_r($users);
print("</h1><br>");

printf("Floor Target<br>");
for($x=1; $x <= (count($_POST)/2-3); $x++) {
    //array_push($floor_target, [$_POST['actual_floor_'.$x] => $_POST['floor_target_'.$x]]);
}

$elevator = new Elevador();
$elevator -> firstStop($initial_state, $users, $floor_target);
$first_position = array_search($elevator -> order_users[0], $users);
$first_destination = $floor_target[$first_position];
$position = $first_position;
$max_floor = max($floor_target);
$min_floor = min($floor_target);
echo($max_floor);

echo ("Get results form the hotel<br>");

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Elevador</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="public/styles/style.css"/>
</head>
<body id="body-background">
    <h1>Bienvenido al elevador.</h1>
    <div class="elevator" >
        <div class="grid-container">
            <?php for($x=0; $x < $max_floor; $x++){ 
                echo '<div class="grid-container__items" id="floor-'.($max_floor-$x).'">Piso '.($max_floor-$x).' </div>';
            }?>
        </div>
        <div class="elevator__results">
        <h3>Información adicional.</h3>
        <?php
            //Elevator initial state echo
            echo ('<style>
            #floor-'.$initial_state.' {
                background-color: rgba(0, 0, 0, 0.3);
            }
            </style>');

            //Elevator arrive to the first user
            foreach($elevator->order_users as $key => $user) {
                if($elevator -> actions[$key] == $initial_state) {
                    echo ("El usuario ".$user." ha abordado al elevador. <br>");
                } else if ($elevator -> actions[$key] != 1) {
                    echo ("El elevador ha recogido al usuario ".$user." <br>");
                } else {
                    echo ("El usuario ".$user." ha salido del elevador. <br>");
                }
            }
            print_r("Primer usuario en posición ".$first_position." con destino a piso ".$first_destination."<br>");
            //Elevator functions for the other users (up, down)
            while($first_destination > $position) {
                for($i=$position; $i <= $max_floor; $i++) {
                    flush(); 
                    ob_flush(); 
                    sleep(2);
                    //echo($i."<br>");
                    echo('<style>
                    #floor-'.$i.' {
                        background-color: #2e2d39;
                    }
                    </style>');
                    //Floors in maintenance
                    if($i == $floor_maintenance) {
                    echo('<style>
                    #floor-'.$i.' {
                        background-color: #525066;
                    }
                    </style>');
                    }
                }
                $elevator -> up($first_destination, $position, $users, $floor_target, $initial_state, $pos, $floor_maintenance);
                $first_destination = $elevator -> destination;
                $position = $elevator -> pos;
            }
            while($first_destination < $position) {
                for($j=$position; $j >= $first_destination; $j--) {
                    flush(); 
                    ob_flush(); 
                    sleep(2);
                    //echo($j."<br>");
                    echo('<style>
                    #floor-'.$j.' {
                        background-color: rgba(0, 0, 0, 0.4);
                    }
                    </style>');
                    //Floors in maintenance
                    if($j == $floor_maintenance) {
                        echo('<style>
                        #floor-'.$i.' {
                            background-color: #525066;
                        }
                        </style>');
                    }
                }
                $elevator -> down($first_destination, $position, $users, $floor_target, $initial_state, $floor_maintenance);
                $first_destination = $elevator -> destination;
                $position = $elevator -> pos;
            }?>
            <p class="results__text">Resultados:
            <?php foreach($elevator -> order_users as $route => $user) {
                print_r(" ".$elevator -> order_users[$route]); 
            }?>
            </p>
        </div>
    </div>
</body>
</html>