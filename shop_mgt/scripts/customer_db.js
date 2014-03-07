
createXmlHttpRequestObject();   //Creates only if the object doesn't exist already

var timeoutId1 = -1;
var timeoutId2 = -1;
var timeoutId3 = -1;
var timeoutId4 = -1;

var message_str;
var billing;

function validate_add_hideform(form_elem, billing_flag)
{
        if( validate_form(form_elem) )
        {
		billing = billing_flag;
		add_customer(form_elem, billing);
                Modalbox.hide();
                return false;
        }
        else
        {
                return false; //return false will not submit the form
        }
}

function validate_edit_hideform(form_elem)
{
        if( validate_form(form_elem) )
        {
                edit_customer(form_elem);
                Modalbox.hide();
                return false;
        }
        else
        {
                return false; //return false will not submit the form
        }
}

function add_customer(elem, billing)
{
	if(billing)
	{
		addNewWordToCache(document.getElementById('a_customer_name').value);
	}
	else
	{
		var message_field = document.getElementById('c_message_field');
		message_field.innerHTML = "Please wait while we add customer" + "<img src='img/wait.gif'/>";
	}

        var url = "ajax_query/add_cust.php?";
        // proceed only if the xmlHttp object isn't busy
        if (xmlHttp.readyState == 4 || xmlHttp.readyState == 0)
        {
                inputs = elem.getElementsByTagName('input');
                for( var i=0; i<inputs.length; i++)
                {
                        if(inputs[i].type == 'text')
                        {
                                url += inputs[i].id + "=" + encodeURIComponent(inputs[i].value) + "&";
                        }
                }

                //xmlHttp.open("GET", "add_cust.php?item_id=" + item_id + "&quantity_needed=" + quantity_needed,  true);
                xmlHttp.open("GET", url,  true);
                // define the method to handle server responses
                xmlHttp.onreadystatechange = handleServerResponse_add_customer;
                // make the server request
                xmlHttp.send(null);
        }
        else
	{
		user_add_elem = elem;
		user_billing = billing;
                // if the connection is busy, try again after 0.5 seconds
                if(timeoutId1 != -1)
                        clearTimeout(timeoutId1);
                timeoutId1 = setTimeout('add_customer(user_add_elem, user_billing)', 500);
   	}
}

function handleServerResponse_add_customer()
{
        if (xmlHttp.readyState == 4)
        {
		var error_field, message_field;
		if( document.getElementById('c_error_field') )
		{
			error_field = document.getElementById('c_error_field');
			message_field = document.getElementById('c_message_field');
		}
		else
		{
			error_field = document.getElementById('customer_name_validate');
			message_field = document.getElementById('gb_message_field');
		}

                if (xmlHttp.status == 200)
                {

                        var xmlResponseText = xmlHttp.responseText;
                        if(xmlResponseText.indexOf("SUCCESS") < 2)
			{
				if( xmlResponseText.indexOf("Duplicate entry") != -1 )
				{
					var customer_name = xmlResponseText.substring(0, xmlResponseText.indexOf(":"));
					error_field.innerHTML = "Error: '" + customer_name + "' already exists";
					message_field.innerHTML = "";
				}
				else 
				{
					error_field.innerHTML = "Error: " + xmlResponseText; 
					message_field.innerHTML = "";
				}
				return;
			}
			else
			{
				error_field.innerHTML = "";
				if( billing )
				{
					message_field.innerHTML = "Added customer '" + xmlResponseText.substr(0, xmlResponseText.indexOf('SUCCESS')-1) + "' successfully";
				}
				else
				{
					message_str = "Added customer '" + xmlResponseText.substr(0, xmlResponseText.indexOf('SUCCESS')-1) + "' successfully";
					update_customer_list();
				}
			}
				
                }
                // a HTTP status different than 200 signals an error
                else
                {
			error_field.innerHTML = "Error: There was a problem accessing the server: " + xmlHttp.statusText;
			message_field.innerHTML = "";
                }
        }
}

function edit_customer(elem)
{
	var message_field = document.getElementById('c_message_field');
	message_field.innerHTML = "Please wait while we modify customer" + "<img src='img/wait.gif'/>";

        var url = "ajax_query/edit_cust.php?";
        // proceed only if the xmlHttp object isn't busy
        if (xmlHttp.readyState == 4 || xmlHttp.readyState == 0)
        {
                inputs = elem.getElementsByTagName('input');
                for( var i=0; i<inputs.length; i++)
                {
                        if(inputs[i].type == 'text')
                        {
                                url += inputs[i].id + "=" + encodeURIComponent(inputs[i].value) + "&";
                        }
                }

                //xmlHttp.open("GET", "edit_cust.php?item_id=" + item_id + "&quantity_needed=" + quantity_needed,  true);
                xmlHttp.open("GET", url,  true);
                // define the method to handle server responses
                xmlHttp.onreadystatechange = handleServerResponse_edit_customer;
                // make the server request
                xmlHttp.send(null);
        }
        else
	{
		user_edit_elem = elem;
                // if the connection is busy, try again after 0.5 seconds
                if(timeoutId2 != -1)
                        clearTimeout(timeoutId2);
                timeoutId2 = setTimeout('edit_customer(user_edit_elem)', 500);
        }
}

