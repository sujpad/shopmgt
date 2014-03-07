
createXmlHttpRequestObject();

function search_bill()
{
	// proceed only if the xmlHttp object isn't busy
	if (xmlHttp.readyState == 4 || xmlHttp.readyState == 0)
	{
		// retrieve the name typed by the user on the form
		var bill_num = encodeURIComponent(document.getElementById("bill_num").value);
		var bill_amount = encodeURIComponent(document.getElementById("bill_amount").value);
		var customer_name = encodeURIComponent(document.getElementById("customer_name").value);
		var var_date = encodeURIComponent(document.getElementById("date").value);

		xmlHttp.open("GET", "ajax_query/bill_query.php?bill_num=" + bill_num + "&bill_amount=" + bill_amount + "&customer_name=" + customer_name + "&date=" + var_date,  true);
		// define the method to handle server responses
		xmlHttp.onreadystatechange = handleServerResponse_search;
		// make the server request
		xmlHttp.send(null);
	}
	else
		// if the connection is busy, try again after 0.5 seconds
		setTimeout('search_bill()', 500);
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
			xmlResponseText = xmlHttp.responseText;
			document.getElementById("view_bills_table").innerHTML = xmlResponseText;
			ts_makeSortable(document.getElementById('RecentBills'));
		}
		else
		{
			alert("There was a problem accessing the server: " + xmlHttp.statusText);
		}
	}
}

