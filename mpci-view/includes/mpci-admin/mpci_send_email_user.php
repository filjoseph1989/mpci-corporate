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
<div class="mpci-admin-tinymce">
	<div class="wrapper">
		<?php 
		echo '
		<div id="mpci-tinymce">
			<form method="post" action="">';
			echo 
			'<div class="mpci-sub-tinymce mpci-sub-contact">'.
				'<table>'.
					'<tr><td><label>Email Address:</label></td><td><input id="title" class="inputs" name="indi_user_email"   type="text" value="'.$data[0].'"></td></tr>'.
					'<tr><td><label>Name:         </label></td><td><input id="title" class="inputs" name="indi_user_name"    type="text" value="'.$data[1].' '.$data[2].'"></td></tr>'.
					'<tr><td><label>Subject:	  </label></td><td><input id="title" class="inputs" name="indi_user_subject" type="text" ></td></tr>'.
				'</table>'.
			'</div>';
			echo '<textarea id="elm1"  name="elm1"></textarea>';
			echo '<input type="submit" name="indi_user_submit" class="mpci-button" value="Send">';
			
		echo '			
			</form>
		</div>';
		?>
	</div>
</div>
