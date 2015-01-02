<?php
/**
 * Author: samokspv <samokspv@yandex.ru>
 * Date: 29.10.2014
 * Time: 15:00:00
 */

App::uses('ExcludeSimilarDocsSimple', 'ExcludeSimilarDocs.Lib');
App::uses('ExcludeSimilarDocsShingles', 'ExcludeSimilarDocs.Lib');

/**
 * Class for returns exclude similar documents instance of certain type
 *
 * @package ExcludeSimilarDocs
 * @subpackage Lib
 */
class ExcludeSimilarDocsFactory {
	
	/**
	 * Returns exclude similar documents instance of certain type
	 * 
	 * @param  array $params
	 * @throws Exception
	 * 
	 * @return object
	 */
	public function getESDType($params) {
		$types = array_keys(Configure::read('ExcludeSimilarDocs.types'));
		$params['type'] = !empty($params['type']) ? $params['type'] : 'simple';
		
		if (!in_array($params['type'], $types)) {
			throw new Exception("Undefined type of engine");
		}

		$ESDType = 'ExcludeSimilarDocs' . ucfirst($params['type']);
		return new $ESDType($params);
	}
}