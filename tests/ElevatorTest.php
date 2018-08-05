<?php

require_once "./elevator.php";
require_once "./elevator_user.php";

class ElevatorTest extends PHPUnit_Framework_TestCase 
{
	function testRunTrue()
	{
		$default_users = [];
		$default_users[] = new Elevator_User("Max", 1, 4);
		$default_users[] = new Elevator_User("Petr", 3, 2, true);
		$default_users[] = new Elevator_User("Andrey", 4, 1, true);

		$elevator = new Elevator();

		$this->assertTrue(
			$elevator->run($default_users);
		);
	}
}`