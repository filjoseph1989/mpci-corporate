<?php /*
Project Name: 	MPCI-CORPORATE
Discription:	MPCI-CORPORATE is new division of Midtown Printing Company Incorporated (MPCI) for creative task.
Developer:		Fil Elman
Version:		mpci-corporate 1.0
Website:		www.mpcicorporate.com
copyright:		@Copyright 2014*/

# this will prevent from direct accessing of  this file
if( count(get_included_files()) == 1) die("Error, Contact webtoprint.midtown.com.ph");
?>
<div class="mpci-admin-content">
	<div class="wrapper">
		<div id="add_admin">
			<fieldset class="field">
				<legend class="form-title">Update admin personal data</legend>
				<form action="" method="POST">
					<table>
						<tr>
							<td><label for="first_name">First Name:</label></td>
							<td><div class="input-container"><input class="inputs" name="first_name"   type="text"     value="<?php echo $first_name;?>"></div></td>
						</tr>
						<tr>
							<td><label for="last_name">Last Name:</label></td>
							<td><div class="input-container"><input class="inputs" name="last_name"    type="text"     value="<?php echo $last_name;?>"></div></td>
						</tr>
						<tr>
							<td><label for="admin_email">Email:</label></td>
							<td><div class="input-container"><input class="inputs" name="update_email" type="text"     value="<?php echo $email;?>"></div></td>
						</tr>
						<tr>
							<td><label for="password">Password:</label></td>
							<td><div class="input-container"><input class="inputs" name="password"     type="password" placeholder="password"></div></td>
						</tr>
						<tr>
							<td><label for="c_password">Confirm Password:</label></td>
							<td><div class="input-container"><input class="inputs" name="c_password"   type="password" placeholder="confirm password"></div></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td><input type="submit" class="mpci-button" value="update" name="update_submit"></td>
						</tr>
							
					</table>
				</form>
			</fieldset>
		</div>
	</div>
</div>
