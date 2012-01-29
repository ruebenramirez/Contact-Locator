<?php
/*
 * index.php
 * load the reseller admin area for now
 *
 * eventually this page will need to redirect people with different permissions to their landing pages
 *  - international distributors will only be able to add/edit/delete reseller and territory records
 *  - newtek internal sales department will be all purpose admins
 *  	* this means that they will be able to add/edit/delete distributors as well as territory and reseller records
 */

//require ('inc.php');

//require('resellers/reseller_list.php');
header('location: resellers/index.php');
?>