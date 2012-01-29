<? if ($_COOKIE['nadmin'] == ""){ echo "<meta http-equiv=\"refresh\" content=\"0;URL=http://www.newtek.com/admin/index.php?error=1\">"; }; ?>
<?
//-CONFIG FILE--------------------------------------------------------------------------------//

// Set Database Info
$server = "jerome.newtek.com";		// Your mySQL Server
$db_user = "news";					// Your mySQL Username
$db_pass = "L&yrFpnp";				// Your mySQL Password
$db = "news";						// Database Name

// Stupid stuff to make WA_* junk connect to database
$hostname_connNews = "jerome.newtek.com";
$database_connNews = "news";
$username_connNews = "news";
$password_connNews = "L&yrFpnp";
$connNews = mysql_pconnect($hostname_connNews, $username_connNews, $password_connNews) or trigger_error(mysql_error(),E_USER_ERROR);

// set error descriptions
$error1 = "Please login first!"; // un-logged in user
$error2 = "You need to enter a username and password!"; // username and password left  blank
$error3 = "You need to enter a username!"; // username left blank
$error4 = "You need to enter a password!"; // password left blank
$error5 = "The username entered does not exist!"; // username not found in the database
$error6 = "The password for this account is incorrect!"; // password doesnt match the username

//-Dont Edit  Below this Line!!---------------------------------------------------------------//

// Actually connect to the database
$dbconnect=@mysql_pconnect($server, $db_user, $db_pass) or die ("Database CONNECT Error");
@mysql_select_db($db, $dbconnect);

// process login errors
$errornum = $_GET['error'];
if($errornum == 1){
$error = $error1;
}elseif($errornum == 2){
$error = $error2;
}elseif($errornum == 3){
$error = $error3;
}elseif($errornum == 4){
$error = $error4;
}elseif($errornum == 5){
$error = $error5;
}elseif($errornum == 6){
$error = $error6;
}else{
$error = "";
}
?>
<?php
//WA Database Search Include

if (file_exists('../../../WADbSearch/HelperPHP.php')) {
	require_once("../../../WADbSearch/HelperPHP.php");
} //else if (file_exists('../../../../WADbSearch/HelperPHP.php')){
	//require_once('../../../../WADbSearch/HelperPHP.php');
//}

?>
<html>
<head>
<title>NewTek: Administration Panel</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="javascript" type="text/javascript">
<!--
function go()
{
	box = document.forms[0].navi;
	destination = box.options[box.selectedIndex].value;
	if (destination) location.href = destination;
}
// -->
</SCRIPT>
<script>
function sendText(e, text)
{
e.value += text
}
</script>

<script>
if(document.getElementById&&!document.all){ns6=1;}else{ns6=0;}
var agtbrw=navigator.userAgent.toLowerCase();
var operaaa=(agtbrw.indexOf('opera')!=-1);
var head="display:''";
var folder='';

function expandit(curobj,hide){
if(document.getElementById(curobj)){
  folder=document.getElementById(curobj).style;

  }else{

if(ns6==1||operaaa==true){
	folder=curobj.nextSibling.nextSibling.style;
}else{
	folder=document.all[curobj.sourceIndex+1].style;
}
   }
if (folder.display=="none"){folder.display="";}else{folder.display="none";}
if(document.getElementById(hide)){
	hidden=document.getElementById(hide).style;
	if (hidden.display=="none"){hidden.display="";}else{hidden.display="none";}
}
}


function urljump(url){
	top.window.location = url;
}

function jsconfirm(thetext){
		return confirm(thetext);
}

function insertext(str,tagid,display){
	document.getElementById(tagid).value = str;
	if(display){
		document.getElementById(display).style.display='none';
	}
}

function appendtext(str,tagid,display){
	document.getElementById(tagid).value += str;
	document.getElementById(tagid).focus();
	if(display){
		document.getElementById(display).style.display='none';
	}
}

function open_window(url,wth,hgt) {
	if('full' == wth){
		pwindow = window.open(url);
	} else {
		if (wth) {
			mywidth=wth;
		} else {
			mywidth=600;
		}

		if (hgt) {
			myheight=hgt;
		} else {
			myheight=400;
		}

		pwindow = window.open(url,'Name', 'top=100,left=100,resizable=yes,width='+mywidth+',height='+myheight+',scrollbars=yes,menubar=yes')
	}
	pwindow.focus();
}

