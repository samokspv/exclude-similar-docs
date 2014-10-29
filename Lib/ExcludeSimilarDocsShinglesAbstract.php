<?php
/**
 * Author: samokspv <samokspv@yandex.ru>
 * Date: 29.10.2014
 * Time: 15:00:00
 */

App::uses('ExcludeSimilarDocsAbstract', 'ExcludeSimilarDocs.Lib');

/**
 * Class exclude similar documents with shingles algorithm
 *
 * @package ExcludeSimilarDocs
 * @subpackage Lib
 */
abstract class ExcludeSimilarDocsShinglesAbstract extends ExcludeSimilarDocsAbstract {
	
	/**
	 * Texts
	 * 
	 * @var array
	 */
	protected $_texts = array();
	
	/**
	 * Shingles
	 * 
	 * @var array
	 */
	protected $_shingles = array();

	/**
	 * Returns text from document fields
	 * 
	 * @param  array $Doc
	 * 
	 * @return string
	 */
	protected function _getTextFromDocFields($Doc) {
		$text = '';
		if (empty($Doc)) {
			return $text;
		}

		foreach ($this->_params['fields'] as $field) {
			if (empty($Doc->{$field})) {
				continue;
			}
			$text .= !empty($text) ? ' ' : '';
			$text .= $Doc->{$field};
		}

		return $text; 
	}

	/**
	 * Adds text
	 * 
	 * @param string $text
	 * @return array
	 */
	protected function _addText($text) {
		if (empty($text)) {
			return false;
		}

		$this->_texts[] = $text;

		return true;
	}

	/**
	 * Returns shingles
	 * 
	 * @return object
	 */
	protected function _getShigles() {
		return $this->_canonizeTexts()->_setShingles()->_shingles;
	}

	/**
	 * Canonize texts
	 * 
	 * @return object
	 */
	protected function _canonizeTexts() {
		if (empty($this->_texts)) {
			return $this;
		}

		foreach ($this->_texts as $key => $text) {
			$this->_texts[$key] = $this->_canonizeText($text);
		}

		return $this;
	}

	/**
	 * Canonize single text
	 * 
	 * @param  string $text
	 * 
	 * @return string
	 */
	protected function _canonizeText($text) {
		$canonizeText = array();
		$text = strip_tags($text);
		$text = html_entity_decode($text);
		$text = str_replace($this->_params['stopSymbols'], null, $text);

		foreach (explode(' ', $text) as $word) {
			$word = trim($word);
			$word = strtolower($word);
			if (!empty($word) && !in_array($word, $this->_params['stopWords'])) {
				$canonizeText[] = $word;
			}
		}

		return strtolower(implode(' ', $canonizeText));
	}

	/**
	 * Sets shingles for texts
	 * 
	 * @return object
	 */
	protected function _setShingles() {
		foreach ($this->_texts as $text) {
			$this->_shingles[] = $this->_getShinglesFromText($text);
		}

		return $this;
	}

	/**
	 * Returns similar documents ids from shingles
	 * 
	 * @return array
	 */
	protected function _getSimilarDocsIds() {
		$similarDocsIds = array();
		$shingles = $this->_getShigles();
		$shinglesList = Hash::extract($shingles, '{n}.{n}');
		$countsEachShingle = array_count_values($shinglesList);
		foreach ($shingles as $docId => $shingles1Doc) {
			$countSimilarShingles = 0;
			foreach ($shingles1Doc as $shingleId => $shingle) {
				if (isset($countsEachShingle[$shingle]) && $countsEachShingle[$shingle] > 1) {
					$countSimilarShingles++;
					unset($countsEachShingle[$shingle]);
				}
			}
			$similarity = round(($countSimilarShingles / count($shingles1Doc)) * 100, 2);
			if ($similarity > $this->_params['allowSimilarity']) {
				$similarDocsIds[$docId] = true; 
			}
		}

		return $similarDocsIds;
	}

	/**
	 * Returns shingles from text
	 * 
	 * @param  string $text
	 * 
	 * @return array
	 */
	abstract protected function _getShinglesFromText($text); 
}