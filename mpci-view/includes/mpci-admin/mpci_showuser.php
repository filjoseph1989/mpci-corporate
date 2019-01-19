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
<div class="mpci-admin-content">
	<div class="wrapper">
		<div id="edit-site">
		<?php
		    echo '
			<table border="1px" cellpadding="0" cellspacing="0">
				<tr>
					<td><strong><a href="#">Email Address </a></strong></td>
					<td><strong><a href="#">Name          </a></strong></td>
					<td><strong><a href="#">Last Name     </a></strong></td>
				</tr>';
		    
		    if($result){
		        while($obj = $result->fetch_object()){
					# store in an array the encrypted data
					$showuser = array(
							$this->model->decrypt($obj->email),
							$this->model->decrypt($obj->first_name),
							$this->model->decrypt($obj->last_name),
							$this->model->decrypt($obj->address),
							$this->model->decrypt($obj->city),
							$this->model->decrypt($obj->zipcode),
							$this->model->decrypt($obj->telephone),
							$this->model->decrypt($obj->mobile),
							# status is not encrypted
							$obj->status
					);
					# encrypt the array		
					$showuser = $this->model->encrypt($showuser);
					
                    echo'
    				<tr>
    					<td><a href="?showuserlist='.urlencode($showuser).'">'.$this->model->decrypt($obj->email).'</a></td>
    					<td><a href="#">'.$this->model->decrypt($obj->first_name).'</a></td>
    					<td><a href="#">'.$this->model->decrypt($obj->last_name). '</a></td>
    				</tr>';
                    
		        }
		    }
			echo
			'</table>';
			echo '<p style="padding:0 0 0 5px;margin:0;margin-top:5px;font-size: 11px;text-align: center;">Click on email address for more information.</p>';
        ?>
		</div>
	</div>
</div>
