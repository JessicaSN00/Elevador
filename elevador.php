<?php
class Elevador
{
    public $initial_state = 1;
    public $difference_aux = [];
    public $order_users = [];
    public $actions = [];
    public $founded_initial = 0;
    public $pos = 0;
    public $destination = 0;

    public function firstStop($initial_state, $users, $floor_target)
    {
        //Elevator initial state echo
        echo "El elevador se encuentra en el piso #".$initial_state." <br>";
        //Checking for a same user state
        foreach($users as $key => $user) {
            if($initial_state == $key) {
                array_push($this -> actions, 1);
                array_push($this -> order_users, $user);
                $this -> founded_initial = 1; 
                return $this -> order_users;
                print_r ($this -> order_users);
            } 
        }    
        //Checking for the closest user to pick
        if($this -> founded_initial == 0) {
            foreach($users as $key => $user) {
                $key = array_search($user, $users);
                $difference = $initial_state - $key;
                if($difference < 0) {
                    $difference *= -1;
                    $this -> difference_aux[$key] = $difference;
                }
            }
            //Moving to nearest position
            $min = min($this -> difference_aux);
            $user_key = array_search($min, $this -> difference_aux);
    
            //Moving elevator to nearest user
            if($user_key  > $initial_state) {
                while($initial_state < $user_key) {
                    echo ("El elevador ha subido al piso ".($initial_state+1)."<br>");
                    $initial_state++;
                }
                array_push($this -> actions, $initial_state);
                array_push($this -> order_users, $user);
                return $initial_state+1;
            }
        }
    }

    public function up($first_destination, $position, $users, $floor_target, $initial_state)
    {
        //Elevator go up
        $this -> pos = $initial_state;
        for($i=$position; $i <= $first_destination; $i++) {
            //Floors in maintenance
            if($i == 2 || $i == 4){
                echo("Mantenimiento! Piso ".$i."<br>");
            }
            //Pick up nearest users
            foreach($floor_target as $key => $des) {
                if($i == $key && $key != $initial_state && $des > $i) {
                    //Only in avilable floors
                    if (($i == 2 || $i == 4) || ($des == 2 || $des == 4)) {
                        echo ("Piso en mantenimiento ".$users[$key]." no puede tomar el elevador");
                        $floor_target[$key] = null;
                    } else {
                    echo ("El usuario ".$users[$key]." ha abordado en el piso ".$i." con destino: ".$des."<br>");
                    array_push($this -> order_users, $users[$key]);
                    }
                }
                if($i == $des && $des != $initial_state && $i != 2 && $i != 4) {
                    echo ("El usuario  ".$users[$key]." bajo en el piso ".$i."<br>");
                }
            }
            echo($i."<br>");
            $this -> pos = $i;
        }
        $this -> destination = min($floor_target);
        return $this -> pos;
    }
    
    public function down($first_destination, $position, $users, $floor_target, $initial_state)
    {
        //Elevator go down
        $this -> pos = $initial_state;
        for($j=$position; $j >= $first_destination; $j--) {
            echo ($j."<br>");
            //Floors in maintenance
            if($j == 2 || $j == 4){
                echo("Mantenimiento! Piso ".$j."<br>");
            }
            //Pick up nearest users
            foreach($floor_target as $key => $des) {
                if($j == $key && $key != $initial_state && $des < $j) {
                    //Only avilable floors
                    if (($j == 2 || $j == 4) || ($des == 2 || $des == 4)) {
                        echo ("Piso en mantenimiento ".$users[$key]." no puede tomar el elevador<br>");
                        $floor_target[$key] = null;
                    } else {
                    echo ("El usuario ".$users[$key]." ha abordado en el piso ".$j." con destino: ".$des."<br>");
                    array_push($this -> order_users, $users[$key]);
                    }
                }
                if($j == $des && $des == $initial_state && $j != 2 && $j != 4) {
                    echo ("El usuario  ".$users[$key]." bajo en el piso ".$j."<br>");
                }
            }
            $this -> pos = $j;
        }
        $this -> destination = max($floor_target);
        return $this -> pos;
    }
}