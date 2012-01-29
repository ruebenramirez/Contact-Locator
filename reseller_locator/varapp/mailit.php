<?
// mail the content
function mailIt($content, $subject, $email, $recipient, $bcc) {
  global $attachuser, $attachtemp, $attachsize, $attachtype, $this_version;  

  $headpart = "";

  // build message headers
  if($email == '') $email = "webmaster@newtek.com";   
  $headpart = "From: $email\r\n"; 
  $headpart .= "Reply-To: $email\r\n";  
  if ($bcc != '') $headpart .= "Bcc: $bcc\r\n";
  $headpart .= "X-Mailer: HiQ FormMail $this_version\r\n";
  $headpart .= "Content-Type: text/plain; charset=ISO-8859-1\r\n";
  $headpart .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
  
  if ($attachuser) {
    // create a MIME boundary string
    $boundary = md5(uniqid(time()));

    // add MIME data to the message headers
    $headpart = "MIME-Version:1.0\r\n";
    $headpart .= "From: $email\r\n"; 
    $headpart .= "Reply-To: $email\r\n";  
    if ($bcc != '') $headpart .= "Bcc: $bcc\r\n";
    $headpart .= "X-Mailer: HiQ FormMail Version $this_version\r\n";
    $headpart .= "Content-Type: multipart/mixed;\r\n\tboundary=\"$boundary\"\r\n";
          
    $msgpart  = "This is a multi-part message in MIME format.\r\n";
    $msgpart .= "\r\n--$boundary\r\n";
    $msgpart .= "Content-Type: text/plain; charset=ISO-8859-1\r\n";
    $msgpart .= "Content-Transfer-Encoding: 8bit\r\n\r\n";
    $msgpart .= "$content\r\n";   
    for($i = 0; $i < count($attachuser); $i++) {
      $msgpart .= "\r\n--$boundary\r\n";
      $fname = basename($attachuser[$i]);
      $msgpart .= "Content-Type: $attachtype[$i]; \r\n\tname=\"$fname\"\r\n";
      $msgpart .= "Content-Transfer-Encoding: base64\r\n";
	  $msgpart .= "Content-Disposition: attachment; filename=\"$fname\"\r\n\r\n";
      $fcontent = fread(fopen($attachtemp[$i], "r"), filesize($attachtemp[$i]));
      $fcontent = chunk_split(base64_encode($fcontent));      
      $msgpart .= "$fcontent\r\n";
    }
    $msgpart .= "\r\n--$boundary--\r\n";
  } else {
    $msgpart .= "$content\r\n";
  }
  
  if(!mail($recipient, $subject, $msgpart, $headpart)) {
    deleteTempFiles();
    issueSingleError("An undetermined error occured while attempting to send mail.");
  }
  deleteTempFiles();
}
?>