<?php
/**
 * Author: samokspv <samokspv@yandex.ru>
 * Date: 29.10.2014
 * Time: 15:00:00
 */

/**
 * Class exclude similar documents of different types
 *
 * @package ExcludeSimilarDocs
 * @subpackage Lib
 */
abstract class ExcludeSimilarDocsAbstract {

	/**
	 * Params exclude similar documents
	 * 
	 * @var array
	 */
	protected $_params = array();

	/**
	 * Constructor
	 * 
	 * @param array $params
	 */
	public function __construct($params) {
		$this->__setParams($params);
	}

	/**
	 * Sets parameters
	 * 
	 * @param  array $params
	 */
	private function __setParams($params) {
		$defaultParams = Configure::read('ExcludeSimilarDocs');
		$defaultParamsType = $defaultParams['types'][$params['type']];
		$this->_params = Hash::mergeDiff($params, $defaultParamsType);

		if ($this->_params['allowSimilarity'] > 100) {
			$this->_params['allowSimilarity'] = $defaultParamsType['allowSimilarity'];
		}
	}

	/**
	 * Returns exclude similar documents
	 * 
	 * @param  array $Docs
	 * 
	 * @return array
	 */
	abstract public function exclude($Docs);
}