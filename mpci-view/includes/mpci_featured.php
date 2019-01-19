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
<!-- sample products -->
<div class="mpci-margin mpci-background mpci-float-left mpci-width mpci-content">
<div class="wrapper">
	<div class="mpci-featured">
	<?php
		# currency symbol
		$currency = '₱';
		$i = 0;
		if ($results) { 
			while($obj = $results->fetch_object()){
				$data = array(
					# identification of the product
					"product_id"     => $obj->id,
					# product's category (e.g. art deco)
					"product_name"   => $obj->product,
					# image path and filename
					"image_filename" => $obj->image,
					# the price
					"product_price"  => $obj->price,
					# name of the product (e.g. Business_Cards)
					"product_category" => $query
				);
			
				echo "
				<div class=\"mpci-featured-box mpci-content mpci-float-left\">
					<div class=\"mpci-featured-banner\">
						<div id=\"featured-name\" class=\"mpci-center\">
							<div id=\"featured-wrapper\">
								<a href=\"?option=".$obj->product."\">".$obj->product."</a>
							</div>
						</div>
					</div>";
					if($_SESSION['loggedin'] == true && $_SESSION['admin'] == true){
						echo 
						"<div class=\"mpci-featured-overlay mpci-center\" id=\"mpci-featured-overlay$i\">
							<table>
							<form action=\"\" method=\"POST\" enctype=\"multipart/form-data\">
								<input type=\"hidden\" name=\"mpci_product_option\"   value=\"".$this->model->encrypt($data)."\">
								<tr>
									<td><input name=\"new_price\" type=\"text\" placeholder=\""."Change Price ".$currency.$obj->price."\" class=\"input\"></td>
									<td><input name=\"new_price_save\" type=\"submit\" value=\"save\"/ class=\"button\"></td>
								</tr>
								<tr>
									<td>
										<input class=\"feature_input\" name=\"mpci_file\" type=\"file\">
										<input class=\"feature_input\" name=\"mpci_sample_category\" type=\"hidden\" value=\"$obj->product\">
									</td>
									<td>
										<input class=\"button\" name=\"feature_upload_file\" type=\"submit\" value=\"upload\"/>
									</td>
								</tr>
							</form>
							</table>
							
						</div>
						<div id=\"featured-product$i\" class=\"featured-product mpci-center\"><a href=\"?option=$obj->product\"><img src=\"mpci-view/images/products/".$obj->image."\"></a></div>
						<div id=\"featured-option$i\" class=\"featured-option\">
							<a id=\"option$i\" href=\"#\">OPTIONS</a>
						</div>";
						$id[$i] = "option$i";
					}
					
					else{
						echo"
						<div id=\"featured-product$i\" class=\"featured-product mpci-center\"><a href=\"?option=$obj->product\"><img src=\"mpci-view/images/products/".$obj->image."\"></a></div>
						<div id=\"mpci-price\" class=\"mpci-center\"><em style=\"color:#cc6600;\">Starting from" .$currency.$obj->price. "</em></div>
						";
					}
				echo "
				</div>				
				";
				
				$i++;
			}// while loop end
		}# if

		# Generate a jquery for display effects
		# if its administrator who are working
		if($_SESSION['loggedin'] == true && $_SESSION['admin'] == true){
			# Open a file
			$myfile = fopen("mpci-view/js/feature.js", "w") or die("Unable to open file!");
			
			# start a jquery
			$txt  = "$(document).ready( \n";
			$txt .= "\tfunction(){ \n";

			# write the jquery to file.
			fwrite($myfile, $txt);
			
			#  Get the count of array using $i
			$length = $i;
			for($i = 0; $i < $length; $i++){
				$txt  = "\t\t$(\"#option$i\").click( \n";
				$txt .= "\t\t\tfunction(){ \n";
				$txt .= "\t\t\t\t$(\"#mpci-featured-overlay$i\").slideDown(\"slow\");\n";
				for($j = 0; $j < $length; $j++){
					if( $j != $i){
						$txt .= "\t\t\t\t$(\"#mpci-featured-overlay$j\").slideUp(\"slow\");\n";
					}
				}
				$txt .= "\t\t\t\t$(\"#mpci-product$i\").slideUp(\"slow\");\n";
				for($j = 0; $j < $length; $j++){
					if( $j != $i){
						$txt .= "\t\t\t\t$(\".mpci-product$j\").slideDown(\"slow\");\n";
					}
				}
				$txt .= "\t\t\t}\n";
				$txt .= "\t\t);\n";
				
				# write the jquery to file.
				fwrite($myfile, $txt);
			}

			# end a jquery
			$txt  = "\t}\n";
			$txt .= ");\n";
			
			# write the jquery to file.
			fwrite($myfile, $txt);
			
			# close file writting
			fclose($myfile);
		}
		
	?>
	</div>
</div>
</div>
