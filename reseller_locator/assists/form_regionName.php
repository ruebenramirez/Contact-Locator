<?php
/*
 * form_regionName.php
 */

//require($_SERVER['DOCUMENT_ROOT'].'/admin/reseller_locator/inc.php');

//configure connection to db
		$server = "jerome.newtek.com";			// Your mySQL Server
		$db_user = "resellers2";				// Your mySQL Username
		$db_pass = "vz35tyU";					// Your mySQL Password
		$db = "resellers2";				// Database Name
		
		$dbconnect=mysql_connect($server, $db_user, $db_pass) or die ("Database CONNECT Error");
		mysql_select_db($db, $dbconnect);

if(isset($_REQUEST['regionid']) && !empty($_REQUEST['regionid'])){
	$regionId = $_REQUEST['regionid'];
	
	$sqlGetRegionInfo = "SELECT name FROM regions WHERE id = '".$regionId."'";
	$resultRegionInfo = mysql_query($sqlGetRegionInfo) or die('died getting region info: '.mysql_error());
	while($rowRegionInfo = mysql_fetch_object($resultRegionInfo)) {
		echo $rowRegionInfo->name;
	}
}

?>