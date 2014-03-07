

function extractPageName(hrefString)
{
	var arr = hrefString.split('.');
	arr = arr[arr.length-2].split('/');
	return arr[arr.length-1].toLowerCase();		
}

function extractPageNameWithExtn(hrefString)
{
	var arr = hrefString.split('/');
	return arr[arr.length-1].toLowerCase();		
}

function setActiveMenu(arr, crtPage)
{
	for(var i=0; i < arr.length; i++)
		if(extractPageName(arr[i].href) == crtPage)
		{
			arr[i].className = "current";
			arr[i].parentNode.className = "current";
		}
}

function setMultActiveMenu(arr, crtPage)
{
	var menu_array = [ 	["item_list.php", "add_item.php", "modify_item.php", "update_item.php", "delete_item.php" , "search_item.php"],
			   	["billing.php", "view_bills.php"],
				["customers.php"],
				["alarms.php"],
				["users.php", "user_roles.php", "change_password.php"]
			 ];

	var current_menu_index;
	for(var i = 0; i < menu_array.length ; i++ )
	{
		for( var j = 0 ; j < menu_array[i].length; j++ )
		{
			//if(menu_array[i][j] == crtPage)
			if(crtPage.indexOf(menu_array[i][j]) > -1)
			{
				current_menu_index = i;
				break;
			}
		}
	}

	for( var i = 0 ; i < arr.length; i++ )
	{
		for( var j = 0; j < menu_array[i].length; j++ )
		{
			if(extractPageNameWithExtn(arr[i].href) == menu_array[current_menu_index][j])
			{
				arr[i].className = "current";
				arr[i].parentNode.className = "current";
				break;
			}
		}
	}
}


function setPage()
{
	if(document.location.href) 
		hrefString = document.location.href;
	else
		hrefString = document.location;

	if (document.getElementById("menu")!=null) 
		setActiveMenu(document.getElementById("menu").getElementsByTagName("a"), extractPageName(hrefString));
}

function setMainMenu()
{
	if(document.location.href) 
	{
		hrefString = document.location.href;
	}
	else
	{
		hrefString = document.location;
	}

	if (document.getElementById("main_menu")!=null) 
	{
		setMultActiveMenu(document.getElementById("main_menu").getElementsByTagName("a"), extractPageNameWithExtn(hrefString));
	}
}
