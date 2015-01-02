<?php
/**
 * Author: samokspv <samokspv@yandex.ru>
 * Date: 29.10.2014
 * Time: 15:00:00
 * Format: http://book.cakephp.org/2.0/en/development/testing.html
 */

App::uses('ExcludeSimilarDocs', 'ExcludeSimilarDocs.Utility');

/**
 * ExcludeSimilarDocsTest
 * 
 * @property ExcludeSimilarDocs $ExcludeSimilarDocs ExcludeSimilarDocs
 * 
 * @package ExcludeSimilarDocs
 * @subpackage Test
 */
class ExcludeSimilarDocsTest extends CakeTestCase {

	/**
	 * {@inheritdoc}
	 */
	public function setUp() {
		parent::setUp();
		$this->dataPath = App::pluginPath('ExcludeSimilarDocs') . 'Test' . DS . 'Data' . DS;
	}

	/**
	 * Test exclude documents
	 * 
	 * @param  array $conditions
	 * @param  array $expected
	 * 
	 * @dataProvider excludeProvider
	 */
	public function testExclude($conditions, $expected) {
		$docs = include $this->dataPath . $conditions['fileName'];
		$expected = include $this->dataPath . $expected['fileName'];

		$actual = ExcludeSimilarDocs::exclude($docs, $conditions['params']);

		$this->assertEquals($expected, $actual);
	}

	/**
	 * Data provider for testExclude
	 * 
	 * @return array
	 */
	public function excludeProvider() {
		return array(
			// set #0
			array(
				array(
					'fileName' => 'actual.php',
					'params' => array(
						'type' => 'shingles',
						'length' => '10',
						'allowSimilarity' => '1'
					)
				),
				array(
					'fileName' => '0' . DS . 'expected.php'
				)	
			),
			// set #1
			array(
				array(
					'fileName' => 'actual.php',
					'params' => array(
						'type' => 'simple'
					)
				),
				array(
					'fileName' => '1' . DS . 'expected.php'
				)
			)
		);
	}

}
