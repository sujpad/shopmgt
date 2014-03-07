<?
	$billing = $_GET['billing'];
?>
	<form id="add_customer_form" method="post" action="#">
        <table class='no_border' border="0">
                <tr>
                        <td>Customer Name</td>
                        <td><input type="text" id="a_customer_name" name="a_customer_name" onkeyup="checkName(this);iftabmovenext(this, this.form, event);" size='25' maxlength='50'></input></td>
                </tr>
                <tr>
                        <td id='a_customer_name_validate' colspan='2'> &nbsp; </td>
                </tr>
                <tr>
                        <td>Contact number <span> (Optional) </span> </td>
			<td><input type="text" id="contact_num" name="contact_num" onkeyup="checkContactNumber(this);iftabmovenext(this, this.form, event);" size='25' maxlength='25' class="optional"></input></td>
                </tr>
                <tr>
                        <td id='contact_num_validate' colspan='2'> &nbsp; </td>
                </tr>
                <tr>
                        <td>Email ID <span> (Optional) </span> </td>
			<td><input type="text" id="email_id" name="email_id" onchange="checkEmail(this);" onkeyup="iftabmovenext(this, this.form, event);" size='25' maxlength='50' class="optional"></input></td>
                </tr>
                <tr>
                        <td id='email_id_validate' colspan='2'> &nbsp; </td>
                <tr>
                        <td>Contact address <span> (Optional) </span> </td>
			<td><input type="text" id="contact_addr1" name="contact_addr1" onkeyup="iftabmovenext(this, this.form, event);" size='25' maxlength='50' class="optional"></input></td>
                </tr>
                <tr>
			<td> &nbsp; </td>
			<td><input type="text" id="contact_addr2" name="contact_addr2" onkeyup="iftabmovenext(this, this.form, event);" size='25' maxlength='50' class="optional"></input></td>
                </tr>
                <tr>
			<td> &nbsp; </td>
			<td><input type="text" id="contact_addr3" name="contact_addr3" onkeyup="iftabmovenext(this, this.form, event);" size='25' maxlength='50' class="optional"></input></td>
                </tr>
                <tr>
			<td> &nbsp; </td>
			<td><input type="text" id="contact_addr4" name="contact_addr4" onkeyup="iftabmovenext(this, this.form, event);" size='25' maxlength='50' class="optional"></input></td>
                </tr>
                <tr align='center'>
                        <td id='submit_validate' colspan='2'> &nbsp; </td>
                </tr>
	</table>
	</form>

	<p class='center'><button class='gray_button' id="submit_button" value="Add Customer" onclick='return validate_add_hideform( document.getElementById("add_customer_form"), <?echo $billing ?>);'>Add Customer</button>&nbsp;&nbsp;<button class='gray_button' onclick='Modalbox.hide();'> Close </button></p>
