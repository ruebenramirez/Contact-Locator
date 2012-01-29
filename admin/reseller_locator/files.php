<?php
function set_filename($path, $filename, $file_ext, $encrypt_name = TRUE)
{
	if ($encrypt_name == TRUE)
	{
		mt_srand();
		$filename = md5(uniqid(mt_rand())).$file_ext;
	}

	if ( ! file_exists($path.$filename))
	{
		return $filename;
	}

	$filename = str_replace($file_ext, '', $filename);

	$new_filename = '';
	for ($i = 1; $i < 100; $i++)
	{
		if ( ! file_exists($path.$filename.$i.$file_ext))
		{
			$new_filename = $filename.$i.$file_ext;
			break;
		}
	}
	if ($new_filename == '')
	{
		return FALSE;
	}
	else
	{
		return $new_filename;
	}
}

//just resets the filename
function prep_filename($filename) {
	if (strpos($filename, '.') === FALSE) {
		return $filename;
	}
	$parts = explode('.', $filename);
	$ext = array_pop($parts);
	$filename    = array_shift($parts);
	foreach ($parts as $part) {
		$filename .= '.'.$part;
	}
	$filename .= '.'.$ext;
	return $filename;
}

function get_extension($filename) {
	$x = explode('.', $filename);
	return '.'.end($x);
}

function saveFile($postFileField) {
	//get location where file will be saved
	$path = getenv("DOCUMENT_ROOT").'/admin/reseller_locator/products/product_images/';

	$file_temp = $_FILES[$postFileField]['tmp_name'];
	$file_name = prep_filename($_FILES[$postFileField]['name']);
	$file_ext = get_extension($_FILES[$postFileField]['name']);
	$newf_name = set_filename($path, $file_name, $file_ext);
	$file_size = round($_FILES[$postFileField]['size']/1024, 2);
	$targetFile =  str_replace('//','/',$path) . $newf_name;

	//save the file
	move_uploaded_file($file_temp,$targetFile);
	if ($GLOBALS['debug']) {
		echo 'file '.$file_name.' was saved.';
	}
	//save file permissions
	chmod($targetFile, 0777);
	//return $file_name; //to be saved in the db
	return $newf_name; //to be saved in the db
}

function fileURL($filename) {
	$fileURL = getServerURL().'/admin/reseller_locator/products/product_images/'.$filename;;

	//	if($GLOBALS['debug']) {
	//		echo 'file\'s full path on the webserver: ' . $fileURL;
	//	}
	return $fileURL;
}

function getServerURL() {
	$url = 'http';
	if(!empty($_SERVER["HTTPS"])){
		if ($_SERVER["HTTPS"] == "on") {$url .= "s";}
	}
	$url .= "://";
	if ($_SERVER["SERVER_PORT"] != "80") {
		$url .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"];
	} else {
		$url .= $_SERVER["SERVER_NAME"];
	}
	return $url;
}

function deleteFile($file=null) {
	if(isset($file)) {
		$filePath = $_SERVER['DOCUMENT_ROOT'].'/admin/reseller_locator/products/product_images/'.$file;
		if($GLOBALS['debug']) {
			echo '<br />Trying to delete file: '.$filePath;
		}
		//check to make sure not more than 1 product is using the same file...
		$sql = "SELECT id FROM products WHERE logo = '".$file."';";
		$result = mysql_query($sql) or die('died trying to find multiple products using the same logo.  sql: '.$sql.' error: '.mysql_error());
		if(mysql_num_rows($result) < 2) {
			//check to make sure the file exists on the file system
			if (!is_dir($filePath) && file_exists($filePath)) {
				unlink($filePath);
			}
			if ($GLOBALS['debug']) {
				echo "<br />Just deleted '".$filePath."' with extreme prejudice.";
			}
		} else {
			if($GLOBALS['debug']) {
				echo "<br />Looks like more than one product is using this file.  I'm not touching it!";
			}
		}
	} else {
		if($GLOBALS['debug']) {
			echo '<br />No file to delete here...';
		}
	}
}


