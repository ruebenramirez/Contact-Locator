<?php
/*
 * add_reseller.php
 *
 */
require('../inc.php');

//end testing...

/*
 * if we get to this point we've...
 *  -not posted any form data
 *  -failed to save (possibly due to failed validation attempt)
 */

if ($GLOBALS['debug']) {
	var_dump($_POST);
}

$myReseller = new Reseller();
if (isset($_POST) && !empty($_POST)) {
	$myReseller->saveReseller();
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Add reseller</title>
<script type="text/javascript" src="/admin/reseller_locator/js/jquery.1.3.2.js"></script>

<link href="/admin/reseller_locator/css/newtek_nav.css" rel="stylesheet" type="text/css" />
<link href="/admin/reseller_locator/css/tri_subnav.css" rel="stylesheet" type="text/css" />

<link href="/admin/reseller_locator/css/tricaster_main.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="/admin/reseller_locator/js/p7popmenu.js"></script>
<script type="text/javascript" src="/admin/reseller_locator/js/bodyload.js"></script>
<script type="text/javascript" src="/admin/reseller_locator/js/AC_OETags.js"></script>
<!-- SHADOWTBOX -->
<!--<script type="text/javascript" src="/admin/reseller_locator/js/jquery.js"></script>-->
<script type="text/javascript" src="/admin/reseller_locator/js/shadowbox-base.js"></script>
<script type="text/javascript" src="/admin/reseller_locator/js/shadowbox.js"></script>

<link href="../css/resellers.css" media="screen" rel="Stylesheet" type="text/css"/>
<script type="text/javascript">

	function geocodeHandler() {
		$('#geocodeLinkButton').die();
		$('#geocodeLinkButton').live('click', function() {
			//alert('GeoCode button was clicked');
			var zipCode = $('#zip').val().trim();
			if (zipCode == "") {
				alert('Please input a Zip code.');
			} else {
				$.ajax({
                    type: "POST",
                    url: 'assists/us_geocode.php',
                    cache:false,
                    data: {zip: zipCode},
                    dataType:'json',
                    success: function(json){
						var errorCode = json.errorCode;
						if (errorCode == null) {
							var lat = json.lat;
							$('#lat').val(lat);
							
							var lon = json.lon;
							$('#lon').val(lon);
						} else {
							alert(errorCode);
						}
					}// end success function
				//return false;
				});// end ajax call
			}
			return false;
		});
	}

	function bindRemoveTerritoryButtons() {
		//remove territory click handler
		$('.removeTerritoryLink').bind('click', function(event) {
			$(this).parent().remove();
			return false;
		});
	}

	// update form because the location has changed
	function formLocationUpdate() {
		var reseller_location = $('input:radio[name=rb_location]:checked').val();
		if (reseller_location == 'int') {
			//populate international form input fields
			$('#eliteformInputField').load('assists/form_elite.php', {us: 0 <?php $myReseller->printjQueryElite(); ?> });
			$('#catalogformInputField').load('assists/form_catalog.php', {us: 0 <?php $myReseller->printjQueryCatalog(); ?> });
			$('#distributorformInputField').load('assists/form_distributor.php', {us: 0 <?php $myReseller->printjQueryDistributor(); ?> });
			$('#specialistDealerInputField').load('assists/form_specialistDealer.php', {us: 0 <?php $myReseller->printjQuerySpecialistDealer(); ?> });
			$('#countryFormFields').load('assists/form_countries.php', {us: 0 <?php $myReseller->printjQueryCountry(); ?>});
			$('#stateInputField').load('assists/form_states.php', {us: 0 <?php $myReseller->printjQueryState(); ?>}, function() {
				var stateValue = $('#state').val();
				$('#state').val($.trim(stateValue));
			});
			
			$('#zipInputField').load('assists/form_zip.php', {us: 0});
				
			$('#latlonInputField').load('assists/form_latlon.php', {us: 0}, function(event) {
				geocodeHandler();
			});
			// update territories ddl
			$("#form_territories").load('assists/territories_form.php', {us: 0 <?php $myReseller->printjQueryTerritories(); ?> }, function() {
				bindRemoveTerritoryButtons();
			});
		} else {
			//populate us form input fields
			$('#eliteformInputField').load('assists/form_elite.php', {us: 1 <?php $myReseller->printjQueryElite(); ?> });
			$('#catalogformInputField').load('assists/form_catalog.php', {us: 1 <?php $myReseller->printjQueryCatalog(); ?> });
			$('#distributorformInputField').load('assists/form_distributor.php', {us: 1 <?php $myReseller->printjQueryDistributor(); ?> });
			$('#specialistDealerInputField').load('assists/form_specialistDealer.php', {us: 1 <?php $myReseller->printjQuerySpecialistDealer(); ?> });
			$('#countryFormFields').load('assists/form_countries.php', {us: 1});
			$('#stateInputField').load('assists/form_states.php', {us: 1 <?php $myReseller->printjQueryState(); ?>});
			$('#zipInputField').load('assists/form_zip.php', {us: 1}, function() {
				var zipValue = $("#zip").val();
				$("#zip").val($.trim(zipValue));
//				alert('just tried to trim the zip field.  Zip code text field contents: "'+ $("#zip").val()) + '"';
			});
			
			$('#latlonInputField').load('assists/form_latlon.php', {us: 1});

			// update territories ddl
			$("#form_territories").load('assists/territories_form.php', {us: 1 <?php $myReseller->printjQueryTerritories(); ?> }, function() {
				bindRemoveTerritoryButtons();
			});
		}

		// "add territory" click handler
		$('#add_additional_territory').unbind();
		$('#add_additional_territory').bind('click', function(event) {
			//alert('add additional territory was clicked');
			var reseller_location = $('input:radio[name=rb_location]:checked').val();
			if(reseller_location == 'int') {
				$.get('assists/territories_form.php', {us: 0}, function(data) {
					$("#form_territories").append(data);
					bindRemoveTerritoryButtons();
				});
			} else {
				$.get('assists/territories_form.php', {us: 1}, function(data) {
					$("#form_territories").append(data);
					bindRemoveTerritoryButtons();
				});
			}
			return false;
		});
	}
	
	function initRun() {
		formLocationUpdate();
		
		$('#checkbox_products').load('assists/form_list_products.php', {<?php $myReseller->printjQueryProducts(); ?>});
	}
	
	$(document).ready( function(){
		// This is the hack for IE  source: http://stackoverflow.com/questions/208471/getting-jquery-to-recognise-change-in-ie
		if ($.browser.msie) {
		  $("input:radio[name=rb_location]").click(function() {
			  this.blur();
			  this.focus();
		  });
		}
		
		initRun();

		// web resource: http://www.techiegyan.com/?p=112
		$("input:radio[name=rb_location]").bind('change', function (event) {
			this.focus();
			formLocationUpdate();
			return false;
		});

		initialize();
		
		$('#GoogleMapAddressCheck').bind('click', function(event) {
			showLocation();
			return false;
		});
	});

</script>

<!-- google maps includes -->

<!--
	Acquired all of these keys directly from the Google Maps API signup page (accepting their TOS)
	http://code.google.com/apis/maps/signup.html
	
	http://localhost google maps api key
	ABQIAAAAvT84jNxObRYfTQMwBDy3kxT2yXp_ZAY8_ufC3CFXhHIE1NvwkxQqhJOkx_lhw9wfemCJpxQ1KCH6rQ
	
	http://www.newtek.com domain google maps api key
	ABQIAAAAvT84jNxObRYfTQMwBDy3kxQ_dQLzk1oeIvgShATXnUl87ZiM3xRsnXeZC1aYHf5MxUWbqI3_4idvIw
	
	http://newtek.com domain google maps api key
	ABQIAAAAvT84jNxObRYfTQMwBDy3kxQQpexNEi5mhwtx9-XpPolcUInXsBQt84XL8jveI81itZEXIoiFBecmaQ
	
	http://sandbox.newtek.com google maps api key
	ABQIAAAAvT84jNxObRYfTQMwBDy3kxShoMkSDHUHFaXguhbBYfM-2jXzxhSYahZvkG6p0_C5iBCknCLKVBqp6Q
-->
<?php if ($_SERVER['SERVER_NAME'] == 'localhost') {
	$googleMapsAPIKey = "ABQIAAAAvT84jNxObRYfTQMwBDy3kxT2yXp_ZAY8_ufC3CFXhHIE1NvwkxQqhJOkx_lhw9wfemCJpxQ1KCH6rQ";
} else if ($_SERVER['SERVER_NAME'] == 'www.newtek.com') {
	$googleMapsAPIKey = "ABQIAAAAvT84jNxObRYfTQMwBDy3kxQ_dQLzk1oeIvgShATXnUl87ZiM3xRsnXeZC1aYHf5MxUWbqI3_4idvIw";
} else if ($_SERVER['SERVER_NAME'] == 'newtek.com') {
	$googleMapsAPIKey = "ABQIAAAAvT84jNxObRYfTQMwBDy3kxQQpexNEi5mhwtx9-XpPolcUInXsBQt84XL8jveI81itZEXIoiFBecmaQ";
} else if ($_SERVER['SERVER_NAME'] == 'sandbox.newtek.com') {
	$googleMapsAPIKey = "ABQIAAAAvT84jNxObRYfTQMwBDy3kxShoMkSDHUHFaXguhbBYfM-2jXzxhSYahZvkG6p0_C5iBCknCLKVBqp6Q";
}
?>
<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=true&amp;key=<?php echo $googleMapsAPIKey;?>" type="text/javascript"></script>
             
<script type="text/javascript">
	var map;
	var geocoder;
	
	function initialize() {
	  map = new GMap2(document.getElementById("map_canvas"));
	  map.setCenter(new GLatLng(34, 0), 17);
	  geocoder = new GClientGeocoder();
	}
	
	// addAddressToMap() is called when the geocoder returns an
	// answer.  It adds a marker to the map with an open info window
	// showing the nicely formatted version of the address and the country code.
	function addAddressToMap(response) {
		map.clearOverlays();
		if (!response || response.Status.code != 200) {
			alert("Please check the address you entered to make sure it's correct.");
		} else {
			place = response.Placemark[0];
			point = new GLatLng(place.Point.coordinates[1],
			place.Point.coordinates[0]);
			marker = new GMarker(point);
			map.addOverlay(marker);
			marker.openInfoWindowHtml(place.address + '<br>' +
	  			'<b>Country code:</b> ' + place.AddressDetails.Country.CountryNameCode);
		}
	}
	
	// showLocation() is called when you click on the Search button
	// in the form.  It geocodes the address entered into the form
	// and adds a marker to the map at that location.
	function showLocation() {
		var address;
		var reseller_location = $('input:radio[name=rb_location]:checked').val();
		if (reseller_location == 'int') {
			// International
			address = $('#address').val() + " " + $('#city').val() + " " + $('#state').val() + " " + $("#country_select_input option:selected").text();
		} else {
			// US
			address = $('#address').val() + " " + $('#city').val() + " " + $('#state option:selected').text() + " " + $('#zip').val();
		}

//		alert('this is the entered information: \nreseller_location: ' + reseller_location + '\naddress: ' + $('#address').val() +
//			'\ncity: ' + $('#city').val() + '\nstate ' + $('#state').val() + '\nzip: ' + $('#zip').val() + '\ncountry: ' + $("#country_select_input option:selected").text());
		
		geocoder.getLocations(address, addAddressToMap);
	}
</script>

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
<!--<ul>-->
<!--	<li><a href="index.php">resellers</a></li>-->
<!--	<li><a href="../products/index.php">products</a></li>-->
<!--	<li><a href="../territories/index.php">territories</a></li>-->
<!--</ul>-->
<!--</div>-->

Add a reseller:
<br />
<br />
<form method="POST" action="">
	Reseller location: <br />
	<input name="rb_location" type="radio" value="us" <?php if (isset($_POST['rb_location']) && $_POST['rb_location'] == "us"){ echo 'checked="checked"';} ?>></input> US
	<input name="rb_location" type="radio" value="int" <?php if(!isset($_POST['rb_location']) || isset($_POST['rb_location']) && $_POST['rb_location'] != 'us'){ echo 'checked="checked"';} ?>></input> International<br />
	<br />
	<?php
	if (!empty($myReseller->nValid_message['company'])) {
		echo $myReseller->nValid_message['company'];
	}
	?>
	<div class="label">Company:</div>
	<div class="formInput"><input name="company" type="text" value="<?php if (isset($myReseller->company)) echo $myReseller->company;?>"></input></div>
	<br />
	<br />
	
	<div id="eliteformInputField"></div>
	<div id="catalogformInputField"></div>
	<div id="specialistDealerInputField"></div>
	<div id="distributorformInputField"></div>
	
	<div class="label">Territories:</div>
	<div class="formInput">
		<div id="form_territories"></div>
		<br />
		<a id="add_additional_territory" href="">+ add another territory</a>
	</div>
	<br />
	<br />
	<br />
	<br />
	<?php
	if (isset($myReseller->nValid_message['website'])) {
		echo $myReseller->nValid_message['website'];
	}
	?>
	<div class="label">Website:</div>
	<div class="formInput"><input name="website" type="text" value="<?php if(isset($myReseller->website)){echo $myReseller->website;}else{echo "http://";}?>"></input></div>
	<br />
	<br />
	
	
	<!-- primary contact for the reseller -->
	<?php
	if (isset($myReseller->nValid_message['contact'])) {
		echo $myReseller->nValid_message['contact'];
	}
	?>
	<div class="label">Contact:</div>
	<div class="formInput"><input name="contact" type="text" value="<?php if(isset($myReseller->contact))echo $myReseller->contact;?>"></input></div>
	<br />
	<br />
	
	<?php
	if (isset($myReseller->nValid_message['phone'])) {
		echo $myReseller->nValid_message['phone'];
	}
	?>
	<div class="label">Phone:</div>
	<div class="formInput"><input name="phone" type="text" value="<?php if(isset($myReseller->phone)) echo $myReseller->phone;?>"></input></div>
	<br />
	<br />
	
	<?php
	if (isset($myReseller->nValid_message['email'])) {
		echo $myReseller->nValid_message['email'];
	}
	?>
	<div class="label">Email:</div>
	<div class="formInput"><input name="email" type="text" value="<?php if(isset($myReseller->email)) echo $myReseller->email;?>"></input></div>
	<br />
	<br />
	
	<?php
	if(isset($myReseller->nValid_message['fax'])) {
		echo $myReseller->nValid_message['fax'];
	}
	?>
	<div class="label">Fax:</div>
	<div class="formInput"><input name="fax" type="text" value="<?php if(isset($myReseller->fax)) echo $myReseller->fax;?>"></input></div>
	<br />
	<br />
	<br />
	
	<!-- another contact for the reseller -->
	<div class="label">Contact2:</div>
	<div class="formInput"><input name="contact2" type="text" value="<?php if(isset($myReseller->contact2)) echo $myReseller->contact2;?>"></input></div>
	<br />
	<br />
	
	<div class="label">Phone2:</div>
	<div class="formInput"><input name="phone2" type="text" value="<?php if(isset($myReseller->phone2)) echo $myReseller->phone2;?>"></input></div>
	<br />
	<br />
	
	<div class="label">Email2:</div>
	<div class="formInput"><input name="email2" type="text" value="<?php if(isset($myReseller->email2)) echo $myReseller->email2;?>"></input></div>
	<br />
	<br />
	<br />
	
	Reseller location information:<br />
	
	<?php
	if (isset($myReseller->nValid_message['country'])) {
		echo $myReseller->nValid_message['country'];
	}
	?>
	<div id="countryFormFields"></div>
	
	<?php
	if(isset($myReseller->nValid_message['address'])) {
		echo $myReseller->nValid_message['address'];
	}
	?>
	<div class="label">Street address:</div>
	<div class="formInput"><input id="address" name="address" type="text" value="<?php if (isset($myReseller->address)) echo $myReseller->address;?>"></input></div>
	<br />
	<br />
	
	<?php
	if(isset($myReseller->nValid_message['city'])) {
		echo $myReseller->nValid_message['city'];
	}
	?>
	<div class="label">City:</div>
	<div class="formInput">
		<input id="city" name="city" type="text" value="<?php if (isset($myReseller->city)) echo $myReseller->city;?>"></input>
	</div>
	<br />
	<br />
	
	<?php
	if (isset($myReseller->nValid_message['state'])) {
		echo $myReseller->nValid_message['state'];
	}
	?>
	<div id="stateInputField"></div>
	
	<?php
	if (isset($myReseller->nValid_message['zip'])) {
		echo $myReseller->nValid_message['zip'];
	}
	?>
	<div id="zipInputField"></div>
	
	<?php
	if (isset($myReseller->nValid_message['latlon'])) {
		echo $myReseller->nValid_message['latlon'];
	}
	?>
	<div id="latlonInputField"></div>
	
	
	
	
	<!-- Google Map Display -->
	<a id="GoogleMapAddressCheck" href="#">Check entered address</a><br />
	<div id="map_canvas" style="width: 500px; height: 300px"></div>
	
	
	
	
	<?php
	if(isset($myReseller->nValid_message['products'])) {
		echo $myReseller->nValid_message['products'];
	}
	?>
	<div class="label">Products:</div>
	<!-- populate a list of checkboxes for all products -->
	<div class="formInput">
		<div id="checkbox_products"></div>
	</div><br />
	<br />
	
	<input name="createdby" type="hidden" value="<?php echo $GLOBALS['cookie'];?>"></input>
	<input name="modify" type="hidden" value="1" />
	<div class="submit">
		<input type="submit" value="Save reseller" /> | <a href="index.php">cancel</a>
	</div>
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