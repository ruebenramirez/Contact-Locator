<?php
/*
 * populateCountryShortNames.php
 * populate country short names where they don't already exist
 *
 * (the only reason they wouldn't exist is because the GNS dataset from the NGA didn't have
 * 	City listing data records in the dataset we're using for international geocoding by city name)
 * (so all these countries without pre-existing short_names come from Irene's excel spreadsheet)
 */

require('../inc.php');

$sqlGetNullShortNamedCountries = "SELECT id, name FROM countries WHERE short_name = ''";
$resultNullShortNamedCountries = mysql_query($sqlGetNullShortNamedCountries) or die('died getting null short_named country listings: '.mysql_error);
while($countryRow = mysql_fetch_object($resultNullShortNamedCountries)) {
	echo "working with: ".$countryRow->name."<br />";
	
	$shortName = generateShortName($countryRow->name);
	
	echo "short name for this record is: ".$shortName."<br /><br />";
	
	$sqlInsertNewShortName = "UPDATE countries SET short_name = '".$shortName."' WHERE id = '".$countryRow->id."' OR name = short_name";
	mysql_query($sqlInsertNewShortName) or die('died trying to update the country\'s short name: '.mysql_error());
}

function generateShortName($longName) {
	$explodedName = explode(' ', $longName);
	$shortName = '';
	
// more than one word for the country name
	foreach($explodedName as $subStr) {
		if($subStr != 'and' && $subStr != 'del' && $subStr != '/' && $subStr != 'of' && $subStr != 'the') {
			if (substr($subStr, 0, 1) != "(") {
				$shortName .= substr($subStr, 0, 1);
			} else {
				$shortName .= substr($subStr, 1, 1);
			}
		}
	}
	
	if (count($explodedName) == 1) {
		// only 1 word for the country name
		$shortName .= strtoupper(substr($longName, -1));
		
	}

	$count = 1;
	while(countryShortNameExists($shortName)) {
		if (!countryShortNameExists($shortName.$count)) {
			$shortName = $shortName.$count;
		} else {
			$count++;
		}
	}
	return $shortName;
}

function countryShortNameExists($short_name=null) {
	if (!isset($short_name)) {
		return false;
	}
	
	$sqlFindShortName = "SELECT * FROM countries WHERE short_name = '".$short_name."'";
	$resultShortNames = mysql_query($sqlFindShortName) or die('died locating existing shortname: '.mysql_error());
	if(mysql_num_rows($resultShortNames) > 0) {
		return true;
	}
	return false;
}

?>
