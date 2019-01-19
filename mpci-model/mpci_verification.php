<?php /*
Project Name: 	MPCI-CORPORATE
Description:	MPCI-CORPORATE is new division of Midtown Printing Company Incorporated (MPCI) for creative task.
Developer:		Fil Elman
Version:		mpci-corporate 1.0
Website:		www.mpcicorporate.com
copyright:		@Copyright 2014*/

# this will prevent from direct accessing of  this file
if( count(get_included_files()) == 1) {
	die("Error, Contact webtoprint.midtown.com.ph");
}

# Beginning of class mpci_verification
class mpci_verification{
	# Identifiers
	protected $verification;
	
	# constructor
	public function __construct($data){
		$this->verification = $data;
	}
	
	# Main method for verification
	public function price_verification(){
		# variable for error message.
		$error_message = "";

		# loop through array to determine if alphanumeric or not
		foreach ($this->verification as $validate){ 
			# initialize the value of result as true.
			$result = "true";

			# remove the space(s)
			$temp = str_replace(" ", "", $validate[0]);

			# initial message
			$error_message = "Please enter a valid input, and don't include special characters on field ";

			# validate for alphanumeric value
			if(!empty($validate[0]) && $validate[1] == "alphanumeric"){
				# verify if temp is alpha-numeric characters
				$result = $this->alphanumeric( $temp );
				if($result == "false"){
					$error_message .= "that require letters and number only.";
					break;
				}
			}

			# validate for float value
			if(!empty($validate[0]) && $validate[1] == "float"){
				# verify if temp has float value
				$result = $this->floatcharacter( $temp );
				if($result == "false"){
					$error_message .= "that require decimal number only.";
					break;
				}
			}

			# validate for letter value
			if(!empty($validate[0]) && $validate[1] == "letters"){
				# verify if temp is letter only
				$result = $this->letteronly( $temp );
				if($result == "false"){
					$error_message .= "that require letters only.";
					break;
				}
			}

			# validate for letter and integer value
			if(!empty($validate[0]) && $validate[1] == "letterinteger"){
				# verify if temp is letter and number
				$result = $this->letterandnumber( $temp );
				if($result == "false"){
					$error_message .= "that require letters and number only.";
					break;
				}
			}

			# re empty the value of $error_message when true.
			if($result == "true"){
				$error_message = "";
			}
		}

		# return the result
		if( empty($error_message) ){
			return "true";
		}else{
			return $error_message;
		}
	}
	
	# check if alphanumeric characters
	public function alphanumeric($string){
		if( ctype_alnum ( $string ) ){
			return "true";
		}else{
			return "false";
		}
	}

	# check if float characters
	public function floatcharacter($string){
		if( is_numeric ( $string ) ){
			return "true";
		}else{
			return "false";
		}
	}

	# check if letters only
	public function letteronly($string){
		if( ctype_alpha ( $string ) ){
			return "true";
		}else{
			return "false";
		}
	}

	# check if letters and number only
	public function letterandnumber($string){
		if( preg_match('/^[\w.]*$/', $string) ){
			return "true";
		}else{
			return "false";
		}
	}
}#end of class mpci_verification

?>