<?php /*
Project Name: 	MPCI-CORPORATE
Description:	MPCI-CORPORATE is new division of Midtown Printing Company Incorporated (MPCI) for creative task.
Developer:		Fil Elman
Version:		mpci-corporate 1.0
Website:		www.mpcicorporate.com
copyright:		@Copyright 2014*/

# this will prevent from direct accessing of  this file
if( count(get_included_files()) == 1){
	die("Error, Contact webtoprint.midtown.com.ph");
}
?>
<div class="mpci-admin-content">
	<div class="wrapper">
		<div id="edit-site">
			<?php 
				$info = array("Email:", "Name:", "Family Name:", "Street:", "City:", "Zipcode:", "Telephone:", "Mobile:", "Status:");
				echo"
				<div id=\"indi\">
					<p>Personal Data of</p>
					<form action=\"\" method=\"post\">
					<table>
						<tbody>";
						for( $i = 0; $i < 9; $i++){
							# get the email, use for removing or sending email
							if($i == 0){ 
								$email = $data[$i]; 
							}
							# get the name, use for sending email
							if($i == 1){
								$name  = $data[$i]; 
								$lname = $data[$i+1]; 
							}
							
							# if not email address convert first letter to uppercase letter.
							if($i != 0){
								# Get the first letter from $data[$i]
								$ch = substr( $data[$i], 0, 1 );
								# Convert the first letter to uppercase.
								$cn = strtoupper ( $ch );
								# Replace it to the first letter in $data[$i]
								$data[$i] = str_replace($ch,$cn,$data[$i]); 
							}

							# check the status of email
							if(isset($data[8])){
								if($data[8] == "0"){
									$data[8] = "Unverified email address";
								}
								if($data[8] == "1"){
									$data[8] = "Verified email address";
								}
							}

							# print data
							echo "
							<tr>
								<td><div class=\"info\">$info[$i]</div></td>
								<td><div class=\"info\">$data[$i]</div></td>
							</tr>";
						}
						
					$lname = $this->model->encrypt($lname);
					$name  = $this->model->encrypt($name);
					$email = $this->model->encrypt($email);

					echo"
						</tbody>
					</table>
					<p>
						<input type=\"hidden\" name=\"user_indi_lname\"  value=\"$lname\">
						<input type=\"hidden\" name=\"user_indi_name\"   value=\"$name\">
						<input type=\"hidden\" name=\"user_indi_email\"  value=\"$email\">
						<input type=\"submit\" class=\"mpci-button\" name=\"user_indi_sendemail\" value=\"Send Email\">
						<input type=\"submit\" class=\"mpci-button\" name=\"user_indi_delete\" value=\"Delete\">
					</p>
					</form>
				</div>";
			?>
		</div>
	</div>
</div>
