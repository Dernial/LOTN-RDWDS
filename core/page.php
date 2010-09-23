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
		
		}
		catch(Exception $e)
		{
			Page::$errorCode = $e -> code;
			return Page::buildExceptionPage($e);
		}
	}
	
	// Build the error code page headers and return them
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

?>