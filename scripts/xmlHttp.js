
// stores the reference to the XMLHttpRequest object
var xmlHttp = null;
// retrieves the XMLHttpRequest object
function createXmlHttpRequestObject()
{
	if(!xmlHttp)
	{
		// if running Internet Explorer
		if(window.ActiveXObject)
		{
			try
			{
				xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch (e)
			{
				xmlHttp = false;
			}
		}
		// if running Mozilla or other browsers
		else
		{
			try
			{
				xmlHttp = new XMLHttpRequest();
			}
			catch (e)
			{
				xmlHttp = NULL;
			}
		}
		// return the created object or display an error message
		if (!xmlHttp)
			alert("Error creating the XMLHttpRequest object.");
	}
}
