<?php
header('Content-type: text/javascript');

require_once 'base.php';
$documents = collection()->find();
$documents->sort(array('Timestamp' => -1));

$res = array();
$i=0;
foreach ($documents as $document) {
	$id = $document['_id'];

	unset($document['manifest']);

	$res[] = sprintf("    '%s' : %s", $id, json_encode($document));

	if ($i==10) {
		break;
	}
}

$res = array_reverse($res);
$res = array_splice($res, 0, 10);

echo "collection = {\n";
echo implode(",\n", $res);
echo "\n};";
