<?php /*
Project Name: 	MPCI-CORPORATE
Description:	MPCI-CORPORATE is new division of Midtown Printing Company Incorporated (MPCI) for creative task.
Developer:		Fil Elman
Version:		mpci-corporate 1.0
Website:		www.mpcicorporate.com
copyright:		@Copyright 2014*/

# this will prevent from direct accessing of  this file
if( count(get_included_files()) == 1) die("Error, Contact webtoprint.midtown.com.ph");

class mpci_process extends mpci_includes{

    # ----------------------------------------
	# CAPTCHA
	# ----------------------------------------
	public function display_captcha($option){
		switch($option){
		    # Editor 
			case "captchaeditor":
    			$captcha = '
    			 * CAPTCHA*<br/>
    			 * Using captcha or text image is our way to identify that you are not a robot who want to register or contact us*<br/>
    			 *              please prove that you are not.          *<br/>
    			';
    			$this->mpci_message($captcha);
    			$this->mpci_editor("", "", "", "", 'contact');
		    break;
		    
			# Sign Up
		    case "captchasignup":
    			$captcha = '
    			 * CAPTCHA*<br/>
    			 * Using captcha or text image is our way to identify that you are not a robot who want to register or contact us*<br/>
    			 *              please prove that you are not.          *<br/>
    			';
    			$this->mpci_message($captcha);
		    break;
		}
	
	}


    # ----------------------------------------
	# REMOVE ADMIN
	# ----------------------------------------
	public function remove_admin($email, $option){
		$message = "";
		# confirm
		if(!isset($_POST['remove_yes'])){
			# confirm the administrator about removing registered admin.
			$message = "Are you sure you want to remove ".$email;
		}
		# remove if confirm
		if(isset($_POST['remove_yes'])){
			if($option == "get"){
				# submit a query to mysql to display all admin record
				$result  = $this->model->model_query("SELECT * FROM mpci_admin");
			}
			if($option == "post"){
				# submit a query to mysql to display all admin record
				$result  = $this->model->model_query("SELECT * FROM mpci_users");
			}
			# fetch the encrypted email from database.
			$email = $this->model->isregister("update_admin", $result, $email);	
			
			if($option == "get"){
				# Submit a query to database that remove the registered admin
				$result = $this->model->model_query("DELETE FROM mpci_admin WHERE email='$email'");
			}
			if($option == "post"){
				# Submit a query to database that remove the registered admin
				$result = $this->model->model_query("DELETE FROM mpci_users WHERE email='$email'");
			}
			# if the result is good.
			if($result){
				$message = "Successfuly remove ".$this->model->decrypt($email);
			}
		}
		# -----------------------------------------
		# if "no" was clicked in the message, 
		# redirect to update admin.
		# -----------------------------------------
		if(isset($_POST['remove_no'])){
			$message = "adminlist";
		}
		
		return $message;
	}
	

