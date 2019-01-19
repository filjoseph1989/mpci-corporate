<?php /*
Project Name: 	MPCI-CORPORATE
Description:	MPCI-CORPORATE is new division of Midtown Printing Company Incorporated (MPCI) for creative task.
Developer:		Fil Elman
Version:		mpci-corporate 1.0
Website:		www.mpcicorporate.com
copyright:		@Copyright 2014*/

# this will prevent from direct accessing of  this file
if( count(get_included_files()) == 1) die("Error, Contact webtoprint.midtown.com.ph");

# break the option to get the individual data
$temp = explode("/",$option);


echo '<div class="mpci-admin-tinymce">';
echo '	<div class="wrapper">';
echo '		<div class="background">';
					if($temp[0] == "contact"){
						echo 
						'<a href="#" class="close contact-close">
							<img src="mpci-view/images/close_pop.png" class="btn_close" title="Close Window" alt="Close">
						</a>';
					}
echo '			<form method="post" action="" enctype="multipart/form-data">';
					if($temp[0] == "contact"){
						$option = $temp[0];
					}

					switch($option){
						case "contact":
							echo '
							<div class="mpci-sub-contact">
								<table>';
								if(isset($temp[1])){
									echo '<tr><td><label>	 First Name:	</label></td><td><input id="title" class="inputs" type="text" name="first_name" 	value="'.$temp[1].'" placeholder="First Name">	</td></tr>';
								}else{
									echo '<tr><td><label>	 First Name:	</label></td><td><input id="title" class="inputs" type="text" name="first_name" 	value="" placeholder="First Name">	</td></tr>';
								}
								if(isset($temp[2])){
									echo '<tr><td><label>	 Last Name:		</label></td><td><input id="title" class="inputs" type="text" name="last_name" 		value="'.$temp[2].'" placeholder="Last Name">	</td></tr>';
								}else{
									echo '<tr><td><label>	 Last Name:		</label></td><td><input id="title" class="inputs" type="text" name="last_name" 		value="" placeholder="Last Name">	</td></tr>';
								}
								if(isset($temp[3])){
									echo '<tr><td><label>  Email Address:	</label></td><td><input id="title" class="inputs" type="text" name="contact_email" 	value="'.$temp[3].'" placeholder="Email Address"></td></tr>';
								}else{
									echo '<tr><td><label>  Email Address:	</label></td><td><input id="title" class="inputs" type="text" name="contact_email" 	value="" placeholder="Email Address"></td></tr>';
								}
								if(isset($temp[9])){
									echo '<tr><td><label>	 Telephone:		</label></td><td><input id="title" class="inputs" type="text" name="telephone" 		value="'.$temp[9].'" placeholder="telephone">	</td></tr>';
								}else{
									echo '<tr><td><label>	 Telephone:		</label></td><td><input id="title" class="inputs" type="text" name="telephone" 		value="" placeholder="telephone">	</td></tr>';
								}
							echo '
									<tr><td><div id="captcha"><a href="?captcha=captchaeditor"><img src="mpci-view/images/captcha.php"></a></div></td><td><input id="title" class="inputs captcha" type="text" name="captcha" placeholder="please enter the image in the left"></td></tr>
								</table>
							</div>';
						break;
								
						case "site_update":
							echo 
							'<div class="mpci-sub-tinymce mpci-sub-contact">'.
								'<table>'.
									'<tr><td><label for="title">Title:   </label></td><td><input id="title" class="inputs" name="site-title" 	  type="text" value="'.$title.    '"></td></tr>'.
									'<tr><td><label for="page"> Category:</label></td><td><input id="title" class="inputs" name="site-category"   type="text" value="'.$category .'"></td></tr>'.
									'<tr><td><label for="page"> ID:	  	 </label></td><td><input id="title" class="inputs" name="site-id"  	      type="text" value="'.$id .'">		 </td></tr>'.
								'</table>'.
							'</div>';
							break;
					}# switch 
	
					# Display the Editor
					echo '<textarea id="elm1"  name="elm1">'.$message.'</textarea>';
					
					# display submit button.
					switch($option){
						case "addinfo":
							echo '<input type="submit" class="mpci-button" name="mpci-information-save"  value="save" />';
						break;
								
						case "site_update":
							echo '<input type="submit" class="mpci-button" name="mpci-information-update"  value="update" />';
						break;
								
						case "contact":
							echo 
							'<table>
								<tr>
									<td>Attachment:</td>
									<td><input type="file" id="attachment" name="attachment_file"></td>
									<td><input type="submit" class="mpci-button" name="contact-us" value="Submit"></td>
								</tr>
							</table>';
						break;
					}# switch
echo '			</form>';
echo '		</div>';
echo '	</div>';
echo '</div>';
?>
