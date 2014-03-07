
createXmlHttpRequestObject();   //Creates only if the object doesn't exist already

var timeoutId = -1;
var timeoutId1 = -1;
var timeoutId2 = -1;
var timeoutId3 = -1;

var message_str;

function validate_change_password(form_elem)
{
	if( validate_form(form_elem) )
	{
		change_password(form_elem);
		return false;
	}
	else
	{
		return false;
	}
}

function change_password(form_elem)
{
	var message_field = document.getElementById('submit_message');
	message_field.innerHTML = "Please wait while we change password" + "<img src='img/wait.gif'/>";	

	var url = "ajax_query/change_passwd.php?";
        //proceed only if the xmlHttp object isn't busy
        if (xmlHttp.readyState == 4 || xmlHttp.readyState == 0)
        {
		var old_passwd, new_passwd;
		var inputs = form_elem.getElementsByTagName('input');
		for( var i=0; i<inputs.length; i++)
        	{
			if(inputs[i].id == 'old_password')
				old_passwd = inputs[i].value;
			else if( inputs[i].id == 'new_password')
				new_passwd = inputs[i].value;
		}
		
		url += "old_password=" + encodeURIComponent(old_passwd);
		url += "&new_password=" + encodeURIComponent(new_passwd);

	
		xmlHttp.open("GET", url,  false);
		xmlHttp.send(null);
		
		var error_field = document.getElementById('submit_validate');
		var message_field = document.getElementById('submit_message');
		var xmlResponseText = xmlHttp.responseText;
		if(xmlResponseText != "SUCCESS")
		{
			error_field.innerHTML = "Error: " + xmlResponseText;
			message_field.innerHTML = "";
		}
		else
		{
			error_field.innerHTML = "" ;
			message_field.innerHTML = "Changed password successfully";
		}
	}
}

function enable_disable_user(user_name, enable)
{
	var message_field = document.getElementById('u_message_field');
	message_field.innerHTML = "Please wait while we enable/disable user" + "<img src='img/wait.gif'/>";	

	var url = "ajax_query/enable_disable_user.php?";
        //proceed only if the xmlHttp object isn't busy
        if (xmlHttp.readyState == 4 || xmlHttp.readyState == 0)
        {

		url += "user_name=" + user_name; 
		url += "&enable=" + enable; 

		xmlHttp.open("GET", url,  false);
		xmlHttp.send(null);

		var error_field = document.getElementById('u_error_field');
		var message_field = document.getElementById('u_message_field');
		
		var responseText = xmlHttp.responseText;
		if(responseText != "SUCCESS")
		{
			error_field.innerHTML = "Error: " + responseText;
			message_field.innerHTML = "";
		}
		else
		{
			error_field.innerHTML = "" ;
			if(enable)
				message_str = "'" + user_name + "' is enabled";
			else
				message_str = "'" + user_name + "' is disabled";

			update_user_list();
		}
	}	
}

function validate_add_user(form_elem)
{
        if( validate_form(form_elem) )
        {
		add_user(form_elem);
		Modalbox.hide();
                return false;
	}
        else
        {
                return false; //return false will not submit the form
        }
}

function add_user(form_elem)
{
	var message_field = document.getElementById('u_message_field');
	message_field.innerHTML = "Please wait while we add user" + "<img src='img/wait.gif'/>";	

	var url = "ajax_query/add_usr.php?";

        if (xmlHttp.readyState == 4 || xmlHttp.readyState == 0)
        {
                inputs = form_elem.getElementsByTagName('input');
                for( var i=0; i<inputs.length; i++)
                {
                        if(inputs[i].type == 'text' || inputs[i].type == 'password')
                        {
                                url += inputs[i].id + "=" + encodeURIComponent(inputs[i].value) + "&";
                        }
			else if(inputs[i].type == 'checkbox')
			{
                                url += inputs[i].id + "=" + inputs[i].checked + "&";
			}
                }

		select = form_elem.getElementsByTagName('select');
		url += "a_user_role=" + select[0].value;

		xmlHttp.open("GET", url, true);
		xmlHttp.onreadystatechange = handleServerResponse_add_user;
		xmlHttp.send(null);
	}
        else
        {
                user_form_elem = form_elem;
                // if the connection is busy, try again after 0.5 seconds
                if(timeoutId != -1)
			clearTimeout(timeoutId);
                timeoutId = setTimeout('add_user(user_form_elem)', 500);
	}
}

