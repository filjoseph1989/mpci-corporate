<?php /*
Project Name: 	MPCI-CORPORATE
Description:	MPCI-CORPORATE is new division of Midtown Printing Company Incorporated (MPCI) for creative task.
Developer:		Fil Elman
Version:		mpci-corporate 1.0
Website:		www.mpcicorporate.com
copyright:		@Copyright 2014*/

# this will prevent from direct accessing of  this file
#if( count(get_included_files()) == 1) die("Error, Contact webtoprint.midtown.com.ph");
?>

<div id="mpci_msg" class="mpci-margin mpci-background mpci-float-left mpci-width mpci-content">
	<div class="wrapper" >
		<div id="message" class="password_reset">
			<header>Reset your password here</header>
			<?php 
			    # ------------------------------------
				# password reset
			    # ------------------------------------
				echo'
				
				<form action="" method="POST">
					<table>
						<tbody>
							<tr>
								<td><label>New Password:</label></td>
								<td><div class="input-container"><input class="inputs" name="mpci_new_password" type="password" placeholder="New Password"></div></td>
							</tr>
							<tr>
								<td><label>Confirmation Password:</label></td>
								<td><div class="input-container"><input class="inputs" name="mpci_con_password" type="password" placeholder="Confirmation password"></div></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td>
									<input type="submit" class="mpci-button" name="change_password" value="Submit"/>
								</td>
							</tr>
						</tbody>
					</table>
				</form>
				';
			?>
		</div>
	<!-- .wapper end-->
	</div>
<!-- .mpci-login-form end-->
</div>
