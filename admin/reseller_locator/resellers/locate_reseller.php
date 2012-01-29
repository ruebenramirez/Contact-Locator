<?php
/*
 * locate_reseller.php
 *
 * look for the closest reseller based on the input zip code search criteria
 *
 *	geodesic functions pulled from http://imaginerc.com/software/GeoCalc/
 *
 */

//require('inc.php'); //grab the reseller class from the inc.php....

//if (isset($_REQUEST['zip_code'])) {
//	getCloseUSResellers($_REQUEST['zip_code']);
//}


function validateZipCode($zip) {
	if (empty($zip) || !isset($zip)) {
		return false;
	}

	$sqlZipCheck = "SELECT zip_code FROM zip_codes WHERE zip_code = '$zip';";
	$rZipCheck = mysql_query($sqlZipCheck) or die('Died trying to confirm valid zip code. error: '.mysql_error());
	if (mysql_num_rows($rZipCheck)> 0) {
		return true;
	}

	return false;
}

function getTerritoryElites($zip=null) {
	global $debug;
	
	
	if(empty($zip) || !isset($zip)) {
		return false; 
	}
	
	$resellers = array();
	$sqlGetTerritoryResellers = "SELECT `resellers`.id
		FROM `resellers`
		JOIN `reseller_territories` ON `reseller_territories`.reseller_id = `resellers`.id
		JOIN `territories` ON `territories`.id = `reseller_territories`.territory_id
		JOIN `states` ON `states`.state = `territories`.name
		JOIN `zip_codes` ON `zip_codes`.state_prefix = `states`.state_abbr
		WHERE `zip_codes`.zip_code = '".$zip."'
		AND `resellers`.elite = '1'";
	$sqlResultTerritoryResellers = mysql_query($sqlGetTerritoryResellers) or die('died getting elite partners by territory: '.mysql_error());
	while($territoryReseller = mysql_fetch_object($sqlResultTerritoryResellers)) {
		if($debug) {
			echo '<br />Elite partner id: '.$territoryReseller->id.'<br />';
		}
		$resellers[] = $territoryReseller->id;
	}
	return $resellers;
}

function getCloseUSResellers($zip=null, $product=null, $elite=false) {
	global $debug;
	if (empty($zip) || empty($product)) {
		return false;
	}
	
	
	$minResellerResults = 3;
	$resellers = array();

	if ($debug) {
		echo "zip code is valid.  Locating resellers. <br />";
	}
	
	if($elite) {
		$resellers = getTerritoryElites($zip);
	} else {
		// check resellers list for identical zip code matches
		$sqlExactZipMatch = "SELECT * FROM `resellers` ";
		if ($product != 'all') {
			$sqlExactZipMatch .= "JOIN `reseller_products` ON `resellers`.id = `reseller_products`.reseller_id WHERE `reseller_products`.product_id = '".$product."' AND zip = '".$zip."'";
		} else {
			$sqlExactZipMatch .= "WHERE zip = '".$zip."'";
		}
		
//		echo "sql exact zip: ";
//		var_dump($sqlExactZipMatch);
//		echo "<br />";
		
		$rExactMatch = mysql_query($sqlExactZipMatch) or die('died trying to get exact match listings: '.mysql_error());
		if (mysql_num_rows($rExactMatch) >= $minResellerResults) {
			while ($row = mysql_fetch_assoc($rExactMatch)) {
				//we found enough resellers by exact zip
				$resellers[] = $row['id'];
			}
			return $resellers = sortResellersByDistance($zip, $resellers); //sort the array based on distances from the zip
		} else {
			// didn't find enough exact zip code matches
			if ($debug) {
				echo "Not enough resellers yet (only found ".mysql_num_rows($rExactMatch).")<br /><br />";
			}
	
			$dRadius = null;
	
			while(count($resellers) <= $minResellerResults) { //do we have enough resellers?
				//increase the search range by 20% for every pass that we haven't met our success record count
				if (!isset($dRadius)) {
					$dRadius = 16.09344;  //10 miles in kilometers
					if ($debug) {
						echo "Search radius is: $dRadius<br />";
					}
				} else {
					$dRadius *= 1.025;
					if ($debug) {
						if (count($resellers) > 0) {
							echo "<br />".count($resellers)." resellers found.<br />New search radius is: $dRadius<br />";
						} else {
							echo "<br />nothing found yet.<br />New search radius is: $dRadius<br />";
						}
					}
				}
				$resellers = resellersCloseToZip($dRadius, $zip, $product, $elite);
			}
			if($debug) {
				echo "<br /><b>We found enough resellers to display!</b><br />";
			}
		}
	}
	
	$resellers = sortResellersByDistance($zip, $resellers);
	return $resellers;
}

