<?php
/*
 * delete_reseller.php
 */
require('../inc.php');

//var_dump($_POST);

if(isset($_REQUEST['id'])) {
	$reseller_id = $_REQUEST['id'];
} else {
	header('location: index.php');
}
$myReseller = new Reseller($reseller_id, true);

if(isset($_POST['submitted'])) {
	if (isset($_POST['confirm']) && $_POST['confirm'] == "1") {
		//delete the reseller record information
		$myReseller->deleteReseller();
		header('location: index.php');
		
	}
	if (!isset($_POST['confirm'])) {
		//tell user that they have to check the box to confirm the reseller delete action
		$confirmDeleteMessage = '<div class="validation_error">Must check the "confirm delete" checkbox to delete this reseller.</div>';
	}
}
	?>
	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Delete reseller</title>
	<script type="text/javascript" src="/admin/reseller_locator/js/jquery.1.3.2.js"></script>
	
	<link href="/admin/reseller_locator/css/newtek_nav.css" rel="stylesheet" type="text/css" />
	<link href="/admin/reseller_locator/css/tri_subnav.css" rel="stylesheet" type="text/css" />
	
	<link href="/admin/reseller_locator/css/tricaster_main.css" rel="stylesheet" type="text/css" />
	
	<script type="text/javascript" src="/admin/reseller_locator/js/p7popmenu.js"></script>
	<script type="text/javascript" src="/admin/reseller_locator/js/bodyload.js"></script>
	<script type="text/javascript" src="/admin/reseller_locator/js/AC_OETags.js"></script>
	<!-- SHADOWTBOX -->
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
<!--		<li><a href="index.php">resellers</a></li>-->
<!--		<li><a href="../products/index.php">products</a></li>-->
<!--		<li><a href="../territories/index.php">territories</a></li>-->
<!--	</ul>-->
<!--</div>-->


Are you sure you want to delete this reseller? <br />
<br />
<div class="column">Reseller: </div>
<div class="column"><?php echo $myReseller->company; ?></div>
<div class="column"><?php echo $myReseller->contact; ?></div>
<br />

<?php
if(isset($confirmDeleteMessage)) {
	echo $confirmDeleteMessage;
}
?>

<form method="POST" action="">
	<div class="column">
		<input name="confirm" type="checkbox" value="1" /> Confirm delete..
	</div>
	<br />
	<br />
	<input name="submitted" type="hidden" value="1"></input>
	<input name="id" type="hidden" value="<?php echo $myReseller->id; ?>"></input>
	<input name="submit" type="submit" value="Delete" /> | <a href="index.php">cancel</a>
</form>
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