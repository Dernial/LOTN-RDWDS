<?php
/***
  **	bootstrap.php
  **	This prepares the system and builds the environment.
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

// Define system root directories
define('CMS_DIR_MODULES', CMS_ROOT . "/modules"); 
define('CMS_DIR_CONFIG', CMS_ROOT . "/config"); 
define('CMS_DIR_CORE', CMS_ROOT . "/core");

// Load up the required core functions and modules
require_once(CMS_DIR_CORE . "/exceptionDefinitions.php");
require_once(CMS_DIR_CORE . "/template.php");

// Load up the page handling class
require_once(CMS_DIR_CORE . "/page.php");

// Build the main environment
$Environment["version"] = "2.0.1";

// Load configuration
require_once(CMS_DIR_CONFIG . "/config.php");

?>