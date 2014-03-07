
createXmlHttpRequestObject();   //Creates only if the object doesn't exist already

var timeoutId = -1;

/* ---------- [ Check stock availability  ----------------------*/
function isStockPresent(item_id, quantity_needed)
{
	var message_field = document.getElementById('gb_message_field');
	var error_field = document.getElementById('gb_error_field');
	message_field.innerHTML = "Please wait while we check stock availability" + "<img src='img/wait.gif'/>";
	// proceed only if the xmlHttp object isn't busy
	if (xmlHttp.readyState == 4 || xmlHttp.readyState == 0)
	{
		xmlHttp.open("GET", "ajax_query/check_stock.php?item_id=" + item_id + "&quantity_needed=" + quantity_needed,  false);
		xmlHttp.send(null);
		var xmlResponseText = xmlHttp.responseText;
		var yes_index = xmlResponseText.indexOf('YES');
		if ( yes_index >= 0 )
		{
			error_field.innerHTML = "";
			var total = xmlResponseText.substring(xmlResponseText.indexOf(':') + 1, xmlResponseText.length);
			message_field.innerHTML = "";
			return total;
		}
		else
		{
			error_field.innerHTML = "Error: There is no enough stock of item '" + xmlResponseText + "'";
			message_field.innerHTML = "";
			return -1;
		}
	}
}

/* ---------- Check stock availability ] ----------------------*/
