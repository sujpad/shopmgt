
var ns6 = document.getElementById &&! document.all
var ie=document.all

createXmlHttpRequestObject();	//Creates only if the object doesn't exist already

/*function clear_bill_details()
{
	elem = document.getElementById("bill_details");
	elem.className = "hide";
	document.getElementById("bill_details_table").innerHTML = "";
}
*/

function show_bill_details(elem)
{
	var row_elem;
	if( elem.tagName != "TR" )
		row_elem=ns6? elem.parentNode : elem.parentElement;
	else
		row_elem = elem;
		
	var enum_bill_num = 0;
	var enum_bill_amount = 1;
	var enum_customer_name = 2;
	var enum_bill_date = 3;

	var cells = row_elem.getElementsByTagName("TD");
	var bill_num = cells[enum_bill_num].innerHTML;
	var bill_amount = cells[enum_bill_amount].innerHTML;
	var customer_name = cells[enum_customer_name].innerHTML;
	var bill_date = cells[enum_bill_date].innerHTML;

        // proceed only if the xmlHttp object isn't busy
        if (xmlHttp.readyState == 4 || xmlHttp.readyState == 0)
        {
                xmlHttp.open("GET", "ajax_query/bill_details.php?bill_num=" + bill_num ,  false);
                // define the method to handle server responses
                //xmlHttp.onreadystatechange = handleServerResponse_bill_details;
                // make the server request
                xmlHttp.send(null);
		var table_data = xmlHttp.responseText;
		
                Modalbox.show('display_bill.php?customer_name=' + customer_name + '&bill_num=' + bill_num + '&bill_amount=' + bill_amount + '&bill_date=' + bill_date + '&table_data=' + table_data, {title: 'Invoice', width:600, height:370 });
        }
        /*else
	{
		var user_row_elem = row_elem;
                // if the connection is busy, try again after 0.5 seconds
                setTimeout('show_bill_details(user_row_elem)', 500);
	}
	*/
}

/*
function handleServerResponse_bill_details()
{
        if (xmlHttp.readyState == 4)
        {
                if (xmlHttp.status == 200)
                {
                        var xmlResponseText = xmlHttp.responseText;

			elem = document.getElementById("bill_details");
			elem.className = "";
			document.getElementById("bill_details_table").innerHTML = xmlResponseText;
			ts_makeSortable(document.getElementById('BillDetails'));

                }
                // a HTTP status different than 200 signals an error
                else
                {
                        alert("There was a problem accessing the server: " + xmlHttp.statusText);
                }
        }
}
*/

