<?php
/*
 * international_city_ddl.php
 * get the country id and pull a list of cities to populate a cities ddl_ for selected country
 */


require('../inc.php');

if(isset($_REQUEST['country_id']) && !empty($_REQUEST['country_id'])) {
	outputDDLCities($_REQUEST['country_id']);
}

function outputDDLCities($countryCode=null) {
	
	global $server, $db_user, $db_pass, $db;
	$dbconnectother=mysql_connect($server, $db_user, $db_pass) or die ("Database CONNECT Error");
	mysql_select_db('international_cities_rrr', $dbconnectother);
				
				
	$sql="SELECT id, name FROM `$countryCode` ORDER BY name;";
	$results = mysql_query($sql) or die('died trying to get cities for this country: <br />sql: '.$sql.'<br />error:'.mysql_error());
	
	if (mysql_num_rows($results) > 0) {
	?>
		<select name="city">
		<?php
		while($city = mysql_fetch_assoc($results)) {
		?>
			<option value="<?php echo $city['id'];?>"><?php echo $city['name'];?></option>
		<?php
		}
		?>
		</select>
	
	<?php
	} else {
	?>
		<input name="city" type="text"></input>
	<?php
	}
}