<?php
/*
 * resellers_table_stateName_to_stateId.php
 *
 * requires that the resellers table have a state (type varchar) and separately a state_id (type varchar)
 */

require('../inc.php');


//get all reseller states that need to be modified
$sqlGetResellerStates = "SELECT state FROM resellers GROUP BY state";
$resultResellerStates = mysql_query($sqlGetResellerStates) or die('died getting reseller states: '.mysql_error());
while($stateName = mysql_fetch_object($resultResellerStates)) {
	//get the stateID for the state_id field of the resellers table
	echo "working with state: ".$stateName->state."<br />";
	$sqlStateId = "SELECT id FROM states WHERE state = '".$stateName->state."'";
	$resultStateId = mysql_query($sqlStateId) or die('died getting state id from name lookup: '.mysql_error());
	while($stateRow = mysql_fetch_object($resultStateId)) {
		//save the id to the state_id field of the resellers table
		$sqlSaveStateId = "UPDATE resellers SET state_id = '".$stateRow->id."' WHERE state = '".$stateName->state."'";
		mysql_query($sqlSaveStateId) or die('died saving the state_id to the resellers table: '.mysql_error());
	}
}

echo "<br /><br />";

//update the state field from the state_id field
$sqlUpdateStateFromId = "SELECT id, state_id FROM resellers WHERE state_id != ''";
$resultStates = mysql_query($sqlUpdateStateFromId) or die('died grabbing state records with a state_id: '.mysql_error());
while($staterow = mysql_fetch_object($resultStates)) {
	echo "updating id: ".$staterow->id."<br />";
	$sqlUpdateStateField = "UPDATE resellers SET state = '".$staterow->state_id."' WHERE id = '".$staterow->id."'";
	mysql_query($sqlUpdateStateField) or die('died trying to update the state field with the contents of the state_id: '.mysql_error());
}


?>