function handleServerResponse_add_user()
{
        if (xmlHttp.readyState == 4)
        {
		var error_field = document.getElementById('u_error_field');
		var message_field = document.getElementById('u_message_field');

                if (xmlHttp.status == 200)
                {

                        var xmlResponseText = xmlHttp.responseText;
                        if(xmlResponseText.indexOf("SUCCESS") < 2) //Response will be user_name:SUCCESS
                        {
                                if( xmlResponseText.indexOf("Duplicate entry") != -1 )
                                {
                                        var user_name = xmlResponseText.substring(0, xmlResponseText.indexOf(":"));
					error_field.innerHTML = "Error: '" + user_name + "' already exists";
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
				message_str = "Added user '" + xmlResponseText.substr(0, xmlResponseText.indexOf('SUCCESS')-1) + "' successfully";
				update_user_list();
                        }

                }
                // a HTTP status different than 200 signals an error
                else
                {
                        error_field.innerHTML = "Error: There was a problem accessing the server: " + xmlHttp.statusText;
                }
        }
}

function update_user_list()
{
        if (xmlHttp.readyState == 4 || xmlHttp.readyState == 0)
        {
                xmlHttp.open("GET", "ajax_query/update_user_list.php",  true);
                xmlHttp.onreadystatechange = handleServerResponse_update_user_list;
                xmlHttp.send(null);
        }
        else
        {
                if(timeoutId1 != -1)
                        clearTimeout(timeoutId1);
                timeoutId1 = setTimeout('update_user_list()', 500);
        }
}

function handleServerResponse_update_user_list()
{
        if (xmlHttp.readyState == 4)
        {
                var error_field = document.getElementById('u_error_field');
                var message_field = document.getElementById('u_message_field');
                if (xmlHttp.status == 200)
                {
                        var xmlResponseText = xmlHttp.responseText;
                        document.getElementById("user_list_table").innerHTML = xmlResponseText;
                        ts_makeSortable(document.getElementById('UserList'));
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
                

function delete_user( user_name )
{
	var message_field = document.getElementById('u_message_field');
	message_field.innerHTML = "Please wait while we delete user" + "<img src='img/wait.gif'/>";	

	var url = "ajax_query/delete_usr.php?user_name=" + user_name;
        //proceed only if the xmlHttp object isn't busy
        if (xmlHttp.readyState == 4 || xmlHttp.readyState == 0)
        {
		xmlHttp.open("GET", url, true);
		xmlHttp.onreadystatechange = handleServerResponse_delete_user;
		xmlHttp.send(null);
	}
        else
        {
                a_user_name = user_name;
                // if the connection is busy, try again after 0.5 seconds
                if(timeoutId2 != -1)
			clearTimeout(timeoutId2);
		
                timeoutId2 = setTimeout('delete_user()', 500);
        }
}

function handleServerResponse_delete_user()
{
        if (xmlHttp.readyState == 4)
	{
		var error_field = document.getElementById('u_error_field');
		var message_field = document.getElementById('u_message_field');

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
				update_user_list();
                        }

                }
                // a HTTP status different than 200 signals an error
                else
                {
                        error_field.innerHTML = "Error: There was a problem accessing the server: " + xmlHttp.statusText;
                }
	}
}

function togglePasswordField( modify_password )
{
	elem = document.getElementById('a_password');
	elem.disabled = !modify_password;
	if(modify_password) 
		elem.className = "";
	else
		elem.className = "optional";
}


function validate_modify_user(form_elem)
{
        if( validate_form(form_elem) )
        {
		modify_user(form_elem);
		Modalbox.hide();
                return false;
	}
        else
        {
                return false; //return false will not submit the form
        }
}




function modify_user(form_elem)
{
	var message_field = document.getElementById('u_message_field');
	message_field.innerHTML = "Please wait while we modify user" + "<img src='img/wait.gif'/>";	

	var url = "ajax_query/modify_usr.php?";
	var user_name = "";

        if (xmlHttp.readyState == 4 || xmlHttp.readyState == 0)
        {
                inputs = form_elem.getElementsByTagName('input');
                for( var i=0; i<inputs.length; i++)
                {
                        if(inputs[i].type == 'text' || inputs[i].type == 'password')
                        {
				if(inputs[i].id.indexOf('user_name') != -1) 
					user_name = inputs[i].value;		
                                url += inputs[i].id + "=" + encodeURIComponent(inputs[i].value) + "&";
                        }
			else if(inputs[i].type == 'checkbox')
			{
                                url += inputs[i].id + "=" + inputs[i].checked + "&";
			}
                }

		select = form_elem.getElementsByTagName('select');
		url += "a_user_role=" + select[0].value;

		xmlHttp.open("GET", url, true);
		xmlHttp.onreadystatechange = handleServerResponse_modify_user;
		xmlHttp.send(null);
	}
        else
        {
                user_form_elem = form_elem;
                // if the connection is busy, try again after 0.5 seconds
                if(timeoutId3 != -1)
			clearTimeout(timeoutId3);
                timeoutId3 = setTimeout('modify_user(user_form_elem)', 500);
	}
}



function handleServerResponse_modify_user()
{
        if (xmlHttp.readyState == 4)
        {
		var error_field = document.getElementById('u_error_field');
		var message_field = document.getElementById('u_message_field');

                if (xmlHttp.status == 200)
                {

                        var xmlResponseText = xmlHttp.responseText;
                        if(xmlResponseText.indexOf("SUCCESS") < 2) //Response will be user_name:SUCCESS
                        {
                                if( xmlResponseText.indexOf("Duplicate entry") != -1 )
                                {
                                        var user_name = xmlResponseText.substring(0, xmlResponseText.indexOf(":"));
					error_field.innerHTML = "Error: '" + user_name + "' already exists";
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
				message_str = "Modified user '" + xmlResponseText.substr(0, xmlResponseText.indexOf('SUCCESS')-1) + "' successfully";
				update_user_list();
                        }

                }
                // a HTTP status different than 200 signals an error
                else
                {
                        error_field.innerHTML = "Error: There was a problem accessing the server: " + xmlHttp.statusText;
                }
        }
}
