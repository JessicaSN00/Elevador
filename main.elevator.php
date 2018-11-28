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
        //Checking for a same user state
        foreach($users as $key => $user) {
            if($initial_state == $key) {
                array_push($this -> actions, 1);
                array_push($this -> order_users, $user);
                $this -> founded_initial = 1; 
                return $this -> order_users;
                //print_r ($this -> order_users);
            } 
        }    
        //Checking for the closest user to pick
        if($this -> founded_initial == 0) {
            echo("Checking for the closest user to pick");
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
                    echo("Moving elevator to nearest user-------------".$user_key);
                    echo ("El elevador ha subido al piso ".($initial_state+1)."<br>");
                    $initial_state++;
                }
                foreach($users as $key => $user) {
                    if($user_key == $key) {
                        array_push($this -> order_users, $user);
                    }
                }
                array_push($this -> actions, $initial_state);
                return $initial_state+1;
            }
        }
    }

    public function up($first_destination, $position, $users, $floor_target, $initial_state, $floor_maintenance)
    {
        //Elevator go up
        $this -> pos = $initial_state;
        for($i=$position; $i <= $first_destination; $i++) {
            //Pick up nearest users
            foreach($floor_target as $key => $des) {
                if($i == $key && $key != $initial_state && $des > $i) {
                    //Only in avilable floors
                    if ($des == $floor_maintenance) {
                        //echo ("Piso en mantenimiento ".$users[$key]." no puede tomar el elevador");
                        $floor_target[$key] = null;
                    } else {
                    echo ("El usuario ".$users[$key]." ha abordado en el piso ".$i." con destino: ".$des."<br>");
                    array_push($this -> order_users, $users[$key]);
                    }
                }
                if($i == $des && $des != $initial_state && $i != $floor_maintenance && in_array($users[$key], $this -> order_users)) {
                    echo ("El usuario  ".$users[$key]." bajo en el piso ".$i." de funcion subir.<br>");
                }
            }
            $this -> pos = $i;
        }
        
        $this -> destination = min($floor_target);
    }
    
    public function down($first_destination, $position, $users, $floor_target, $initial_state, $floor_maintenance)
    {
        //Elevator go down
        $this -> pos = $initial_state;
        for($j=$position; $j >= $first_destination; $j--) {
            //echo ($j."<br>");
            //Pick up nearest users
            foreach($floor_target as $key => $des) {
                if($j == $key && $key != $initial_state && $des < $j) {
                    //Only avilable floors
                    if ($des == $floor_maintenance) {
                        //echo ("Piso en mantenimiento ".$users[$key]." no puede tomar el elevador<br>");
                        $floor_target[$key] = null;
                    } else {
                        echo ("El usuario ".$users[$key]." ha abordado en el piso ".$j." con destino: ".$des."<br>");
                        array_push($this -> order_users, $users[$key]);
                    }
                }
                if($j == $des && $des !== $initial_state && $j != $floor_maintenance && in_array($users[$key], $this -> order_users)) {
                    echo ("El usuario  ".$users[$key]." bajo en el piso ".$j." de funcion bajar.<br>");
                    if($des >= $j ) {
                        echo("subir porfavor<br>");
                        $j == $des;      
                    }
                }
            }
            $this -> pos = $j;
        }
        $this -> destination = max($floor_target);
    }
}