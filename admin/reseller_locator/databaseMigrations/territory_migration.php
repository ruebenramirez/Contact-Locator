<?php

/*
 * territory_migration.php
 * migrate territory data out of the resellers table into the territories and reseller_territories tables
 */

require('inc.php');

echo "This script migrates territories out of the resellers table and populates both the territories and reseller_territories tables<br />";

cycleTerritoriesFromResellers();

/*
 * cycle through existing reseller records in the resellers table
 * 	to grab the t_state_x territory associations
 */
function cycleTerritoriesFromResellers() {
	$sqlExistingTerritories = "SELECT * FROM resellers WHERE t_state_1 != '' OR t_state_2 != '' OR t_state_3 != '' OR t_state_4 != '' OR t_state_5 != '' OR t_state_6 != '' OR t_state_7 != '' OR t_state_8 != '' OR t_state_9 != t_state_10 != '';";
	$resultsExistingTerritories = mysql_query($sqlExistingTerritories) or die('died trying to get existing territories. error: '.mysql_error());
	echo mysql_num_rows($resultsExistingTerritories)." records were returned for the migration. <br />";
	while ($row = mysql_fetch_assoc($resultsExistingTerritories)) {
		echo "Checking out reseller: ".$row['company'].'<br />';
		// process through existing territories and populate the new territories table
		for ($i = 1; $i<11; $i++) {
			//echo "checking out t_state_".$i."<br />";
			if (isset($row['t_state_'.$i]) && !empty($row['t_state_'.$i])) {
				echo "looking at t_state_$i <br />";
				addResellerTerritory($row['t_state_'.$i], $row['id']);
			}
		}
		echo "<br />";
	}
}

/*
 * add territory string passed (which should be a state abbreviation)
 * and save the new territory and then tie an association
 * 	between a reseller and that territory
 */
function addResellerTerritory($territory, $resellerId) {
	if ($territory != "") {
		echo "addResellerTerritory() init<br />";

		//get state name from the state abbreviation in the $territory var
		$state = null;
		$sql = "SELECT state FROM states WHERE state_abbr = '$territory';";
		$result = mysql_query($sql) or die('died trying to get the state name from the abbreviation. error: '.mysql_error());
		while ($row = mysql_fetch_assoc($result)) {
			$state = $row['state'];
		}

		//if state information wasn't returned, then save the new territory as the former table's abbreviation
		if (!empty($state)) {
			$state = $territory;
		}

		$territory_id = null;
		// check for existing territory.  (add if necessary)
		$sql = "SELECT id FROM territories WHERE name = '$state';";
		$result = mysql_query($sql) or die('died trying to see if territory already exists');
		if (mysql_num_rows($result) > 0) {
			//territory already exists
			$territory_id = $row['id'];
		} else {
			//add this territory
			$sqlAddTerritory = "INSERT INTO territories (name) VALUES('$state')";
			mysql_query($sqlAddTerritory) or die('died trying to add this territory: $state...  error: '.mysql_error());
			$territory_id = mysql_insert_id();
		}

		//make sure this reseller territory association hasn't already been made
		$sql = "SELECT id FROM reseller_territories WHERE reseller_id = '$resellerId' AND territory_id = '$territory_id';";
		$results = mysql_query($sql) or die("died trying to find previous associations for reseller id: $resellerId and territory_id: $territory_id error: ".mysql_error());
		if (mysql_num_rows($results) < 1) { //only add an association if it hasn't been made yet
			// add territory association to reseller_territories
			echo "New reseller-territory association is being made.";
			$sqlAddassociation = "INSERT INTO reseller_territories (reseller_id, territory_id) VALUES('$resellerId', '$territory_id')";
			mysql_query($sqlAddassociation) or die("died trying to make association. error: ".mysql_error());
		} else {
			echo "this association has already been made...<br />";
		}
	}
}





