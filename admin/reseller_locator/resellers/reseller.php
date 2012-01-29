<?php
/*
 * resellers.php
 * resellers class
 */


Class Reseller {
	var $company;
	var $elite;
	var $distributor;
	var $specialistDealer;
	var $catalog;
	var $website;
	var $contact;
	var $email;
	var $phone;
	var $contact2;
	var $email2;
	var $phone2;
	var $fax;
	var $address;
	var $city;
	var $state;
	var $zip;
	var $lat;
	var $lon;
	var $country;
	var $products;
	var $territories;
	var $nValid_message;
	var $saved;
	var $createdby; //using custom NewTek admin user authentication to grab the user name that is adding/editing this reseller record...

	function Reseller($id=null, $grabInfoOnly=null) {
		if ($GLOBALS['debug']) {
			echo "Reseller constructor was called <br />";
		}
		$this->id = $id;
		$this->company = null;
		$this->elite = null;
		$this->distributor = null;
		$this->specialistDealer = null;
		$this->catalog = null;
		$this->website = null;
		$this->contact = null;
		$this->email = null;
		$this->phone = null;
		$this->contact2 = null;
		$this->email2 = null;
		$this->phone2 = null;
		$this->fax = null;
		$this->address = null;
		$this->city = null;
		$this->state = null;
		$this->zip = null;
		$this->lat = null;
		$this->lon = null;
		$this->country = null;
		$this->products = array();
		$this->territories = array();
		$this->nValid_message = array();
		$this->saved = null;
		$this->createdby = null;
		

		if (!isset($id)) { //handle add reseller
			if(isset($_POST['modify'])) { //handle the edit form submission
				$this->validatePostsAndPopulateObject();
			}
		} else { //handle reseller edits
			if (!isset($_POST['modify'])) { // edit form needs to be populated
				$this->populateFromID();
			} else { //save the edit form submission
				$this->validatePostsAndPopulateObject();
			}
		}
	}

	/*
	 * don't have access to filter functions to apply field specific validation filters
	 */
	function validatePostsAndPopulateObject() {
		if (isset($_POST['rb_location']) && $_POST['rb_location'] == 'us') {
			//validate us reseller submission
			if (isset($_POST['elite']) && $_POST['elite'] != 0) {
				$this->elite = 1;
			} else {
				$this->elite = 0;
			}

			if (!$this->isFieldValid('state')) {
				$this->nValid_message['state'] = '<div class="validation_error">Input a state</div>';
			} else {
				$this->state = addslashes($_POST['state']);
			}
			
			//state is mandatory in US
			if (!$this->isFieldValid('zip')) {
				$this->nValid_message['zip'] = '<div class="validation_error">Input a zip</div>';
			} else {
				$this->zip = addslashes($_POST['zip']);
			}

			//lat long validation
			if (!$this->isFieldValid('lat') || !$this->isFieldValid('lon')) {
				$this->nValid_message['latlon'] = '<div class="validation_error">Need to geocode</div>';
			} else {
				$this->lat = addslashes($_POST['lat']);
				$this->lon = addslashes($_POST['lon']);
			}

		} else {
			//validate specific international reseller fields submitted
				
			if (isset($_POST['distributor']) && $_POST['distributor'] != 0) {
				$this->distributor = 1;
			} else {
				$this->distributor = 0;
			}
			
			if (isset($_POST['specialistDealer']) && $_POST['specialistDealer'] != 0) {
				$this->specialistDealer = 1;
			} else {
				$this->specialistDealer = 0;
			}
			
			//state is optional in International
			if ($this->isFieldValid('state')) {
				$this->state = addslashes($_POST['state']);
			}

		}

		//validation generic reseller submission fields

		if (!$this->isFieldValid('company')) {
			$this->nValid_message['company'] = '<div class="validation_error">Input a company name</div>';
		} else {
			$this->company = addslashes($_POST['company']);
		}
		
		if (isset($_POST['catalog']) && $_POST['catalog'] != 0) {
				$this->catalog = 1;
			} else {
				$this->catalog = 0;
			}

		if (!$this->isFieldValid('website')) {
			$this->nValid_message['website'] = '<div class="validation_error">Input a web url for the company\'s website</div>';
		} else {
			$this->website = addslashes($_POST['website']);
		}

		if (!$this->isFieldValid('contact')) {
			$this->nValid_message['contact'] = '<div class="validation_error">Input a contact name</div>';
		} else {
			$this->contact = addslashes($_POST['contact']);
		}

		if (!$this->isFieldValid('email')) {
			$this->nValid_message['email'] = '<div class="validation_error">Input an email address</div>';
		} else {
			$this->email = addslashes($_POST['email']);
		}

		if (!$this->isFieldValid('phone')) {
			$this->nValid_message['phone'] = '<div class="validation_error">Input a phone number</div>';
		} else {
			$this->phone = addslashes($_POST['phone']);
		}
		//		if (!$this->isFieldValid('contact2')) {
		//			$this->nValid_message['contact2'] = '<div class="validation_error"></div>';
		//		}

		if(isset($_POST['contact2'])) {
			$this->contact2 = addslashes($_POST['contact2']);
		}

		//		if (!$this->isFieldValid('email2')) {
		//			$this->nValid_message['email2'] = '<div class="validation_error"></div>';
		//		}
		if(isset($_POST['email2'])) {
			$this->email2 = addslashes($_POST['email2']);
		}

		//		if (!$this->isFieldValid('phone2')) {
		//			$this->nValid_message['phone2'] = '<div class="validation_error"></div>';
		//		}
		if(isset($_POST['phone2'])) {
			$this->phone2 = addslashes($_POST['phone2']);
		}

		if (isset($_POST['fax'])) {
			$this->fax = addslashes($_POST['fax']);
		}

		if (!$this->isFieldValid('address')) {
			$this->nValid_message['address'] = '<div class="validation_error">Input a street address</div>';
		} else  {
			$this->address = addslashes($_POST['address']);
		}

		if (!$this->isFieldValid('city')) {
			$this->nValid_message['city'] = '<div class="validation_error">Input a city</div>';
		} else {
			$this->city = addslashes($_POST['city']);
		}

		if (!$this->isFieldValid('products')) {
			$this->nValid_message['products'] = '<div class="validation_error">Select some products</div>';
		} else {
			$this->products = $_POST['products'];
		}

		if(isset($_POST['territories'])) {
			$this->territories = $_POST['territories'];
		}

		if (!$this->isFieldValid('country')) {
			$this->nValid_message['country'] = '<div class="validation_error">Select a country</div>';
		} else {
			$this->country = addslashes($_POST['country']);
		}

		if (isset($_POST['createdby']) && $_POST['createdby']) {
			$this->createdby = $_POST['createdby'];
		}

		if (empty($this->nValid_message)) {
			return true;
		}
		return false;
	}

	function isFieldValid($fieldname) {
		//handle all text based inputs
		if (!isset($_POST[$fieldname])
		|| (isset($_POST[$fieldname]) && empty($_POST[$fieldname])) //&& $_POST[$fieldname] != -1) //-1 means ddl element was unused
		|| (isset($_POST[$fieldname]) && $_POST[$fieldname] == '')
		|| (isset($_POST[$fieldname]) && $_POST[$fieldname] == 'http://')) {
			if($GLOBALS['debug']) {
				echo '<br/>field '.$fieldname.' didn\'t pass validation:
					<br />field value: '.$_POST[$fieldname].'<br />';
			}
			return false;
		}
		return true;
	}

	function populateFromID() {
		$sqlGetReseller = "SELECT * FROM resellers WHERE id = '".$this->id."';";
		$resultReseller = mysql_query($sqlGetReseller) or die('died getting reseller: '.mysql_error());
		while($reseller = mysql_fetch_assoc($resultReseller)) {
			$this->company = $reseller['company'];
			$this->elite = $reseller['elite'];
			$this->website = $reseller['website'];
			$this->contact = $reseller['contact'];
			$this->email = $reseller['email'];
			$this->phone = $reseller['phone'];
			$this->contact2 = $reseller['contact2'];
			$this->email2 = $reseller['email2'];
			$this->phone2 = $reseller['phone2'];
			$this->fax = $reseller['fax'];
			$this->address = $reseller['address'];
			$this->city = $reseller['city'];
			$this->state = $reseller['state'];
			$this->zip = $reseller['zip'];
			$this->country = $reseller['country_id'];
			$this->lat = $reseller['lat'];
			$this->lon = $reseller['lon'];
			$this->catalog = $reseller['catalog'];
			$this->distributor = $reseller['distributor'];
			$this->specialistDealer = $reseller['specialistDealer'];

			if ($GLOBALS['debug']) {
				echo "Reseller populated with: ";
				var_dump($this);
				echo "<br />";
			}

		}

		//get products
		$sqlGetProducts = "SELECT product_id FROM reseller_products WHERE reseller_id = '".$this->id."';";
		$resultProducts = mysql_query($sqlGetProducts) or die('died getting products: '.mysql_error());
		while($products = mysql_fetch_assoc($resultProducts)) {
			$this->products[] = $products['product_id'];
		}
		//get territories
		$sqlGetTerritories = "SELECT `reseller_territories`.territory_id "
		."FROM `reseller_territories` "
		."JOIN `territories` ON `reseller_territories`.territory_id = `territories`.id "
		."WHERE reseller_id = '".$this->id."' "
		."ORDER BY `territories`.name ASC";
		$resultTerritories = mysql_query($sqlGetTerritories) or die('died getting territories: '.mysql_error());
		while($territories = mysql_fetch_assoc($resultTerritories)) {
			$this->territories[] = $territories['territory_id'];
		}


		if($GLOBALS['debug']) {
			echo "populated from id in the database: <br />";
			var_dump($this);
		}
	}

	/*
	 * save new reseller with this reseller objects values
	 */
	function saveReseller() {
		$this->saved = false;
		while(empty($this->nValid_message) && $this->saved != true) {
			$sqlSaveReseller = "INSERT INTO resellers (company, elite, website, contact, email, phone, fax, address, city, state, zip, country_id, created, modified";
			if(isset($this->createdby) && !empty($this->createdby)) {
				$sqlSaveReseller.= ", createdby, modifiedby";
			}
				
			if (isset($this->contact2)) {
				$sqlSaveReseller .= ", contact2";
			}
			if (isset($this->email2)) {
				$sqlSaveReseller .= ", email2";
			}
			if(isset($this->phone2)) {
				$sqlSaveReseller .= ", phone2";
			}
			if(isset($this->catalog)) {
				$sqlSaveReseller .= ", catalog";
			}
			if(isset($this->distributor)) {
				$sqlSaveReseller .= ", distributor";
			}
			if(isset($this->specialistDealer)) {
				$sqlSaveReseller .= ", specialistDealer";
			}
			$sqlSaveReseller.= ") VALUES('".$this->company."', '".$this->elite."', '"
			.$this->website."', '".$this->contact."', '".$this->email."', '".$this->phone."', '"
			.$this->fax."', '".$this->address."', '".$this->city."', '".$this->state."', '"
			.$this->zip."', '".$this->country."', NOW(), NOW()";

			if(isset($this->createdby) && !empty($this->createdby)) {
				$sqlSaveReseller .= ", '".$this->createdby."', '".$this->createdby."'"; //save created by and modified by
			}

			if (isset($this->contact2)) {
				$sqlSaveReseller .= ", '".$this->contact2."'";
			}
			if (isset($this->email2)) {
				$sqlSaveReseller .= ", '".$this->email2."'";
			}
			if(isset($this->phone2)) {
				$sqlSaveReseller .= ", '".$this->phone2."'";
			}
			if(isset($this->catalog)) {
				$sqlSaveReseller .= ", '".$this->catalog."'";
			}
			if(isset($this->distributor)) {
				$sqlSaveReseller .= ", '".$this->distributor."'";
			}
			if(isset($this->specialistDealer)) {
				$sqlSaveReseller .= ", '".$this->specialistDealer."'";
			}
			$sqlSaveReseller.= ");";

			if($GLOBALS['debug']) {
				echo 'Saving new reseller with sql: '.$sqlSaveReseller.'<br />';
			}
			//save the reseller
			mysql_query($sqlSaveReseller) or die('died saving new reseller: '.mysql_error().'<br /> sql: '.$sqlSaveReseller);
			$this->id = mysql_insert_id();

			$this->saveTerritories();
			$this->saveProducts();
			//redirect the user to the list screen with "reseller saved" message
			header('location: index.php?message=newSaved');
			$this->saved = true; //no infinite loops in debug mode
		}
	}

	/*
	 * modify an existing reseller in the database with this reseller object's values
	 */
	function editReseller() {
		if (isset($this->id)) {
			$this->saved = false;
			while(empty($this->nValid_message) && $this->saved != true) {
				$sqlUpdateReseller = "UPDATE resellers SET company = '".$this->company
				."', elite = '".$this->elite."', website = '".$this->website
				."', contact = '".$this->contact."', email = '".$this->email
				."', phone = '".$this->phone."', fax = '".$this->fax."', modified=NOW(), country_id = '".$this->country
				."', address = '".$this->address."', city = '".$this->city
				."', state = '".$this->state."', zip= '".$this->zip
				."', lat = '".$this->lat."', lon = '".$this->lon."'";
				if (isset($this->createdby) && !empty($this->createdby)) {
					$sqlUpdateReseller .= ", modifiedby = '".$this->createdby."'"; // update the last modified by record..

				}
				if ($GLOBALS['debug']) {
					echo "<br />cookie: ".$this->createdby,"<br />";
				}

				if (isset($this->contact2)) {
					$sqlUpdateReseller .= ", contact2 = '".$this->contact2."'";
				}
				if (isset($this->email2)) {
					$sqlUpdateReseller .= ", email2 = '".$this->email2."'";
				}
				if(isset($this->phone2)) {
					$sqlUpdateReseller .= ", phone2 = '".$this->phone2."'";
				}
				if(isset($this->catalog)) {
					$sqlUpdateReseller .= ", catalog = '".$this->catalog."'";
				}
				if(isset($this->distributor)) {
					$sqlUpdateReseller .= ", distributor = '".$this->distributor."'";
				}
				if(isset($this->specialistDealer)) {
					$sqlUpdateReseller .= ", specialistDealer = '".$this->specialistDealer."'";
				}

				$sqlUpdateReseller .= " WHERE id = '".$this->id."';";

				if($GLOBALS['debug']) {
					echo "sql update reseller: <br />".$sqlUpdateReseller."<br />";
				}
				mysql_query($sqlUpdateReseller) or die('died updating reseller: '.mysql_error().'<br />sql: '.$sqlUpdateReseller);

				$this->removeExistingTerritories();
				$this->saveTerritories();
				$this->removeExistingProducts();
				$this->saveProducts();

				header('location: index.php?message=editsaved&reseller_id='.$this->id);
				$this->saved = true; //no infinite loops in debug mode
			}
		}
	}

	function deleteReseller() {
		if(isset($this->id)) {
			$sqlDeleteReseller = "DELETE FROM resellers WHERE id='".$this->id."';";
			mysql_query($sqlDeleteReseller) or die('died deleteting reseller: '.mysql_error());

			$this->removeExistingTerritories();
			$this->removeExistingProducts();
		}
	}

	function removeExistingProducts() {
		$sql = "DELETE FROM reseller_products WHERE reseller_id = '".$this->id."';";
		mysql_query($sql) or die('died removing products: '.mysql_error());
	}

	function saveProducts() {
		if ($this->products != null) {
			$sqlAddResellersProducts = null;
			//save this reseller's products
			foreach($this->products as $product_id) {
				$sqlAddResellersProducts = " INSERT INTO reseller_products (reseller_id, product_id) VALUES('".$this->id."', '".$product_id."');";
				mysql_query($sqlAddResellersProducts) or die('died adding reseller\'s products: '.mysql_error().' <br />sql: '.$sqlAddResellersProducts.'<br />');
				if ($GLOBALS['debug']) {
					echo "saved reseller product with sql: ".$sqlAddResellersProducts."<br />";
				}
			}
		}
	}

	function removeExistingTerritories() {
		//clear out the old territories
		$sqlClearTerritories = "DELETE FROM reseller_territories WHERE reseller_id = '".$this->id."';";
		mysql_query($sqlClearTerritories) or die('died clearing out old territories: '.mysql_error());
	}

	function saveTerritories() {
		if ($this->territories != null) {
			$sqlAddResellersTerritories = null;
			//save this reseller's territories
			foreach($this->territories as $territory_id) {
				if ($territory_id != -1 && $territory_id != 0) { //if territory was selected from the ddl html element
					$sqlRemoveDuplicates = "DELETE FROM reseller_territories WHERE reseller_id = '".$this->id."' AND territory_id = '".$territory_id."'";
					mysql_query($sqlRemoveDuplicates) or die('died removing duplicate territories: '.mysql_error().' <br />sql: '.$sqlRemoveDuplicates);
						
					$sqlAddResellersTerritories = "INSERT INTO reseller_territories (reseller_id, territory_id) VALUES('".$this->id."', '".$territory_id."');";
					mysql_query($sqlAddResellersTerritories) or die('died adding reseller\'s territories: '.mysql_error());
				}
				if($GLOBALS['debug']) {
					echo "saved new resellers territory with sql: ".$sqlAddResellersTerritories."<br />";
				}
			}
		}
	}

	// HELPERfunctionS (for javascript,jQuery, or HTML)

	function printjQueryElite() {
		if (isset($this->elite)) {
			if($this->elite != 0) {
				echo ', elite: 1';
			}
		}
	}

	function printjQueryDistributor() {
		if (isset($this->distributor)) {
			if($this->distributor != 0) {
				echo ', distributor: 1';
			}
		}
	}

	function printjQueryCatalog() {
		if (isset($this->catalog)) {
			if($this->catalog != 0) {
				echo ', catalog: 1';
			}
		}
	}

	function printjQuerySpecialistDealer() {
		if (isset($this->specialistDealer)) {
			if($this->specialistDealer != 0) {
				echo ', specialistDealer: 1';
			}
		}
	}

	function printjQueryState() {
		if (isset($this->state)) {
			echo ", state: '".$this->state."'";
		}
		if (isset($this->country)) {
			$sql = "SELECT id FROM countries WHERE short_name='US'";
			$result = mysql_query($sql) or die('died getting us id: '.mysql_error());
			while($row = mysql_fetch_assoc($result)) {
				$usid = $row['id'];
			}
			if (isset($usid)) {
				if ($usid == $this->country) {
					echo ", us_reseller: '1'";
				}
			}
		}
	}

	function printjQueryCountry() {
		if (isset($this->country)) {
			echo ", country: '".$this->country."'";
		}
	}

	function printjQueryTerritories() {
		if (isset($this->territories)) {
			echo ", 'territories[]': [";
			for($i = 0; $i < count($this->territories); $i++) {
				if ($i != count($this->territories)-1) { //output all except for last territory
					echo $this->territories[$i].', ';
				} else { //output the last territory
					echo $this->territories[$i];
				}
			}
			echo "]";
		}
	}

	//print out the products array to pass the required active products to be checked when pulling via Ajax...
	function printjQueryProducts() {
		if (isset($this->products)) {
			echo "'products[]': [";
			for ($i = 0; $i<count($this->products);$i++) {
				if ($i != count($this->products)-1) {
					echo $this->products[$i].', ';
				} else {
					echo $this->products[$i]; //print out the last product in the array
				}
			}
			echo "]";
		}
	}

	function printjQueryZip() {
		if (isset($this->zip)) {
			echo ", zip: '".$this->zip."'";
		}
	}

	function printjQueryLatLon() {
		if(isset($this->lat) && isset($this->lon)) {
			echo ", lat: '".$this->lat."', lon: '".$this->lon."'";
		}
	}
}