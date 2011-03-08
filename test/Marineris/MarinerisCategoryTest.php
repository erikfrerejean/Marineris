<?php
/**
 * @package Marineris-Tests
 * @author Erik Frèrejean (N/A)
 * @license http://www.opensource.org/licenses/bsd-license.php BSD License
 */

/**
 * Test the MarinerisCategory class
 * @package Marineris-Tests
 */
class MarinerisCategoryTest extends PHPUnit_Framework_TestCase
{
	private $fixture = null;

	protected function setUp()
	{
		$this->fixture = new MarinerisCategory('TestCategory');
	}

	/**
	 * Test the getNodeName method
	 */
	public function testGetNodeName()
	{
		$this->assertEquals('TestCategory', $this->fixture->getNodeName());
	}

	/**
	 * Test attaching a non MarinerisTreeNode element
	 * @expectedException InvalidArgumentException
	 */
	public function testAttachWrongElement()
	{
		$stub = $this->getMock('InvalidClass');
		$this->fixture->attachElement($stub);
	}

	/**
	 * Test attaching a category element
	 */
	public function testAttachCategoryElement()
	{
		$this->assertEmpty($this->fixture->toArray());
		$added = new MarinerisCategory('AddedCategory');
		$this->fixture->attachElement($added);
		$children = $this->fixture->toArray();
		$this->assertNotEmpty($children);
		$this->assertEquals($added, $children['AddedCategory']);
	}

	/**
	 * Test attaching a plugin element
	 */
	public function testAttachPluginElement()
	{
		$this->assertEmpty($this->fixture->toArray());
		$added = new MarinerisPlugin('AddedPlugin');
		$this->fixture->attachElement($added);
		$children = $this->fixture->toArray();
		$this->assertNotEmpty($children);
		$this->assertEquals($added, $children['AddedPlugin']);
	}

	/**
	 * Test attaching a second element with the same name
	 */
	public function testAttachDoubleElement()
	{
		$this->assertEmpty($this->fixture->toArray());
		$added1 = new MarinerisPlugin('AddedPlugin');
		$added2 = new MarinerisPlugin('AddedPlugin');
		$this->fixture->attachElement($added1);
		$this->fixture->attachElement($added2);
		$children = $this->fixture->toArray();
		$this->assertEquals(1, sizeof($children));
	}

	/**
	 * Test non existing element
	 */
	public function testGetElementNotExisting()
	{
		$this->assertFalse($this->fixture->getElement('DoesntExists'));
	}

	/**
	 * Test get element
	 */
	public function testGetElement()
	{
		$add = new MarinerisPlugin('Added');
		$this->assertEmpty($this->fixture->toArray());
		$this->fixture->attachElement($add);
		$this->assertEquals($add, $this->fixture->getElement('Added'));
	}

	/**
	 * Test count
	 */
	public function testCount()
	{
		$this->assertEquals(0, sizeof($this->fixture));
		$this->fixture->attachElement(new MarinerisCategory('IncreaseCat'));
		$this->assertEquals(1, sizeof($this->fixture));
		$this->fixture->attachElement(new MarinerisPlugin('IncreasePlugin'));
		$this->assertEquals(2, sizeof($this->fixture));
	}
}
