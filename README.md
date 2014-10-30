ExcludeSimilarDocs
==================
[![Build Status](https://travis-ci.org/samokspv/exclude-similar-docs.png)](https://travis-ci.org/samokspv/exclude-similar-docs) [![Coverage Status](https://coveralls.io/repos/samokspv/exclude-similar-docs/badge.png?branch=master)](https://coveralls.io/r/samokspv/exclude-similar-docs?branch=master) [![Latest Stable Version](https://poser.pugx.org/samokspv/exclude-similar-docs/v/stable.svg)](https://packagist.org/packages/samokspv/exclude-similar-docs) [![Total Downloads](https://poser.pugx.org/samokspv/exclude-similar-docs/downloads.svg)](https://packagist.org/packages/samokspv/exclude-similar-docs) [![Latest Unstable Version](https://poser.pugx.org/samokspv/exclude-similar-docs/v/unstable.svg)](https://packagist.org/packages/samokspv/exclude-similar-docs) [![License](https://poser.pugx.org/samokspv/exclude-similar-docs/license.svg)](https://packagist.org/packages/samokspv/exclude-similar-docs)

ExcludeSimilarDocs plugin for CakePHP

Use it if you want to exclude similar documents:
	Types exclude:
		simple   - exclude documents by identical duplication search
		shingles - exclude documents by near-duplicate search (shingles algorithm)

## Installation

	cd my_cake_app/app
	git clone git@github.com:samokspv/exclude-similar-docs.git Plugin/ExcludeSimilarDocs

or if you use git add as submodule:

	cd my_cake_app
	git submodule add "git@github.com:samokspv/exclude-similar-docs.git" "app/Plugin/ExcludeSimilarDocs"

then add plugin loading in Config/bootstrap.php

	CakePlugin::load('ExcludeSimilarDocs', array('bootstrap' => true, 'routes' => false));

## Usage

In any place of your code:
	
	App::uses('ExcludeSimilarDocs', 'ExcludeSimilarDocs.Utility');

	Configure::write('ExcludeSimilarDocs', array(
		'types' => array(
			'simple' => array(
				'fields' => array(
					'title',
					'description'
				) // documents fields for comparison
			),
			'shingles' => array(
				'fields' => array(
					'title',
					'description'
				), // documents fields for comparison
				'length' => 10, // length of single shingle
				'allowSimilarity' => 1, // alllow percent similarity documents
				'stopWords' => array(), // your own prepositions and conjunction for clear in texts
				'stopSymbols' => array() // your own punctuation marks, others symbols for clear in texts
			)
		)
	));

	For example:
	
	---------------
	(type - simple)

	// array of objects documents with fields title/description (default)
	$arrayOfObjDocs = array(
		objDoc1, 
			/* 
			title = 
				'title 1'
			description = 
				'description 1'
			*/
		objDoc2, 
			/* 
			title = 
				'title 1'
			description = 
				'description 2'
			*/
		objDoc3 
			/* 
			title = 
				'title 3'
			description = 
				'description 1'
			*/
		//...
	);

	$arrayOfObjDocs = ExcludeSimilarDocs::exclude($arrayOfObjDocs);
	debug($arrayOfObjDocs); 
	/*
		array(
			objDoc1 // document with 'title 1' or 'description 1' we already have
			//...
		);
	*/

	-----------------
	(type - shingles)

	// array of objects documents with fields title/description (default)
	$arrayOfObjDocs = array(
		objDoc1, 
			/* 
			title = 
				'Hong Kong Security Chief Says 6 Police Seen on Video Beating Protester Have Been Reassigned'
			description = 
				'Hong Kong security chief says 6 police seen on video beating protester have been reassigned'
			*/
		
		objDoc2, 
			/* 
			title = 
				'Hong Kong police seen beating activist reassigned'
			description = 
				'HONG KONG (AP) — Hong Kong’s security chief says some police officers who were captured on video kicking a democracy protester during an operation to clear demonstrators from a tunnel have been reassigned. Secretary for Security Lai Tung-kwok said Wednesday that the officers were moved to other posts and that the police department is carrying out an investigation. (MORE: Violence flares in Hong Kong as protests continue) Local television channel TVB showed footage of around six plainclothes police officers taking a man around the side of a building, placing him on the ground and...'
			*/
		
		objDoc3
			/* 
			title = 
				'Violence flares in Hong Kong as protests continue'
			description = 
				'Police officers push protesters out to a nearby park to clear the main roads outside government headquarters in Hong Kong’s Admiralty, Wednesday. Pic: AP. Violence flared again in Hong Kong last night as police clashed with protesters. Police are reported to have beaten pro-democracy protesters as they attempted to clear the streets after more than two weeks of rallies. Tuesday night’s clashes followed a tense two days on Hong Kong’s streets. Events have been so fast that even reporting has proven a challenge. Some barricades have been removed, others built. A major road...'
			*/
		//...
	);

	$arrayOfObjDocs = ExcludeSimilarDocs::exclude($arrayOfObjDocs, array('type' => 'shingles'));
	debug($arrayOfObjDocs); 
	/*
		array(
			objDoc2,
			objDoc3
			//...
		);
	*/