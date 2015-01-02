<?php
/**
 * Author: samokspv <samokspv@yandex.ru>
 * Date: 05.11.2014
 * Time: 12:00:00
 *
 * @package ExcludeSimilarDocs
 * @subpackage Test
 */

class AllExcludeSimilarDocsTest extends PHPUnit_Framework_TestSuite {

	/**
	 * Suite define the tests for this suite
	 *
	 * @return void
	 */
	public static function suite() {
		$suite = new CakeTestSuite('All NLP Data Source Tests');
		$path = App::pluginPath('ExcludeSimilarDocs') . 'Test' . DS . 'Case' . DS;
		$suite->addTestFile($path . 'Model' . DS . 'ExcludeSimilarDocsTest.php');
		return $suite;
	}

}