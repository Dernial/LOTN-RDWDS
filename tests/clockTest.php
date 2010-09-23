<?php
/***
  **	loadTest.php
  **	This file is for template purposes on adding a test to the testing system
  **
  */

/***
  **	Copyright (C) 2006  Larry Kuehner
  **
  **	This program is free software; you can redistribute it and/or
  **	modify it under the terms of the GNU General Public License
  **	as published by the Free Software Foundation; either version 2
  **	of the License, or (at your option) any later version.
  **	
  **	This program is distributed in the hope that it will be useful,
  **	but WITHOUT ANY WARRANTY; without even the implied warranty of
  **	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  **	GNU General Public License for more details.
  **	
  **	You should have received a copy of the GNU General Public License
  **	along with this program; if not, write to the Free Software
  **	Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
  **/

/*
Add a "_" at the beginning of the file (_loadTest.php) if you do not want it to be loaded.
*/

/*
Add a "!" at the beginning of the file (!loadTest.php) if the module MUST be loaded before anything else, make sure no ! modules require another ! module, as those will all load in alphebetical order.
*/

// Uncomment the line below to add in the file your testing
require_once(dirname(__FILE__) . '/classes/Clock.php');

// In order to add a test, use the following class to define the tests.
// The file being tested needs to be added
// The class name needs to be changed to something unique

class TimeTestCase extends UnitTestCase {

	function TimeTestCase($test_name = false) {
		$this->UnitTestCase($test_name);
	}

	// Some functions used by the tests
	function assertSameTime($time1, $time2, $message = '') {
		if(!$message)
			$message = "Time [$time1] should match time [$time2]";

		$this->assertTrue(
				($time1 == $time2) || ($time1 + 1 == $time2), $message);
	}

}

class TestOfClock extends TimeTestCase {

	// Define the human readable name of the tests
    function __construct() {
        parent::__construct('Clock Tests');
    }

	// Any test prep
    function setUp() {
        //@unlink('../temp/test.log');
    }
  
	// Any test tear down
    function tearDown() {
        //@unlink('../temp/test.log');
    }

	// Tests
    function testClockTellsTime() {
		$clock = new Clock();
		$this->assertSameTime($clock->now(), time(), 'Now is the right time');
    }

	function testClockAdvance() {
		$clock = new Clock();
		$clock->advance(10);
		$this->assertSameTime($clock->now(), time() + 10, 'Advancement');
		$clock->advance(-5);
		$this->assertSameTime($clock->now(), time() + 5, 'De-Advancement');
	}

	function testClockSet() {
		$clock = new Clock();
		$clock->setOffset(10);
		$this->assertSameTime($clock->now(), time() + 10, 'Set');
		$clock->setOffset(-5);
		$this->assertSameTime($clock->now(), time() - 5, 'Set Back');
	}
}

// Have to add ourselves to the testing platform
$testingPlatform->addTestCase(new TestOfClock());

?>