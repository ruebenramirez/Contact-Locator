<?php
/*
 * remove_duplicate_city_entries.php
 */

//select
$server = "localhost";			// Your mySQL Server
$db_user = "root";				// Your mySQL Username
$db_pass = "bamalam@";					// Your mySQL Password
//$db = "reseller_rrr";				// Database Name

//use the international_cities db
$dbconnectINTCities=mysql_pconnect($server, $db_user, $db_pass) or die ("Database CONNECT Error");
mysql_select_db('international_cities_rrr', $dbconnectINTCities);

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
			mysql_select_db('international_cities_rrr', $dbconnectINTCities);
			//get all duplicate city entries for this country
			$sqlGetDuplicates = "SELECT cc1, COUNT(name), name FROM `".$country['short_name']."` GROUP BY name HAVING(COUNT(name) > 1);";
			$resultDuplicates = mysql_query($sqlGetDuplicates) or die('died trying to get duplicates: '.mysql_error());
			while($city = mysql_fetch_assoc($resultDuplicates)) {
				echo "Duplicate Found: ".$city['name'].'<br />';
				removeDuplicates($city['name'], $city['cc1']);
			}
		}
	}
}


function removeDuplicates($cityName=null,$countryCode=null) {
	$duplicates = array();

	//get all id's for city duplicates
	$sql = "SELECT id FROM `$countryCode` WHERE name = '".addslashes($cityName)."'";
	$results = mysql_query($sql) or die('died getting all this city\'s duplicate entries: '.mysql_error());
	while($city = mysql_fetch_assoc($results)) {
		$duplicates[] = $city['id'];
	}

	//go through and delete all the duplicate cities (leaving the last city record only)
	for ($i = 0; $i < count($duplicates)-1; $i++) { //don't go through the entire duplicates array (leave the last one alone)
		$sql = "DELETE FROM `$countryCode` WHERE id = '$duplicates[$i]';";
		mysql_query($sql) or die('died trying to delete a duplicate city: '.mysql_error());
	}

}

?>