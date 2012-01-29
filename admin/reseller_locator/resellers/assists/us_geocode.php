<?php

/*
 * us_geocode.php
 *
 *	The idea is that I get a zipcode to lookup and return a Lat/Lon coordinate pair via JSON...
 *
 * I would like to use this: http://php.net/manual/en/function.json-encode.php
 *  but we won't have access to php 5.2 on the production server for a while, so I'll have to code the JSON response by hand.
 *
 */

require('../../inc.php');

if(isset($_REQUEST['zip'])) {
	geocode($_REQUEST['zip']);
}

function geocode($zip=null) {
	$sql = "SELECT lat,lon FROM zip_codes WHERE zip_code = '".addslashes($zip)."';";
	$results = mysql_query($sql) or die('died getting lat/lon coordinate pairs: '.mysql_error());
	while($row = mysql_fetch_assoc($results)) {
		//build the JSON output here
		
		// build up a test request to mimic
//		$jsonReturn["lat"] = $row['lat'];
//		$jsonReturn["lon"] = $row['lon'];
//		print json_encode($jsonReturn); //only available in php 5.2
		/*
		 * echoed out:
		 * {"lat":"29.56","lon":"-98.61"}
		 */
		
		// only use the last values returned from the database
		$latitude = $row['lat'];
		$longitude = $row['lon'];
	}
	if (isset($latitude) && isset($longitude)) {
		echo '{"lat":"'.$latitude.'","lon":"'.$longitude.'"}'; //outputting JSON by hand
	} else {
		echo '{"errorCode":"Could not use that zip code.  Try something else."}'; //outputting JSON by hand
	}
}
