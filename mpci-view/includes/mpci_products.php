<?php 
/*
Project Name: 	MPCI-CORPORATE
Description:	MPCI-CORPORATE is new division of Midtown Printing Company Incorporated (MPCI) for creative task.
Developer:		Fil Elman
Version:		mpci-corporate 1.0
Website:		www.mpcicorporate.com
copyright:		@Copyright 2014
*/

# this will prevent from direct accessing of  this file
if( count(get_included_files()) == 1){
	die("Error, Contact webtoprint.midtown.com.ph");
}
?>

<div class="mpci-margin mpci-background mpci-float-left mpci-width mpci-content">
	<div class="wrapper">
		<div class="mpci-featured">
		<?php 
			$currency = '₱';
			$i = 0;
			
			# $text is the variable handler for generating jquery
			$text = "";
			
			if ($results) { 
				# the loop start here
        # fetching the data from database.
				while( $obj = $results->fetch_object() ) {
          
					# Get the filename of the image
					# ------------------------------
					$imagename = explode("/",$obj->image);
					if(isset($imagename[2])){
						$image_name = $imagename[2];
						$img_src = "mpci-view/images/products/$obj->image";
					}else{
						$image_name = "";
						$img_src = "mpci-view/images/products/Default.png";
					}

					# store the details in a array.
					# -----------------------------
					$data = array(
						# identification of the product
						"product_id"     => $obj->id,
						# product's category (e.g. art deco)
						"product_name"   => $obj->product,
						# image path and filename
						"image_filename" => $obj->image,
						# the price
						"product_price"  => $obj->price,
						# option for adding new category
						"product_addbox" => $obj->addbox,
						# name of the product (e.g. Business_Cards)
						"product_category" => $product_category,
						# number of category
						"number_category" => $i
					);
					

					# display the form for new category name
					# --------------------------------------
					$text .= 
					"$(document).ready(function(){".
						"$(\"#edit-$i\").click(function(){".
							"$(\"#edit-form-$i\").slideDown(\"slow\");".
							"$(\"#wrap-$i\").slideUp(\"slow\");";
							if( $obj->addbox == "yes" ) {
								$text .= "$(\"#product-add-$i\").slideUp(\"slow\");";
							}
					$text .=
						"});".
					"});\n";
					
					# close the form for rename the category
					# --------------------------------------
					$text .= 
					"$(document).ready(function(){".
						"$(\"#close-$i\").click(function(){".
							"$(\"#edit-form-$i\").slideUp(\"slow\");".
							"$(\"#wrap-$i\").slideDown(\"slow\");";
							if($obj->addbox == "yes"){
								$text .= "$(\"#product-add-$i\").slideDown(\"slow\");";
							}
					$text .=
						"});".
					"});\n";
					
					if($obj->addbox == "yes"){
						# jquery for adding new category
						# ------------------------------
						$text .= 
						"$(document).ready(function(){".
							"$(\"#product-add-$i\").click(function(){".
								"$(\"#add-box-$i\").slideDown(\"slow\");".
								"$(\"#product-add-$i\").slideUp(\"slow\");".
								"$(\"#product-add-$i\").slideUp(\"slow\");".
								"$(\"#wrap-$i\").slideUp(\"slow\");".
							"});".
						"});\n";

						# jquery to close the form for add new category
						# ---------------------------------------------
						$text .= 
						"$(document).ready(function(){".
							"$(\"#close-add-$i\").click(function(){".
								"$(\"#add-box-$i\").slideUp(\"slow\");".
								"$(\"#product-add-$i\").slideDown(\"slow\");".
								"$(\"#product-add-$i\").slideDown(\"slow\");".
								"$(\"#wrap-$i\").slideDown(\"slow\");".
							"});".
						"});\n";
					}


					# ---------------------------------------------------
					echo '
					<div class="mpci-products mpci-content mpci-float-left">'.
						# the title section of the product
						# compose of four(4) major division
						'<div id="mpci-product-banner">
							<div id="product-name" class="mpci-center">';
								
								# 1.) title of the category
								# -------------------------
								echo
								'<div id="wrap-'.$i.'"class="product-wrapper">
									<div class="product-title">'.
										# the title
										'<a href="#">'.$obj->product.'</a>';

										# edit icon (image)
										if($_SESSION['loggedin'] == true && $_SESSION['admin'] == true){
											echo
											'<span id="edit-'.$i.'" class="product-option edit">
												<img src="mpci-view/images/mpci_edit.png" title="rename">
											</span>'.
											
											# remove option (image)
											'<div class="product-option product-remove">
												<a class="product-remove" href="?remove_category='.urlencode($this->model->encrypt($data)).'">
													<span title="remove this category">
														<img src="mpci-view/images/mpci_trash.png">
													</span>
												</a>
											</div>';
											# end
										}
									echo	
									'</div>
								</div>';
								# end
								
								# 2.) Hidden form which will display if the edit is click
								# -------------------------------------------------------
								if($_SESSION['loggedin'] == true && $_SESSION['admin'] == true){
									echo
									'<form action="" method="POST">
										<input name="new_title_data" type="hidden" value="'.$this->model->encrypt($data).'"/>
										<div id="edit-form-'.$i.'" class="product-wrapper product-form form">
											<table>
												<tbody>
													<tr>'.
														# accept input for creating a new name of a category
														'<td><input id="cat_title_input"  name="new_title" type="text" placeholder="'.$obj->product.'"></td>'.
														# submit
														'<td><input id="cat_title_submit" name="new_title_submit" type="submit" value="change"></td>'.
														# close
														'<td><img id="close-'.$i.'" class="remove" src="mpci-view/images/remove.png" title="close"></td>
													</tr>									
												</tbody>
											</table>
										</div>
									</form>';
									# end
								}

								# accept title and add new category
								# -----------------------------
								if( $obj->addbox == 'yes' ){
									if($_SESSION['loggedin'] == true && $_SESSION['admin'] == true){
										echo '
										<form action="" method="POST">
											<input name="new_box" type="hidden" value="'.$this->model->encrypt($data).'"/>'.

											# 3.) add icon
											# ---------------------------------------
											'<div id="product-add-'.$i.'" class="product-option product-add">
												<span title="create a new category"><img src="mpci-view/images/add.png"></span>
											</div>'.

											# 4.) accept new title for creating new category
											# ----------------------------------------------
											'<div id="add-box-'.$i.'" class="product-wrapper product-form">
												<table>
													<tr>'.
														# accept input
														'<td><input id="cat_category_input"  name="new_category" type="text" placeholder="Type New Title"/></td>'.
														# submit
														'<td><input id="cat_category_submit" name="new_category_submit" type="submit" value="Add"/></td>'.
														# close
														'<td><img id="close-add-'.$i.'" class="close-add" src="mpci-view/images/remove.png" title="close"></td>
													</tr>									
												</table>
											</div>
										</form>';
									}
								}

							echo	
							'</div>
						</div>';
						
						if($_SESSION['loggedin'] == true && $_SESSION['admin'] == true){
							# a loader display when upload
							# ------------------------------------
							echo '
							<div id="loader'.$i.'" class="loader">
								<script>

								var loader'.$i.' = new Sonic({

									width: 50,
									height: 50,
									padding: 3,
									strokeColor: "#000",
									pointDistance: .01,
									stepsPerFrame: 3,
									trailLength: .7,
									step: "fader",
									setup: function() {
										this._.lineWidth = 5;
									},
									path: [
										['."'arc'".', 25, 25, 25, 0, 360]
									]

								});

								loader'.$i.'.play();
								document.getElementById("loader'.$i.'").appendChild(loader'.$i.'.canvas);

								</script> 
							</div>
							';
						
							# display the upload division
							# ----------------------------------------------------------------------------------------
							echo '
							<div id="product-list-'.$i.'" class="product-list-2">
								<div class="mpci-overlay">
									<form action="" method="POST" enctype="multipart/form-data">
										<input type="hidden" name="mpci_product_option"   value="'.$this->model->encrypt($data).'">
										<table>
											<tr class="mpci-center">
												<td><input class="feature_input" name="mpci_file" type="file"></td>
												<td><input id="upload-'.$i.'" class="feature_button" name="upload_file" type="submit" value="upload"/></td>
											</tr>
											<tr class="mpci-center">
												<td><input class="feature_input_1"  name="new_price" type="text" placeholder="Change Price'.$currency.$obj->price.'"></td>
												<td><input class="feature_button_1" name="new_price_submit" type="submit" value="save"/></td>
											</tr>
											<tr>
												<td><p class="checkbox">UPLOAD OPTIONS</p></td>
												<td>&nbsp;</td>
											</tr>
											<tr>
												<td><input class="feature_checkbox" type="checkbox" name="actualsize" checked><p class="checkbox"> Add to Product list</p></td>
												<td>&nbsp;</td>
											</tr>
											<tr>
												<td><input class="feature_checkbox" type="checkbox" name="thumbnail" checked><p class="checkbox"> New Featured Image</p></td>
												<td>&nbsp;</td>
											</tr>
										</table>
									</form>
									<div id="close'.$i.'" class="upload-close">
										<img src="mpci-view/images/remove.png" title="close">
									</div>
								</div>
							</div>
							';
						}
						
						$cat = strtolower($product_category);
						# if the value falls on the following.
						# flyers, greeting_cards, letterhead.
						# there are diff class name declared within a dev, diff declaration of attribute
						# so that it doesnt conflict the position of other product
						if($cat == "flyers" || $cat ==  "greeting_cards" || $cat ==  "letterhead"){
							$style = "";
							if(empty($image_name)){
								$style = "margin-top: 35px;";
							}
							echo "
							<div id=\"$product_category-product$i\" class=\"mpci-center $product_category-product\">";
								# If the admin is the one who is loggedin, if he click the image
								# then he/she can view the list of item within a category, delete, update and etc
								# else if not if the image is click, he can edit the image 
								if($_SESSION['loggedin'] == true && $_SESSION['admin'] == true){
									echo "<a href=\"?display_product=".urlencode($this->model->encrypt($data))."\"><img src=\"$img_src\" title=\"$image_name\" style=\"$style\"></a>";
								}else{
									echo "<a href=\"?edit_product=".urlencode("temp")."\"><img src=\"$img_src\" title=\"$image_name\" style=\"$style\"></a>";
								}
							
							echo "</div>";
						}else{
							echo "
							<div id=\"$product_category-product$i\" class=\"mpci-center product-list $product_category\">";
								# If the admin is the one who is loggedin, if he click the image
								# then he/she can view the list of item within a category, delete, update and etc
								# else if not if the image is click, he can edit the image 
								if($_SESSION['loggedin'] == true && $_SESSION['admin'] == true){
									echo "<a href=\"?display_product=".urlencode($this->model->encrypt($data))."\"><img src=\"$img_src\" title=\"$image_name\"></a>";
								}else{
									echo "<a href=\"?edit_product=".urlencode("temp")."\"><img src=\"$img_src\" title=\"$image_name\"></a>";
								}
							echo "</div>";
						}
						
						# this division will display if loggedin as admin
						if($_SESSION['loggedin'] == true && $_SESSION['admin'] == true){
							
							# make something like this "business_card"
							$id  = str_replace(' ','_',$obj->product);
							# stored id in an array
							$id1[$i] = $id;

							echo "
							<div class=\"mpci-product-update\">
								<a id=\"$id\" href=\"#\">OPTIONS</a>
							</div>";
							
							# make a jquery for upload options
							# --------------------------------
							$text .= 
							"$(document).ready(function(){".
								"$(\"#$id\").click(function(){".
									"$(\"#$product_category-product$i\").slideUp(\"slow\");".
									"$(\"#$id\").slideUp(\"slow\");".
									"$(\"#product-list-$i\").slideDown(\"slow\");".
								"});".
							"});\n";
							# jquery for closing upload option
							# --------------------------------
							$text .= 
							"$(document).ready(function(){".
								"$(\"#close$i\").click(function(){".
									"$(\"#product-list-$i\").slideUp(\"slow\");".
									"$(\"#$product_category-product$i\").slideDown(\"slow\");".
									"$(\"#$id\").slideDown(\"slow\");".
								"});".
							"});\n";
							# jquery for loader display
							# -------------------------
							$text .= 
							"$(document).ready(function(){".
								"$(\"#upload-$i\").click(function(){".
									"$(\"#loader$i\").show();".
									"$(\"#product-list-$i\").hide();".
									"$(\"#$id\").hide();".
								"});".
							"});\n";

						}else{

							echo "
							<div id=\"mpci-price\" class=\"mpci-center\">
								<em style=\"color:#cc6600;\">Starting from $currency$obj->price</em>
							</div>";
							
						}
						
					echo'
					</div>';
					
					# increment the value of $i so that
					# all class name and id will be updated
					# and does not conflict on the jquery effect
					$i++;
				}#while end
			}#if end

			# Make a jquery file
			# ---------------------------------------------------
			$myfile = fopen("mpci-view/js/product01.js", "w") or die("Unable to open file!");

			# write the jquery to file.
			fwrite($myfile, $text);

			# close file writting
			fclose($myfile);
			
		?>
		</div>
	</div>
</div>