function ejs_preload(ejs_path, ejs_imagestring){
	var ejs_imageArray = ejs_imagestring.split(',');
	for(ejs_loadall=0; ejs_loadall<ejs_imageArray.length; ejs_loadall++){
		var ejs_LoadedImage=new Image();
		ejs_LoadedImage.src=ejs_path + ejs_imageArray[ejs_loadall];
	}
}

function textCounter(field,cntfield) {
	cntfield.value = field.value.length;
}

function openwindow() {
	opener = window.open("htmlarea/index.php", "popup","top=50,left=100,resizable=no,width=670,height=520,scrollbars=no,menubar=no");
	opener.focus();
}

function setCheckboxes(the_form, do_check, the_cb){
	var elts = (typeof(document.forms[the_form].elements[the_cb]) != 'undefined') ? document.forms[the_form].elements[the_cb] : document.forms[the_form].elements[the_cb];
	var elts_cnt  = (typeof(elts.length) != 'undefined') ? elts.length : 0;
	if(elts_cnt){
		for(var i = 0; i < elts_cnt; i++){
			elts[i].checked = do_check;
		}
	}else{
		elts.checked        = do_check;
		}
	return true;
}

var ref=""+escape(top.document.referrer);
var colord = window.screen.colorDepth;
var res = window.screen.width + "x" + window.screen.height;
var eself = document.location;

// From http://phpbb.com
var clientPC = navigator.userAgent.toLowerCase();
var clientVer = parseInt(navigator.appVersion);
var is_ie = ((clientPC.indexOf("msie") != -1) && (clientPC.indexOf("opera") == -1));
var is_nav = ((clientPC.indexOf('mozilla')!=-1) && (clientPC.indexOf('spoofer')==-1) && (clientPC.indexOf('compatible') == -1) && (clientPC.indexOf('opera')==-1) && (clientPC.indexOf('webtv')==-1) && (clientPC.indexOf('hotjava')==-1));
var is_moz = 0;
var is_win = ((clientPC.indexOf("win")!=-1) || (clientPC.indexOf("16bit") != -1));
var is_mac = (clientPC.indexOf("mac")!=-1);
var e107_selectedInputArea;
var e107_selectedRange;
var e107_dupCounter = 1;

// From http://www.massless.org/mozedit/
function mozWrap(txtarea, open, close){
	var selLength = txtarea.textLength;
	var selStart = txtarea.selectionStart;
	var selEnd = txtarea.selectionEnd;
	if (selEnd == 1 || selEnd == 2) selEnd = selLength;
	var s1 = (txtarea.value).substring(0,selStart);
	var s2 = (txtarea.value).substring(selStart, selEnd)
	var s3 = (txtarea.value).substring(selEnd, selLength);
	txtarea.value = s1 + open + s2 + close + s3;
	return;
}

function storeCaret (textAr){
	e107_selectedInputArea = textAr;
	if (textAr.createTextRange){
		e107_selectedRange = document.selection.createRange().duplicate();
	}
}

function addtext(text, emote){
	if (window.e107_selectedInputArea){
		var ta = e107_selectedInputArea;
		if (emote != true){
			val = text.split('><');
			}
		else { val = text; }

		if ((clientVer >= 4) && is_ie && is_win){
			theSelection = document.selection.createRange().text; /* wrap selected text */
			if (theSelection) {
				if (emote != true){
					document.selection.createRange().text = val[0]+'>'+theSelection+'<'+val[1];
				} else {
					document.selection.createRange().text = val +theSelection;
				}
				ta.focus();
				theSelection = '';
				return;
			}

		}else if (ta.selectionEnd && (ta.selectionEnd - ta.selectionStart > 0)){
			if (emote != true){
				mozWrap(ta, val[0] +'>', '<' + val[1]); /* wrap selected text */
			} else {
				mozWrap(ta, val, ''); /* wrap selected text */
			}
			return;
		}
		text = ' ' + text + ' ';
		if (ta.createTextRange && e107_selectedRange) {
			var caretPos = e107_selectedRange; /* IE */
			caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ? caretPos.text + text + ' ' : caretPos.text + text;
		} else if (ta.selectionStart || ta.selectionStart == '0') { /* Moz */
		   	var startPos = ta.selectionStart;
			var endPos = ta.selectionEnd;
			var charb4 = ta.value.charAt(endPos-1);
			ta.value = ta.value.substring(0, endPos)+ text + ta.value.substring(endPos);
		} else {
			ta.value  += text;
		}
		ta.focus();
	}
}

