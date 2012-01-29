<?php
/*
 * change the short state name and
 */
require('inc.php');

//get all territories
$sqlSelectAll = "SELECT * FROM territories;";
$resultsALL = mysql_query($sqlSelectAll) or die('died trying to get all territory information: '.mysql_error());
while ($rowAll = mysql_fetch_assoc($resultsALL)) {
	//get the current territories full state name
	$sqlGrabFullName = "SELECT state FROM states WHERE state_abbr = '".$rowAll['name']."'";
	$resultsFullname = mysql_query($sqlGrabFullName) or die ('died trying to get this states full name: '.mysql_error());
	while($rowFullname = mysql_fetch_assoc($resultsFullname)){
		//update this territory to include the full state name
		$sqlUpdateTerritoryName = "UPDATE territories set full_name = '".$rowFullname['state']."' WHERE name = '".$rowAll['name']."';";
		mysql_query($sqlUpdateTerritoryName) or die('died trying to save this territories full name: '.mysql_error());
	}
}


?>