// stores the reference to the XMLHttpRequest object
createXmlHttpRequestObject();

function search_items()
{
	// proceed only if the xmlHttp object isn't busy
	if (xmlHttp.readyState == 4 || xmlHttp.readyState == 0)
	{
		// retrieve the name typed by the user on the form
		item_name = encodeURIComponent(document.getElementById("item_name").value);
		count = encodeURIComponent(document.getElementById("count").value);
		id = encodeURIComponent(document.getElementById("id").value);
		original_price = encodeURIComponent(document.getElementById("original_price").value);
		selling_price = encodeURIComponent(document.getElementById("selling_price").value);
		last_updated_time = encodeURIComponent(document.getElementById("last_updated_time").value);

		xmlHttp.open("GET", "ajax_query/search_query.php?item_name=" + item_name + "&count=" + count + "&id=" + id + "&original_price=" + original_price + "&selling_price=" + selling_price + "&last_updated_time=" + last_updated_time,  true);
		// define the method to handle server responses
		xmlHttp.onreadystatechange = handleServerResponse;
		// make the server request
		xmlHttp.send(null);
	}
	else
	// if the connection is busy, try again after 0.5 seconds
		setTimeout('search_items()', 500);
}

// executed automatically when a message is received from the server
function handleServerResponse()
{
	// move forward only if the transaction has completed
	if (xmlHttp.readyState == 4)
	{
		// status of 200 indicates the transaction completed successfully
		if (xmlHttp.status == 200)
		{
		// extract the XML retrieved from the server
		//xmlResponse = xmlHttp.responseXML;
		xmlResponseText = xmlHttp.responseText;
		// obtain the document element (the root element) of the XML structure
		//xmlDocumentElement = xmlResponse.documentElement;
		// get the text message, which is in the first child of
		// the the document element
		//helloMessage = xmlDocumentElement.firstChild.data;
		// update the client display using the data received from the server
		//document.getElementById("divMessage").innerHTML =
		//'<i>' + helloMessage + '</i>' + '<br> </br>' + xmlResponseText;
		document.getElementById("tableContainer").innerHTML =
		 xmlResponseText ;
		
		ts_makeSortable(document.getElementById('item_list_table'));
		}
		// a HTTP status different than 200 signals an error
		else
		{
		alert("There was a problem accessing the server: " + xmlHttp.statusText);
		}
	}
}

