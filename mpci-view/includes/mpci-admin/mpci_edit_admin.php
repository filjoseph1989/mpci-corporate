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
				<tr>
					<td><strong><a href="#">Update</a></strong></td>
					<td><strong><a href="#">Remove</a></strong></td>
					<td><strong><a href="#">Email</a></strong></td>
					<td><strong><a href="#">First Name</a></strong></td>
					<td><strong><a href="#">Last Name</a></strong></td>
				</tr>
				<?php 
					if($result){
						while($obj = $result->fetch_object()){
							# form a single statement of remove, email blank.
							$remove = 'remove/'.$this->model->decrypt($obj->email).'//';
							# encrypt as a whole
							$remove = $this->model->encrypt($remove);
							# form a single statement of update, email, first name and last name.
							$update = 'update/'.$this->model->decrypt($obj->email).'/'.$this->model->decrypt($obj->first_name).'/'.$this->model->decrypt($obj->last_name);
							# encrypt as a whole
							$update = $this->model->encrypt($update);
							# store in an array the encrypted data
							$showadmin = array(
								"email"	=> $this->model->decrypt($obj->email),
								"first_name" => $this->model->decrypt($obj->first_name),
								"last_name" => $this->model->decrypt($obj->last_name),
								"status" => $obj->status
							);
							# encrypt the array		
							$showadmin = $this->model->encrypt($showadmin);
							
							echo '
							<tr>
								<td><a href="?adminupdate='. urlencode($update) .'">update</a></td>
								<td><a href="?remove=' . urlencode($remove) . '">remove</a></td>
								<td><a href="?showadmin='.urlencode($showadmin).'">'.$this->model->decrypt($obj->email).'</a></td>
								<td><a href="#">'.$this->model->decrypt($obj->first_name).'</a></td>
								<td><a href="#">'.$this->model->decrypt($obj->last_name). '</a></td>
							</tr>';
						}
					}
				?>
			</table>
			<?php echo '<p style="padding:0 0 0 5px;margin:0;margin-top:5px;font-size: 11px;text-align: center;">Click on email address for more information.</p>'; ?>
		</div>
	</div>
</div>
