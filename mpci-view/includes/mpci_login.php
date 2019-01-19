<?php /*
Project Name: 	MPCI-CORPORATE
Description:	MPCI-CORPORATE is new division of Midtown Printing Company Incorporated (MPCI) for creative task.
Developer:		Fil Elman
Version:		mpci-corporate 1.0
Website:		www.mpcicorporate.com
copyright:		@Copyright 2014*/

# this will prevent from direct accessing of  this file
if( count(get_included_files()) == 1) die("Error, Contact webtoprint.midtown.com.ph");
?>

<!-- mpci login -->
<div id="mpci-login-form" class="mpci-margin mpci-float-left mpci-width mpci-content">
	<div class="wrapper" >
		<a href="#" class="close login-close"><img src="mpci-view/images/close_pop.png" class="btn_close" title="Close Window" alt="Close"></a>

		<!-- division for login form -->
		<div class="mpci-login">
			<fieldset class="field">
				<legend class="form-title">Login</legend>
				<form action="" method="POST" enctype="multipart/form-data">
					<table>
						<tbody>
							<tr>
								<td><label for="fname">Username:</label></td> 
								<td><div class="input-container"><input required class="inputs" name="login_email" type="text" placeholder="Username or Email"></div></td>
							</tr>
							<tr>
								<td><label for="fname">Password:</label></td>
								<td><div class="input-container"><input required class="inputs" name="login_password" type="password" placeholder="Password"></div></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td>
									<input type="submit" class="mpci-button" name="login_submit" value="Login"/>
									<input type="checkbox" name="login_remember" value="yes">
									<label for="remember">Remember Me:</label><br/>
									<a href="?forgot">Forgot Password?</a>
								</td>
							</tr>
						</tbody>
					</table>
				</form>
			</fieldset>
		<!-- .mpci-login end-->
		</div>

	<!-- #mpci-product-title-wapper end-->
	</div>
<!-- .mpci-login-login end-->
</div>