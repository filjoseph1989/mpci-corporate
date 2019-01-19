<?php # this will prevent from direct accessing of  this file
if( count(get_included_files()) == 1) die("Error, Contact webtoprint.midtown.com.ph");
?>
<!-- mpci slider -->
<div class="mpci-margin mpci-content mpci-background mpci-float-left mpci-width">
	<div class="wrapper" >
	<section class="slider">
		<div class="flexslider">
			<ul class="slides">
			<?php
				# let get data from table slider where filenames fo product's images are stores.
				if ($results) { 
					#display all the images from database into slider.
					while($obj = $results->fetch_object()){
						echo '<li><img src="mpci-view/images/slider/' . $obj->image . '" /></li>';
					}
				}
			?>
			</ul>
		</div>
	</section>
	</div>
</div>
