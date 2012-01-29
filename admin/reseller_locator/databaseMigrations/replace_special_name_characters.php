<?php

/*
 * replace_special_name_characters.php
 *
 */

$server = "localhost";			// Your mySQL Server
$db_user = "root";				// Your mySQL Username
$db_pass = "bamalam@";					// Your mySQL Password
$db = "international_cities_rrr";				// Database Name

//use the international_cities db
$dbconnectINTCities=mysql_pconnect($server, $db_user, $db_pass) or die ("Database CONNECT Error");
mysql_select_db($db, $dbconnectINTCities);

//get all countries
$sqlGetCountries = "SELECT short_name FROM countries WHERE short_name != '';";
$resultCountries = mysql_query($sqlGetCountries) or die('died getting countries: '.mysql_error());
while($country = mysql_fetch_assoc($resultCountries)) {
	mysql_select_db('information_schema', $dbconnectINTCities);
	//check if the table exists  query pulled from: http://www.electrictoolbox.com/check-if-mysql-table-exists/
	$sqlCheckTableExists = "SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = 'international_cities_rrr' AND table_name = '".$country['short_name']."';";
	$resultsTableExistsCheck = mysql_query($sqlCheckTableExists) or die('died trying to see if the table exists: '.mysql_error());
	if(mysql_num_rows($resultsTableExistsCheck) > 0) {
		//		echo $country['short_name']." ";
		$tableExists = mysql_fetch_assoc($resultsTableExistsCheck);
		//		echo $tableExists['COUNT(*)'];
		//		echo '<br />';

		if ($tableExists['COUNT(*)'] > 0) { //see if the country table exists in the international_cities db
			echo "modifying records of: ".$country['short_name']."<br />";
			mysql_select_db($db, $dbconnectINTCities);

			//add the updatedNameColumn
			$field_array = array();
			$fields = mysql_list_fields($db, $country['short_name']);
			$columns = mysql_num_fields($fields);
			for ($i = 0; $i < $columns; $i++) {
				$field_array[] = mysql_field_name($fields, $i);
			}
			
			echo '<br />';
			var_dump($field_array);
			echo '<br />';
			
			if (!in_array('updatedName', $field_array)) {
				echo "altering table: adding updatedName<br/>";
				$sqlAddUpdatedColumnToTable = "ALTER TABLE `".$country['short_name']."` ADD `updatedName` TINYINT NOT NULL DEFAULT '0';";
				mysql_query($sqlAddUpdatedColumnToTable) or die('died modifying the table to add the updatedName column: <br />sql: '.$sqlAddUpdatedColumnToTable.' <br />error: '.mysql_error());
			} else {
				echo "table was already altered <br />";
			}

			$sqlGetCities = "SELECT id, name FROM `".$country['short_name']."` WHERE updatedName != '1';";
			$resultCities = mysql_query($sqlGetCities) or die('died getting cities: <br />sql: '.$sqlGetCities.' <br />error: '.mysql_error());
			while($city = mysql_fetch_assoc($resultCities)) {
				updateName($city['id'], $city['name'], $country['short_name']);
			}
		}
	}
}


function updateName($id=null, $cityName=null, $countryCode=null) {
	$city = addslashes(filter_var($cityName, FILTER_SANITIZE_STRING));
	$sqlUpdateCityName = "UPDATE `".$countryCode."` SET name = '".$city."', updatedName = '1' WHERE id ='".$id."'";
	mysql_query($sqlUpdateCityName) or die('died updating city name: <br />sql: '.$sqlUpdateCityName.' <br />error: '.mysql_error());
}





