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

<div id="mpci-signup" class="mpci-margin mpci-content mpci-background mpci-float-left mpci-width">
	<div class="wrapper" >
		<a href="#" class="close signup-close"><img src="mpci-view/images/close_pop.png" class="btn_close" title="Close Window" alt="Close"></a>
		<!-- division for registration form -->
		<div class="mpci-form">
			<fieldset class="field">
				<legend class="form-title">Sign Up Free</legend>
				<form action="" method="POST">
					<table>
						<tbody>
							<?php 
								$label  = array("First Name","Last Name","Email","Password","Confirm Password","Address","City","Zip Code","Telephone","Mobile");
								$name   = array("first_name","last_name","email","password","c_password","address","city","zipcode","telephone","mobile");
								$length = count($label);
								
								if(!empty($data)){
									$data   = explode("/",$data);
									for( $i=0; $i<$length; $i++ ){
										echo '
											<tr>
												<td><label for="'.$label[$i].'">'.$label[$i].':</label></td>
												<td><div class="input-container"><input class="inputs" name="'.$name[$i].'" type="'.$this->model->print_password($name[$i]).'" value="'.$data[$i].'"></div></td>
											</tr>';
									}# end
								}else{
									for( $i=0; $i<$length; $i++ ){
										echo '
											<tr>
												<td><label for="'.$name[$i].'">'.$label[$i].':</label></td>
												<td><div class="input-container"><input class="inputs" name="'.$name[$i].'" type="'.$this->model->print_password($name[$i]).'" placeholder="'.$label[$i].'"></div></td>
											</tr>';
									}# end
								}
								echo '
								<tr>
									<td><a href="?captcha=captchasignup"><img src="mpci-view/images/captcha.php"></a></td>
									<td><input id="signtitle" class="inputs captcha" type="text" name="captcha" placeholder="please enter the image in the left"></td>
								</tr>
								<tr>
									<td>&nbsp;</td>'.
									'<td><input type="submit" class="mpci-button" value="register" name="signup_submit"></td>
								</tr>';
							?>
						</tbody>
					</table>
				</form>				
			</fieldset>	
		</div>
	
	</div>
</div>