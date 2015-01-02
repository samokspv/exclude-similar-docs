<?php
/**
 * Author: samokspv <samokspv@yandex.ru>
 * Date: 29.10.2014
 * Time: 15:00:00
 */

App::uses('ExcludeSimilarDocsShinglesAbstract', 'ExcludeSimilarDocs.Lib');

/**
 * Class exclude similar documents with shingles algorithm
 *
 * @package ExcludeSimilarDocs
 * @subpackage Lib
 */
class ExcludeSimilarDocsShingles extends ExcludeSimilarDocsShinglesAbstract {
	
	/**
	 * {@inheritdoc}
	 *
	 */
	public function exclude($Docs) {
		foreach ($Docs as $key => $Doc) {
			$this->_addText($this->_getTextFromDocFields($Doc));
		}
		return array_diff_key($Docs, $this->_getSimilarDocsIds());
	}

	/**
	 * {@inheritdoc}
	 *
	 * @throws Exception
	 */
	protected function _getShinglesFromText($text) {
		if (empty($text)) {
			return array();
		}
		if (!$this->_params['length']) {
			throw new Exception('Not found param of length');
		}
		
		$shingleLen = (int)$this->_params['length'];
		$textLen = mb_strlen($text);
		for ($start = 0; $start < $textLen; $start++) { 
			$shingles[] = md5(mb_substr($text, $start, ($shingleLen))); 
		}

		return $shingles;
	}
}