<?php
/***
  **	pageTest.php
  **	Tests for the page class
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
require_once(CMS_ROOT . "/core/exceptionDefinitions.php");
require_once(CMS_ROOT . "/core/page.php");

// In order to add a test, use the following class to define the tests.
// The file being tested needs to be added
// The class name needs to be changed to something unique

class pageTests extends UnitTestCase {

	// Define the human readable name of the tests
    function __construct() {
        parent::__construct('Loading Tests');
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
    function testEmptyEnvironment() {
		Page::handlePage();
		$this->assertEqual(400, Page::$errorCode );
    }
}

// Have to add ourselves to the testing platform
$testingPlatform->addTestCase(new pageTests());

?>