/* ----------  [ Generate bill ----------------------*/

createXmlHttpRequestObject();   //Creates only if the object doesn't exist already

var timeoutId1 = -1;
var timeoutId2 = -1;
var timeoutId3 = -1;

function generate_bill()
{
        if (xmlHttp.readyState == 4 || xmlHttp.readyState == 0)
        {
                var bill_amount = document.getElementById('bill_amount');

                var billed_items = document.getElementById('BillingTable');
                var rows = billed_items.getElementsByTagName('TR');

		var customer_name = document.getElementById('customer_name').value;

                var to_bill = bill_amount.innerHTML + ",";
                var row_length = rows.length;
                //FOOTER LENGTH
                for( var i = 1 ; i < row_length; i++ )
                {
                        var cells = rows[i].getElementsByTagName('TD');
                        to_bill += cells[enum_id].innerHTML + "," + cells[enum_quantity].innerHTML + ",";
                }

                xmlHttp.open("GET", "ajax_query/generate_bill.php?customer_name=" + customer_name + "&to_bill=" + to_bill,  false);
                //xmlHttp.onreadystatechange = handleServerResponse_bill;
                xmlHttp.send(null);

		if( customer_name != "" )
		{
			addNewWordToCache(customer_name);
		}

 		var response = xmlHttp.responseText;
                if (response.indexOf("ERRNO") >= 0
                        || response.indexOf("error:") >= 0
                        || response.length == 0)
       		{ 
       			//alert("Void server response : " +  response);
			var error_field = document.getElementById('u_error_field');
        		error_field.innerHTML = "Void server response : " +  response;
		}
	
		var customer_name = "";
		var bill_num = "";
		var bill_amount = "";
		var bill_date = "";
		
		response = xmlHttp.responseXML.documentElement;
		if(response.childNodes.length)
        	{
			var customer_name_dom = response.getElementsByTagName('customer_name');
			if(customer_name_dom.item(0).childNodes.length)
				customer_name = customer_name_dom.item(0).firstChild.nodeValue;
			var bill_num_dom = response.getElementsByTagName('bill_num');
			if(bill_num_dom.item(0).childNodes.length)
				bill_num = bill_num_dom.item(0).firstChild.nodeValue;
			var bill_amount_dom = response.getElementsByTagName('bill_amount');
			if(bill_amount_dom.item(0).childNodes.length)
				bill_amount = bill_amount_dom.item(0).firstChild.nodeValue;
			var bill_date_dom = response.getElementsByTagName('date');
			if(bill_date_dom.item(0).childNodes.length)
				bill_date = bill_date_dom.item(0).firstChild.nodeValue;
		}

		var table_data = extract_billed_data();

		//Call update_bills() before opening modalbox
		update_bills();

		Modalbox.show('display_bill.php?customer_name=' + customer_name + '&bill_num=' + bill_num + '&bill_amount=' + bill_amount + '&bill_date=' + bill_date + '&table_data=' + table_data, {title: 'Invoice', width:600, height:370 });
		
		delete_all('BillingTable');
		document.getElementById('customer_name').value = "";
		document.getElementById('gb_message_field').innerHTML = "";
        }
}

function update_bills()
{
        if (xmlHttp.readyState == 4 || xmlHttp.readyState == 0)
        {
                xmlHttp.open("GET", "ajax_query/update_bills.php",  true);
                xmlHttp.onreadystatechange = handleServerResponse_update_bills;
                xmlHttp.send(null);
        }
        else
	{
		if(timeoutId2 != -1)
			clearTimeout(timeoutId2);
                timeoutId2 = setTimeout('update_bills()', 500);
	}
}

function handleServerResponse_update_bills()
{
	if (xmlHttp.readyState == 4)
	{
		if (xmlHttp.status == 200)
		{
			var xmlResponseText = xmlHttp.responseText;
			var table_elem = document.getElementById("bill_table");
			table_elem.innerHTML = xmlResponseText;
			ts_makeSortable(document.getElementById('RecentBills'));

			update_stocks();
		}
		// a HTTP status different than 200 signals an error
		else
		{
			//alert("There was a problem accessing the server: " + xmlHttp.statusText);
			var error_field = document.getElementById('u_error_field');
        		error_field.innerHTML = "There was a problem accessing the server: " + xmlHttp.statusText;
		}
	}
}

function update_stocks()
{
        if (xmlHttp.readyState == 4 || xmlHttp.readyState == 0)
        {
                xmlHttp.open("GET", "ajax_query/stock_query.php?id=&item_name=",  true);
                xmlHttp.onreadystatechange = handleServerResponse_update_stocks;
                xmlHttp.send(null);
        }
        else
	{
		if(timeoutId3 != -1)
			clearTimeout(timeoutId3);
                timeoutId3 = setTimeout('update_stocks()', 500);
	}
}

function handleServerResponse_update_stocks()
{
	if (xmlHttp.readyState == 4)
	{
		if (xmlHttp.status == 200)
		{
			var xmlResponseText = xmlHttp.responseText;
			var table_elem = document.getElementById("stock_list_table");
			table_elem.innerHTML = xmlResponseText;
			ts_makeSortable(document.getElementById('item_list_table'));
		}
		// a HTTP status different than 200 signals an error
		else
		{
			//alert("There was a problem accessing the server: " + xmlHttp.statusText);
			var error_field = document.getElementById('u_error_field');
        		error_field.innerHTML = "There was a problem accessing the server: " + xmlHttp.statusText;
		}
	}
}

function extract_billed_data()
{
	var table_data_str = "";
	table_elem = document.getElementById('BillingTable');

	rows = table_elem.getElementsByTagName('TR');
	
	//FOOTER LENGTH
	for(var i=1; i < rows.length ; i++)
	{
		/*if( i == 0 )
			cells = rows[i].getElementsByTagName('TH');
		else
		*/
		cells = rows[i].getElementsByTagName('TD');

		for( var j=1; j<cells.length - 1; j++)	//Skip ID and delete button 
		{
			table_data_str += cells[j].innerHTML + ",";
		}
		table_data_str = table_data_str.substring(0, table_data_str.length-1);	//Strip off extra ','
		table_data_str += ';';
	}
	table_data_str = table_data_str.substring(0, table_data_str.length-1);	//Strip off extra ';'
	return table_data_str;
}
/* ----------   Generate bill ] ----------------------*/
