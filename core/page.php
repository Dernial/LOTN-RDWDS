<?php
/***
  **	page.php
  **	This is the main command processor of the web system.
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

class Page
{
	public static $errorCode = 200;
	
	/**
	 * Takes all input: get, post, etc. sanatizes and handles
	 * @param array $Environment the main environment array containing a lot of things
	 * @return same $Environment variable with all needed inputs added
	 */
	public static function handleInput($Environment = null)
	{
		// Ensure that the request variables are safeslashed
		// Function is borrowed from phpBB
		if( !get_magic_quotes_gpc() )
		{
			if( is_array($_REQUEST) )
			{
				while( list($k, $v) = each($_REQUEST) )
				{
					if( is_array($_REQUEST[$k]) )
					{
						while( list($k2, $v2) = each($_REQUEST[$k]) )
						{
							$Environment["request"][$k][$k2] = addslashes($v2);
						}
						@reset($_REQUEST[$k]);
					}
					else
					{
						$Environment["request"][$k] = addslashes($v);
					}
				}
				@reset($_REQUEST);
			}
		}
		
		return $Environment;
	}

	/**
	 * Loads all modules
	 * @param array $Environment the main environment array containing a lot of things
	 * @return same $Environment variable with all page, sidebar, etc modules added.
	 */
	public static function loadModules($Environment = null)
	{
		try
		{
			$folder = dir(CMS_DIR_MODULES);
			while ($mod = $folder->read())
			{
				if (!is_dir($mod) && !preg_match("/^_/", $mod) && preg_match("/php$/i", $mod) )
				{
					if(preg_match("/^!/", $mod))
						array_unshift($moduleLoader, CMS_DIR_MODULES . "/" . $mod);
					else 
						$moduleLoader[] = CMS_DIR_MODULES . "/" . $mod;
				}
			}

			foreach($moduleLoader as $moduleToLoad)
			{
				require_once($moduleToLoad);
			}
		}
		catch( FatalLoadException $e )
		{
			Page::buildExceptionPage($e);
		}
		catch( Exception $e )
		{
			Page::buildExceptionPage($e);
		}
		
		return $Environment;
	}
	
	/**
	 * Main page building function, takes in all the environmental variables and puts the page together
	 * @param array $Environment the main environment array containing a lot of things
	 * @return page to be displayed
	 */	
	public static function handlePage($Environment = null)
	{
		// Create the return value
		$pageText = "";
		
		// Start catching errors
		try
		{
			// Immedately error out if there's no environment
			if(!isset($Environment))
				throw new FatalException("Environment doesn't exist");
			
			$page = new $Environment["theme"]();
			
			return $page -> buildPage($Environment);
		
		}
		catch(Exception $e)
		{
			Page::$errorCode = $e -> code;
			return Page::buildExceptionPage($e);
		}
	}

	/**
	 * Build the error code page headers and return them
	 * @return error page to be displayed
	 */
	static function buildExceptionPage($e)
	{
		switch($e -> code)
		{
			case 400:
				$headerCode = "400 Bad Request";
				break;
			case 403:
				$headerCode = "403 Forbidden";
				break;
			case 404:
				$headerCode = "404 Not Found";
				break;
			default:
				$headerCode = $e -> code;
		}
		
		header("HTTP/1.0 $headerCode");
		return "Error Loading Page.<br>Message was: " . $e -> msg;
	}
}
