<?php
/**
 * @package Marineris
 * @author Erik Frèrejean (N/A)
 * @license http://www.opensource.org/licenses/bsd-license.php BSD License
 */

/**
 * @package Marineris
 */
class MarinerisCategory implements MarinerisTreeNode, Countable, RecursiveIterator
{
	private $children = array();
	private $childrenNames = array();
	private $name = '';
	private $position = 0;

	public function __construct($name)
	{
		$this->name = $name;
	}

	public function attachElement($element)
	{
		if ($element instanceof MarinerisTreeNode === false)
		{
			throw new InvalidArgumentException('Can only attach elements from the type `MarinerisTreeNode` to the tree!');
		}

		// Do not overwrite
		$name = $element->getNodeName();
		if (!in_array($name, $this->childrenNames))
		{
			$this->children[] = $element;
			$this->childrenNames[] = $name;
			return $element;
		}
	}

	public function getElement($name)
	{
		foreach ($this->childrenNames as $k => $n)
		{
			if ($n == $name)
			{
				return $this->children[$k];
			}
		}

		return false;
	}

	public function getNodeName()
	{
		return $this->name;
	}

	/**
	 * Get all the children
	 *
	 * Get an array with all the children attached to this category,
	 * the resulting array is an combination of `MarinerisCategory::children`
	 * and `MarinerisCategory::childrenNames`. Where the childrenNames
	 * have become the keys of the assoc array.
	 *
	 * @return array The children array
	 */
	public function toArray()
	{
		$array = array();

		foreach ($this->children as $key => $obj)
		{
			$array[$this->childrenNames[$key]] = $obj;
		}

		return $array;
	}

	//-- Implement Countble
	public function count()
	{
		return sizeof($this->children);
	}

	//-- RecursiveIterator implementation

	public function hasChildren()
	{
		return ($this->children[$this->position] instanceof MarinerisCategory) ? true : false;
	}

	public function getChildren()
	{
		return $this->children[$this->position];
	}

	public function current()
	{
		return $this->children[$this->position];
	}

	public function key()
	{
		return $this->position;
	}

	public function next()
	{
		++$this->position;
	}

	public function rewind()
	{
		$this->position = 0;
	}

	public function valid()
	{
		return isset($this->children[$this->position]);
	}
}