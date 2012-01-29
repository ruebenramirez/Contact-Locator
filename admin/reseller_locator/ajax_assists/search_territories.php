<?php
/*
 * search_territories.php
 *
 * http://docs.jquery.com/Plugins/Autocomplete
 * http://view.jquery.com/trunk/plugins/autocomplete/demo/
 *
 */


$q = strtolower($_GET["q"]);
if (!$q) return;
$items = array(
"Great <em>Bittern</em>"=>"Botaurus stellaris",
"Little <em>Grebe</em>"=>"Tachybaptus ruficollis",
"Black-necked Grebe"=>"Podiceps nigricollis",
"Little Bittern"=>"Ixobrychus minutus",
"Black-crowned Night Heron"=>"Nycticorax nycticorax",
"Purple Heron"=>"Ardea purpurea",
"White Stork"=>"Ciconia ciconia",
"Spoonbill"=>"Platalea leucorodia",
);

foreach ($items as $key=>$value) {
	if (strpos(strtolower($key), $q) !== false) {
		echo "$key|$value\n";
	}
}

?>