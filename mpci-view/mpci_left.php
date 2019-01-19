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
<div id="mpci-left" class="mpci-float-left mpci-background" >
			
	<!-- display logo -->
	<div id="mpci-logo-back">
		<div id="mpci-logo-border" class="mpci-border">
			<div id="mpci-logo"></div>
		</div>
	</div>
		
	<!-- Products Header-->
	<div id="mpci-products" class="mpci-border"><h2>Products</h2></div>
	
	<?php
		# display all the products names from the database table mpci_left_sidebar.
		echo '<ul>';
		if ($result) { 
			while($obj = $result->fetch_object()){
				echo '<li id="'.$obj->name.'">
						<div><a href="?option='.$obj->name.'">' . $obj->name . '</a></div>
					  </li>';
			}
		}
		echo '</ul>';
	?>
<div id="zoholivechat">
	<!-- zoho live chat -->
	<script type="text/javascript">
		var $zoho= $zoho || {livedesk:{values:{},ready:function(){}}};
		var d=document;
			s=d.createElement("script");
			s.type="text/javascript";
			s.defer=true;
			s.src="https://livedesk.zoho.com/midtownprinting/button.ls?embedname=midtownprinting";
			t=d.getElementsByTagName("script")[0];
			t.parentNode.insertBefore(s,t);
			document.write("<div id='zldbtnframe'></div>");
	</script>
</div>

</div><!-- end of #mpci-left -->

