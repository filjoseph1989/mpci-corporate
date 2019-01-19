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

<div id="mpci_msg" class="mpci-margin mpci-float-left mpci-width mpci-content">
	<div class="message_wrapper" >
		<div id="message">
			<?php
			echo '
			<form action="" method="post">
				<table>
					<tbody>
					<tr>
						<td class="green">Are you sure you want to delete '.$confirmation.'?</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td >
							<input type="submit" name="price_row_delete"  value="yes">
							<input type="submit" name="price_row_delete"  value="no">
							<input type="hidden" name="price_row_data"    value="'.$price_data.'">
						</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					</tbody>
				</table>
			</form>';
			?>
		</div>
	</div>
</div>
