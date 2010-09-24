<?php
/****
 ** Debug Page
 ** This page is built to display debugging information for diagnostic purposes
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
Add a "_" at the beginning of the file (_moduleTemplate.php) if you do not want it to be loaded.
*/

/*
Add a "!" at the beginning of the file (!moduleTemplate.php) if the module MUST be loaded before anything else, make sure no ! modules require another ! module, as those will all load in alphebetical order.
*/

// This adds the template as needing a menu option
$Environment["menu"][] = 'debugPage';
// This adds the template as having a page value, the array's reference value must be the same as $pageURL inside the class
$Environment["page"]["debug"] = 'debugPage';
// This indicates that the template has a module for display on all pages
//$_SiteModule[] = &$moduleTemplate;
// This indicates that the template is to display on special sections of the page.
//$_SiteSpecial["footer"][] = &$moduleTemplate;

// This adds the template as needing an Admin menu option
//$_AdminMenu[] = &$moduleTemplate;
// This indicates that the template has a module for display on Admin pages
//$_AdminModule[] = &$moduleTemplate;


class debugPage
{
	// This is what is displayed for the menu option
	var $menuName = "Debug";
	// This is the page name that is given as the url, must be the same as the entry for $_SitePage
	var $pageURL = "debug";

	// This is what is displayed for the Admin menu option
	var $menuAdminName = "Template";
	var $adminPermission = "template_admin";


	// Variables for Modules
	var $moduleType = "floating";		// Floating = Floating div module
										// static = static module to be placed in a location on the page
	var $moduleTop = 100;				// Floating Module "pixels from top" coordinates
	var $moduleLeft = 100;				// Floating Module "pixels from left" coordinates
	var $moduleWidth = 100;				// Floating Module's width
	var $moduleHeight = 100;			// Floating Module's Height

 	
	public function __construct()
	{
	}

	// This function must exist if the module has a page, as indicated by adding the $_SitePage
	public function page($subPage)
	{
		global $_CONF;
		global $_DATABASE;
		global $coreLoader;
		global $moduleLoader;
		global $_SiteMenu;
		global $_SitePage;
		global $_SiteModule;
		
		
	   $m_Return = "<!-- Debug information -->\n\n";
	   $m_Return .= "<br><br>_Conf<br><pre>";
	   $m_Return .= print_r($_CONF, true);
	   $m_Return .= "</pre><br><br>_DATABASE<br><pre>";
	   $m_Return .= print_r($_DATABASE, true);
	   $m_Return .= "</pre><br><br>coreLoader<br><pre>";
	   $m_Return .= print_r($coreLoader, true);
	   $m_Return .= "</pre><br><br>moduleLoader<br><pre>";
	   $m_Return .= print_r($moduleLoader, true);
	   $m_Return .= "</pre><br><br>_SiteMenu<br><pre>";
	   $m_Return .= print_r($_SiteMenu, true);
	   $m_Return .= "</pre><br><br>_SitePage<br><pre>";
	   $m_Return .= print_r($_SitePage, true);
	   $m_Return .= "</pre><br><br>_SiteModule<br><pre>";
	   $m_Return .= print_r($_SiteModule, true);
	   $m_Return .= "</pre>";
	   
	   //phpinfo();
	   
	   return $m_Return;
	}

	// This function must exist if the module has a page, as indicated by adding the $_SiteModule
	public function module()
	{
		return "Hello World!";
	}

	// This function must exist if the module has a page, as indicated by adding the $_SitePage
	public function adminPage($subPage)
	{
		return "Hello World!";
	}

	// This function must exist if the module has a page, as indicated by adding the $_SiteModule
	public function adminModule()
	{
		return "Hello World!";
	}


	// This function must exist if the module has a special display section, denoted by $_SiteSpecial
	public function special_display()
	{
		return "Hello World!";
	}

}

?>