<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');

function preg_return($pattern, $subject, $keys=null) {
	$matches = array();
	$count = preg_match_all($pattern, $subject, $matches);

	array_shift($matches);
	
	if ($keys===null) {
		$res = $matches;
	}
	elseif ($keys===false) {
		return $matches[0][0];
	}
	else {
		$res = array();

		for ($i=0; $i<$count; $i++) {
			for ($j=0; $j<count($matches[$i]); $j++) {
				$res[$i][$keys[$j]] = $matches[$j][$i];
			}
		}
	}

	return $res;
}

function getVarOrDie($arr, $var) {
	$res = getVarOrNull($arr, $var);
	if ($res===null) {
		goAway();
	}
	return $res;
}

function getVarOrNull($arr, $var) {
	$res = isset($arr[$var]) ? $arr[$var] : null;
	return $res;
}

function goAway() {
	header('Location: .');
	exit;
}

$db = null;
function &db() {
	global $db;

	if ($db===null) {
		$m = new Mongo();
		$db = $m->collegerama;
	}

	return $db;
}

$collection = null;
function &collection() {
	global $collection;

	if ($collection===null) {
		$db = db();
		$collection = $db->collegerama;
	}

	return $collection;
}

function start() {
	collection();
}

// 	// select a collection (analogous to a relational database's table)
// 	$collection = $db->cartoons;

// 	// add a record
// 	$document = array( "title" => "Calvin and Hobbes", "author" => "Bill Watterson" );
// 	$collection->insert($document);

// 	// add another record, with a different "shape"
// 	$document = array( "title" => "XKCD", "online" => true );
// 	$collection->insert($document);

// 	// find everything in the collection
// 	$cursor = $collection->find();

// 	// iterate through the results
// 	foreach ($cursor as $document) {
// 	    echo $document["title"] . "\n";
// 	}
// }