function help(help,tagid){
	if(tagid){
		document.getElementById(tagid).value = help;
	} else {
	document.getElementById('dataform').helpb.value = help;
	}
}
function externalLinks() {
	if (!document.getElementsByTagName) return;
	var anchors = document.getElementsByTagName("a");
	for (var i=0; i<anchors.length; i++) {
	var anchor = anchors[i];
	if (anchor.getAttribute("href") &&
		anchor.getAttribute("rel") == "external")
		anchor.target = "_blank";
	}
}

function eover(object, over) {
	object.className = over;
}

function duplicateHTML(copy,paste,baseid){
		if(document.getElementById(copy)){

			e107_dupCounter++;
			var type = document.getElementById(copy).nodeName; // get the tag name of the source copy.

			var but = document.createElement('input');
			var br = document.createElement('br');

			but.type = 'button';
			but.value = 'x';
			but.className = 'button';
			but.onclick = function(){ this.parentNode.parentNode.removeChild(this.parentNode); };

			var destination = document.getElementById(paste);
			var source      = document.getElementById(copy).cloneNode(true);

			var newentry = document.createElement(type);

			newentry.appendChild(source);
			newentry.value='';
			newentry.appendChild(but);
			newentry.appendChild(br);
			if(baseid)
			{
				newid = baseid+e107_dupCounter;
				newentry.innerHTML = newentry.innerHTML.replace(new RegExp(baseid, 'g'), newid);
				newentry.id=newid;
			}

			destination.appendChild(newentry);
		}
}
</script>
<script>
//verify for netscape/mozilla
var isNS4 = (navigator.appName=="Netscape")?1:0;
</script>
<script language="JavaScript1.2">

// Script Source: CodeLifter.com
// Copyright 2003
// Do not remove this header

isIE=document.all;
isNN=!document.all&&document.getElementById;
isN4=document.layers;
isHot=false;

function ddInit(e){
  topDog=isIE ? "BODY" : "HTML";
  whichDog=isIE ? document.all.theLayer : document.getElementById("theLayer");
  hotDog=isIE ? event.srcElement : e.target;
  while (hotDog.id!="titleBar"&&hotDog.tagName!=topDog){
    hotDog=isIE ? hotDog.parentElement : hotDog.parentNode;
  }
  if (hotDog.id=="titleBar"){
    offsetx=isIE ? event.clientX : e.clientX;
    offsety=isIE ? event.clientY : e.clientY;
    nowX=parseInt(whichDog.style.left);
    nowY=parseInt(whichDog.style.top);
    ddEnabled=true;
    document.onmousemove=dd;
  }
}

function dd(e){
  if (!ddEnabled) return;
  whichDog.style.left=isIE ? nowX+event.clientX-offsetx : nowX+e.clientX-offsetx;
  whichDog.style.top=isIE ? nowY+event.clientY-offsety : nowY+e.clientY-offsety;
  return false;
}

function ddN4(whatDog){
  if (!isN4) return;
  N4=eval(whatDog);
  N4.captureEvents(Event.MOUSEDOWN|Event.MOUSEUP);
  N4.onmousedown=function(e){
    N4.captureEvents(Event.MOUSEMOVE);
    N4x=e.x;
    N4y=e.y;
  }
  N4.onmousemove=function(e){
    if (isHot){
      N4.moveBy(e.x-N4x,e.y-N4y);
      return false;
    }
  }
  N4.onmouseup=function(){
    N4.releaseEvents(Event.MOUSEMOVE);
  }
}

