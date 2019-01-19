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

<div id="mpci_msg" class="mpci-margin mpci-float-left mpci-width mpci-content">
	<div class="message_wrapper" >
		<div id="message">
			<?php 
			    # ------------------------------------
				# Break the message.
			    # ------------------------------------
				$temp  = explode(" ",$message);
				$temp2 = explode("|",$message);
                
			    # ------------------------------------
			    # confirmation code.
			    # ------------------------------------
				if(isset($temp2[1]) && $temp2[1] == "mpci_confirmation"){
			        $message = $temp2[0];
			    }


			    # ------------------------------------
                # Check if there is a session of login.
			    # ------------------------------------
				if(isset($_SESSION['name']) && strcmp($message, $_SESSION['name']) == 0){
					# assign values to message.
					$message = "welcome back " . $message . "!";
				}
				

			    # ------------------------------------
				# Display any message.
			    # ------------------------------------
				echo "
				<table>
				<tr>
					<td class=\"green\">$message</td>
				</tr>
				</table>";
				

			    # ------------------------------------
				# if found "remove" then print also the following.
			    # ------------------------------------
				if (isset($temp[6]) && $temp[6] == "remove"){
					echo '
					<form action="" method="POST">';
					if(isset($temp[7])){
						echo '<input type="hidden" name="remove_email" value="'.$temp[7].'"/>';
					}
					echo '
						<input type="submit" class="mpci-button" name="remove_yes" value="yes"/>
						<input type="submit" class="mpci-button" name="remove_no"  value="no"/>
					</form>';
				}


			    # ------------------------------------
				# Accepts confirmation code .
			    # ------------------------------------
			    if(isset($temp2[1]) && $temp2[1] == "mpci_confirmation"){
					echo '
					<form action="" method="POST">
					    <label>Enter the verification code</label>
						<input type="input" class="inputs" name="mpci_verification" placeholder="verification code"/>
						<input type="submit" class="inputs"/>
					</form>';
			    }
			?>
		</div>
	<!-- .wapper end-->
	</div>
<!-- .mpci-login-form end-->
</div>
