<?php
/**
 * @package Marineris
 * @author Erik Frèrejean (N/A)
 * @license http://www.opensource.org/licenses/bsd-license.php BSD License
 */

/**
 * @package Marineris
 */
class MarinerisPlugin implements MarinerisTreeNode
{
	private $name = '';

	public function __construct($name)
	{
		$this->name = $name;
	}

	public function getNodeName()
	{
		return $this->name;
	}
}