function hideMe(){
  if (isIE||isNN) whichDog.style.visibility="hidden";
  else if (isN4) document.theLayer.visibility="hide";
}

function showMe(){
  if (isIE||isNN) whichDog.style.visibility="visible";
  else if (isN4) document.theLayer.visibility="show";
}

document.onmousedown=ddInit;
document.onmouseup=Function("ddEnabled=false");

</script>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->
</script>

<script type="text/javascript" src="images/calendar/calendarDateInput.js"></script>

<link href="http://www.newtek.com/admin/style.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style1 {font-size: 11px}
-->
</style>
</head>
<body bgcolor="#ffffff" onLoad="MM_preloadImages('http://www.newtek.com/admin/images/layout/layout_r2_c3_f2.png','http://www.newtek.com/admin/images/layout/layout_r2_c6_f2.png','http://www.newtek.com/admin/images/layout/layout_r2_c7_f2.png','http://www.newtek.com/admin/images/layout/layout_r2_c10_f2.png');" onload="document.form1.username.focus()"><body onLoad="MM_preloadImages('http://www.newtek.com/admin/images/layout/layout_r2_c10_f2.png')">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
  <tr>
    <td><img src="http://www.newtek.com/admin/images/layout/spacer.gif" width="134" height="1" border="0" alt=""></td>
    <td><img src="http://www.newtek.com/admin/images/layout/spacer.gif" width="6" height="1" border="0" alt=""></td>
    <td width="102"><img src="http://www.newtek.com/admin/images/layout/spacer.gif" width="4" height="1" border="0" alt=""></td>
    <td><img src="http://www.newtek.com/admin/images/layout/spacer.gif" width="78" height="1" border="0" alt=""></td>
    <td><img src="http://www.newtek.com/admin/images/layout/spacer.gif" width="20" height="1" border="0" alt=""></td>
    <td width="102"><img src="http://www.newtek.com/admin/images/layout/spacer.gif" width="102" height="1" border="0" alt=""></td>
    <td width="102"><img src="http://www.newtek.com/admin/images/layout/spacer.gif" width="102" height="1" border="0" alt=""></td>
    <td width="100%"><img src="http://www.newtek.com/admin/images/layout/spacer.gif" width="480" height="1" border="0" alt=""></td>
    <td><img src="http://www.newtek.com/admin/images/layout/spacer.gif" width="7" height="1" border="0" alt=""></td>
    <td><img src="http://www.newtek.com/admin/images/layout/spacer.gif" width="78" height="1" border="0" alt=""></td>
    <td><img src="http://www.newtek.com/admin/images/layout/spacer.gif" width="1" height="1" border="0" alt=""></td>
    <td><img src="http://www.newtek.com/admin/images/layout/spacer.gif" width="1" height="1" border="0" alt=""></td>
  </tr>
  <tr>
    <td colspan="4" background="http://www.newtek.com/admin/images/layout/layout_r1_c5.png"><img name="layout_r1_c1" src="http://www.newtek.com/admin/images/layout/layout_r1_c1.png" width="222" height="55" border="0" alt=""></td>
    <td colspan="7" background="http://www.newtek.com/admin/images/layout/layout_r1_c5.png">&nbsp;</td>
    <td><img src="http://www.newtek.com/admin/images/layout/spacer.gif" width="1" height="55" border="0" alt=""></td>
  </tr>
  <tr>
    <td background="http://www.newtek.com/admin/images/layout/layout_r2_c1.png">&nbsp;
<?
//Query database
$cookie = $_COOKIE['nadmin'];
$sql = "SELECT * FROM admins WHERE username = '$cookie'";
$result=mysql_query($sql);
while($row=mysql_fetch_array($result)) {
$theuser = $row[name];
echo "<b>Hi,  $row[name]!</b>";
}
?>
	</td>
    <td width="7"><img name="layout_r2_c2" src="http://www.newtek.com/admin/images/layout/layout_r2_c2.png" width="6" height="21" border="0" alt=""></td>
    <td colspan="6" background="http://www.newtek.com/admin/images/layout/layout_r2_c8.png">
	<div class="menu2"><table width="100%"  border="0" cellpadding="0" cellspacing="0" class="menu2a">
