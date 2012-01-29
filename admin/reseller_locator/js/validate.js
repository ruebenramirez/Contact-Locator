function WAAddError(formElement,errorMsg,focusIt,stopIt)  {
  if (document.WAFV_Error)  {
	  document.WAFV_Error += "\n" + errorMsg;
  }
  else  {
    document.WAFV_Error = errorMsg;
  }
  if (!document.WAFV_InvalidArray)  {
    document.WAFV_InvalidArray = new Array();
  }
  document.WAFV_InvalidArray[document.WAFV_InvalidArray.length] = formElement;
  if (focusIt && !document.WAFV_Focus)  {
	document.WAFV_Focus = focusIt;
  }

  if (stopIt == 1)  {
	document.WAFV_Stop = true;
  }
  else if (stopIt == 2)  {
	formElement.WAFV_Continue = true;
  }
  else if (stopIt == 3)  {
	formElement.WAFV_Stop = true;
	formElement.WAFV_Continue = false;
  }
}

function WAValidateAN(formElement,value,errorMsg,allowUpper,allowLower,allowNumbers,allowSpace,extraChars,focusIt,stopIt,required)  {
  var isValid = true;
  extraChars = extraChars.replace(/&quot;/g,'"');
  if ((!document.WAFV_Stop && !formElement.WAFV_Stop) || formElement.WAFV_Continue)  {
    for (var x=0; x<value.length; x++)  {
	  var charGood = false;
	  var nextChar = value.charAt(x);
	  var charCode = value.charCodeAt(x);
	  if (allowLower)  {
	    if (charCode >= 97 && charCode <= 122)  {
		  charGood = true;
		}
	  }
	  if (allowUpper)  {
	    if (charCode >= 65 && charCode <= 90)  {
		  charGood = true;
		}
	  }
	  if (allowNumbers)  {
	    if (charCode >= 48 && charCode <= 57)  {
		  charGood = true;
		}
	  }
	  if (allowSpace)  {
	    if (nextChar == " ")  {
		  charGood = true;
		}
	  }
	  if (extraChars)  {
	    if (unescape(extraChars).indexOf(nextChar) >= 0)  {
		  charGood = true;
		}
	  }
	  if (!charGood)  {
	    isValid = false;
		x = value.length;
	  }
	}
	if (required && value=="")
	  isValid = false;
  }
  if (!isValid)  {
    WAAddError(formElement,errorMsg,focusIt,stopIt);
  }
}
function WAValidatePN(formElement,errorMsg,areaCode,international,reformat,focusIt,stopIt,required)  {
  var value = formElement.value;
  var isValid = true;
  var allowed = "*() -./_\n\r+";
  var newVal = "";
  if ((!document.WAFV_Stop && !formElement.WAFV_Stop) && !(!required && value==""))  {
    for (var x=0; x<value.length; x++)  {
      var z = value.charAt(x);
      if ((z >= "0") && (z <= "9")) {
	    newVal += z;
	  }
	  else  {
		if (allowed.indexOf(z) < 0)  {
		  isValid = false;
		}
	  }
    }	
	if (international)  {
	  if  (newVal.length < 5)  {
	    isValid = false;
	  }
	}
	else if (newVal.length == 11)  {
	  if (newVal.charAt(0) != "1")	{
		isValid = false;
	  }
	}
	else if ((newVal.length != 10 && newVal.length != 7) || (newVal.length==7 && areaCode)) {
	  isValid = false;
	}
  }
  if (!isValid)  {
    WAAddError(formElement,errorMsg,focusIt,stopIt);
  }
  else  {
    formElement.WAValid = true;
    if (reformat != "" && newVal != "")  {
      for (var x=0; x<newVal.length; x++)  {
	    reformat = reformat.substring(0,reformat.lastIndexOf("x")) + newVal.charAt(newVal.length-(x+1)) + reformat.substring(reformat.lastIndexOf("x")+1);
	  }
	  if (reformat.indexOf("x")>=0)  {
	    reformat = reformat.substring(reformat.lastIndexOf("x")+1);
        z = reformat.charAt(0);
	    while (((z < "0") || (z > "9")) && z != "(")  {
	      reformat = reformat.substring(1);
		  z = reformat.charAt(0);
		}
	  }
      formElement.value = reformat;
	}
  }
}
function WAValidateEM(formElement,value,errorMsg,focusIt,stopIt,required) {
  var isValid = true;
  if ((!document.WAFV_Stop && !formElement.WAFV_Stop) && !(!required && value==""))  {
    value = value.toLowerCase();
    var knownDomsPat = /^(com|net|org|edu|int|mil|gov|arpa|biz|aero|name|coop|info|pro|museum)$/i;
    var emailPat = /^(.+)@(.+)$/i;
    var accepted = "\[^\\s\\(\\)><@,;:\\\\\\\"\\.\\[\\]\]+";
    var quotedUser = "(\"[^\"]*\")";
    var ipDomainPat = /^\[(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})\]$/i;
    var section = "(" + accepted + "|" + quotedUser + ")";
    var userPat = new RegExp("^" + section + "(\\." + section + ")*$");
    var domainPat = new RegExp("^" + accepted + "(\\." + accepted +")*$");
    var theMatch = value.match(emailPat);
    var acceptedPat = new RegExp("^" + accepted + "$");
    var userName = "";
    var domainName = "";
    if (theMatch==null) {
      isValid = false;
    }
    else  {
      userName = theMatch[1];
      domainName = theMatch[2];
	  var domArr = domainName.split(".");
	  var IPArray = domainName.match(ipDomainPat);
      for (x=0; x < userName.length; x++) {
        if ((userName.charCodeAt(x) > 127 && userName.charCodeAt(x) < 192) || userName.charCodeAt(x) > 255) {
          isValid = false;
        }
      }
      for (x=0; x < domainName.length; x++) {
        if ((domainName.charCodeAt(x) > 127 && domainName.charCodeAt(x) < 192) || domainName.charCodeAt(x) > 255) {
          isValid = false;
        }
      }
      if (userName.match(userPat) == null) {
        isValid = false;
      }
      if (IPArray != null) {
        for (var x=1; x<=4; x++) {
          if (IPArray[x] > 255) {
            isValid = false;
          }
        }
      }
      for (x=0; x < domArr.length; x++) {
        if (domArr[x].search(acceptedPat) == -1 || domArr[x].length == 0 || (domArr[x].length < 2 && x >= domArr.length-2  && x > 0)) {
          isValid = false;
        }
      }
      if (domArr[domArr.length-1].length !=2 && domArr[domArr.length-1].search(knownDomsPat) == -1) {
        isValid = false;
      }
      if (domArr.length < 2) {
        isValid = false;
      }
    }
  }
  if (!isValid)  {
    WAAddError(formElement,errorMsg,focusIt,stopIt);
  }
}
function WAtrimIt(theString,leaveLeft,leaveRight)  {
  if (!leaveLeft)  {
    while (theString.charAt(0) == " ")
      theString = theString.substring(1);
  }
  if (!leaveRight)  {
    while (theString.charAt(theString.length-1) == " ")
      theString = theString.substring(0,theString.length-1);
  }
  return theString;
}

