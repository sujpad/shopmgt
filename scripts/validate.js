
var error_background_color = "#ff9966";
var error_font_color = "red";

//createXmlHttpRequestObject();

function checkEmail (field, error_field_id) 
{
	var error_text_field = (typeof(error_field_id) == 'undefined') ? document.getElementById(field.id + "_validate") : document.getElementById(error_field_id);
		
	strng = field.value;
	var error="";

	var emailFilter=/^.+@.+\..{2,3}$/;
	if (!(emailFilter.test(strng))) { 
		error = "Please enter a valid email address.\n";
	}
	else {
		//test email for illegal characters
		var illegalChars= /[\(\)\<\>\,\;\:\\\"\[\]]/
			if (strng.match(illegalChars)) {
				error = "The email address contains illegal characters.\n";
			}
	}

	if( error != ""  )
	{
               	field.style.backgroundColor = error_background_color;

		error_text_field.innerHTML  = error;
               	error_text_field.style.color = error_font_color;
        }
        else
        {
               	field.style.backgroundColor = "white";
		error_text_field.innerHTML  = "&nbsp;";
	}
}


// phone number - strip out delimiters and check for 10 digits

function checkPhone (strng) {
	var error = "";
	if (strng == "") {
		error = "You didn't enter a phone number.\n";
	}

	var stripped = strng.replace(/[\(\)\.\-\ ]/g, ''); //strip out acceptable non-numeric characters
	if (isNaN(parseInt(stripped))) {
		error = "The phone number contains illegal characters.";

    }
    if (!(stripped.length == 10)) {
	error = "The phone number is the wrong length. Make sure you included an area code.\n";
    } 
return error;
}


// password - between 6-8 chars, uppercase, lowercase, and numeral

function checkPassword (field, error_field_id) 
{
	var error_text_field = (typeof(error_field_id) == 'undefined') ? document.getElementById(field.id + "_validate") : document.getElementById(error_field_id);

	var strng = field.value;
	var error = "";
	if (strng == "") {
		error = "You didn't enter a password.\n";
	}

	var illegalChars = /[\W_]/; // allow only letters and numbers

	if (strng.length < 6) 
		error = "Password should be at least 6 characters";
	else if (strng.length > 15)
		error = "Password length should not exceed 15 characters";
	else if (illegalChars.test(strng)) {
		error = "The password contains illegal characters.\n";
	} 
	else if (!((strng.search(/(a-z)+/)) && (strng.search(/(A-Z)+/)) && (strng.search(/(0-9)+/)))) {
		error = "The password must contain at least one uppercase letter, one lowercase letter, and one numeral.\n";
	}  

	if( error != ""  )
	{
               	field.style.backgroundColor = error_background_color;

		error_text_field.innerHTML  = error;
               	error_text_field.style.color = error_font_color;
        }
        else
        {
               	field.style.backgroundColor = "white";
		error_text_field.innerHTML  = "&nbsp;";
	}
}    


// username - 4-10 chars, uc, lc, and underscore only.

function checkUsername (strng) {
var error = "";
if (strng == "") {
   error = "You didn't enter a username.\n";
}


    var illegalChars = /\W/; // allow letters, numbers, and underscores
    if ((strng.length < 4) || (strng.length > 10)) {
       error = "The username is the wrong length.\n";
    }
    else if (illegalChars.test(strng)) {
    error = "The username contains illegal characters.\n";
    } 
return error;
}       


// non-empty textbox

function isEmpty(strng) {
var error = "";
  if (strng.length == 0) {
     error = "The mandatory text area has not been filled in.\n"
  }
return error;	  
}

// was textbox altered

function isDifferent(strng) {
var error = ""; 
  if (strng != "Can\'t touch this!") {
     error = "You altered the inviolate text area.\n";
  }
return error;
}

// exactly one radio button is chosen

function checkRadio(checkvalue) {
var error = "";
   if (!(checkvalue)) {
       error = "Please check a radio button.\n";
    }
return error;
}

// valid selector from dropdown list

function checkDropdown(choice) {
var error = "";
    if (choice == 0) {
    error = "You didn't choose an option from the drop-down list.\n";
    }    
return error;
}    


function checkIfPosNum(field, error_field_id)
{
	var error_text_field = (typeof(error_field_id) == 'undefined') ? document.getElementById(field.id + "_validate") : document.getElementById(error_field_id);
        var check = true;
        var value = field.value; //get characters
        //check that all characters are digits, ., -, or ""

        for(var i=0;i < field.value.length; ++i)
        {
               var new_key = value.charAt(i); //cycle through characters
		if( new_key == "." )
			check = true;
	
               else if( ( (new_key < "0") || (new_key > "9") ) &&
                    !(new_key == ""))
               {
                    check = false;
                    break;
               }
        }

        //apply appropriate colour based on value
	if(!check)
        {
               	field.style.backgroundColor = error_background_color;
               	//field.focus();
	       	//field.select();

		error_text_field.innerHTML  = "Error: Please enter a positive number";
               	error_text_field.style.color = error_font_color;
               	//error_text_field.style.fontWeight = "bold";
		return false;
        }
       	else
        {
               	field.style.backgroundColor = "white";
		error_text_field.innerHTML  = "&nbsp;";
		return true;
        }
}

function checkContactNumber(field)
{
        var check = true;
        var value = field.value; //get characters
        //check that all characters are digits, ., -, or ""

        for(var i=0;i < field.value.length; ++i)
        {
               var new_key = value.charAt(i); //cycle through characters
               if(((new_key < "0") || (new_key > "9")) &&
                    !(new_key == "") && !(new_key == " "))
               {
                    check = false;
                    break;
               }
        }

	error_text_field =  document.getElementById(field.id + "_validate");

        //apply appropriate colour based on value
	if(!check)
        {
               	field.style.backgroundColor = error_background_color;
               	//field.focus();
	       	//field.select();

		error_text_field.innerHTML  = "Error: Please enter a positive number";
               	error_text_field.style.color = error_font_color;
               	//error_text_field.style.fontWeight = "bold";
		return false;
        }
       	else
        {
               	field.style.backgroundColor = "white";
		error_text_field.innerHTML  = "&nbsp;";
		return true;
        }
}
function checkName(field, error_field_id)
{
	var error_text_field = (typeof(error_field_id) == 'undefined') ? document.getElementById(field.id + "_validate") : document.getElementById(error_field_id);

        var check = true;
        var value = field.value; //get characters
	var wrong_char;
        //check that all characters are digits, ., -, or ""
        for(var i=0;i < field.value.length; ++i)
        {
               	var new_key = value.charAt(i); //cycle through characters
               	if( ( ((new_key >= "0") && (new_key <= "9")) || ((new_key >= "a") && (new_key <="z")) || ((new_key >= "A") && (new_key <="Z")) ) &&
                    !(new_key == ""))
               	{
                    	check = true;
               	}
		else if( (new_key == ' ' || new_key == '_' || new_key == '-') && !(new_key == "") )
		{
                    	check = true;
		}
		else
		{
		    	check = false;
			wrong_char = new_key;
                    	break;
		}
        }

        //apply appropriate colour based on value
	if(!check)
        {
               	field.style.backgroundColor = error_background_color;

		error_text_field.innerHTML  = "Error: \'" + wrong_char + "\' is not allowed";
               	error_text_field.style.color = error_font_color;
               	//error_text_field.style.fontWeight = "bold";
               	//error_text_field.style.backgroundColor = "#ff00ff";
        }
        else
        {
               	field.style.backgroundColor = "white";
		error_text_field.innerHTML  = "&nbsp;";
	}
}

function checkIfGreater(selling_price, error_field_id)
{
	var error_text_field = (typeof(error_field_id) == 'undefined') ? document.getElementById(field.id + "_validate") : document.getElementById(error_field_id);

        var check = true;
        var selling_price_value = parseFloat(selling_price.value); //get characters

	original_price =  document.getElementById('original_price');
	var original_price_value = parseFloat(original_price.value);
	
	if( selling_price_value < original_price_value )
		check = false ;

	if( !check )
	{
               	selling_price.style.backgroundColor = error_background_color;

		error_text_field.innerHTML  = "Selling price should be greater than original price";
               	error_text_field.style.color = error_font_color;
        }
        else
        {
               	selling_price.style.backgroundColor = "white";
		error_text_field.innerHTML  = "&nbsp;";
	}
}

function checkMltPosNum(field)
{
	search_items();
	//checkIfPosNum(field);
}
function checkMltName(field)
{
	search_items();
	//checkName(field);
}
function search_date()
{
	search_items();
}
function checkSellingPrice(field)
{
	if( checkIfPosNum(field) )
		checkIfGreater(field);
}

function validate_add_item(field)
{
	error_text_field = document.getElementById('submit_validate');

	if( document.getElementById("item_name").value == "" )
	{
		error_text_field.innerHTML = "Please enter item name";
               	error_text_field.style.color = error_font_color;
               	error_text_field.style.fontWeight = "bold";
		
		return false;	
	}
	else if(document.getElementById("item_name").style.backgroundColor != "white") 
	{
		error_text_field.innerHTML = "Please enter a valid item name";
               	error_text_field.style.color = error_font_color;
               	error_text_field.style.fontWeight = "bold";
		
		return false;	
	}
	
	else if(document.getElementById("count").value == "" )
	{
		error_text_field.innerHTML = "Please enter count";
               	error_text_field.style.color = error_font_color;
               	error_text_field.style.fontWeight = "bold";
		return false;	
	}
	else if(document.getElementById("count").style.backgroundColor != "white")
	{
		error_text_field.innerHTML = "Please enter a valid count";
               	error_text_field.style.color = error_font_color;
               	error_text_field.style.fontWeight = "bold";
		return false;	
	}
	else if(document.getElementById("original_price").value == "" )
	{
		error_text_field.innerHTML = "Please enter original price";
               	error_text_field.style.color = error_font_color;
               	error_text_field.style.fontWeight = "bold";
		return false;	
	}
	//else if(document.getElementById("original_price").style.backgroundColor == "#ff9966")
	else if(document.getElementById("original_price").style.backgroundColor != "white")
	{
		error_text_field.innerHTML = "Please enter a valid original price";
               	error_text_field.style.color = error_font_color;
               	error_text_field.style.fontWeight = "bold";
		return false;	
	}
	else if(document.getElementById("selling_price").value == "" )
	{
		error_text_field.innerHTML = "Please enter selling price";
               	error_text_field.style.color = error_font_color;
               	error_text_field.style.fontWeight = "bold";
		return false;	
	}
	//else if(document.getElementById("selling_price").style.backgroundColor == "#ff9966")
	else if(document.getElementById("selling_price").style.backgroundColor != "white")
	{
		error_text_field.innerHTML = "Please enter a valid selling price";
               	error_text_field.style.color = error_font_color;
               	error_text_field.style.fontWeight = "bold";
		return false;	
	}
	else
	{
		error_text_field.innerHTML = "&nbsp";
		return true;
	}
}

function validate_form(elem)
{
	error_text_field = document.getElementById('submit_validate');
	inputs = elem.getElementsByTagName('input');
	for( var i=0; i<inputs.length; i++)
	{
		if(inputs[i].type == 'text' || inputs[i].type == 'password' )
		{
			if(inputs[i].className.search('optional')==-1 && inputs[i].value == "")
			{
				error_text_field.innerHTML = "Please fill all the mandatory fields";
				error_text_field.style.color = error_font_color;
				error_text_field.style.fontWeight = "bold";
				return false;	
			}
			field = document.getElementById(inputs[i].id);
			if(field.style.backgroundColor != "" && field.style.backgroundColor != "white" )
			{
				error_text_field.innerHTML = "Please correct the marked fields";
				error_text_field.style.color = error_font_color;
				error_text_field.style.fontWeight = "bold";
				return false;	
			}
		}
	}
	return true;
}

function iftabmovenext(elem, form_elem, e)
{
	for(var i=0; i<form_elem.length; i++)
	{
		if(elem == form_elem.elements[i])
		{
			// get the event
			e = (!e) ? window.event : e;
			// get the character code of the pressed button
			code = (e.charCode) ? e.charCode :
				((e.keyCode) ? e.keyCode :
				 ((e.which) ? e.which : 0));
			// check to see if the event was keyup
			if (e.type == "keyup")
			{
				if(code == 9)	//If tab is pressed
				{
					i++;
					form_elem.elements[i].focus();
				}
			}
		}
	}
}


function checkRetypedPassword(retype_password, password, error_field_id)
{
	var error_text_field = (typeof(error_field_id) == 'undefined') ? document.getElementById(retype_password.id + "_validate") : document.getElementById(error_field_id);

	if( retype_password.value != password )
	{
               	retype_password.style.backgroundColor = error_background_color;

		error_text_field.innerHTML  = "New password and retyped password do not match";
               	error_text_field.style.color = error_font_color;
        }
        else
        {
               	retype_password.style.backgroundColor = "white";
		error_text_field.innerHTML  = "&nbsp;";
	}
}
