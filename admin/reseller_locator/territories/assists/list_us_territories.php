<?php
/*
 * us_territories.php
 * list all US territories (per state)
 * 	and all resellers covering those states.
 *
 * resellers should be assigned to (states/territories) that they can operate within.
 */

require('../../inc.php');

$sql = "SELECT id, name FROM territories WHERE us = '1' ORDER BY name;";
$results = mysql_query($sql) or die('died trying to get territories: '.mysql_error());
while($row = mysql_fetch_assoc($results)) {
	?>
	
	<div class="territory_listing">
		<div class="territory_name"><?php echo $row['name'];?></div>
		<div class="territory_edit"><a href="edit_territory.php?id=<?php echo $row['id'];?>">edit</a></div>
		<div class="territory_delete"><a href="delete_territory.php?id=<?php echo $row['id'];?>">delete</a></div>
		
		<?php
		$sqlResellerCount = "SELECT COUNT(id) FROM reseller_territories WHERE territory_id='".$row['id']."'";
		$resultResellerCount = mysql_query($sqlResellerCount) or die('died getting reseller count: '.mysql_error());
		while ($resellerCount = mysql_fetch_assoc($resultResellerCount)) {
			?>
			<?php //var_dump($resellerCount);?>
			<div class="column"><?php echo $resellerCount["COUNT(id)"]; ?> resellers</div>
			<?php
		}
		$sqlTerritoryCount = "SELECT COUNT(id) FROM territory_regions WHERE territory_id='".$row['id']."'";
		$resultTerritoryCount = mysql_query($sqlTerritoryCount) or die('died getting territory count: '.mysql_error());
		while ($territoryCount = mysql_fetch_assoc($resultTerritoryCount)) {
			?>
			<div class="column"><?php echo $territoryCount['COUNT(id)']; ?> regions</div>
			<?php
		}
		?>
	</div>
	
	<?php
}
?>
