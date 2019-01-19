<?php /*
Project Name: 	MPCI-CORPORATE
Description:	MPCI-CORPORATE is new division of Midtown Printing Company Incorporated (MPCI) for creative task.
Developer:		Fil Elman
Version:		mpci-corporate 1.0
Website:		www.mpcicorporate.com
copyright:		@Copyright 2014*/


# this will prevent from direct accessing of  this file
if( count(get_included_files()) == 1){
	die("Error, Contact webtoprint.midtown.com.ph");
} 
?>

<!-- Price Table -->
<div class="mpci-business-table mpci-margin mpci-content mpci-background mpci-float-left mpci-width">
	<div class="wrapper">
		<!-- header title -->
		<div id="pricing_table" class="form-title">Price Table</div>
		
		<div id="price-div-table">
		<?php 
			# produce a new style and header
			if($_SESSION['loggedin'] == true && $_SESSION['admin'] == true){
				$style = 'style="width: 107px;"';
				$name 	= array("Paper", "Description", "Product Price", "VAT", "Style", "Size", "Options"); 
			}else{
				$style = 'style="width: 125px;"';
				$name 	= array("Paper", "Description", "Product Price", "VAT", "Style", "Size"); 
			}
			
			# length of the array 
			$length = count($name);
			
			# Table Header
			for( $i = 0; $i < $length; $i++){
				if($i == 0){
					$id = "id=\"first-div\"";
				}else{
					$id = "";
				}
				echo '
				<div '.$id.'class="mpci-business-table-border mpci-business-table-border-top" '.$style.'>
					<p align="center"><b><font size="3">'.$name[$i].'</font></b></p>
				</div>';
			}
			
			# ---------------------------------------------------------------------------------------------
			if ($results) { 
				# variable initialization
				$i = 0;
				$text = "";
				while($obj = $results->fetch_object()){
					$price_data = array(
						"price_id" => $obj->price_id,
						"paper" => $obj->paper,
						"description" => $obj->discription,
						"price" => $obj->price,
						"tax" => $obj->Tax,
						"style" => $obj->style,
						"size" => $obj->size,
						"product" => $obj->product
					);
					
					if($obj->product == $product){
						echo '
						<form action="" method="POST">

							<!------------Type of paper use------------>
							<div id="div-first" class="mpci-business-table-border" '.$style.'>
								<div id="paper-div-'.$i.'">
									<p>'.$obj->paper.'</p>
								</div>';
								
								# This division will display when the admin is loggedin.
								if($_SESSION['loggedin'] == true && $_SESSION['admin'] == true){
									echo
									'<div id="paper-input-'.$i.'" class="price-table">
										<input class="price-table-accept" name="paper" type="text" placeholder="'.$obj->paper.'">
										<input name="price_data" type="hidden" value="'.$this->model->encrypt($price_data).'">
									</div>';
								}
							echo'
							</div>

							<!------------Description------------>
							<div class="mpci-business-table-border" '.$style.'>
								<div id="discription-div-'.$i.'">
									<p>'.$obj->discription.'</p>
								</div>';
								
								# This division will display when the admin is loggedin.
								if($_SESSION['loggedin'] == true && $_SESSION['admin'] == true){
									echo '
									<div id="discription-input-'.$i.'" class="price-table">
										<input class="price-table-accept" name="discription" type="text" placeholder="'.$obj->discription.'">
									</div>';
								}
							echo '
							</div>
							
							<!------------Price------------>
							<div class="mpci-business-table-border" '.$style.'>
								<div id="price-div-'.$i.'">
									<p>'.$obj->price.'</p>
								</div>';
								
								# This division will display when the admin is loggedin.
								if($_SESSION['loggedin'] == true && $_SESSION['admin'] == true){
									echo '
									<div id="price-input-'.$i.'" class="price-table">
										<input class="price-table-accept" name="price" type="text" placeholder="'.$obj->price.'">
									</div>';
								}
							echo '
							</div>
							
							<!------------Tax------------>
							<div class="mpci-business-table-border" '.$style.'>
								<div id="tax-div-'.$i.'">
									<p>'.$obj->Tax.'</p>
								</div>';
								
								# This division will display when the admin is loggedin.
								if($_SESSION['loggedin'] == true && $_SESSION['admin'] == true){
									echo '
									<div id="tax-input-'.$i.'" class="price-table">
										<input class="price-table-accept" name="tax" type="text" placeholder="'.$obj->Tax.'">
									</div>';
								}
								
							echo '
							</div>
							
							<!------------Style------------>
							<div class="mpci-business-table-border" '.$style.'>
								<div id="style-div-'.$i.'">
									<p>'.$obj->style.'</p>
								</div>';
								
								# This division will display when the admin is loggedin.
								if($_SESSION['loggedin'] == true && $_SESSION['admin'] == true){
									echo '
									<div id="style-input-'.$i.'" class="price-table">
										<input class="price-table-accept" name="style" type="text" placeholder="'.$obj->style.'">
									</div>';
								}
								
							echo '
							</div>
							
							<!------------Size------------>
							<div class="mpci-business-table-border" '.$style.'>
								<div id="size-div-'.$i.'">
									<p>'.$obj->size.'</p>
								</div>';
								
								# This division will display when the admin is loggedin.
								if($_SESSION['loggedin'] == true && $_SESSION['admin'] == true){
									echo '
									<div id="size-input-'.$i.'" class="price-table">
										<input class="price-table-accept" name="size" type="text" placeholder="'.$obj->size.'">
									</div>';
								}
							echo '
							</div>';
							
							# This division will display when the admin is loggedin.
							if($_SESSION['loggedin'] == true && $_SESSION['admin'] == true){
							
								echo'
								<!------------Submit------------>
								<div class="mpci-business-table-border" '.$style.'>
									<div id="submit-div-'.$i.'">
										<span class="product-option edit">
											<img id="submit-'.$i.'" src="mpci-view/images/mpci_edit.png" title="Edit">
										</span>
										<span title="remove column" class="edit remove-new-price">
											<a href="?price_row_delete='.urlencode($this->model->encrypt($price_data)).'"><img src="mpci-view/images/mpci_trash.png"></a>
										</span>';
										
										# show the add (plus symbol) sign
										if(($number_rows - 1) == $i){
											echo 
											'<span title="add new column" id="add-new-price" class="edit">
												<img src="mpci-view/images/add.png">
											</span>';
										}
									echo 
									'</div>';
								
									echo '
									<div id="submit-input-'.$i.'" class="price-table">
										<input class="price-table-submit" name="price-table-submit" type="submit">
										<img id="submit-close-'.$i.'" class="remove" src="mpci-view/images/remove.png" title="close">											
									</div>';

									# jquery
									$text .= 
									"$(document).ready(function(){".
										"$(\"#submit-$i\").click(function(){".
											"$(\"#paper-input-$i\").slideDown(\"slow\");".
											"$(\"#paper-div-$i\").slideUp(\"slow\");".
											"$(\"#discription-input-$i\").slideDown(\"slow\");".
											"$(\"#discription-div-$i\").slideUp(\"slow\");".
											"$(\"#price-input-$i\").slideDown(\"slow\");".
											"$(\"#price-div-$i\").slideUp(\"slow\");".
											"$(\"#tax-input-$i\").slideDown(\"slow\");".
											"$(\"#tax-div-$i\").slideUp(\"slow\");".
											"$(\"#style-input-$i\").slideDown(\"slow\");".
											"$(\"#style-div-$i\").slideUp(\"slow\");".
											"$(\"#size-input-$i\").slideDown(\"slow\");".
											"$(\"#size-div-$i\").slideUp(\"slow\");".
											"$(\"#submit-input-$i\").slideDown(\"slow\");".
											"$(\"#submit-div-$i\").slideUp(\"slow\");".
										"});".
									"});\n";
									
									# jquery for close
									$text .= 
									"$(document).ready(function(){".
										"$(\"#submit-close-$i\").click(function(){".
											"$(\"#paper-input-$i\").slideUp(\"slow\");".
											"$(\"#paper-div-$i\").slideDown(\"slow\");".
											"$(\"#discription-input-$i\").slideUp(\"slow\");".
											"$(\"#discription-div-$i\").slideDown(\"slow\");".
											"$(\"#price-input-$i\").slideUp(\"slow\");".
											"$(\"#price-div-$i\").slideDown(\"slow\");".
											"$(\"#tax-input-$i\").slideUp(\"slow\");".
											"$(\"#tax-div-$i\").slideDown(\"slow\");".
											"$(\"#style-input-$i\").slideUp(\"slow\");".
											"$(\"#style-div-$i\").slideDown(\"slow\");".
											"$(\"#size-input-$i\").slideUp(\"slow\");".
											"$(\"#size-div-$i\").slideDown(\"slow\");".
											"$(\"#submit-input-$i\").slideUp(\"slow\");".
											"$(\"#submit-div-$i\").slideDown(\"slow\");".
										"});".
									"});\n";
									
									# jquery for new set of price
									$text .= 
									"$(document).ready(function(){".
										"$(\"#add-new-price\").click(function(){".
											"$(\"#new-set-row\").slideDown(\"slow\");".
										"});".
									"});\n";
									
							echo'</div>';
							}# if end
					# end of form
					echo'</form>';
					}# if end 
					
					# increment the value of $i
					$i++;
				}# while end
			}# if end
			
			# include mpci_new_set_price.php from directory insert
			if($_SESSION['loggedin'] == true && $_SESSION['admin'] == true){
				echo
				'<form action="" method="post">'.
				'<div id="new-set-row" style="display:none;">';
					include('mpci-view/includes/insert/mpci_new_set_price.php');
					
				echo 
				'</div>'.
				'</form>';
			}
					
			# This division will display when the admin is loggedin.
			if($_SESSION['loggedin'] == true && $_SESSION['admin'] == true){
				# Make a jquery file
				$myfile = fopen("mpci-view/js/mpci_price.js", "w") or die("Unable to open file!");

				# write the jquery to file.
				fwrite($myfile, $text);

				# close file writting
				fclose($myfile);
			}
		?>
		</div>
		<div id="note">
			<div id="take-note">
				<p>Note: Tax is included in product price and additional 12% value added tax.</p>
				<?php 
					if($_SESSION['loggedin'] == true && $_SESSION['admin'] == true){
						echo "<p>Note: Press ctrl+shift+del to clear cache in chrome if the options doesn't work.</p>";
					}
				?>
			</div>
		</div>
		
	<!-- .wrapper end-->	
	</div>

<!-- .mpci-business-table end-->		
</div>