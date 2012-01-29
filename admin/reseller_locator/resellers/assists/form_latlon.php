<?php

/*
 * latlon_form.php
 * output form elements for lat/lon html form input field
 */

$lat = $lon = null;
if(isset($_REQUEST['lat'])) {
	$lat = $_REQUEST['lat'];
}
if(isset($_REQUEST['lon'])) {
	$lon = $_REQUEST['lon'];
}


if (isset($_REQUEST['us']) && $_REQUEST['us'] == 1) {
	printForUS($lat, $lon);
} else {
	printForInt();
}

function printForUS($lat=null, $lon=null) {
	if (isset($myReseller->nValid_message['latlong'])) {
		echo $myReseller->nValid_message['latlong'];
	}
	?>
	<div class="label">Latitude:</div>
	<div class="formInput">
		<input id="lat" name="lat" type="text" value="
		<?php
		if(isset($lat)) {
			echo $lat;
		}
		?>
		"></input>
	</div>
	
	<div class="label">Longitude:</div>
	<div class="formInput">
		<input id="lon" name="lon" type="text" value="
		<?php
		if (isset($lon)) {
			echo $lon;
		}
		?>
		"></input>
	</div>
	<div class="column">
		<a id="geocodeLinkButton" href="">Geocode</a>
	</div>
	<br />
	<br />
	<br />
	<br />
	<?php
}

function printForInt() {
	?>
	<input name="lat" type="hidden" value="-1"></input>
	<input name="lon" type="hidden" value="-1"></input>
	<?php
}