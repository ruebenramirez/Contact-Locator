<?php
/*
 * product.php
 * class definition for products
 */

class Product {
	var $id;
	var $name;
//	var $logo;
	var $website;
	var $nValid_message;
	var $saved;

	function Product($id=null) {
		$this->id = $id;
		$this->name = null;
//		$this->logo = null;
		$this->website = null;
		$this->nValid_message = array();
		$this->saved = null;


		if (!isset($id)) { //handle add product
			if(!empty($_POST)) {
				$this->validatePostsandPopulateObject();
			}
		} else { //handle product edits
			if (empty($_POST)) {
				$this->populateFromID();
			} else {
				$this->validatePostsandPopulateObject();
			}
		}

	}

	/*
	 * populate products object with
	 */
	function populateFromID() {
		$sql ="SELECT name, logo, website FROM products WHERE id = '$this->id';";
		$result = mysql_query($sql) or die('died trying to get the product name: '.mysql_error());
		while($product = mysql_fetch_assoc($result)) {
			$this->name = $product['name'];
			$this->logo = $product['logo'];
			$this->website = $product['website'];
		}
	}

	function validatePostsandPopulateObject() {
		if($GLOBALS['debug']) {
			echo "validating posted values. <br />";
		}
		
		if (!$this->isFieldValid('name')) {
			$this->nValid_message['name'] = '<div class="validation_error">Please input a product name</div>';
		} else {
			$this->name = $_POST['name'];
		}
		
		if (!$this->isFieldValid('website')) {
			$this->nValid_message['website'] = '<div class="validation_error">Please input the product website</div>';
		} else {
			$this->website = $_POST['website'];
		}
		
//		if((isset($_POST['rb_keep_old_logo']) && $_POST['rb_keep_old_logo'] == 1) //1 means upload a new file..
//		|| (!isset($_POST['rb_keep_old_logo']))) { //or there wasn't a radio button option available (like on the add form)
//			if ($_FILES['logo']['tmp_name'] == ""){ //bad upload
//				$this->nValid_message['logo'] = '<div class="validation_error">Select a file for the logo image.</div>';
//				if ($GLOBALS['debug']) {
//					echo '<br />fullimg file not uploaded';
//				}
//			}
//		}
		
		if($GLOBALS['debug']) {
			echo "Finished validating posted values. <br />";
		}
	}

	function isFieldValid($fieldname) {
		//handle all text based inputs
		if (!isset($_POST[$fieldname])
			|| (isset($_POST[$fieldname]) && empty($_POST[$fieldname]) && $_POST[$fieldname] != 0)
			|| isset($_POST[$fieldname]) && $_POST[$fieldname] == '') {
			if($GLOBALS['debug']) {
				echo '<br/>field '.$fieldname.' didn\'t pass validation';
			}
			return false;
		}
		return true;
	}

	function saveProduct() {
		$this->saved = false;
		while(empty($this->nValid_message) && !$this->saved) {
			$sqlCheckProductExists = "SELECT id FROM products WHERE name = '".$this->name."'";
			$resultProductExists = mysql_query($sqlCheckProductExists) or die('died checking if product exists: '.mysql_error());
			if (mysql_num_rows($resultProductExists) < 1) {
				$sqlAddProduct = "INSERT INTO products (name, website) VALUES('".$this->name."', '".$this->website."')";
				mysql_query($sqlAddProduct) or die('died adding new product: '.mysql_error());
				
//				$this->id = mysql_insert_id();
//
//				$this->saveProductFiles();
				
				$this->saved = true;
				header('location: index.php');
			} else {
				$this->nValid_message['name'] = '<div class="validation_error">This name is already used for another product</div>';
				break;
			}
		}
	}

	function updateProduct() {
		$this->saved = false;

		while(empty($this->nValid_message) && !$this->saved) { //use break if set error message
			//construct the edit product query
			$sql = "UPDATE products SET name = '".$this->name."', website = '".$this->website."' WHERE id = '".$this->id."'";
			mysql_query($sql) or die('died updating product name: '.mysql_error());
			
//			$this->saveProductFiles();

			$this->saved = true; //to exit the save loop
			header('Location: index.php');
		}
	}

//	function saveProductFiles() {
//		//$_FILES['fullimg']
//		if(!isset($_POST['rb_keep_old_logo']) || isset($_POST['rb_keep_old_logo']) && $_POST['rb_keep_old_logo'] == 1) {
//			//first delete the old file
//			$oldFile = null;
//			$sql = "SELECT logo FROM products WHERE id = '".$this->id."';";
//			$results = mysql_query($sql) or die('Looking up old fullimg_filename to delete it: error in sql: '.$sql);
//			while($row = mysql_fetch_assoc($results)) {
//				$oldFile = $row['logo'];
//			}
//			deleteFile($oldFile);
//
//			if($GLOBALS['debug']) {
//				echo "<br />just deleted old logo file: ".$oldFile;
//			}
//
//			//then save the new one...
//			$this->logo = saveFile('logo');
//			if($GLOBALS['debug']) {
//				echo "<br />just saved new logo file: ".$this->logo;
//			}
//
//			$sqlUpdateProductLogo = "UPDATE products SET logo = '".$this->logo."' WHERE id = '".$this->id."'";
//			mysql_query($sqlUpdateProductLogo) or die('died updating product logo: '.mysql_error());
//		} else {
//			if($GLOBALS['debug']) {
//				echo "Keeping the old file <br/>";
//			}
//		}
//	}
}
