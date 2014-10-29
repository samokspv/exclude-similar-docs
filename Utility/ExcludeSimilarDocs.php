<?php
/**
 * Author: samokspv <samokspv@yandex.ru>
 * Date: 29.10.2014
 * Time: 15:00:00
 */

App::uses('ExcludeSimilarDocsFactory', 'ExcludeSimilarDocs.Lib');

/**
 * Class for exclude similar documents
 *
 * @package ExcludeSimilarDocs
 * @subpackage Utility
 */
class ExcludeSimilarDocs {

	/**
	 * Exclude similar documents factory instance
	 *
	 * @var object
	 */
	protected static $_ESDFactory = null;

	/**
	 * Returns not similar documents
	 * 
	 * @param  array $docs
	 * @param  array $params
	 * 
	 * @return array
	 */
	public static function exclude($docs, $params = array()) {
		if (empty($docs)) {
			return array();
		}
		
		return self::_getExcludeSimilarDocsFactory()
				->getESDType($params)
				->exclude($docs);
	}

	/**
	 * Returns exclude similar documents instance
	 *
	 * @return object
	 */
	protected static function _getExcludeSimilarDocsFactory() {
		if (!self::$_ESDFactory) {
			self::$_ESDFactory = new ExcludeSimilarDocsFactory();
		}

		return self::$_ESDFactory;
	}
}