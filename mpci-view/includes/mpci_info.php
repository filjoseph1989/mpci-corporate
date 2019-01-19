<?php /*
Project Name: 	MPCI-CORPORATE
Description:	MPCI-CORPORATE is new division of Midtown Printing Company Incorporated (MPCI) for creative task.
Developer:		Fil Elman
Version:		mpci-corporate 1.0
Website:		www.mpcicorporate.com
copyright:		@Copyright 2014*/

# this will prevent from direct accessing of  this file
if( count(get_included_files()) == 1) die("Error, Contact webtoprint.midtown.com.ph");

# display mpci information.
$id = array("info_1","info_2");
$i=0;
if ($results) { 
	while($object = $results->fetch_object()){
		if(strcmp($object->category,$category) == 0){
			# concatenate all necessary information 
			$update = 'site_update/'.$object->ID.'/'.$object->category.'/'.$object->title;
			
			echo
			'<div id="'.$id[$i++].'" class="mpci-info mpci-margin mpci-float-left mpci-width mpci-content">
				<div class="wrapper">
					<div class="form-title mpci-about-us">' . $object->title . '</div>'
					# message content
					.$object->message;
					# a link direct to editor if logged in as admin.
					if(isset($_SESSION['admin']) && $_SESSION['admin'] == true){
						echo '<div id="edit"><a href="?site_update=' . urlencode( $this->model->encrypt($update) ) . '">EDIT</a></div>';
					}
			echo
				'</div>
			</div>';
		}
	}# while
}# if
?>
