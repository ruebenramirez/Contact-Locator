<?php 

/*
 * gmaps_us.php
 * display resellers on map of the US
 */

require('../inc.php');

//google maps api key

if($_SERVER['SERVER_NAME'] == 'localhost') {
	$googleMapsAPIKey = "ABQIAAAAvT84jNxObRYfTQMwBDy3kxT2yXp_ZAY8_ufC3CFXhHIE1NvwkxQqhJOkx_lhw9wfemCJpxQ1KCH6rQ";
} elseif($_SERVER['SERVER_NAME'] == 'sandbox.newtek.com') {
	$googleMapsAPIKey = "ABQIAAAAvT84jNxObRYfTQMwBDy3kxShoMkSDHUHFaXguhbBYfM-2jXzxhSYahZvkG6p0_C5iBCknCLKVBqp6Q";
} elseif($_SERVER['SERVER_NAME'] == 'newtek.com') {
	$googleMapsAPIKey = "ABQIAAAAvT84jNxObRYfTQMwBDy3kxQQpexNEi5mhwtx9-XpPolcUInXsBQt84XL8jveI81itZEXIoiFBecmaQ";
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <title>Google Maps JavaScript API Example: Simple Markers</title>
    <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=<?php echo $googleMapsAPIKey;?>"
            type="text/javascript"></script>
    <script type="text/javascript">

	function createMarker(point, html) {
		var marker = new GMarker(point);
		GEvent.addListener(marker, "click", function(){
			marker.openInfoWindowHtml(html);
		});
		return marker;
	}
    
	function initialize() {
		if (GBrowserIsCompatible()) {
			var map = new GMap2(document.getElementById("map_canvas"));
			map.setCenter(new GLatLng(37.78,-98.98), 5);
			map.addControl(new GLargeMapControl());
	        map.addControl(new GOverviewMapControl());
	        map.enableDoubleClickZoom();
	        map.enableScrollWheelZoom();

			var bounds = map.getBounds();
			
			<?php 
				$sqlGetUSResellers = "SELECT * FROM `resellers` 
					WHERE country_id = 247 AND `resellers`.lat != 'NULL' AND `resellers`.lon != 'NULL'
					ORDER BY company ASC;";
				$resultUSResellers = mysql_query($sqlGetUSResellers) or die('died getting US resellers: '.mysql_error());
				
				while($reseller = mysql_fetch_object($resultUSResellers)) {
					echo 'var marker = createMarker(new GLatLng('.$reseller->lat.', '.$reseller->lon.'), '
					.'"<a href=\"'.$reseller->website.'\">'.$reseller->company.'</a>'
					.' <br /> '.$reseller->contact
					.' <br /> '.$reseller->email
					.' <br /> '.$reseller->phone
					.' <br /><br /> '.$reseller->address
					.' <br /> '.$reseller->city.'");';
					echo "\n";
					echo 'map.addOverlay(marker);';
					echo "\n";
				}
			?>
		}
	}

    </script>
  </head>

  <body onload="initialize()" onunload="GUnload()">
    <div id="map_canvas" style="width: 1400px; height: 800px"></div>
  </body>
</html>

