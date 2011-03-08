<?php
/**
 * @package Marineris
 * @author Erik Frèrejean (N/A)
 * @license http://www.opensource.org/licenses/bsd-license.php BSD License
 */

/**
 * @package Marineris
 */
class MarinerisTree
{
	/**
	 * @var string Path to the plugin directory
	 */
	private $pluginPath = '';

	/**
	 * @var MarinerisCategory The top category, which is used to access the tree
	 */
	private $tree = null;

	/**
	 * Construct the tree object
	 *
	 * @param string $path The plugin path
	 */
	public function __construct($path = '')
	{
		// Validate
		if (!is_dir($path))
		{
			throw new RuntimeException('The provided path isn\'t a directory!');
		}

		$this->pluginPath = rtrim($path, '/') . '/';

		// Create the top node
		$this->tree = new MarinerisCategory('TopNode');
	}

	/**
	 * Build the plugin tree
	 *
	 * Loop through the provided plugin directory and build the plugin
	 * tree, this does some initial file validation but doesn't actually
	 * validate the plugin code. This should be handled by the plugin
	 * loader before the actual plugin gets loaded.
	 *
	 * @return void
	 */
	public function buildTree()
	{
		// Get all the plugin files
		$treeFiles = new RegexIterator(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($this->pluginPath)), '/^.+\.php$/', RegexIterator::GET_MATCH);

		// Loop through the files and create the tree
		foreach ($treeFiles as $file)
		{
			// Remove the pluginPath
			$fileShort = preg_replace('#^' . preg_quote($this->pluginPath) . '#', '', $file[0]);

			// All directories become a sub category
			$subCategories = explode(DIRECTORY_SEPARATOR, $fileShort, -1);

			$parent = $this->tree;
			foreach ($subCategories as $subCategory)
			{
				if (!$parent->getElement($subCategory))
				{
					$c = new MarinerisCategory($subCategory);
					$parent->attachElement($c);
				}
				$parent = $parent->getElement($subCategory);
			}

			// Attach the plugin itself
			$pluginName = $this->cleanPluginName($fileShort);
			$plugin = new MarinerisPlugin($pluginName);
			$parent->attachElement($plugin);
		}
	}

	/**
	 * Get the plugin name
	 *
	 * Fetch the plugin name from the file path of the plugin
	 *
	 * @param  string $path The path to the file
	 * @return string       The plugin name
	 */
	public function cleanPluginName($path)
	{
		return substr($path, strrpos($path, '/') + 1, -(strlen($path) - strrpos($path, '.')));
	}

	/**
	 * Get iterator
	 *
	 * Get an iterator that can be used to traverse the plugin tree
	 *
	 * @return RecursiveIteratorIterator The iterator
	 * @throws RuntimeException          Runtime exception if the iterator is requested before the tree was build
	 */
	public function getTreeIterator()
	{
		if (!sizeof($this->tree))
		{
			throw new RuntimeException("The plugin tree must be build before you can request its iterator!");
		}

		return new RecursiveIteratorIterator($this->tree);
	}

	/**
	 * Get the tree
	 *
	 * Returns the top level element that starts the tree
	 *
	 * @return MarinerisCategory
	 */
	public function getTree()
	{
		return $this->tree;
	}
}
