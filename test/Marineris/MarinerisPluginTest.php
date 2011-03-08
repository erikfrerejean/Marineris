<?php
/**
 * @package Marineris-Tests
 * @author Erik Frèrejean (N/A)
 * @license http://www.opensource.org/licenses/bsd-license.php BSD License
 */

/**
 * Test the MarinerisPlugin class
 * @package Marineris-Tests
 */
class MarinerisPluginTest extends PHPUnit_Framework_TestCase
{
	private $fixture = null;

	protected function setUp()
	{
		$this->fixture = new MarinerisPlugin('TestPlugin');
	}

	/**
	 * Test the getNodeName method
	 */
	public function testGetNodeName()
	{
		$this->assertEquals('TestPlugin', $this->fixture->getNodeName());
	}
}
