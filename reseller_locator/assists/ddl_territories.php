<?php
/*
 * ddl_territories.php
 *
 * return a select html element full of territories for a passed region id
 */

//require($_SERVER['DOCUMENT_ROOT'].'/admin/reseller_locator/inc.php');

//configure connection to db
		$server = "jerome.newtek.com";			// Your mySQL Server
		$db_user = "resellers2";				// Your mySQL Username
		$db_pass = "vz35tyU";					// Your mySQL Password
		$db = "resellers2";				// Database Name
		
		$dbconnect=mysql_connect($server, $db_user, $db_pass) or die ("Database CONNECT Error");
		mysql_select_db($db, $dbconnect);

if (isset($_REQUEST['region']) && !empty($_REQUEST['region'])) {
	printddlTerritories($_REQUEST['region']);
}

function printddlTerritories($region_id) {
	$sqlGetTerritories = "SELECT territory_id, name "
		."FROM `territory_regions` JOIN `territories` "
		."ON `territory_regions`.territory_id = `territories`.id "
		."WHERE region_id ='".$region_id."' "
		."ORDER BY `territories`.name ASC";
	$resultTerritories = mysql_query($sqlGetTerritories) or die('died getting territories for a region: '.mysql_error());
//	if(myslq_num_rows($resultTerritories) > 0) {
	?>
		<div class="label">Territory: </div>
		<div class="formInput">
			<select id="territory" name="territory">
				<option value="">-Select Territory-</option>
				<?php
				
				while($territory = mysql_fetch_object($resultTerritories)) {
					echo '<option value="'.$territory->territory_id.'">'.$territory->name.'</option>';
				}
			?>
			</select>
		</div>
	<?php
//	}
}

?>