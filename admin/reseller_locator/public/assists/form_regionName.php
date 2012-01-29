<?php
/*
 * form_regionName.php
 */

require('../../inc.php');

if(isset($_REQUEST['regionid']) && !empty($_REQUEST['regionid'])){
	$regionId = $_REQUEST['regionid'];
	
	$sqlGetRegionInfo = "SELECT name FROM regions WHERE id = '".$regionId."'";
	$resultRegionInfo = mysql_query($sqlGetRegionInfo) or die('died getting region info: '.mysql_error());
	while($rowRegionInfo = mysql_fetch_object($resultRegionInfo)) {
		echo $rowRegionInfo->name;
	}
}

?>