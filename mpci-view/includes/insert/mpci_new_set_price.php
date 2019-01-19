<?php /*
Project Name: 	MPCI-CORPORATE
Description:	MPCI-CORPORATE is new division of Midtown Printing Company Incorporated (MPCI) for creative task.
Developer:		Fil Elman
Version:		mpci-corporate 1.0
Website:		www.mpcicorporate.com
copyright:		@Copyright 2014*/


# this will prevent from direct accessing of  this file
if( count(get_included_files()) == 1) die("Error, Contact webtoprint.midtown.com.ph");

$price_data = array(
	"product" => $product,
	"last_row" => $number_rows
);
?>

<form action="" method="post">
	<!------------Type of paper use------------>
	<div id="div-first" class="mpci-business-table-border" style="width: 107px;">
		<div class="additional-new-price-row-01">
			<p>Paper</p>
		</div>
		<div class="price-table additional-new-price-row-02">
			<input class="price-table-accept" name="paper" type="text" placeholder="Paper">
			<?php echo '<input name="price_data" type="hidden" value="'.$this->model->encrypt($price_data).'">'; ?>
		</div>
	</div>

	<!------------Description------------>
	<div class="mpci-business-table-border" style="width: 107px;">
		<div class="additional-new-price-row-01">
			<p>Description</p>
		</div>
		<div class="price-table additional-new-price-row-02">
			<input class="price-table-accept" name="discription" type="text" placeholder="Description">
		</div>
	</div>

	<!------------Price------------>
	<div class="mpci-business-table-border" style="width: 107px;">
		<div class="additional-new-price-row-01">
			<p>Price</p>
		</div>
		<div class="price-table additional-new-price-row-02">
			<input class="price-table-accept" name="price" type="text" placeholder="Price">
		</div>
	</div>

	<!------------Tax------------>
	<div class="mpci-business-table-border" style="width: 107px;">
		<div class="additional-new-price-row-01">
			<p>Tax</p>
		</div>
		<div class="price-table additional-new-price-row-02">
			<input class="price-table-accept" name="tax" type="text" placeholder="Tax">
		</div>
	</div>

	<!------------Style------------>
	<div class="mpci-business-table-border" style="width: 107px;">
		<div class="additional-new-price-row-01">
			<p>Style</p>
		</div>
		<div class="price-table additional-new-price-row-02">
			<input class="price-table-accept" name="style" type="text" placeholder="Style">
		</div>
	</div>

	<!------------Size------------>
	<div class="mpci-business-table-border" style="width: 107px;">
		<div class="additional-new-price-row-01">
			<p>Size</p>
		</div>
		<div class="price-table additional-new-price-row-02">
			<input class="price-table-accept" name="size" type="text" placeholder="Size">
		</div>
	</div>

	<!------------Submit------------>
	<div class="mpci-business-table-border" style="width: 107px;">
		<div class="additional-new-price-row-01">
			<span title="Edit" class="product-option edit">
				<img id="submit-new" src="mpci-view/images/mpci_edit.png">
			</span>
			<span title="remove column" class="edit remove-new-price">
				<img src="mpci-view/images/mpci_trash.png">
			</span>
		</div>
		<div class="price-table additional-new-price-row-02">
			<input class="price-table-submit" name="new-price-table-submit" type="submit">
			<img id="new-submit-close" class="remove" src="mpci-view/images/remove.png" title="remove row">
		</div>
	</div>
</form>

<?php
	# jquery
	$text .= 
	"$(document).ready(function(){".
		"$(\"#submit-new\").click(function(){".
			"$(\".additional-new-price-row-02\").slideDown(\"slow\");".
			"$(\".additional-new-price-row-01\").slideUp(\"slow\");".
		"});".
	"});\n";
									
	# jquery for close
	$text .= 
	"$(document).ready(function(){".
		"$(\"#new-submit-close\").click(function(){".
			"$(\".additional-new-price-row-02\").slideUp(\"slow\");".
			"$(\".additional-new-price-row-01\").slideDown(\"slow\");".
		"});".
	"});\n";

?>