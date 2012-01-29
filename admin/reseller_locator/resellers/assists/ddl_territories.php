<?php
/*
 * ddl_territories.php
 *
 * return a select html element full of territories for a passed region id
 */

require('../../inc.php');

if (isset($_REQUEST['region']) && !empty($_REQUEST['region'])) {
	printddlTerritories($_REQUEST['region']);
}

function printddlTerritories($region_id) {
	$sqlGetTerritories = "SELECT territory_id, name "
		."FROM `territory_regions` JOIN `territories` ON `territory_regions`.territory_id = `territories`.id "
		."WHERE region_id ='".$region_id."' "
		."ORDER BY `territories`.name";
	$resultTerritories = mysql_query($sqlGetTerritories) or die('died getting territories for a region: '.mysql_error());
//	if(myslq_num_rows($resultTerritories) > 0) {
	?>
		<div class="label">Territory: </div>
		<div class="formInput">
			<select id="territory" name="territory">
				<option value=""></option>
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