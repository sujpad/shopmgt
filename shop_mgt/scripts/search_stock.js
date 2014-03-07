
var enum_id = 0;
var enum_quantity = 3;

createXmlHttpRequestObject();

function search_stock()
{
	// proceed only if the xmlHttp object isn't busy
	if (xmlHttp.readyState == 4 || xmlHttp.readyState == 0)
	{
		// retrieve the name typed by the user on the form
		var id = encodeURIComponent(document.getElementById("id").value);
		var item_name = encodeURIComponent(document.getElementById("item_name").value);
		xmlHttp.open("GET", "ajax_query/stock_query.php?item_name=" + item_name + "&id=" + id,  true);
		// define the method to handle server responses
		xmlHttp.onreadystatechange = handleServerResponse_search;
		// make the server request
		xmlHttp.send(null);
	}
	else
		// if the connection is busy, try again after 0.5 seconds
		setTimeout('search_stock()', 500);
}

// executed automatically when a message is received from the server
function handleServerResponse_search()
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
		document.getElementById("stock_list_table").innerHTML =
		 xmlResponseText;
		ts_makeSortable(document.getElementById('item_list_table'));
		// restart sequence
		}
		// a HTTP status different than 200 signals an error
		else
		{
			alert("There was a problem accessing the server: " + xmlHttp.statusText);
		}
	}
}