<? //Query database
$cookie = $_COOKIE['nadmin'];
$sql = "SELECT * FROM admins WHERE username = '$cookie'";
$result=mysql_query($sql);
while($row=mysql_fetch_array($result)) {
$rank = $row[faqclass];
global $rank;
if($row[access_admin] == 0){
$display_task = "Task Manager";
}else{
$display_task = "<a href=\"http://www.newtek.com/admin/tasks.php\">Task Manager</a>";
}
if($row[access_news] == 0){
$display_news = "Headlines";
}else{
$display_news = "<a href=\"http://www.newtek.com/admin/news.php?add=true\">Headlines</a>";
}
if($row[access_newsletters] == 0){
$display_newsletter = "Newsletters";
}else{
$display_newsletter = "<a href=\"http://www.newtek.com/admin/newsletter_search.php\">Newsletters</a>";
}
if($row[access_forms] == 0){
$display_forms = "Data Manager";
}else{
$display_forms = "<a href=\"http://www.newtek.com/admin/forms.php\">Data Manager</a>";
}
if($row[access_faq] == 0){
$display_faq = "FAQ Database";
}else{
$display_faq = "<a href=\"http://www.newtek.com/faq/admin\">FAQ Database </a>";
}
if($row[access_reseller] == 0){
$display_reseller = "Reseller Database";
}else{
$display_reseller = "<a href=\"http://www.newtek.com/admin/resellers.php\">Reseller Database </a>";
}
if($row[access_forms] == 0){
$display_tours = "Tours";
}else{
$display_tours = "<a href=\"http://www.newtek.com/admin/tourstops-list.php\">Tours</a>";
}
if($row[access_pr] == 0){
$display_pr = "PR Manager";
}else{
$display_forms = "<a href=\"http://www.newtek.com/admin/pressrelease.php?list=1\">PR Manager</a>";
}
if($row[distributor] == 0){
$display_resellerAdmin = "PR Manager";
}else{
$display_resellerAdmin = '<a href="http://www.newtek.com/admin/reseller_locator/index.php">PR Manager</a>';
}

	}

  ?>
      <tr>
        <td width="110" align="center" valign="middle" class="menu2 style1" scope="col"><a href="http://www.newtek.com/admin/panel.php">Main</a></td>
        
        <td width="110" align="center" valign="middle" class="menu2" scope="col"><? echo "$display_news"; ?></td>
	<td width="110" align="center" valign="middle" class="menu2" scope="col"><? echo "$display_newsletter"; ?></td>
        <td width="110" align="center" valign="middle" class="menu2 style1" scope="col"><? echo "$display_forms"; ?></td>
        <td width="110" align="center" valign="middle" class="menu2 style1" scope="col"><? echo "$display_reseller"; ?></td>
<!--        <td width="110" align="center" valign="middle" class="menu2 style1" scope="col"><a href="http://www.newtek.com/admin/calendar/calendar.php">Event Calendar</a></td> -->
        <td width="110" align="center" valign="middle" class="menu2 style1" scope="col"><a href="http://www.newtek.com/faq/admin/">FAQ Database</a></td>
        <td width="110" align="center" valign="middle" class="menu2 style1" scope="col"><? echo "$display_tours"; ?></a> </td>
        <td width="110" align="center" valign="middle" class="menu2 style1" scope="col"><? echo "$display_pr"; ?></a> </td>

      </tr>
    </table>
	</div>
	</td>
    <td width="7"><img name="layout_r2_c9" src="http://www.newtek.com/admin/images/layout/layout_r2_c9.png" width="7" height="21" border="0" alt=""></td>
    <td colspan="2"><a href="http://www.newtek.com/admin/process_logout.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('layout_r2_c10','','http://www.newtek.com/admin/images/layout/layout_r2_c10_f2.png',1);"><img name="layout_r2_c10" src="http://www.newtek.com/admin/images/layout/layout_r2_c10.png" width="79" height="21" border="0" alt=""></a></td>
    <td><img src="http://www.newtek.com/admin/images/layout/spacer.gif" width="1" height="21" border="0" alt=""></td>
  </tr>
</table>
