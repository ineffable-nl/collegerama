<?php

require_once 'base.php';

$collection = collection();

// iterate through the results
if (isset($_GET['clear'])) {
	$cursor = $collection->find();

	foreach ($cursor as $document) {
	    $collection->remove($document);
	}
	
	exit('cleared!!');
}


$link = getVarOrDie(array_merge($_GET, $_POST), 'link');

$matches = array();
if (preg_match("/([a-z0-9]){34}/", $link, $matches)===false) {
	goAway();
}

if (count($matches)==0) {
	exit;
}

$collegeramaId = $matches[0];

// $document = $collection->findOne(['collegeramaId' => $collegeramaId]);

// if (!is_array($document)) {
	$document = [
		'collegeramaId' => $collegeramaId,
		'Timestamp' 	=> time()
	];


	$manifest = getVarOrNull($document, 'manifest');
	if (!$manifest) {
		$url = 'http://collegerama.tudelft.nl/Mediasite/FileServer/Presentation/'.$collegeramaId.'/manifest.js';
		$manifest = file_get_contents($url);
	}

	$document['Title'] 		= preg_return("/Mediasite.PlaybackManifest.Title=\"(.+)\"/", $manifest, false);

	$airDate 				= preg_return("/Mediasite.PlaybackManifest.AirDate=\"(.+)\"/", $manifest, false);
	$airTime 				= preg_return("/Mediasite.PlaybackManifest.AirTime=\"(.+)\"/", $manifest, false);
	$document['Aired'] 		= strtotime($airDate.' '.substr($airTime, 0, strpos($airTime, ' ')));
	$document['Duration'] 	= gmdate('H:i:s', ((int)preg_return("/Mediasite.PlaybackManifest.Duration=(.+);/", $manifest, false))/1000);

	$document['videoUrls'] 	= preg_return("/Mediasite.PlaybackManifest.VideoUrls\[[0-9]\].+MimeType:\"(.+)\".+Location:\"(.+)\"/", $manifest, array('mimeType', 'Location'));

	$document['manifest'] 	= $manifest;


	unset($document['manifest']);
// }
// else {
// 	$document = [
// 		'Timestamp' 	=> time()
// 	];
// }

if (isset($document['videoUrls']) && is_array($document['videoUrls'])) {
	$collection->save($document);
	echo json_encode($document);
}