function WAFV_GetValueFromInputType(formElement,inputType,trimWhite) {
  var value="";
  if (inputType == "select")  {
    if (formElement.selectedIndex != -1 && formElement.options[formElement.selectedIndex].value && formElement.options[formElement.selectedIndex].value != "") {
      value = formElement.options[formElement.selectedIndex].value;
    }
  }
  else if (inputType == "checkbox")  {
    if (formElement.length)  {
      for (var x=0; x<formElement.length ; x++)  {
        if (formElement[x].checked && formElement[x].value!="")  {
          value = formElement[x].value;
          break;
        }
      }
    }
    else if (formElement.checked)
      value = formElement.value;
  }
  else if (inputType == "radio")  {
    if (formElement.length)  {
      for (var x=0; x<formElement.length; x++)  {
        if (formElement[x].checked && formElement[x].value!="")  {
          value = formElement[x].value;
          break;
        }
      }
    }
    else if (formElement.checked)
      value = formElement.value;
  }
  else if (inputType == "radiogroup")  {
    for (var x=0; x<formElement.length; x++)  {
      if (formElement[x].checked && formElement[x].value!="")  {
        value = formElement[x].value;
        break;
      }
    }
  }
  else if (inputType == "iRite")  {
     var theEditor = FCKeditorAPI.GetInstance(formElement.name) ;
     value = theEditor.GetXHTML(true);
  }
  else  {
    var value = formElement.value;
  }
  if (trimWhite)  {
    value = WAtrimIt(value);
  }
  return value;
}

function WAValidateRQ(formElement,errorMsg,focusIt,stopIt,trimWhite,inputType)  {
  var isValid = true;
  if (!document.WAFV_Stop && !formElement.WAFV_Stop)  {
    var value=WAFV_GetValueFromInputType(formElement,inputType,trimWhite);
    if (value == "")  {
	    isValid = false;
    }
  }
  if (!isValid)  {
    WAAddError(formElement,errorMsg,focusIt,stopIt);
  }
}
function WAAlertErrors(errorHead,errorFoot,setFocus,submitForm)  { 
  if (!document.WAFV_StopAlert)  { 
	  document.WAFV_StopAlert = true;
	  if (document.WAFV_InvalidArray)  {  
	    document.WAFV_Stop = true;
        var errorMsg = document.WAFV_Error;
	    if (errorHead!="")
		  errorMsg = errorHead + "\n" + errorMsg;
		if (errorFoot!="")
		  errorMsg += "\n" + errorFoot;
		document.MM_returnValue = false;
		if (document.WAFV_Error!="")
		  alert(errorMsg.replace(/&quot;/g,'"'));
		else if (submitForm)
		  submitForm.submit();
	    if (setFocus && document.WAFV_Focus)  {
		  document.tempFocus = document.WAFV_Focus;
          setTimeout("document.tempFocus.focus();setTimeout('document.WAFV_Stop = false;document.WAFV_StopAlert = false;',1)",1); 
        }
        else {
          document.WAFV_Stop = false;
          document.WAFV_StopAlert = false;
        }
        for (var x=0; x<document.WAFV_InvalidArray.length; x++)  {
	      document.WAFV_InvalidArray[x].WAFV_Stop = false;
	    }
	  }
	  else  {
        document.WAFV_Stop = false;
        document.WAFV_StopAlert = false;
	    if (submitForm)  {
	      submitForm.submit();
	    }
	    document.MM_returnValue = true;
	  }
      document.WAFV_Focus = false;
	  document.WAFV_Error = false;
	  document.WAFV_InvalidArray = false;
  }
}