function getZipsLat($zip) {
	global $debug;
	if ($debug) {
	}
	$sqlCoordFind = "SELECT lat, lon FROM zip_codes WHERE zip_code = '".$zip."'";
	$resultCoordFind = mysql_query($sqlCoordFind) or die ('died trying to get zip for this coord. error:'.mysql_error());
	$dLongitude = null;
	$dLatitude = null;
	while($row = mysql_fetch_assoc($resultCoordFind)) {

		$dLatitude = $row['lat'];
		if($debug) {
			echo "zip latitude is $dLatitude <br />";
		}
		return $dLatitude;
	}
}

function getZipsLong($zip) {
	global $debug;

	$sqlCoordFind = "SELECT lat, lon FROM zip_codes WHERE zip_code ='$zip'";
	$resultCoordFind = mysql_query($sqlCoordFind) or die ('died trying to get zip for this coord. error:'.mysql_error());
	$dLongitude = null;
	$dLatitude = null;
	while($row = mysql_fetch_assoc($resultCoordFind)) {
		$dLongitude = $row['lon'];
		if($debug) {
			echo "zip longitude is $dLongitude <br />";
		}
		return $dLongitude;
	}
}

function getResellerLat($id=null) {
	global $debug;

	$sql = "SELECT lat FROM resellers WHERE id = '$id';";
	$results = mysql_query($sql) or die('died trying to get reseller lat. error: '.mysql_error());
	while ($row = mysql_fetch_assoc($results)) {
		$resellerLat = $row['lat'];
		if($debug) {
			echo "reseller latitude: $resellerLat <br />";
		}
		return $resellerLat;
	}
}

function getResellerLong($id=null) {
	global $debug;

	$sql = "SELECT lon FROM resellers WHERE id = '$id';";
	$results = mysql_query($sql) or die('died trying to get reseller lat. error: '.mysql_error());
	while ($row = mysql_fetch_assoc($results)) {
		$resellerLong = $row['lon'];
		if($debug) {
			echo "reseller logitude: $resellerLong <br />";
		}
		return $resellerLong;
	}
}


/*
 * return a list of resellers that are close to the input zip
 */
