<?php
/****
 ** Error Module
 ** A module to display errors.
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

// Generic Error
class FatalException extends Exception
{
	public $msg;
	public $code;

	function __construct($msg = false, $code = false)
	{
		if(!$msg)
		{
		    $msg = "There was an error building the page!";
		}
		if(!$code)
		{
		    $code = "400";
		}
		$this->msg = $msg;
		$this->code = $code;
	}
}

// A module has failed to load correctly
class FatalModuleLoadException extends Exception
{
	public $msg;
	public $code;

	function __construct($msg = false, $code = false)
	{
		if(!$msg)
		{
		    $msg = "There was an error loading the module!";
		}
		if(!$code)
		{
		    $code = "400";
		}
		$this->msg = $msg;
		$this->code = $code;
	}
}

// Page was not found
class PageNotFoundException extends Exception
{
	public $msg;
	public $code;

	function __construct($msg = false, $code = false)
	{
		if(!$msg)
		{
		    $msg = "That page was not found!";
		}
		if(!$code)
		{
		    $code = "404";
		}
		$this->msg = $msg;
		$this->code = $code;
	}
}

// Something was trying to be accessed that the user has no permission to
class UserNoPermissionException extends Exception
{
	public $msg;
	public $code;

	function __construct($msg = false, $code = false)
	{
		if(!$msg)
		{
		    $msg = "I'm afraid you can't access that page. You don't have permission!";
		}
		if(!$code)
		{
		    $code = "403";
		}
		$this->msg = $msg;
		$this->code = $code;
	}
}