function handleServerResponse_edit_customer()
{
        if (xmlHttp.readyState == 4)
        {
		var error_field = document.getElementById('c_error_field');
		var message_field = document.getElementById('c_message_field');
                if (xmlHttp.status == 200)
                {
                        var xmlResponseText = xmlHttp.responseText;
                        if(xmlResponseText.indexOf("SUCCESS") < 2) //Response will be customer_name:SUCCESS
			{
				error_field.innerHTML = "Error: " + xmlResponseText;
				message_field.innerHTML = "";
				return;
			}
			else
			{
				error_field.innerHTML = "";
				message_str = "Modified customer '" + xmlResponseText.substr(0, xmlResponseText.indexOf('SUCCESS')-1) + "' successfully";
				update_customer_list();
			}
                }
                // a HTTP status different than 200 signals an error
                else
                {
			error_field.innerHTML = "Error: There was a problem accessing the server: " + xmlHttp.statusText;
			message_field.innerHTML = "";
                }
        }
}


function update_customer_list()
{
        if (xmlHttp.readyState == 4 || xmlHttp.readyState == 0)
        {
                xmlHttp.open("GET", "ajax_query/update_customer_list.php",  true);
                xmlHttp.onreadystatechange = handleServerResponse_update_customer_list;
                xmlHttp.send(null);
        }
        else
	{
                if(timeoutId3 != -1)
                        clearTimeout(timeoutId3);
                timeoutId3 = setTimeout('update_customer_list()', 500);
	}
}


function handleServerResponse_update_customer_list()
{
        if (xmlHttp.readyState == 4)
        {
		var error_field = document.getElementById('c_error_field');
		var message_field = document.getElementById('c_message_field');
                if (xmlHttp.status == 200)
                {
                        var xmlResponseText = xmlHttp.responseText;
			document.getElementById("customer_list_table").innerHTML = xmlResponseText;
			ts_makeSortable(document.getElementById('CustomerList'));
			error_field.innerHTML = "";
			message_field.innerHTML = message_str;
                }
                // a HTTP status different than 200 signals an error
                else
                {
			error_field.innerHTML = "Error: There was a problem accessing the server: " + xmlHttp.statusText;
			message_field.innerHTML = "";
                }
        }
}


function delete_customer(customer_name, customer_id)
{
	var message_field = document.getElementById('c_message_field');
	message_field.innerHTML = "Please wait while we delete customer" + "<img src='img/wait.gif'/>";

        var url = "ajax_query/delete_cust.php?customer_name=" + customer_name + "&customer_id=" + customer_id;
        // proceed only if the xmlHttp object isn't busy
        if (xmlHttp.readyState == 4 || xmlHttp.readyState == 0)
        {
                xmlHttp.open("GET", url, true);
                xmlHttp.onreadystatechange = handleServerResponse_delete_customer;
                xmlHttp.send(null);
        }
        else
	{
		user_delete_elem = elem;
                // if the connection is busy, try again after 0.5 seconds
                if(timeoutId4 != -1)
                        clearTimeout(timeoutId4);
                timeoutId4 = setTimeout('delete_customer(user_delete_elem)', 500);
        }
}

function handleServerResponse_delete_customer()
{
        if (xmlHttp.readyState == 4)
        {
                var error_field = document.getElementById('c_error_field');
                var message_field = document.getElementById('c_message_field');

                if (xmlHttp.status == 200)
                {

                        var xmlResponseText = xmlHttp.responseText;
                        if(xmlResponseText.indexOf("SUCCESS") < 2)
                        {
                                error_field.innerHTML = "Error: " + xmlResponseText;
                                message_field.innerHTML = "";
                                return;
                        }
                        else
                        {
                                error_field.innerHTML = "";
                                message_str = "Deleted user '" + xmlResponseText.substr(0, xmlResponseText.indexOf('SUCCESS')-1) + "' successfully";
;
				update_customer_list();
                        }

                }
                else
                {
                        error_field.innerHTML = "Error: There was a problem accessing the server: " + xmlHttp.statusText;
			message_field.innerHTML = "";
                }
        }
}
