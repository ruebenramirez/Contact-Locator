<?php
/*
 * reseller_checkbox_products.php
 * output a listing of html form checkboxes to be displayed in US or International add/edit reseller forms
 *
 */


// check for a $_REQUEST['reseller_id']
// if has a reseller_id, then need to populate the checkboxes with the ones that the reseller is already using

//check for validation issue
// if the form submitted but failed validation, then we need to repopulate the checkboxes checking the ones that were checked in the last submission

?>