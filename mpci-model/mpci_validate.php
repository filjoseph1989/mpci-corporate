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
# and can be use in this class.
class mpci_validate{
    
	# --------------------------------------------
	# VALIDATION OF INPUTS
	# --------------------------------------------
	public function mpci_validation($data){
		
		# ----------------------------------------
		/* 	Break the data into array
			temp[0] is first name
			temp[1] is last name
			temp[2] is email
			temp[3] is password
			temp[4] is confirm password
			temp[5] is street
			temp[6] is city
			temp[7] is zip code
			temp[8] is telephone number
			temp[9] is mobile number
			temp[10] is captha
		*/
		# ----------------------------------------
		$temp = explode("/",$data);
		
		# ----------------------------------------
		# Variable use to handle error messages.
		# ----------------------------------------
		$error_message = "";

		# ----------------------------------------
		# Charaters use to determine a valid names, 
		# last names and address.
		# ----------------------------------------
		$string_exp = "/^[A-Za-z .'-]+$/";

		# ----------------------------------------
		# Charaters use to validate email address
		# ----------------------------------------
		$email_exp = "/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/";


		# ----------------------------------------
		# Verify the Name and Last Name
		# ----------------------------------------
		# First Name
		if(isset($temp[0])){
			# if name is empty
			if(empty($temp[0])){
				$error_message .= 'The Name field was empty.<br />';
			}else
			# check if contain letters only
			if(!preg_match($string_exp,$temp[0])){
				$error_message .= 'The Name you have entered does not appear to be valid.<br />';
			}			
		}
		# Last Name
		if(isset($temp[1])){
			# if last name is empty
			if(empty($temp[1])){
				$error_message .= 'The Last Name field was empty.<br />';
			}else
			# check if letters only
			if(!preg_match($string_exp,$temp[1])){
				$error_message .= 'The Last Name you have entered does not appear to be valid.<br />';
			}			
		}


		# -------------------------------------------------------------------------------------
		# VERIFY EMAIL ADDRESS
		# -------------------------------------------------------------------------------------
		if(isset($temp[2])) {
			# if email is empty
			if(empty($temp[2])){
				$error_message .= 'The Email Address field was empty.<br />';
			}else
			# check if valid charaters
			if(!preg_match($email_exp,$temp[2])){
				$error_message .= 'The Email Address you have entered does not appear to be valid.<br />';
			}			
		}


		# -------------------------------------------------------------------------------------
		# VALIDATE PASSWORD
		# -------------------------------------------------------------------------------------
		if(isset($temp[3]) && isset($temp[4])){
			$length = strlen($temp[3]);
			
			# verify if has a character
			if(empty($temp[3]) || empty($temp[4])){
				$error_message .= 'The Password field was empty.<br/>';			
			}else
			
			# Verify if it is 8-20 character.
			if($length < 8 || $length > 20){
				$error_message .= 'The Password must have 8-20 characters long.<br/>';			
			}else
			
			# verify if the password and confirmation password match
			if($temp[3] != $temp[4]){
				$error_message .= 'The Password and confirmation password does not match.<br/>';
			}
		}
		

		# -------------------------------------------------------------------------------------
		# VALIDATE ADDRESS (street and city)
		# -------------------------------------------------------------------------------------
		if( isset($temp[5]) || isset($temp[6]) ){
			# verify if the addres field is not empty
			if(empty($temp[5]) || empty($temp[6])){
				$error_message .= 'The Address field was empty.<br />'; 
			}else
			
			# verify the characters
			if(!preg_match($string_exp,$temp[5]) || !preg_match($string_exp,$temp[5])){
				$error_message .= 'The Address you entered does not appear to be valid.<br />'; 
			}
		}


		# -------------------------------------------------------------------------------------
        # VALIDATE zip code
		# -------------------------------------------------------------------------------------
		if(isset($temp[7])){
			# check if its not empty
			if( empty($temp[7]) ){
				$error_message .= 'The zip code field was empty.<br />';
			}else
			# digit only
			if( !ctype_digit($temp[7]) ){
				$error_message .= 'The zip code does not appear to valid.<br />';
			}
		}


		# -------------------------------------------------------------------------------------
        # VALIDATE telephone number of the user.
		# -------------------------------------------------------------------------------------
		if( isset($temp[8]) ){
			# check if not empty
			if( empty($temp[8]) ){
				$error_message .= 'The telephone number field was empty.<br />';
			}else
			
			# check if number only
			if( !preg_match('/^[0-9]{7}$/', $temp[8]) ){
				$error_message .= 'The telephone number you entered does not appear to be valid.<br />';
			}
		}


		# -------------------------------------------------------------------------------------
        # VALIDATE mobile number of the user.
		# -------------------------------------------------------------------------------------
		if( isset($temp[9]) ){
			# check if its not empy
			if(empty($temp[9])){
				$error_message .= 'The Mobile number field was empty.<br />';
			}else
			
			# check if number only
			if(!preg_match('/^[0-9]{11}$/', $temp[9])){
				$error_message .= 'The Mobile number you entered does not appear to be valid.<br />';
			}
		}


		# -------------------------------------------------------------------------------------
        # VALIDATE captha
		# -------------------------------------------------------------------------------------
		if( isset($temp[10]) ){
			# check if its not empty
			if(empty($temp[10])){
				$error_message .= 'Image text field was empty.<br />';
			}else
			
			# if match the key
			if($temp[10] != $_SESSION['key']){
				$error_message .= 'Image text does not match to your input.<br />';
			}
		}


		# ----------------------------------------
		# Return any errors found.
		# ----------------------------------------
		return $error_message;
	}# end of mpci_validation
	

	# ----------------------------------------
	# VALIDATE PRODUCT OPTION
	# ----------------------------------------
	public function validate_product_category($category){
		# set an empty result
		$result = "";
		# set sql query
		$query  = "SELECT * FROM mpci_left"; 
		# submit to mysql_affected_rows
		$result = $this->model_query($query);
		# retrive data from result
		if($result){
			while($obj = $result->fetch_object()){
				if($category == $obj->name){
					$result = "okay";
					break;
				}
			}
		}
		
		return $result;
	}


	# ----------------------------------------
	# VALIDATE PRODUCT OPTION
	# ----------------------------------------
	public function validate_folder_filename($filename){
		if (strpbrk($filename, "\\/?%*:|\"<>") === FALSE) {
			return "true";
		}else {
			return "false";
		}
	}
}# class end.

?>