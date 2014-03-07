
var ns6 = document.getElementById &&! document.all
var ie=document.all

/*Billing table's column idices*/
enum_id = 0;
enum_item_name = 1;
enum_price = 2;
enum_quantity = 3;
enum_total = 4;
enum_del = 5;
BILLED_ITEMS_COL_COUNT = 6;

ITEMS_IN_STOCK_COL_COUNT = 5;

/*Stock table column index */
enum_item_name = 1;
enum_count = 2;

var previous_highlighted_row = null;

function changeto(e)
{
	source=ie? event.srcElement : e.target
	if (source.tagName=="TABLE")
		return;
	/*if (source.tagName!="TR" && source.tagName!="HTML")
		source=ns6? source.parentNode : source.parentElement;*/
	
	while( source.tagName!="TR" )
	{
		source=ns6? source.parentNode : source.parentElement;
	}
	
	if (source.className!='highlighted'&&source.className!="donot_highlight")
	{
		source.className = 'highlighted';
		previous_highlighted_row = source;
	}

}

function changeback(e)
{
	if (ie && source.className=="donot_highlight")
		return
	else if (ns6&&source.className=="donot_highlight")
		return
	else
	{
		if(source.tagName == "TR")
			source.className = 'not_highlighted';
	}
}

function changeback_previous()
{
	if(previous_highlighted_row)
	{
		previous_highlighted_row.className = 'not_highlighted';
	}
}

function delete_row(evt)
{
	elem = ie? event.srcElement : evt.target;
	while ( elem.tagName != "TR" )
	{
		//elem = ns6? elem.parentNode : elem.parentElement;
		elem = elem.parentNode;
	}

	//Clear error for this item, if exists [
	cells = elem.getElementsByTagName("TD");

	var item_name = cells[enum_item_name].innerHTML;

	var error_field = document.getElementById('gb_error_field');
	var message_field = document.getElementById('gb_message_field');
	if( error_field.innerHTML.indexOf(item_name) != -1 )
	{
		error_field.innerHTML = "";
		message_field.innerHTML = "";
	}
	//Clear error for this item, if exists ]

	var index = elem.rowIndex;

	table_elem = ns6? elem.parentNode.parentNode: elem.parentElement.parentElement;
	table_elem.deleteRow(index);
	calculate_grand_total();
}

function delete_all(table)
{
	//Clear error string if exists.
	error_field = document.getElementById('gb_error_field');
	error_field.innerHTML = "";

	table_elem = document.getElementById(table);
	rows = table_elem.getElementsByTagName("TR");
	len = rows.length;
	for( var i = 1; i < len ; i++ )
	{
		table_elem.deleteRow(1);	
	}
	calculate_grand_total();
}

function calculate_total(row_elem, total)
{
	cells = row_elem.getElementsByTagName("TD");
	cell_elem = cells[enum_total];
	//var total = parseInt(cells[enum_quantity].innerHTML, 10) * parseInt(cells[enum_price].innerHTML, 10);
	//cell_elem.innerHTML = total.toFixed(2) ;
	cell_elem.innerHTML = total;
	calculate_grand_total();
}

function calculate_grand_total()
{
        var grand_total = 0.00;
        table_elem = document.getElementById("BillingTable");
        rows = table_elem.getElementsByTagName("TR");
        for( var i = 1 ; i < rows.length; i++ )
        {
                cells = rows[i].getElementsByTagName("TD");
                grand_total += parseFloat(cells[enum_total].innerHTML);
        }

	cell = document.getElementById('bill_amount'); 
	cell.innerHTML = grand_total.toFixed(2);
}

function edit_cell(evt)
{
	      //' ONMOUSEOUT="setCell(this.parentElement, this.value)" ' +
	cell=ie? event.srcElement : evt.target
	if (document.all) {
	    cell.innerHTML =
	      '<INPUT ' +
	      ' ID="editCell"' +
	      ' ONCLICK="event.cancelBubble = true;"' + 
	      ' ONCHANGE="setCell(this.parentElement, this.value)" ' +
	      ' VALUE="' + cell.innerText + '"' +
	      ' SIZE="' + cell.innerText.length + '"' +
	      '>';
	    document.all.editCell.focus();
	    document.all.editCell.select();
	}
	else if (document.getElementById) {
	    cell.normalize();
	    var input = document.createElement('INPUT');
	    input.setAttribute('value', cell.firstChild.nodeValue);
	    input.setAttribute('size', cell.firstChild.nodeValue.length);
	    input.onchange = function (evt) { setCell(this.parentNode, this.value); };
	    //input.onmouseout = function (evt) { setCell(this.parentNode, this.value); };
	    input.onclick = function (evt) { 
	      evt.cancelBubble = true;
	      if (evt.stopPropagation)
		evt.stopPropagation();
	   };
	    cell.replaceChild(input, cell.firstChild);
	    input.focus();
	    input.select();
	}
	//edited_cell = true;
}

