<?php
/**
 * @package Marineris-Tests
 * @author Erik Frèrejean (N/A)
 * @license http://www.opensource.org/licenses/bsd-license.php BSD License
 */

/**
 * @package Marineris-Tests
 */
class MarinerisTreeTest extends PHPUnit_Framework_TestCase
{
	private $fixture = null;

	protected function setUp()
	{
		$this->fixture = new MarinerisTree(TREE_PATH);
	}

	/**
	 * @expectedException RuntimeException
	 */
	public function testNonExistingPluginPath()
	{
		new MarinerisTree('/path/doesnt/exists/');
	}

	public function testCleanPluginName()
	{
		$path = '/just/some/path/file.php';
		$expected = 'file';
		$this->assertEquals($expected, $this->fixture->cleanPluginName($path));
	}

	/**
	 * Test build tree
	 */
	public function testBuildTree()
	{
		$this->fixture->buildTree();
		$tree = $this->fixture->getTree();

		// The easy bit first, top categories
		$cat1 = $tree->getElement('category1');
		$cat2 = $tree->getElement('category2');
		$this->assertInstanceOf('MarinerisCategory', $cat1);
		$this->assertEquals('category2', $cat2->getNodeName());

		// get all top level plugins
		$top1 = $cat1->getElement('NormalTopLevelPlugin');
		$top2 = $cat1->getElement('PluginWithIncorrectClassName');
		$this->assertInstanceOf('MarinerisPlugin', $top1);
		$this->assertEquals('PluginWithIncorrectClassName', $top2->getNodeName());

		// Now test the deep nested stuff
		$subcategory = $cat2->getElement('subcategory');
		$this->assertInstanceOf('MarinerisCategory', $subcategory);
		$this->assertEquals('subcategory', $subcategory->getNodeName());

		$sub  = $subcategory->getElement('sub');
		$sub2 = $sub->getElement('sub2');
		$sub3 = $sub2->getElement('sub3');
		$deep = $sub3->getElement('DeepNestedPlugin');
		$this->assertInstanceOf('MarinerisPlugin', $deep);
		$this->assertEquals('DeepNestedPlugin', $deep->getNodeName());
	}

	/**
	 * Test getTreeIterator before build
	 */
	public function testGetTreeIteratorBeforeBuild()
	{
		$this->setExpectedException('RuntimeException');
		$this->fixture->getTreeIterator();
	}

	/**
	 * Test getTreeIterator
	 */
	public function testGetTreeIterator()
	{
		$this->fixture->buildTree();
		$expected = new RecursiveIteratorIterator($this->fixture->getTree());
		$this->assertEquals($expected, $this->fixture->getTreeIterator());
	}
}
