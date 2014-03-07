
var ns6 = document.getElementById &&! document.all
var ie=document.all

createXmlHttpRequestObject();   //Creates only if the object doesn't exist already

var timeoutId = -1;
var timeoutId1 = -1;
var timeoutId2 = -1;
var timeoutId3 = -1;

var add_role;
var message_str;

function validate_add_modify_role(role_name_form, role_perm_form, add_rl)
{
        if( validate_form(role_name_form) )
        {
		add_role = add_rl;
		add_modify_role(role_name_form, role_perm_form, add_role);
		Modalbox.hide();
                return false;
	}
        else
        {
                return false; //return false will not submit the form
        }
}

function add_modify_role(role_name_form, role_perm_form, add_role)
{
        var message_field = document.getElementById('u_message_field');

	var url;
	if( add_role )
	{
		url = "ajax_query/add_rl.php?";
		message_field.innerHTML = "Please wait while we add role" + "<img src='img/wait.gif'/>";
	}
	else
	{
		url = "ajax_query/modify_rl.php?";
		message_field.innerHTML = "Please wait while we modify role" + "<img src='img/wait.gif'/>";
	}

        if (xmlHttp.readyState == 4 || xmlHttp.readyState == 0)
        {
                var inputs = role_name_form.getElementsByTagName('input');
                for( var i=0; i<inputs.length; i++)
                {
                        if(inputs[i].type == 'text' || inputs[i].type == 'password')
                        {
                                url += inputs[i].id + "=" + encodeURIComponent(inputs[i].value) + "&";
                        }
                }

                inputs = role_perm_form.getElementsByTagName('input');
                for( var i=0; i<inputs.length; i++)
                {
			if( inputs[i].type == 'checkbox' && (inputs[i].id.indexOf('_ckb') > -1) )
			{
                                url += inputs[i].id + "=" + inputs[i].checked + "&";
			}
		}

		xmlHttp.open("GET", url, true);
		xmlHttp.onreadystatechange = handleServerResponse_add_modify_role;
		xmlHttp.send(null);
	}
        else
        {
                user_role_name_form = role_name_form;
                user_role_perm_form = role_perm_form;
                user_add_role = add_role;
                // if the connection is busy, try again after 0.5 seconds
                if(timeoutId != -1)
			clearTimeout(timeoutId);
                timeoutId = setTimeout('add_modify_role(user_role_name_form, user_role_perm_form, user_add_role)', 500);
	}
}

function handleServerResponse_add_modify_role()
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
                                        var role_name = xmlResponseText.substring(0, xmlResponseText.indexOf(":"));
					error_field.innerHTML = "Error: '" + role_name + "' already exists";
					message_field.innerHTML = "";
                                }
                                else
                                {
                                        error_field.innerHTML = "Error: " + xmlResponseText;
					message_field.innerHTML = "";
                                }
                                return;
                        }
                        else if(xmlResponseText.indexOf("SHMGT_CHANGE_EFFECT") > -1)
                        {
				message_str = "Modified role successfully. But the changes will take effect only after you logout and login again";
			}
			else
                        {
                                error_field.innerHTML = "";

  				if(add_role)
					message_str = "Added";
				else
					message_str = "Modified";

				message_str += " role '" + xmlResponseText.substr(0, xmlResponseText.indexOf('SUCCESS')-1) + "' successfully";
				update_role_list();
                        }
                }
                // a HTTP status different than 200 signals an error
                else
                {
                        error_field.innerHTML = "Error: There was a problem accessing the server: " + xmlHttp.statusText;
                }
        }
}

function update_role_list()
{
        if (xmlHttp.readyState == 4 || xmlHttp.readyState == 0)
        {
                xmlHttp.open("GET", "ajax_query/update_role_list.php",  true);
                xmlHttp.onreadystatechange = handleServerResponse_update_role_list;
                xmlHttp.send(null);
        }
        else
        {
                if(timeoutId1 != -1)
                        clearTimeout(timeoutId1);
                timeoutId1 = setTimeout('update_role_list()', 500);
        }
}

