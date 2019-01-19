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
<div class="mpci-margin mpci-background mpci-float-left mpci-width mpci-content">
	<div class="wrapper">
		<div class="mpci-display-large">
			<?php
			# $link is the path, pick the filename of the image used for displaying title
			$title = explode("/", $link);
			echo '
			<div class="mpci-display-products image-large">
				<img src="'.$link.'" title="'.$title[5].'"><br/>
			</div>';
			?>
		</div>
	</div>
</div>
