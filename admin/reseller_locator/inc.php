<?php

//set debug flags
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
//set_time_limit(3); //give the save 5 seconds to go through.. (should be plenty of time..)
global $debug;
$debug = false;

if ($_SERVER["SERVER_NAME"] == "newtek.com" || $_SERVER["SERVER_NAME"] == "www.newtek.com")
{
	// checks for login (don't do this if developing locally)
	if (!isset($_COOKIE['nadmin']) || empty($_COOKIE['nadmin'])) {
		echo "<meta http-equiv=\"refresh\" content=\"0;URL=http://www.newtek.com/admin/index.php?error=1\">";
	} else {
		global $cookie;
		$cookie = $_COOKIE['nadmin'];
	}

	//configure connection to db
	$server = "jerome.newtek.com";			// Your mySQL Server
	$db_user = "resellers2";				// Your mySQL Username
	$db_pass = "vz35tyU";					// Your mySQL Password
	$db = "resellers2";				// Database Name
	
	$dbconnect=mysql_connect($server, $db_user, $db_pass) or die ("Database CONNECT Error");
	mysql_select_db($db, $dbconnect);
} else {
	
	$cookie = 'dev';
	
	//configure connection to db
	$server = "localhost";			// Your mySQL Server
	$db_user = "root";				// Your mySQL Username
	$db_pass = "bamalam@";					// Your mySQL Password
	//$db_pass = "";					// Your mySQL Password
	$db = "resellers2";				// Database Name
	
	$dbconnect=mysql_connect($server, $db_user, $db_pass) or die ("Database CONNECT Error");
	mysql_select_db($db, $dbconnect);
}

//bring in all classes
//require('resellers.php');
require('GeoCalc.class.php');

//bring in all helper functions
require('resellers/locate_reseller.php');

//include the products class
require('products/product.php');

require('resellers/reseller.php');

require('files.php');

/*********************************/
// generic functions
/*********************************/
function curPageURL() {
	return baseWebAddress().$_SERVER["REQUEST_URI"];
}

function baseWebAddress() {
	$baseURL = 'http';
	if(!empty($_SERVER["HTTPS"])){
		if ($_SERVER["HTTPS"] == "on") {$baseURL .= "s";}
	}
	$baseURL .= "://".$_SERVER["SERVER_NAME"];
	if ($_SERVER["SERVER_PORT"] != "80") {
		$baseURL .= ":".$_SERVER["SERVER_PORT"];
	}
	return $baseURL;
}

function resellerLocatorBaseWebAddress() {
	return baseWebAddress().'/admin/reseller_locator';
}