function handleServerResponse_update_role_list()
{
        if (xmlHttp.readyState == 4)
        {
		var message_field = document.getElementById('u_message_field');
                var error_field = document.getElementById('u_error_field');
                if (xmlHttp.status == 200)
                {
                        var xmlResponseText = xmlHttp.responseText;
                        document.getElementById("role_list_table").innerHTML = xmlResponseText;
                        ts_makeSortable(document.getElementById('RoleList'));
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
                

function delete_role( role_name )
{
        var message_field = document.getElementById('u_message_field');
        message_field.innerHTML = "Please wait while we delete role" + "<img src='img/wait.gif'/>";

	var url = "ajax_query/delete_rl.php?role_name=" + role_name;
        //proceed only if the xmlHttp object isn't busy
        if (xmlHttp.readyState == 4 || xmlHttp.readyState == 0)
        {
		xmlHttp.open("GET", url, true);
		xmlHttp.onreadystatechange = handleServerResponse_delete_role;
		xmlHttp.send(null);
	}
        else
        {
                a_role_name = role_name;
                // if the connection is busy, try again after 0.5 seconds
                if(timeoutId2 != -1)
			clearTimeout(timeoutId2);
		
                timeoutId2 = setTimeout('delete_role()', 500);
        }
}

function handleServerResponse_delete_role()
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
				message_str = "Deleted role '" + xmlResponseText.substr(0, xmlResponseText.indexOf('SUCCESS')-1) + "' successfully";
				update_role_list();
                        }

                }
                // a HTTP status different than 200 signals an error
                else
                {
                        error_field.innerHTML = "Error: There was a problem accessing the server: " + xmlHttp.statusText;
                }
	}
}

function select_unselect_all( check_box_elem )
{
	var parent_checked = check_box_elem.checked;

	var id = check_box_elem.id;
	var prefix_len = id.indexOf("_");
	var prefix = id.substring(0, prefix_len);

	var form_elem = check_box_elem;
	while ( form_elem.tagName != 'FORM' )
	{
		form_elem = ns6? form_elem.parentNode : form_elem.parentElement;
	}

	var inputs = form_elem.getElementsByTagName('input');
	for( var i=0; i<inputs.length; i++)
	{
		if(inputs[i].type == 'checkbox')
		{
			if(inputs[i].id.indexOf(prefix) == 0)
			{
				if(parent_checked)
					inputs[i].checked = 'checked';
				else
					inputs[i].checked = '';
			}
		}
	}
}

function select_unselect_parent(child_elem)
{
	var child_checked = child_elem.checked;

	var id = child_elem.id;
	var prefix_len = id.indexOf("_");
	var prefix = id.substring(0, prefix_len);

	var form_elem = child_elem;
	while ( form_elem.tagName != 'FORM' )
	{
		form_elem = ns6? form_elem.parentNode : form_elem.parentElement;
	}

	var parent_elem;
	var other_children_checked = false;
	var inputs = form_elem.getElementsByTagName('input');
	for( var i=0; i<inputs.length; i++)
	{
		if(inputs[i].type == 'checkbox')
		{
			if(child_checked)
			{
				if(inputs[i].id.indexOf(prefix + '_parent') == 0)
				{
					inputs[i].checked = 'checked';
					break;
				}
			}
			else
			{
				if(inputs[i].id.indexOf(prefix + '_parent' ) == 0)
				{
					parent_elem = inputs[i];
				}
				else if(inputs[i].id.indexOf(prefix) == 0)
				{
					if(inputs[i].checked)
					{
						other_children_checked = true;
					}
				}
			}
		}
	}

	if( !child_checked && !other_children_checked )
	{
		parent_elem.checked = '';
	}
}

function select_dependent(elem, dependent, dependent1)
{
	var dependent_elem1 =  typeof(dependent1) == 'undefined' ? null: document.getElementById(dependent1);
	var dependent_elem = document.getElementById(dependent);
	if( elem.checked )
	{
		dependent_elem.checked = 'checked';
		if( dependent_elem1 )
			dependent_elem1.checked = 'checked';
	}
}

function unselect(elem, unselect, unselect1)
{
	var unselect_elem1 =  typeof(unselect1) == 'undefined' ? null: document.getElementById(unselect1);
	var unselect_elem = document.getElementById(unselect);
	if( !elem.checked )
	{
		unselect_elem.checked = '';
		unselect_elem1.checked = '';
	}
}
