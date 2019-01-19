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
<div class="mpci-margin mpci-background mpci-float-left mpci-width mpci-content">
	<div class="wrapper">
		<div class="mpci-display">
			<?php
			while ($obj = $result->fetch_object()) {
				$img = array(
					"link" => $product_dir.'/'.$obj->product_thumb,
					"link_encrypted" => $this->model->encrypt($product_dir.'/'.$obj->product_image)
				);
				echo '
				<div class="mpci-display-products product-'.strtolower($display_product["product_category"]).'">
					<a href="?large_display='.urlencode($img["link_encrypted"]).'"><img src="'.$img["link"].'"></a>
				</div>
				';
			}
			?>
		</div>
	</div>
</div>
