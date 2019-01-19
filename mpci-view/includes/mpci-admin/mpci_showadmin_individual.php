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
				# Administrator's information use for sending email.
				$email_info = array(
					"email"      => $data['email'],
					"first_name" => $data['first_name'],
					"last_name"  => $data['last_name']
				);
				
				$email_info = $this->model->encrypt($email_info);
				
				# check if verified email address.
				if($data['status'] == '1'){
					$status = "Verified Email Address";
				}else{
					$status = "Unverified Email Address";
				}
				
				echo
				"<div id=\"indi\">
					<p>Personal Data of</p>
					<form action=\"\" method=\"post\">
					<table>
						<tr>
							<td><div class=\"info\">Email:</div></td>
							<td><div class=\"info\">".$data['email']."</div></td>
						</tr>
						<tr>
							<td><div class=\"info\">Name::</div></td>
							<td><div class=\"info\">".$data['first_name']."</div></td>
						</tr>
						<tr>
							<td><div class=\"info\">Family Name::</div></td>
							<td><div class=\"info\">".$data['last_name']."</div></td>
						</tr>
						<tr>
							<td><div class=\"info\">Status::</div></td>
							<td><div class=\"info\">$status</div></td>
						</tr>
					</table>
					<p>
						<input type=\"hidden\" name=\"email_info\"  value=\"$email_info\">
						<input type=\"submit\" class=\"mpci-button\" name=\"admin_indi_sendemail\" value=\"Send Email\">
					</p>
					</form>
				</div>";
			?>
		</div>
	</div>
</div>