function setCell (cell, value ) 
{
	//if(edited_cell)
	{
		row = ns6? cell.parentNode : cell.parentElement;
		cells = row.getElementsByTagName("TD");
		//Get the item_id
		item_id = cells[0].innerHTML;

		//Check if there is enough stock
		var total = isStockPresent(item_id, value);
		if(  total == -1 )
		{
			//no stock
			return;
		}
		else
		{

			//edited_cell = false;
			//Allow quantity to be set only if there is stock
			if (document.all)
			{
				cell.innerText = value;
			}
			else if (document.getElementById)
			{
				cell.innerHTML = value;
			}

			calculate_total(cell.parentNode, total);
		}
	}
}

function insert_row(row_elem)
{

	target_table_elem = document.getElementById('BillingTable');

	add_this_row(row_elem, target_table_elem);

	calculate_grand_total();
}

function insert_all(elem, target_table)
{
	target_table_elem = document.getElementById(target_table);

	while( elem.tagName != 'TABLE' )
	{
		elem = ns6? elem.parentNode : elem.parentElement;
	}

	var rows = elem.getElementsByTagName("TR");
	var row_count = rows.length;

	for( row_id = 1; row_id < row_count; row_id++ )
	{
		add_this_row( rows[row_id] , target_table_elem );
	}
	calculate_grand_total();
}

function add_this_row( row_elem, target_table )
{
	var cells = row_elem.getElementsByTagName("TD");

	var t_rows = target_table.getElementsByTagName('tr');

	//Check if the item is already added
	item_present = false;
	for ( var i = 1 ; i < t_rows.length ; i++ )
	{
		t_cells = t_rows[i].getElementsByTagName('TD');	
		if( t_cells[enum_id].innerHTML == cells[0].innerHTML )
		{
			item_present = true;
			break;
		}
	}

	if(item_present)
	{
		document.getElementById('gb_error_field').innerHTML = "'" + cells[1].innerHTML + "' is already added";
		return;
	}
	else
		document.getElementById('gb_error_field').innerHTML = "";


	//FOOTER LENGTH
	var t_row_index = t_rows.length;
	var new_row = target_table.insertRow(t_row_index);

	//Read all the parameters of the item to be billed
	var item = new Object();
	for ( var j = 0 ; j < ITEMS_IN_STOCK_COL_COUNT-1 ; j++ )
	{
		switch (j)
		{
			case 0:
				item.id = cells[j].innerHTML;
				break;
			case 1:
				item.name = cells[j].innerHTML;
				break;
			case 2:
				item.count = cells[j].innerHTML;
				break;
			case 3: 
				item.price = cells[j].innerHTML;
				break;
			default:
				break;
		} 
	}



	for ( var i = enum_id; i < BILLED_ITEMS_COL_COUNT;  i++)
	{
		var new_cell = new_row.insertCell(i);

		switch ( i )
		{
			case enum_id:
				new_cell.innerHTML = item.id;
				new_cell.className = 'number';
				break;
			case enum_item_name:
				new_cell.innerHTML = item.name;
				break;
			case enum_price:
				new_cell.innerHTML = item.price;
				new_cell.className = 'number';
				break;
			case enum_quantity:
				if( item.count < 1 )
					new_cell.innerHTML = item.count;
				else
					new_cell.innerHTML = "1";

				new_cell.className = 'number';
				if(ns6)
					new_cell.addEventListener("click", edit_cell, false);
				else
					new_cell.attachEvent('onclick', edit_cell);
				break;
			case enum_total:
				cells = new_row.getElementsByTagName("TD");
				//new_cell.innerHTML = item.price * cells[enum_quantity].innerHTML;
				var total = item.price * cells[enum_quantity].innerHTML;
				new_cell.innerHTML = total.toFixed(2);
				new_cell.className = 'number';
				break;
			case enum_del:
				new_cell.innerHTML = "&nbsp;&nbsp;" + "<img src='img/delete.png' />";
				new_cell.style.cursor = "pointer";
				if(ns6)
					new_cell.addEventListener("click", delete_row, false);
				else
					new_cell.attachEvent('onclick', delete_row);
				break;
		}
	}
}

function validate_bill()
{
	table_elem = document.getElementById("BillingTable");
	rows = table_elem.getElementsByTagName("TR");

	var error_output = document.getElementById('gb_error_field1');
	var error_output1 = document.getElementById('gb_error_field');
	var error_output2 = document.getElementById('customer_name_validate');

	if(rows.length == 1)
	{
		error_output.innerHTML = "Error: Please add at least one item to bill";

		return false;
	}
	for( var i = 1 ; i < rows.length; i++ )
	{
		cells = rows[i].getElementsByTagName("TD");
		if(cells[enum_quantity].firstChild.tagName == "INPUT")
		{
			error_output.innerHTML = "Error: Please correct the quantities of all the billed items";
			return false;
		}
	}

	error_output.innerHTML = "";
	error_output1.innerHTML = "";
	error_output2.innerHTML = "";
	//document.getElementsByClassName("error_field");

	return true;
}

