<?php 
# this will prevent from direct accessing of  this file
if( count(get_included_files()) == 1) die("Error, Contact webtoprint.midtown.com.ph");

#	display mpci information.
	if ($results) { 
		while($object = $results->fetch_object()){
			if(strcmp($object->category,$category)){
				echo '<div id="mpci-info" class="mpci-margin mpci-background mpci-float-left mpci-width mpci-content">';
				echo '<div class="wrapper">';
				echo '<div class="form-title mpci-about-us">' . $object->title . '</div>';
				echo $object->message;
				echo '</div>';
				echo '</div>';
			}
		}
	}
?>
