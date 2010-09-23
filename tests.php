<?php
/***
  **	tests.php
  **	This is the main test running file, it allows all tests to be loaded up and run
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

// Define the root for tests
define('CMS_ROOT', getcwd()); 

require_once(dirname(__FILE__) . '/tests/simpletest/autorun.php');

// Define the testing group
$testingPlatform = &new GroupTest('All tests');

// Might as well automate the loading of testing files
// Each test needs to add themselves to the group

$testLoader = array();

try
{
	$folder = dir(dirname(__FILE__) . "/tests");
	while ($mod = $folder->read())
	{
		if (!is_dir($mod) && !preg_match("/^_/", $mod) && preg_match("/php$/i", $mod) )
		{
			if(preg_match("/^!/", $mod))
				array_unshift($testLoader, dirname(__FILE__) . "/tests/" . $mod);
			else 
				$testLoader[] = dirname(__FILE__) . "/tests/" . $mod;
		}
	}

	foreach($testLoader as $testToLoad)
	{
		require_once($testToLoad);
	}
}
catch( FatalLoadException $e )
{
	FatalError("Fatal Error while loading tests.<br>Message was: " . $e->msg);
}
catch( Exception $e )
{
	FatalError("Uncaught exception while loading tests.<br>Message was: " . $e->msg);
}

// Overload the html reporter to show all tests passing
class ShowPasses extends HtmlReporter {
    
    function paintPass($message) {
        parent::paintPass($message);
        print "<span class=\"pass\">Pass</span>: ";
        $breadcrumb = $this->getTestList();
        array_shift($breadcrumb);
        print implode("->", $breadcrumb);
        print "->$message<br />\n";
    }
    
    protected function getCss() {
        return parent::getCss() . ' .pass { color: green; }';
    }
}

// Add the test of testing! It's so meta

class TestOfTesting extends UnitTestCase {

	// Define the human readable name of the tests
    function __construct() {
        parent::__construct('Test of Testing');
    }

    function testCrazyNonexistantTestJustToMakeSureThingsAreWorking() {
		$this->assertTrue(true, 'We work!');
    }
}

$testingPlatform->addTestCase(new TestOfTesting());
$testingPlatform->run(new ShowPasses());

?>
