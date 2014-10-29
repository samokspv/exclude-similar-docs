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
	 */
	protected function _getShinglesFromText($text) {
		if (empty($text)) {
			return array();
		}
		if (!$this->_params['length']) {
			throw new Exception('Not found param of length');
		}

		$length = (int)$this->_params['length'];
		$words = explode(' ', $text);
		$countWords = count($words);
		if ($countWords <= $length) {
			return array(md5(implode(' ', $words)));
		}
		$shingles = array();
		$countShingles = $countWords - $length;
		for ($i = 1; $i <= $countShingles; $i++) {
			$shingles[] = md5(implode(' ', array_slice($words, $i, $length)));
		}

		return $shingles;
	}
}