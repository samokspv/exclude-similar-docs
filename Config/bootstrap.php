<?php
/**
 * Author: samokspv <samokspv@yandex.ru>
 * Date: 29.10.2014
 * Time: 15:00:00
 */

CakePlugin::load('CakePdf', array('bootstrap' => true, 'routes' => false));

include 'defaultConfig.php';
$config = Hash::mergeDiff(
	(array)Configure::read('ExcludeSimilarDocs'),
	$defaultConfig
);
Configure::write('ExcludeSimilarDocs', $config);