<?php /*
Project Name: 	MPCI-CORPORATE
Description:	MPCI-CORPORATE is new division of Midtown Printing Company Incorporated (MPCI) for creative task.
Developer:		Fil Elman
Version:		mpci-corporate 1.0
Website:		www.mpcicorporate.com
copyright:		@Copyright 2014*/

# this will prevent from direct accessing of  this file
if( count(get_included_files()) == 1) die("Error, Contact webtoprint.midtown.com.ph");

# note: $this->db and $this->crypt is declare in class model
# and can be use un this class.
class mpci_create extends mpci_validate{
    
	# Function that create image captcha.
	public function generate_code(){
        # Md5 to generate the random string
        $mpci_code = md5(microtime());
        
        # Return code.
        return $mpci_code;
	}
	
	# Making a thumbnails size images
	public function make_thumbnail($data) {
		$newwidth  = 0;
		$newheight = 0;
		
		# get the height and width of the image
		# -------------------------------------------------------
		list($width, $height) = getimagesize( $data["image_temp"] );

		# get the standard dimension of the image and
		# set a new height and width for thumbnails
		switch($data["image_tablename"]){
			case "mpci_sample":
			case "mpci_business_cards":
				if($width >= 246){
					$newwidth = 246;
				}
				if($height >= 142){
					$newheight = 142;
				}
			break;

			case "mpci_flyers":
			case "mpci_greeting_cards":
			case "mpci_letterhead":
			case "mpci_bookmarks":
				if($width >= 157){
					$newwidth = 157;
				}
				if($height >= 237){
					$newheight = 237;
				}
			break;

			case "mpci_invitation":
				if($width >= 246){
					$newwidth = 246;
				}
				if($height >= 180){
					$newheight = 180;
				}
			break;

			case "mpci_postcards":
				if($width >= 246){
					$newwidth = 246;
				}
				if($height >= 164){
					$newheight = 164;
				}
			break;

			case "mpci_labels":
				if($width >= 246){
					$newwidth = 246;
				}
				if($height >= 142){
					$newheight = 142;
				}
			break;

		}
		
		# To create thumbnail of image
		if($data["image_extension"] == "jpg" || $data["image_extension"] == "jpeg" ){
			$src = imagecreatefromjpeg($data["image_temp"]);
		}else if( $data["image_extension"] == "png" ){
			$src = imagecreatefrompng($data["image_temp"]);
		}else{
			$src = imagecreatefromgif($data["image_temp"]);
		}

		# Check if the new dimension is created
		if($newwidth != 0){
			# folder path
			$img_dir = "mpci-view/images/products/";
			# make a path to a folder for thumbnail
			$img_thumb = $img_dir . $data["image_fileName"];	
			# set a true color to retain the images quality
			$dest = imagecreatetruecolor($newwidth,$newheight);
			# create a new image
			imagecopyresampled($dest, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
			# save image to its own folder destination
			imagejpeg($dest, $img_thumb, 100);			
			# create mysql query
			$query = "UPDATE ".$data["image_tablename"]." SET image='".$data["image_fileName"]."' WHERE product='".$data["image_category"]."'";
			# return a query to mpci_process.php
			return $query;
		}else{
			return "The size of image is not supported.";
		}

	}
	
	
	# ---------------------------------------------------------
	# This method will generate an identification(id) for price.
	# ---------------------------------------------------------
	public function generate_price_id(){
		# Determine the last id recorded from the database.
		# This query will display only one last record
		$query = "SELECT * FROM mpci_price ORDER BY price_id DESC LIMIT 1";
		$results = $this->model_query($query);
		if( $results ){
			while($tmp = $results->fetch_object()){
				$last_id = $tmp->price_id;
			}
		}
		
		# Get the number of rows affected
		# To determine if the database has a record and no.
		# And the program can decide whether to generate a
		# new id or not.
		$rows = $results->num_rows;

		# Separate the word 'price' and the 'number' from the given identification(id)
		$id = explode('e',$last_id);
		
		# After separation of word and number
		# increment the number and combine again to the word
		if($rows == 1){
			$id_number = "price";
			if($id[1] >= 1 && $id[1] < 9){
				$id_number .= "00";
			}
			if($id[1] >= 9 && $id[1] < 99){
				$id_number .= "0";
			}
			$id[1]++;
			$id_number .= $id[1];
		}else{
			$id_number = "price001";
		}
		
		# return the generated new id number.
		return $id_number;
		
	}
}# class end.

?>