<?php /*
Project Name: 	MPCI-CORPORATE
Description:	MPCI-CORPORATE is new division of Midtown Printing Company Incorporated (MPCI) for creative task.
Developer:		Fil Elman
Version:		mpci-corporate 1.0
Website:		www.mpcicorporate.com
copyright:		@Copyright 2014*/

# note: the value of $result is passed here.
	
# this will prevent from direct accessing of  this file
if( count(get_included_files()) == 1){
	die("Error, Contact webtoprint.midtown.com.ph");
}
?>
<div id="mpci-admin" class="mpci-margin mpci-background mpci-float-left mpci-width mpci-content">
	<div class="wrapper wrap" >
		<!-- close button on top right -->
		<a href="#" class="close admin-close"><img src="mpci-view/images/close_pop.png" class="btn_close" title="Close Window" alt="Close"></a>
		
		<!-- content of admin -->
		<div class="mpci-administration">
			<div class="mpci-admin-menu">ADMIN MENU</div>
			<ul>
			<?php
				echo '
				<li><div><a href="'.$current_url. '?addadmin=addadmin  " > Add Admin		</a></div></li>
				<li><div><a href="'.$current_url. '?adminlist=adminlist" > Show Admin	    </a></div></li>
				<li><div><a href="'.$current_url. '?showuser=showuser  " > Show Users		</a></div></li>
				<li><div><a href="'.$current_url. '?editinfo=editinfo  " > Edit Info		</a></div></li>
				<li><div><a href="'.$current_url. '?admin=addinfo      " > Add Site Info	</a></div></li>';
			?>
			</ul>
		</div>
		
		<?php 
		    # show add form
			if($option == "addadmin"){
				include('mpci-admin/mpci_add_admin.php');
			}else 
			
			# display list of administrators.
			if($option == "adminlist" || $option == "remove"){
				include('mpci-admin/mpci_edit_admin.php');
			}else 
			
			# show udpate table
			if($option == "update"){
				include('mpci-admin/mpci_update_admin.php');
			}else 
			
			# display the category and title of site information
			if($option == "editinfo"){
				include('mpci-admin/mpci_edit_site.php');
			}else 
			
			# show user information.
			if($option == "showuser"){
			    include('mpci-admin/mpci_showuser.php');
			}else
			
			# show individual information of administrators
			if($option == "showadmin_individual"){
				include('mpci-admin/mpci_showadmin_individual.php');
			}else
			
			# show individual information of user
			if($option == "showuser_individual"){
				include('mpci-admin/mpci_showuser_individual.php');
			}			
			
			# display add administrator
			else{
				include('mpci-admin/mpci_add_admin.php');
			}
		?>	
		
	</div><!--wrapper end-->

</div><!--mpci contact end-->