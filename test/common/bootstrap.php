<?php
/**
 * @package Marineris-Tests
 * @author Erik Frèrejean (N/A)
 * @license http://www.opensource.org/licenses/bsd-license.php BSD License
 */

/**
 * Path to the mack plugin data
 */
define('TREE_PATH', __DIR__ . '/../data/tree/');

// Lazyness FTW
set_include_path(
	get_include_path() . PATH_SEPARATOR .
	__DIR__ . '/../../src/' . PATH_SEPARATOR . 
	__DIR__ . '/../data/mock/' . PATH_SEPARATOR .
	TREE_PATH . PATH_SEPARATOR
);

// Include the Marineris src files
require_once 'MarinerisTreeNode.php';
require_once 'MarinerisCategory.php';
require_once 'MarinerisPlugin.php';
require_once 'MarinerisTree.php';
