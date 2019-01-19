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
<div class="mpci-admin-content">
	<div class="wrapper">
		<div id="edit-site">
			<table border="1px" cellpadding="0" cellspacing="0">
				<?php 
					echo '
						<tr>
							<td><strong><a href="#">Update 	</a></strong></td>
							<td><strong><a href="#">Category</a></strong></td>
							<td><strong><a href="#">Title 	</a></strong></td>
						</tr>';
					if($result){
						while($obj = $result->fetch_object()){
							# concatenate all necessary information 
							$update = 'site_update/'.$obj->ID.'/'.$obj->category.'/'.$obj->title;
							
							# encrypt the concatenated information.
							$update = $this->model->encrypt($update);
							
							# print in the table.
							echo 
                '<tr>'.
								'<td><a href="?site_update=' . urlencode($update) . '">update 			  </a></td>' .
								'<td><a href="?site_update=' . urlencode($update) . '">'.$obj->category.'</a></td>' .
						    '<td><a href="?site_update=' . urlencode($update) . '">'.$obj->title.   '</a></td>' .
						    '</tr>';
						}
					}
				?>
			</table>
		</div>
	</div>
</div>
