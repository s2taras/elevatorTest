<?php

require_once "elevator_user.php";
require_once "elevator.php";

$default_users = [];
$elevator = new Elevator();

$default_users[] = new Elevator_User("Max", 1, 4);
$default_users[] = new Elevator_User("Petr", 3, 2, true);
$default_users[] = new Elevator_User("Andrey", 4, 1, true);

$elevator->run($default_users);