<?php

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

class pageTemplate
{
	/**
	 * @var string $file the file name of the template
	 */
	private $file;
	/**
	 * @var array $vars a hash of the variable and the string to replace it
	 */
	private $vars;
	
	/**
	 * Start template.  Add _CONF to array.  store filename in class.
	 * @param string $filename the filename of the template.
	 * @return void
	 */
 	public function __construct($filename)
	{
		global $_CONF;
		$this->file = $filename;
		$this->vars = array();
		$this->add($_CONF);
	}

	/**
	 * Add passed values to class.
	 *
	 * This adds the passed value(s) to the class.  if its an array then
	 * we add each item else we add the passed value.
	 * @param array $var this is overloaded.  if not array then string
	 * @param string $value default null.  for overloaded var = string
	 */
	public function add($var,$value = null)
	{
		if(is_array($var))
		{
			foreach($var as $i => $v) 
			{
				$this->add($i,$v);
			}
		}
		else
		{
			// Somehow we should allow overiding from outside but
			// not from calling classes...
			$this->vars["{" . $var . "}"] = $value;
		}
	}

	/**
	 * A special case add.
	 * This was made so we can pass variables in with out overwritting
	 * previously set values.  It is only really needed to pass current values
	 * to a sub template to allow nested templates.
	 *
	 * @param array $var could be a string to be the key
	 * @param string $value default null.  needed with var = string
	 * @return void
	 */
	protected function innerAdd($var,$value = null)
	{
		if(is_array($var))
		{
			foreach($var as $i => $v)
			{
				$this->innerAdd($i,$v);
			}
		}
		else
		{
			//We don't want calling class to overwrite our vals
			if( !isset($this->vars["{" . $var . "}"]) )
				$this->vars["{" . $var . "}"] = $value;
		}
	}

	/**
	 * Parse file for keys and replace
	 * @return replaced template file.
	 */
	public function parse()
	{
		//load file
		if(is_file($this->file))
		{
			$handle = @fopen($this->file,'r');
			if(empty($handle))
				throw new FatalException("Error loading file:" . $this->file);
			$str = fread($handle, filesize($this->file));
		}
		else
		{
			$str = $this->file;
		}
		
		foreach($this->vars as $var => $value)
		{
			if( is_a($value, "template") )
			{
				//remove this value to avoid infinite loop
				unset($this->vars[$var]);

				//Pass all values down
				$value->innerAdd($this->vars);
				
				//we need it parsed.
				$value = $value->parse();
			}
			$str = str_replace($var,$value,$str);
		}
		return $str;
	}
}

