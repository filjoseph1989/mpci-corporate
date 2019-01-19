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

# model_query
# encrypt
# evaluate
# extract

class mpci_evaluate extends mpci_create{
    
    # -------------------------------------------
	# function use to submit sql query.
    # -------------------------------------------
	public function model_query($query){
	    # note: $this->db is declare in class model use to coordinate with class safe.
		return $this->db->mpci_query($query);
	}
	
    # -------------------------------------------
	# function use to scape string for mysql query
    # -------------------------------------------
	public function model_string_scape($string){
		return $this->db->string_scape($string);
	}

    # -------------------------------------------
    # function use to submit data for encryption
    # -------------------------------------------
	public function encrypt($data){
		$key  = "0912491878709124918787091249187870912491878709124918787091249187";
		# note: $this->crypt is declare in class model use to coordinate with class safe.
		$data = $this->crypt->encrypt($data,$key);
		return $data;
	}

    # function use to submit data for decryption
	public function decrypt($data){
		$key  = "0912491878709124918787091249187870912491878709124918787091249187";
		# note: $this->crypt is declare in class model use to coordinate with class safe.
		$data = $this->crypt->decrypt($data,$key);
		return $data;
	}
	
    # function use to evaluate left side link information
	public function evaluate($option){
		# trim underscore from both end ex: "_business_card_" will become "business_card"
		$option = trim($option);
		# replace the space with underscore
		$option1 = str_replace(' ', '_', $option);
		# concatenate string.
		$option2 = "SELECT * FROM mpci_" . strtolower($option1);
		# save as an array
		$option  = array($option1, $option2);
		# then return the string assign to $option to class mpci-control.
		return $option;
	}

	public function convert_to_lower($option){
		# trim underscore from both end ex: "_business_card_" will become "business_card"
		$option = trim($option);
		# replace the space with underscore
		$option = str_replace(' ', '_', $option);
		# convert to lower case character.
		$option = strtolower ($option);
		# then return the string assign to $option to class mpci-control.
		return $option;
	}
	

	# ------------------------------------------------------------------------------
	# method use to compare data in the login.
	# ------------------------------------------------------------------------------
	public function compare_data($result, $user, $pass){
		# initiate an empty username.
		$username = "";
		
		# if no error in querying database.
		if($result){
    		# check if there's email address and password in the record.
    		while($obj = $result->fetch_object()){
    		    # decrypt the email and password from database.
    		    $email = $this->decrypt($obj->email);
    		    $paswd = $this->decrypt($obj->password);
				
                # if found in the record, set the session name and username to return.
    			if(strcmp($email, $user) == 0 && strcmp($paswd, $pass) == 0){
					# get the username
    				$username = $this->decrypt($obj->first_name);
    			}
    		}# while
		}
		
		# return the assigned username or return empty username.
		return $username;
	}
	

	# ------------------------------------------------------------------------------
	# Method that return email from the database and 
	# a method that return encrypted email if the request is to update admin record.
	# ------------------------------------------------------------------------------
	public function isregister($option, $result, $email){
	    # initiate variable.
	    $fetch_email = "";
	    
		# check the database if the given email address is in database.
		if($result){
			while($obj = $result->fetch_object()){
				# decrypt email from database.
		    $temp1 = $this->decrypt($obj->email);

				# encrypted email
				$temp2 = $obj->email;
				
				# Determine if the email is match to the given email.
				if(strcmp($temp1,$email) == 0 && !empty($email)){
					# determine the option
				    switch($option){
						# assign the decrypted email.
						case "":
							$fetch_email = $temp1;
							$_SESSION['forgot_password_email'] = $temp2;
						break;
						
						# assign the encrypted email.
						case "update_admin":
							$fetch_email = $temp2;
						break;
					}
				}
				
				# use in verification code.
				if(empty($email)){
					# devrypted email.
					$fetch_email = $temp1;
				}
			}
		}
		
		# return email
		return $fetch_email;
	}
	

	# ------------------------------------------------------------------------------
	# Method fetching the mpci information.
	# ------------------------------------------------------------------------------
	public function display_info($ID, $option, $result){
		$message = "";
		
		# if the option is to update the site info or "site-update"
		if(strcmp($option,"site_update") == 0){
			
			# given the database data or access
			if($result){
				while($obj = $result->fetch_object()){
					# compare the the given ID and the database recorded ID.
					if(strcmp($obj->ID,$ID) == 0){
						$message = $obj->message;
					}
				}
			}
		}
		return $message;
	}
	
    # function that return current year.
	public function current_year($year = 'auto'){
		if(intval($year) == 'auto'){ 
			$year = date('Y'); 
		}
		if(intval($year) == date('Y')){ 
			return intval($year); 
		}
		if(intval($year) < date('Y')){ 
			return intval($year) . ' - ' . date('Y'); 
		}
		if(intval($year) > date('Y')){ 
			return date('Y'); 
		}
	}

	# print password or text function
	public function print_password($password){
		if($password=="password" || $password=="c_password"){
			return 'password';
		}else{
			return 'text';
		}
	}
	

	# ------------------------------------------------------------------------------
	# function that clean the string
	# ------------------------------------------------------------------------------
	public function clean_string($string) {
		$bad = array("content-type","bcc:","to:","cc:","href");
		return str_replace($bad,"",$string);
	}

	
	# ------------------------------------------------------------------------------
	# arrangethe value of the given data for price table
	# ------------------------------------------------------------------------------
	public function price_data_arrange_value($price_data, $data){
		# -------------------------------
		if(!empty($data['paper'][0])){
			$paper = $data['paper'][0];
		}else{
			$paper = $price_data['paper'];
		}

		# -------------------------------
		if(!empty($data['discription'][0])){
			$description = $data['discription'][0];
		}else{
			$description = $price_data['description'];
		}

		# -------------------------------
		if(!empty($data['price'][0])){
			$price = $data['price'][0];
			$tax = $price * 0.12;
		}else{
			$price = $price_data['price'];
			$tax = $price_data['tax'];
		}

		# -------------------------------
		if(!empty($data['style'][0])){
			$style = $data['style'][0];
		}else{
			$style = $price_data['style'];
		}

		# -------------------------------
		if(!empty($data['size'][0])){
			$size = $data['size'][0];
		}else{
			$size = $price_data['size'];
		}
		
		# create an array of the important data for updating the table of price.
		$info = array(
			'paper' 	  => $paper,
			'description' => $description,
			'price'       => $price,
			'tax' 		  => $tax,
			'style' 	  => $style,
			'size' 		  => $size
		);
		return $info;
		
	}
}# class end.

?>