  # ----------------------------------------
  # UPLOAD FILE IN A PRODUCT GROUP
  # ----------------------------------------
	public function upload_file_in_product_group( $data, $img_name, $img_temp ){
		$message   = "";
		$img       = "";
		$extension = "";

		# image path
		# ----------
		$file_exists = "mpci-view/images/products/".strtolower($data["product_category"])."/".$data["product_name"]."/".$img_name;
		$folder_01   = "mpci-view/images/products/".strtolower($data["product_category"]);
		$folder_02   = "mpci-view/images/products/".strtolower($data["product_category"])."/".$data["product_name"];
		
		# check if the upload file already exist and have a filename
		# ----------------------------------------------------------
		if (file_exists( $file_exists )) {
			if(!empty($img_name)){
				$message = $img_name . " already exists. <br/>";
			}else{
				$message = "You have no image to upload";
			}
		}else{
			# error handler
			# -------------
			$error_message	= "";

			# create a folder if it doen't exist
			# ----------------------------------
			if( !is_dir($folder_01) ){
				mkdir($folder_01);
			}
			if( !is_dir($folder_02) ){
				mkdir($folder_02);
			}

			# separate the extension and the name of the image
			# this will be use in making thumbnails and to determine
			# the supported file extension.
			# ------------------------------------------------------
			$image = "";
			if(!empty($img_name)){
				$image = explode('.', $img_name);
				$extension = strtolower($image[1]);
			}

			# Check if the extension of the image is supported
			# -------------------------------------------------
			if(!in_array($extension , array('jpg','jpeg', 'gif', 'png', 'bmp'))){
				$error_message .= "File extension is not supported.";
			}

			# check the filename of the uploaded image if it valid.
			# -----------------------------------------------------
			if(isset($image[0])){
				$result = $this->model->validate_folder_filename($image[0]);
			}
			if($result == "false"){
				$error_message .= "The filename of the image is not supported<br/>";
			}
			
			/* make a filename for thumbnail.
			   e.g Nature_1416908080_thumb.png
			   -------------------------------*/
			# thumb is use in mpci_product.sql
			$thumb = $data["product_name"].'_'.time().'_thumb.'.$extension;
			# this is use in the category's database
			$img_fileName = strtolower($data["product_category"])."/".$data["product_name"].'/'.$thumb;
			# create an array
			$thumbnail = array(
				# path of image temp file
				"image_temp"  => $img_temp,
				# image extension
				"image_extension" => $extension,
				# the filename of the image
				"image_fileName" => $img_fileName,
				# the mysql table name
				"image_tablename" => 'mpci_'.strtolower($data["product_category"]),
				# a cetegory of a product
				"image_category" => $data["product_name"]
			);
			# make a thumbnail of the given image.
			# ------------------------------------
			$query = $this->model->make_thumbnail($thumbnail);
					
			# This option provide the administrator with the authority to set only
			# thumbnail size display of the image in the product page.
			# --------------------------------------------------------------------
			if( isset($_POST['thumbnail']) ){
				# if there were no errors
				if( empty($error_message) ){
					# Check first the return value of the $query.
					# -------------------------------------------
					$message = explode(" ",$query);
					if($message[0] == "UPDATE"){
						# submit query to mysql
						$result = $this->model->model_query($query);
						if($result){
							$message = "Successfully create a thumbnail<br/>";
						}else{
							$message = "Failed To Update Featured Image";
						}
					}else{
						$message = $query;
					}
				}
			}# thumbnail end

			# Option for adding new product in actual dimension
			# ----------------------------------------------
			if( isset($_POST['actualsize']) ){
				$category = $data["product_category"];
				$category = strtolower($category);
				
				if( empty($error_message) ){
					# Get the last recorded ID
					# ------------------------
					$product_id = "SELECT * FROM mpci_products ORDER BY product_id DESC LIMIT 1";
					$result = $this->model->model_query($product_id);

					# get the number of rows affected with the query
					$rows	= $result->num_rows;
					$last_id = "";
					if($result){
						while($tmp = $result->fetch_object()){
							$last_id = $tmp->product_id;
						}
					}
						
					# if there's return a number of row, add 1
					# ----------------------------------------
					if($rows == 1){
						$last_id   = explode("t",$last_id);
						$id_number = "product";
						if($last_id[1] < 9){
							$id_number .= "00";
						}
						if($last_id[1] == 9){
							$id_number .= "0";
						}					
						if($last_id[1] >= 10 && $last_id[1] < 99){
							$id_number .= "0";
						}
						$id_number .= $last_id[1]+1;
					}
					
					# if the return is zero, create a staring id
					else{
						$id_number = "product001";
					}

					# Set an insert query for new product
					$query  = "INSERT INTO mpci_products(product_id, product_category, product_name, product_image, product_thumb) VALUES ('$id_number', '".$category."', '".$data["product_name"]."', 'mpci_".$img_name."', '$thumb')";
						
					# submit query to mysql
					$result = $this->model->model_query($query);

					# Display a message for successful query
					if($result){
						# move uploaded image to mpci-view/images/products/directory/directory/
						move_uploaded_file( $img_temp, $folder_02."/mpci_$img_name");
						$message .= "Successfully updated product image";
					}else{
						$message = "Failed To Update Featured Image";
					}
				}else{
					$message = $error_message;
				}
				
			}

			# check if one one of the checkboxes is not checked.
			# -------------------------------------------------
			if( !isset($_POST['thumbnail']) && !isset($_POST['actualsize'])){
				$message = "You must check at least one of the check boxes.";
			}
		}# else end

		# display the message in the home pages
		return $message;
	
	}
	

    # ----------------------------------------
	# SET NEW PRICE
    # ----------------------------------------
	public function set_new_price($data){
		# Check if has the price
		if(empty($data["product_price"])){
			return "You have no price input.";
		}else
		
		# Validate the price
		if($data["product_price"] < 1){
			return "You price input must not less than P1.00<br/> and you must not include other character in you price input other than number(s)!";
		}
		
		else{
			# change the number format
			$new_price = number_format($data["product_price"], 2, '.', ',');
			# make a query format
			$query = "UPDATE ".$data["db_table"]." SET price='".$new_price."' WHERE id='".$data["product_id"]."'";
			# submit the query to database
			$result = $this->model->model_query($query);
			# return the result
			if($result){
				return "Successfully update the price";
			}
		}
	}
	

	# ------------------------------------------------------
	# this will remove the category name in the database
	# ------------------------------------------------------
	public function remove_directory_extn($remove_category, $product_dir){
		# set an empty message
		$message = "";
		# set an empty mysql query
		$query = "DELETE FROM  mpci_".strtolower($remove_category["product_category"])."  WHERE id='".$remove_category["product_id"]."'";
		# submit a query
		$result = $this->model->model_query($query);

		# -------------------------------------------
		if($result){
			$message = "Successfully remove the category \"".$remove_category["product_name"]."\"";
			rmdir($product_dir);
		}

		# Update the product id
		# ------------------------------------------
		# keep the product ID
		$product_id = $remove_category["product_id"];
		# initialize the value of the row
		$row = 0;
		while($row == 0){
			# decrrement product ID
			$product_id--;
			# make a query base on the given id
			$query = "SELECT id, product, image, price, addbox FROM mpci_".strtolower($remove_category["product_category"])." WHERE id = '$product_id'";
			$result = $this->model->model_query($query);
			# determine the number of row
			$row = $result->num_rows;
		}

		# update the field addbox to 'no'
		# -----------------------------------------------
		if($remove_category["product_addbox"] == "yes"){
			# make a query to update the value of addbox field in mysql
			$query  = "UPDATE mpci_".strtolower($remove_category["product_category"])." SET addbox='yes' WHERE id='$product_id'";
			# submit the query to mysql
			$result = $this->model->model_query($query);
			# emptying this variable to avoid conflict
			$product_id = "";
		}

		return $message;
	}

}
?>
