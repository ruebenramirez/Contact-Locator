<?php

/*
 * country_compilation.php
 * take irene's list of countries and add all countries that we don't already have in the existing dataset
 */

require('../inc.php');

$sql_newCountries = "SELECT irenes_countries.name FROM irenes_countries WHERE irenes_countries.name NOT IN"
	."(SELECT countries.name FROM countries)";
$results_newCountries = mysql_query($sql_newCountries) or die('died trying to find new countries: '.mysql_error());
while($country = mysql_fetch_assoc($results_newCountries)) {
	
	//convert special characters if there are any..
	//$name = filter_var($country['name'], FILTER_SANITIZE_SPECIAL_CHARS);
	$name = addslashes($country['name']); //the safe php4 way
	
	//echo "STARTED adding ".$country['name']." to countries table.<br />";
	echo "STARTED adding ".$name." to countries table.<br />";
	$sql_addCountry = "INSERT INTO countries (name) VALUES(\"".$name."\");";
	mysql_query($sql_addCountry)or die('died trying to add country '.mysql_error());
	echo "FINISHED adding ".$name." to countries table.<br /><br />";
}

?>