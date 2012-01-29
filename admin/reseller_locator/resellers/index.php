<?php
/*
 * reseller_list.php
 *
 *	called by the ../index.php
 * admin: list resellers
 */
require ('../inc.php');

if ($GLOBALS['debug']) {
	var_dump($_POST);
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Resellers: admin</title>
<link href="/admin/reseller_locator/css/newtek_nav.css" rel="stylesheet" type="text/css" />
<link href="/admin/reseller_locator/css/tri_subnav.css" rel="stylesheet" type="text/css" />

<link href="/admin/reseller_locator/css/tricaster_main.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="/admin/reseller_locator/js/p7popmenu.js"></script>
<script type="text/javascript" src="/admin/reseller_locator/js/bodyload.js"></script>
<script type="text/javascript" src="/admin/reseller_locator/js/AC_OETags.js"></script>
<!-- SHADOWTBOX -->
<script type="text/javascript" src="/admin/reseller_locator/js/jquery.js"></script>
<script type="text/javascript" src="/admin/reseller_locator/js/shadowbox-base.js"></script>
<script type="text/javascript" src="/admin/reseller_locator/js/shadowbox.js"></script>

<link href="../css/resellers.css" media="screen" rel="Stylesheet" type="text/css"/>

</head>
<body>


<div id="all">
<div class="space"></div>
<div id="head">
<div id="header_content"><a href="http://www.newtek.com"><img
	src="/admin/reseller_locator/images/newtek_logo.jpg" alt="NewTek Home" width="545"
	height="102" border="0" /></a></div>
</div><!-- end #head -->


<div id="newtek_nav"><?php require_once($_SERVER['DOCUMENT_ROOT'].'/admin/inklood/nav2.php'); // not available from the provided zip ?></div>

<!-- END FLASH --> <!-- ---------------------------------------------------------------- -->

<div id="content">


<!--<div id="nav">-->
<!--	<ul>-->
<!--		<li><a href="../products/index.php">products</a></li>-->
<!--		<li><a href="../territories/index.php">territories</a></li>-->
<!--	</ul>-->
<!---->
<!--</div>-->
<br />
Resellers: <!--- <a href="add_reseller.php">add reseller</a>-->

<form action="" method="POST">
<div id="searchFilter">
Search by:<br />
	<div class="label">Reseller Name:</div>
	<div class="formInput">
		<input type="text" name="searchName"></input>
	</div>
	<br />
	<br />
	
	<div class="label">(and/or) Territory: </div>
	<div class="formInput">
		<select name="searchTerritory">
			<option value="0"></option>
			<?php
			$sqlGetTerritories = "SELECT id, name FROM territories ORDER BY name";
			$resultsTerritory = mysql_query($sqlGetTerritories) or die('died getting territories: '.mysql_error());
			while($territory = mysql_fetch_object($resultsTerritory)) {
				?>
				<option value="
					<?php echo $territory->id; ?>
				">
					<?php echo $territory->name; ?>
				</option>
				<?php
			}
			?>
		</select>
	</div>
	<div class="submit">
		<input type="submit" value="Search" name="submit"/>
	</div>
</div>

</form>

<?php

//function searchTerritorySubmitted() {
//	if(isset($_POST['searchTerritory']) && $_POST['searchTerritory'] != 0) {
//		return true;
//	}
//	return false;
//}

$sqlGetResellers = "SELECT `resellers`.id, `resellers`.company, `resellers`.createdby, `resellers`.created, `resellers`.modifiedby, `resellers`.modified FROM resellers";

if(isset($_POST['searchTerritory']) && $_POST['searchTerritory'] != 0) {
	$sqlGetResellers .= " JOIN reseller_territories on `resellers`.id = `reseller_territories`.reseller_id";
}

if(isset($_POST['searchName']) && $_POST['searchName'] != "") {
	$sqlGetResellers .= " WHERE company like '%".addslashes($_POST['searchName'])."%'";
}
if(isset($_POST['searchTerritory']) && $_POST['searchTerritory'] != 0) {
	$sqlGetResellers .= " AND `reseller_territories`.territory_id = '".$_POST['searchTerritory']."'";
}

$sqlGetResellers .= " ORDER BY company";

$results = mysql_query($sqlGetResellers) or die('died trying to get listing of resellers.  <br />sql:'.$sqlGetResellers.' <br />error: '.mysql_error());

?>

<table id="mytable" cellspacing="0" summary="Admin product management interface">
	<tr>
		<th scope="col" abbr="">Reseller</th>
		<th scope="col" abbr=""></th> <!-- edit -->
		<th scope="col" abbr=""></th> <!-- delete -->
		<th scope="col" abbr="">Created By</th>
		<th scope="col" abbr="">Created</th>
		<th scope="col" abbr="">Last Modified By</th>
		<th scope="col" abbr="">Modified</th>
	</tr>

<?php
while ($row = mysql_fetch_assoc($results)) {
	?>
	
	<tr>
		<td class="leftCol"><?php echo $row['company'];?></td>
		<td><a href="edit_reseller.php?id=<?php echo $row['id'];?>">edit</a></td>
		<td><a href="delete_reseller.php?id=<?php echo $row['id'];?>">delete</a></td>
		<td><?php
		if (!empty($row['createdby'])) {
			echo $row['createdby'];
		} else {
			echo "&nbsp;";
		}
			?></td>
		<td><?php echo $row['created']?></td>
		<td><?php
		if (!empty($row['modifiedby'])) {
			echo $row['modifiedby'];
		} else {
			echo "&nbsp;";
		}
		?></td>
		<td><?php echo $row['modified']?></td>
	</tr>
	<?php
}
?>

</table>


</div><!-- end #content -->
<div id="leftNav">
	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/admin/reseller_locator/subnav.php'); ?>
</div>
<!-- ---------------------------------------------------------------- -->

<div class="clear"></div>

<div id="footer"><?php require_once($_SERVER['DOCUMENT_ROOT'].'/inc/footer.php'); ?>
</div>
</div>
<!-- end #all -->

</body>
</html>
