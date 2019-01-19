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
			echo '
			<form action="" method="post">
				<table>
					<tbody>
					<tr>
						<td class="green">Are you sure you want to delete '.$category.'</td>
						<td ><input type="submit" name="yes_remove_category" value="yes"></td>
						<td ><input type="submit" name="no_remove_category" value="no"></td>
					</tr>
					</tbody>
				</table>
			</form>';
			?>
		</div>
	<!-- .wapper end-->
	</div>
<!-- .mpci-login-form end-->
</div>
