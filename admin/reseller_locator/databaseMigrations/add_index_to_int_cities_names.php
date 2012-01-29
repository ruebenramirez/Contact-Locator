<?php
/*
 * add_index_to_int_cities_names.php
 *
 */


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
		$tableExists = mysql_fetch_assoc($resultsTableExistsCheck);
		if ($tableExists['COUNT(*)'] > 0) { //see if the country table exists in the international_cities db
			mysql_select_db('international_cities_rrr', $dbconnectINTCities);
			$sqlCreateNameIndex ="ALTER TABLE  `international_cities_rrr`.`".$country['short_name']."` ADD UNIQUE (`name`)";
			mysql_query($sqlCreateNameIndex) or die('died creating new index: '.mysql_error());
		}
	}
}