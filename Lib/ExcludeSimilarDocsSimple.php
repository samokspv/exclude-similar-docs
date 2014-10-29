<?php
/**
 * Author: samokspv <samokspv@yandex.ru>
 * Date: 29.10.2014
 * Time: 15:00:00
 */

App::uses('ExcludeSimilarDocsAbstract', 'ExcludeSimilarDocs.Lib');

/**
 * Class exclude similar documents with simple algorithm
 *
 * @package ExcludeSimilarDocs
 * @subpackage Lib
 */
class ExcludeSimilarDocsSimple extends ExcludeSimilarDocsAbstract {
	
	/**
	 * Returns exclude similar documents
	 * 
	 * @param  array $Docs
	 * 
	 * @return array
	 * 
	 * @todo Dynamic title/description fields
	 */
	public function exclude($Docs) {
		$hashChecks = array();
		foreach ($Docs as $key => $Doc) {
			$hashTitle = md5($Doc->title);
			$hashDescr = md5($Doc->description);
			if (isset($hashChecks[$hashTitle]) || isset($hashChecks[$hashDescr])) {
				unset($Docs[$key]);
				continue;
			}
			if (!empty($Doc->title)) {
				$hashChecks[$hashTitle] = true;
			}
			if (!empty($Doc->description)) {
				$hashChecks[$hashDescr] = true;
			}
		}
		
		return $Docs;
	}
}