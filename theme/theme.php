<?php
/***
  **	theme.php
  **	This is classed to create the default page layout that the subpages are dropped into.
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

$Environment["theme"] = 'themeClass';

class themeClass
{
	function makeMenuItem($name, $path)
	{
		global $_CONF;

		$pageMenuItem = new pageTemplate("template/menuItem.thtml");
		$pageMenuLink = new pageTemplate("template/menuLink.thtml");
		$pageMenuLink -> add("M_ITEM", $name);
		
		$pageMenuLink -> add("M_PAGE", makeLink($path));
		
		$pageMenuItem -> add("M_ITEM", $pageMenuLink -> parse());
		return $pageMenuItem -> parse();
	}
	
	function buildBase($Environment)
	{
		$page = new pageTemplate(CMS_DIR_THEME . "/core.thtml");

		// Insert the Head information
		$pageHead = new pageTemplate(CMS_DIR_THEME . "/head.thtml");
		$page -> add("HEADER_INFO", $pageHead -> parse());

		// Insert the Header of the page
		$pageHead = new pageTemplate(CMS_DIR_THEME . "/header.thtml");
		$page -> add("HEADER", $pageHead -> parse());
		
		$page -> add($Environment["config"]);
		
		return $page;
	}

	function buildMenu($Environment)
	{
		// Return empty if there are no menu items
		if(!isset($Environment["menuItem"]))
			return "";
		
		// Insert the Menu
		$pageMenu = new pageTemplate(CMS_DIR_THEME . "/menu.thtml");
		$pageMenuItems = "";

		foreach($Environment["menuItem"] as $menuNext)
		{
			if(is_array($menuNext))
			{
				foreach($menuNext as $arrayMenuItem)
				{
					$pageMenuItems .= $this -> makeMenuItem($arrayMenuItem["Name"],$arrayMenuItem["URL"]);
				}
			}
			else
			{
				$pageMenuItems .= $this -> makeMenuItem($menuNext -> menuName,$menuNext -> pageURL);
			}
		}

		$pageMenu -> add("MENU_ITEMS", $pageMenuItems);
		
		return $pageMenu -> parse();
	}
	
	function buildBody($Envrionment)
	{
		// Body
		if(isset($Envrionment["path"]))
		{
			$displayPage = $Envrionment["path"]["basePage"];
			
			if(isset($Envrionment["page"][$displayPage]))
			{
				$pageBody = $Envrionment["page"][$displayPage] -> page($pieces);
			}
			else
			{
				throw new PageNotFoundException();
			}
		} else {
			if(!isset($Envrionment["page"]["default"]))
			{
				// This is what it should do
				//throw new PageNotFoundException();
				
				// For now:
				$pageBody = "";
			}
			else
				$pageBody = $Envrionment["page"]["default"] -> page();
		}

		return $pageBody;
	}
	
	function buildPage($Environment)
	{
		$page = $this -> buildBase($Environment);
		$page -> add("MENU", $this -> buildMenu($Environment));
		$page -> add("BODY", $this -> buildBody($Environment));
		
		return $page -> parse();
	}

}