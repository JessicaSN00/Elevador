<?php
include "elevador.php";

$initial_state = 1;
$users = [6 => "Juan", 5 => "Pedro", 3 => "Pancho", 1 => "Ramon"];
$floor_target = [6 => 1, 5 => 7, 3 => 1, 1 => 7];
$elevator = new Elevador();
$elevator -> firstStop($initial_state, $users, $floor_target);
$first_position = array_search($elevator -> order_users[0], $users);
$first_destination = $floor_target[$first_position];
$position = $first_position;

echo ("Get results form the hotel<br>");
printf("POST: "); print_r($_POST); printf("<br/>");

for($x=1; $x <= (count($_POST)/2); $x++) {
    $users_floor = [$_POST['actual_floor_'.$x] => $_POST['user_'.$x]];
    print_r($users_floor[5]);
}

echo $_POST['username']."<br>";
print_r($user_floor."<br>");

//Elevator initial state echo
echo "El elevador se encuentra en el piso #".$initial_state." <br>";

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
    $elevator -> up($first_destination, $position, $users, $floor_target, $initial_state, $pos);
    $first_destination = $elevator -> destination;
    $position = $elevator -> pos;
} 
while($first_destination < $position) {
    $elevator -> down($first_destination, $position, $users, $floor_target, $initial_state);
    $first_destination = $elevator -> destination;
    $position = $elevator -> pos;
}
//Results
echo ("<b>Recorrido final de acuerdo a usuarios:<br></b>");
foreach($elevator -> order_users as $route => $user) {
    print_r("--".$elevator -> order_users[$route]); 
}
?>