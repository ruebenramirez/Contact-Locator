<?php
/*
 * international_cities_spread.php
 * Spread out the 'international_cities' table records to their own tables in an 'international_cities' database.
 */

require('../inc.php');

$countryList = new Countries();

mysql_select_db($db, $dbconnect);
$sqlCountries = "SELECT cc1 FROM international_cities GROUP BY cc1;";
$resultCountries = mysql_query($sqlCountries) or die('died trying to get countries out of the international_cities table of resellers_rrr: '.mysql_error());
while ($cityCountries = mysql_fetch_assoc($resultCountries)) {
	$countryList->addCountry($cityCountries['cc1']);
}

echo "creating tables to store all the city information in<br />";
//createTables
$countryList->createCountryTables();


echo "getting ready to fill the newly created tables <br />";
$countryList->fillTables();

class Countries {
	private $countries;
	private $server;			// Your mySQL Server
	private $db_user;				// Your mySQL Username
	private $db_pass;					// Your mySQL Password
	private $db;				// Database Name

	private $dbconnect;

	function __construct() {
		$this->countries = array();

		$this->server = "localhost";			// Your mySQL Server
		$this->db_user = "root";				// Your mySQL Username
		$this->db_pass = "bamalam@";					// Your mySQL Password
		$this->db = "international_cities_rrr";				// Database Name
	}

	function addCountry($countryCode=null) {
		if(empty($countryCode)) {
			die('no country code was passed');
		}
		$this->countries[] = $countryCode;
	}

	function createCountryTables() {
		//global $dbconnect;
		foreach ($this->countries as $country) {
			echo $country.'<br />';
			//mysql_close();

			$this->dbconnect=mysql_connect($this->server, $this->db_user, $this->db_pass) or die ("Database CONNECT Error");
			mysql_select_db($this->db, $this->dbconnect);

			$sqlCreateNewTable = "CREATE TABLE IF NOT EXISTS `$country` ( `id` int(11) NOT NULL AUTO_INCREMENT, `uni` int(11) DEFAULT NULL, `lat` double DEFAULT NULL, `long` double DEFAULT NULL, `cc1` varchar(5) CHARACTER SET latin1 DEFAULT NULL, `name` varchar(255) COLLATE utf8_bin DEFAULT NULL, `country_id` int(11) NOT NULL, PRIMARY KEY (`id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=6646803";
			mysql_query($sqlCreateNewTable, $this->dbconnect) or die('died trying to create new table: <br />sql: '.$sqlCreateNewTable.' <br />error: '.mysql_error());

		}
	}

	function fillTables() {
		global $server, $db_user, $db_pass, $db;

		foreach($this->countries as $country) {
//			if (strcmp($country, 'PE') >= 0) { //if the loop execution times out then we can clear out the last table operated on and start the import there with this...
				echo "getting ready to work on this country: $country <br />";
				$dbconnect=mysql_connect($server, $db_user, $db_pass) or die ("Database CONNECT Error");
				mysql_select_db($db, $dbconnect);

				$sqlCityData = "SELECT * FROM international_cities WHERE cc1 = '$country'";
				$resultCityData = mysql_query($sqlCityData, $dbconnect) or die('died trying to get country data. '.mysql_error());
				while($city = mysql_fetch_assoc($resultCityData)) {
					$this->dbconnect=mysql_connect($this->server, $this->db_user, $this->db_pass) or die ("Database CONNECT Error");
					mysql_select_db($this->db, $this->dbconnect);

					//only run this check if we really need to ensure doubles aren't there.  (takes waaay longer this way)
//					$sqlCheck = "SELECT * FROM `$country` WHERE uni = '".$city['uni']."';";
//					$checkResults = mysql_query($sqlCheck) or die('died checking for this city in this country already existing: '.mysql_error());
//					if (mysql_num_rows($checkResults) < 1) {
					$sqlImportCityData = "INSERT INTO `$country` (`uni`, `lat`, `long`, `cc1`, `name`, `country_id`) VALUES('"
					.$city['uni']."', '".$city['lat']."', '".addslashes($city['long'])."', '".addslashes($city['cc1'])."', '".addslashes($city['name'])."', '".$city['country_id']."')";
					mysql_query($sqlImportCityData) or die('died importing data from the large table into this country: <br />sql: '.$sqlImportCityData.'<br />'.mysql_error());
					//				}
				}
//			}
		}
	}

}