//function resellersCloseToZip($dRadius=null, $zip=null, $resellers=null) {
function resellersCloseToZip($dRadius=null, $zip=null, $product=null, $elite=false) {
	global $debug;

	//	if (!isset($dRadius) || !isset($zip) || !isset($resellers)) {
	if (!isset($dRadius) || !isset($zip) || !isset($product)) {
		if ($debug) {
			echo "<br />someone tried to pass an empty var to resellersCloseToZip()<br />";
		}
		return false;
	}

	//get the input zips lat and long
	$dLatitude = getZipsLat($zip);
	$dLongitude = getZipsLong($zip);

	$oGC = new GeoCalc();
	$dAddLat = $oGC->getLatPerKm() * $dRadius;
	$dAddLon = $oGC->getLonPerKmAtLat($dLatitude) * $dRadius;

	//calculate the search range around the input zip's lat/lon
	$dNorthBounds = $dLatitude + $dAddLat;
	$dSouthBounds = $dLatitude - $dAddLat;
	$dEastBounds = $dLongitude + $dAddLon;
	$dWestBounds = $dLongitude - $dAddLon;

	if ($debug) {
		echo "northbounds: $dNorthBounds<br/>";
		echo "southbounds: $dSouthBounds<br/>";
		echo "eastbounds: $dEastBounds<br/>";
		echo "westbounds: $dWestBounds<br/>";
	}


	// grab all resellers that fall within this geodesic range
	$sqlResellerLocations = "Select `resellers`.id, `resellers`.company FROM `resellers` ";
	
	if ($product != 'all') {
		$sqlResellerLocations .= "JOIN `reseller_products` ON `resellers`.id = `reseller_products`.reseller_id ";
	}
	
	$sqlResellerLocations .= "WHERE lat > '".$dSouthBounds."'"
	." AND lat < '".$dNorthBounds."'"
	." AND lon > '".$dWestBounds."'"
	." AND lon < '".$dEastBounds."'";
	if (!$elite) {
		$sqlResellerLocations .= " AND elite = '0'";
	} else {
		$sqlResellerLocations .= " AND elite = '1'";
	}
	if ($product != "all") {
		$sqlResellerLocations .= " AND `reseller_products`.product_id = '".$product."'";
	}

	//$sqlResellerLocations .= " LIMIT 0, 4";

	$sqlResellerLocations .= " AND  `resellers`.country_id = '247'";
		
	$rResellerLocations = mysql_query($sqlResellerLocations) or die('died trying to get listing of US resellers. <br /> sql: '.$sqlResellerLocations.' <br /> error:'.mysql_error());
	if ($debug) {
		echo "sql: ".$sqlResellerLocations;
		echo "<br />Resellers found for this area: ".mysql_num_rows($rResellerLocations)."<br />";
	}
	while($row = mysql_fetch_assoc($rResellerLocations)) {

		if ($debug) {
			echo "reseller: ".$row['id']." company: ".$row['company']."<br />";
		}

		//add to accessible resellers list
		$resellers[] = $row['id'];
	}
	if (isset($resellers)) {
		return $resellers;
	}
}

/*
 * $zip - users input zip
 * $resellers - array of reseller objects
 */
function sortResellersByDistance($zip, $resellers) {
	global $debug;
	if(empty($zip) || !isset($zip)) {
		if ($debug){
			echo "<br />no zip code provided";
		}
		return false;
	}
	if(empty($resellers)) {
		if($debug) {
			echo "<br />no resellers were provided";
		}
		return false;
	}
	
	$rSorted = array();
	if ($debug) {
		echo "Init sorting resellers by distance: <br />calculating distances...<br />";
		var_dump($resellers);
		echo "<br />";
	}
	

		
	// process through all indexes of the $resellers array
	foreach($resellers as $reseller) {
		//calculate the distance between the home zip and this resellers zip
		$userZiplat = getZipsLat($zip);
		$userZipLong = getZipsLong($zip);

		$resellersLat = getResellerLat($reseller);
		$resellersLong = getResellerLong($reseller);

		$oGC = new GeoCalc();
		$distance = $oGC->EllipsoidDistance($userZiplat, $userZipLong, $resellersLat, $resellersLong);

		//add that distance to the array
		$rSorted[$reseller] = $distance;
	}

	if ($debug) {
		echo "new array: <br />";
		print_r($rSorted);
		echo "<br />";
	}

	//sort the resellers by distance and return the sorted array
	asort($rSorted); //keep key index references (where we're storing the reseller id records from the resellers table)

	if ($debug) {
		echo "<br />sorted list: <br />";
		print_r($rSorted);
		echo "<br />";
	}

	$resellers = array(); //reset the resellers array
	foreach($rSorted as $r=>$distance) {
		$resellers[] = $r;
	}

	if($debug) {
		echo "<br />resellers array before being returned: <br/>";
		print_r($resellers);
		echo "<br />";
	}

	return $resellers;
}