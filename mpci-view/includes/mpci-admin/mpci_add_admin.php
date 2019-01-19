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
				<legend class="form-title">Add new admin personnel</legend>
				<form action="" method="POST">
					<table>
						<?php 	
							$label	= array("First Name","Last Name","Email","Password","Confirm Password");
							$name 	= array("first_name","last_name","email","password","c_password");
							$length = count($label);
							if(!empty($data)){
								$temp   = explode("/",$data);
							}
							
							# loop the form input row.
							for( $i=0; $i<$length; $i++ ){
								if( isset($temp[$i]) && !empty($temp[$i])){
									echo 
									'<tr>
										<td><label>'.$label[$i].':</label></td>
										<td>
											<div class="input-container">
												<input class="inputs" name="'.$name[$i].'" type="'.$this->model->print_password($name[$i]).'" value="'.$temp[$i].'">
											</div>
										</td>
									</tr>';
								}else{
									echo 
									'<tr>
										<td><label>'.$label[$i].':</label></td>
										<td>
											<div class="input-container">
												<input class="inputs" name="'.$name[$i].'" type="'.$this->model->print_password($name[$i]).'" placeholder="'.$label[$i].'">
											</div>
										</td>
									</tr>';
								}
							} # end of loop. 
							
							# print save button.
							echo '
							<tr>
								<td>&nbsp;</td>
								<td><input type="submit" class="mpci-button" value="save" name="admin_submit"></td>
							</tr>';
						?>
							
					</table>
				</form>
			</fieldset>
		</div>
	</div>
</div>
