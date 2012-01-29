<?php

/*
 * public_catalog.php
 *
 * list all authorized catalog resellers
 */

//require($_SERVER['DOCUMENT_ROOT'].'/admin/reseller_locator/inc.php');
		
		//configure connection to db
		$server = "jerome.newtek.com";			// Your mySQL Server
		$db_user = "resellers2";				// Your mySQL Username
		$db_pass = "vz35tyU";					// Your mySQL Password
		$db = "resellers2";				// Database Name
		
		$dbconnect=mysql_connect($server, $db_user, $db_pass) or die ("Database CONNECT Error");
		mysql_select_db($db, $dbconnect);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<script type="text/javascript" src="/admin/reseller_locator/js/jquery.1.3.2.js"></script>

<link href="../css/newtek_main.css" rel="stylesheet" type="text/css" />
<link href="../p7epm/epm50/p7EPM50.css" rel="stylesheet" type="text/css" media="all" />
<script src="../p7epm/p7EPMscripts.js" type="text/javascript"></script>
<script src="../js/p7uberlink.js" type="text/javascript"></script>
<link href="../p7epm/epm50/p7EPM50.css" rel="stylesheet" type="text/css" media="all" />

<script>
	$(document).ready( function() {
		$('#resellerSubNavigationMenuListings').load('/admin/reseller_locator/resellerSubNav.php');
	});
</script>

</head>


<body id="body" onload="P7_Uberlink('uberlink','subnav_list')">

<div class="space"> <a name="top"></a></div>

<div id="all">

<div id="head">

<div id="header_content"><a href="http://www.newtek.com"><img src="../images/newtek_logo.jpg" alt="NewTek Home" width="545" height="102" border="0" /></a></div>

</div>
<!-- end #head -->

  <div id="newtek_nav">
    <?php require_once('../inc/main_menu.php'); ?>
  </div>


<!-- START RIGHT_COL -->
  <div id="right_col">
    <div class="pagetitle_resellers">RESELLERS</div>
    <div id="pagenav">
       
    	<!-- reseller navigation items -->
    	<div id="resellerSubNavigationMenuListings"></div>
    </div>
    <div class="hr"> </div>
    <div class="clear"> </div>
     <?php require_once('../inc/right_col.php'); ?>
  </div>
  <!-- END RIGHT COL -->




<div class="eventbox">

<div class="heading_style">Authorized Catalog Resellers</div>

<div class="hr"></div>
<!--<div style="float:right;"><i>*note: Resellers are not listed in any particular order.</i></div>-->



<?php

$sqlGetCatalogResellers = "SELECT `resellers`.id, `resellers`.company, `resellers`.address, `resellers`.city, `states`.state, `resellers`.zip, `resellers`.phone, `resellers`.fax, `resellers`.website "
	."FROM `resellers` JOIN `states` ON `resellers`.state = `states`.id "
	."WHERE catalog = '1' "
	."ORDER BY `resellers`.company ASC";
$resultCatalogResellers = mysql_query($sqlGetCatalogResellers) or die('died getting catalog resellers: '.mysql_error());
while($row = mysql_fetch_assoc($resultCatalogResellers)) {
	?>
	
    
      <div class="reseller_box">
    <div class="reseller">
			<div class="subtitle_bold"><?php echo $row['company'];?></div><br />
			
			<?php
			if(isset($row['address']) && isset($row['city']) && isset($row['state']) && $row['zip']) {
				?>
				<?php echo $row['address'];?> <br />
				<?php echo $row['city'];?>, <?php echo $row['state'];?> <?php echo $row['zip'];?>
				<br />
				<?php
			}
			?>
			
			<?php
			if (isset($row['phone'])) {
				?>
				Phone:  <?php echo $row['phone'];?><br />
				<?php
			}
			?>
			
			<?php
			if(isset($row['fax']) && !empty($row['fax'])) {
				?>
				Fax:
				<?php echo $row['fax'];?><br />
				<?php
			}
			?>
			<br>

			<?php
			if(isset($row['website'])) {
				?>
				<a href="<?php echo $row['website'];?>"><?php echo $row['website'];?></a><br />
				<?php
			}
			?>
	</div>
    </div>
    
    
      <div align="right" style="margin-bottom:-15px;margin-top:10px;"><a href="#top"><img src="../images/top.jpg" alt="top" width="54" height="25" border="0" /></a></div>
    <div class="hr"></div>
    
    
    
	<?php
}
?>

</div><!-- end #content -->

<div class="clear"> </div>
  <!-- START FOOT LINKS -->
  <div id="footbox">
    <?php include('../inc/footlinks.php'); ?>
  </div>
  <!-- END FOOT LINKS -->
  <div class="clear"></div>
  <!-- START FOOTER -->
  <div id="footer">
    <?php include('../inc/footer.php'); ?>
    </div>
</div>
<!-- end #all -->

<?php include('../inc/google_analytics.php')?>

</body>
</html>