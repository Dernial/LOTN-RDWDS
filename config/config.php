<?php
/***
  **	config.php
  **	Main config file for the site.
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

$Environment["config"]["SiteLocation"] = "http://localhost";
$Environment["config"]["AdminGroupName"] = "Administrator";
$Environment["config"]["SiteTitle"] = "Welcome to Land of the Nerd";

$Environment["config"]["CookieName"] = "landofthenerd";
$Environment["config"]["CookiePath"] = "/";
//$Environment["config"]["CookieDomain"] = "www.landofthenerd.com";
$Environment["config"]["CookieDomain"] = "";
$Environment["config"]["SessionLength"] = 2678400;

// By setting this to anything will disable registration, comment out to allow.
$Environment["config"]["DisableRegistration"] = true;
