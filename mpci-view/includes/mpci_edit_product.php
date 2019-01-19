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
<!-- sample products -->
<div class="mpci-margin mpci-background mpci-float-left mpci-width mpci-content">
<div class="wrapper">
	<div class="mpci-productdesign-background">
		<?php echo $result[0].": ".$result[1];?>
		<div id="drawing-zone">
			<!--  width="270" height="410" -->
			<canvas id="canvas" width="738" height="420">
				If you see this, then your browser is not supported.
			</canvas>
			
		</div>
	</div>
</div>
</div>
