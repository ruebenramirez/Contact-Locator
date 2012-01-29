<?php
/**
 * resellerNav.php
 *
 *
 * !!!!!!!!THIS PAGE IS USED ON RESELLER PAGES!  MODIFY CAREFULLY!!!!!!!!!
 *
 *
 * output html list of dynamic regions + static links to us reseller locator and the catalog resellers
 */

//require('inc.php');
//configure connection to db
	$server = "jerome.newtek.com";			// Your mySQL Server
	$db_user = "resellers2";				// Your mySQL Username
	$db_pass = "vz35tyU";					// Your mySQL Password
	$db = "resellers2";				// Database Name
	
	$dbconnect=mysql_connect($server, $db_user, $db_pass) or die ("Database CONNECT Error");
	mysql_select_db($db, $dbconnect);

?>

<ul id="subnav_list" class="regionsDropDownList">
	
	<li>
		<a href="/us_resellers.php">US Resellers</a>
	</li>
	

	<?php
		$sqlGetRegions = "SELECT `regions`.id, `regions`.name FROM `regions` ORDER BY `regions`.name ASC";
		$resultRegions = mysql_query($sqlGetRegions) or die('died getting regions: '.mysql_error());
		while($region = mysql_fetch_object($resultRegions)) {
			echo '
			<li>
				<!--<a href="/admin/reseller_locator/public/public_find_int_resellers.php?regionid='.$region->id.'">'.$region->name.'</a>-->
				<a href="/reseller_locator/int_resellers.php?regionid='.$region->id.'">'.$region->name.'</a>
			</li>';
		}
	?>

	<li>
		<!--<a href="/admin/reseller_locator/public/public_catalog.php">Catalog Resellers</a>-->
		<a href="/catalog_resellers.php">Catalog Resellers</a>
	</li>
	<li>
		<a href="http://www.newtek.com/resellers/index.php">Resellers Only</a>
	</li>
	<li>
		<a href="http://www.newtek.com/reseller_locator/varapp/index.php">Become a Reseller</a>
	</li>
</ul>
