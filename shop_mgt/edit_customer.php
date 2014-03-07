
<?
$customer_id = $_GET['customer_id'];
$customer_name = $_GET['customer_name'];
$contact_num = $_GET['contact_num'];
$email_id = $_GET['email_id'];
$contact_addr1 = $_GET['contact_addr1'];
$contact_addr2 = $_GET['contact_addr2'];
$contact_addr3 = $_GET['contact_addr3'];
$contact_addr4 = $_GET['contact_addr4'];
?>

	<form id="edit_customer_form" method="post" action="#">
	<input type="text" class='hide' id='customer_id' value='<?echo $customer_id;?>' />
	<input type="text" class='hide' id='prev_customer_name' value='<?echo $customer_name;?>' />
        <table class='no_border' border="0">
                <tr>
                        <td>Customer Name</td>
                        <td><input type="text" id="customer_name" name="customer_name" onkeyup="checkName(this);iftabmovenext(this, this.form, event);" size='25' maxlength='50' value='<?echo $customer_name?>'> </input></td>
                </tr>
                <tr>
                        <td id='customer_name_validate' colspan='2'> &nbsp; </td>
                </tr>
                <tr>
                        <td>Contact number <span> (Optional) </span> </td>
			<td><input type="text" id="contact_num" name="contact_num" onkeyup="checkContactNumber(this);iftabmovenext(this, this.form, event);" size='25' maxlength='25' class="optional" value='<?=stripslashes($contact_num)?>'></input></td>
                </tr>
                <tr>
                        <td id='contact_num_validate' colspan='2'> &nbsp; </td>
                </tr>
                <tr>
                        <td>Email ID <span> (Optional) </span> </td>
			<td><input type="text" id="email_id" name="email_id" onchange="checkEmail(this);" onkeyup="iftabmovenext(this, this.form, event);" size='25' maxlength='50' class="optional" value='<?=stripslashes($email_id)?>'></input></td>
                </tr>
                <tr>
                        <td id='email_id_validate' colspan='2'> &nbsp; </td>
                <tr>
                        <td>Contact address <span> (Optional) </span> </td>
			<td><input type="text" id="contact_addr1" name="contact_addr1" onkeyup="iftabmovenext(this, this.form, event);" size='25' maxlength='50' class="optional" value='<?=stripslashes($contact_addr1)?>'></input></td>
                </tr>
                <tr>
			<td> &nbsp; </td>
			<td><input type="text" id="contact_addr2" name="contact_addr2" onkeyup="iftabmovenext(this, this.form, event);" size='25' maxlength='50' class="optional" value='<?=stripslashes($contact_addr2)?>'></input></td>
                </tr>
                <tr>
			<td> &nbsp; </td>
			<td><input type="text" id="contact_addr3" name="contact_addr3" onkeyup="iftabmovenext(this, this.form, event);" size='25' maxlength='50' class="optional" value='<?=stripslashes($contact_addr3)?>'></input></td>
                </tr>
                <tr>
			<td> &nbsp; </td>
			<td><input type="text" id="contact_addr4" name="contact_addr4" onkeyup="iftabmovenext(this, this.form, event);" size='25' maxlength='50' class="optional" value='<?=stripslashes($contact_addr4)?>'></input></td>
                </tr>
                <tr>
                        <td id='submit_validate' colspan='2'> &nbsp; </td>
                </tr>
	</table>
	</form>

        <p class='center'><button class='gray_button' id="submit_button" value="Modify Customer" onclick='return validate_edit_hideform( document.getElementById("edit_customer_form"));'>Modify Customer</button>&nbsp;&nbsp;<button class='gray_button' onclick='Modalbox.hide();'> Close </button></p>

