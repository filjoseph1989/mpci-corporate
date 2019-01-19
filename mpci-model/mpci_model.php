<?php /*
Project Name: 	MPCI-CORPORATE
Description:	MPCI-CORPORATE is new division of Midtown Printing Company Incorporated (MPCI) for creative task.
Developer:		Fil Elman
Version:		mpci-corporate 1.0
Website:		www.mpcicorporate.com
copyright:		@Copyright 2014*/

# this will prevent from direct accessing of  this file
if( count(get_included_files()) == 1) die("Error, Contact webtoprint.midtown.com.ph");

# Require classes for model
require('mpci-model/mpci-mailer/PHPMailerAutoload.php');
require('mpci-model/mpci_validate.php');
require('mpci-model/mpci_create.php');
require('mpci-model/mpci_evaluate.php');
require('mpci-model/mpci_mailer.php');
require('mpci-model/mpci_database.php');
require('mpci-model/mpci_safe.php');

# Beginning of class mpci_model
class mpci_model extends mpci_mailer{
	# Identifiers
	protected $db;
	protected $crypt;
	protected $config;
	protected $mail;
	
	# -----------------------------------------
	# constructors
	# -----------------------------------------
	public function __construct($config){
		$this->config = $config["ADMIN_EMAIL"];
		# create a new database object.
		$this->db 	  = new mpci_database(
			$config["DB_SERVER"], 
			$config["DB_USERNAME"], 
			$config["DB_PASSWORD"], 
			$config["DB_DATABASE"]
		);
		# create a new safe object.
		$this->crypt = new mpci_safe();
		# create a new mailer object.
		$this->mail  = new PHPMailer;
	}
	

	# --------------------------------------------------
	# LOGIN METHOD
	# --------------------------------------------------
	public function login( $login_email, $login_password){
		$username = "";
		
		# request data from table mpci_admin in mpcicorporate.
		$result = $this->db->mpci_query("SELECT * FROM mpci_admin");
		
		# look at the admin record if username and password exist.
		$admin  = $this->compare_data($result, $login_email, $login_password);

		# request data from table mpci_users in mpcicorporate.
		$result = $this->db->mpci_query("SELECT * FROM mpci_users");
		
		# look at the users record if username and password exist.
		$user   = $this->compare_data($result, $login_email, $login_password);

		# if the username was found as admin, set the following.
		if(!empty($admin)){
		    # assign admin to username.
		    $username = array(
				'username' => $admin,
				'status'   => "admin"
			);
		}else
		
		# if the username was found as admin, set the following.
		if(!empty($user)){
		    #assign user to username.
		    $username = array(
				'username' => $user,
				'status'   => "user"
			);
		}else{
			$username = "invalid username or password";
		}

		# return username or the message "invalid username or password" 
		return $username;
	}
    

	# ------------------------------------------------------------------------
	# SIGN UP METHOD
	# ------------------------------------------------------------------------
	public function mpci_signup($option, $data){
		# set
		$result = "";
		$query  = "";
		$mpci_code = "";
		
		# validate data.
		$message = $this->mpci_validation($data);
		
		# if there's no invalid inputs
		if(empty($message)){
			# generate a email confirmation code
			$mpci_code = $this->generate_code();
			
			# break the data.
			$temp   = explode("/",$data);
			$length = count($temp);
			
			# encrypt each data.
			for($i = 0; $i < $length; $i++){
				$temp[$i] = $this->encrypt($temp[$i]);
			}

			# query to mysql for users
			if($option == "user"){
				# get data from database.
				$result = $this->db->mpci_query("SELECT * FROM mpci_users");
				# make a query
				$query  = "INSERT INTO mpci_users(email, first_name, last_name, password, address, city, zipcode, telephone, mobile, verification, status) 
				VALUES ('$temp[2]', '$temp[0]', '$temp[1]', '$temp[3]','$temp[5]','$temp[6]', '$temp[7]', '$temp[8]', '$temp[9]', '$mpci_code','0')";
			}

			# query to mysql for admin
			if($option == "admin"){
				# get data from database.
				$result = $this->db->mpci_query("SELECT * FROM mpci_admin");
				# make a query
				$query  = "INSERT INTO mpci_admin(email, first_name, last_name, password, verification, status) 
				VALUES ('$temp[2]', '$temp[0]', '$temp[1]', '$temp[3]', '$mpci_code','0')";
			}

			# determine if the email is already registered.
			# the value of $temp[2] is email.
			$registered = $this->isregister("", $result, $this->decrypt($temp[2]));

			# if registered then inform
			if(!empty($registered)){
				$message = 'The email you provide was already registered';
			}

			# else then do the following.
			else{
				# submit the query to mysql
				$result = $this->db->mpci_query($query);

				# if successful, inform the one who register.
				if($result){
					# decrypt back the email
					$temp[2] = $this->decrypt($temp[2]);
					# send a confirmation code to email.
					# $this->config is admin's email.
					$message = $this->sign_up_mail($this->config[4], $temp[2], $mpci_code);
					# if successfully sent
					if($message == "true"){
						$message = $temp[2] . '/successful';
					}
					# else not
					else{
						$message = "we have trouble in sending a confirmation code to your mail.";
					}
				}else{
					$message = "Your Data cannot be saved in our database.";
				}
			}
		}
		
		# return errors
		return $message;
	}
	
	
	# ------------------------------------------------------------------------
	# UPDATE ADMIN METHOD
	# ------------------------------------------------------------------------
	public function mpci_update_admin($data){
		$temp = explode("/",$data);
		# validate data.
		$message = $this->mpci_validation($data);
		if(empty($message)){
			# Get the encrypted email from the database.
			$result		 = $this->db->mpci_query("SELECT * FROM mpci_admin");
            
            # Check the existence of email, and get the email if there exist.
            # this email must satisfy the WHERE clause of the query.
			$fetch_email = $this->isregister("update_admin", $result, $temp[2]);
			
			# encrypt the given information of the admin.
			$first_name  = $this->encrypt($temp[0]);
			$last_name   = $this->encrypt($temp[1]);
			$email 		 = $this->encrypt($temp[2]);
			$password 	 = $this->encrypt($temp[3]);
			
			# Make a query to update the admin's record.
			$query 	= "UPDATE mpci_admin SET email='$email', first_name='$first_name', last_name='$last_name', password='$password' WHERE email='$fetch_email'";
			
			# Make a query to database.
			$result = $this->db->mpci_query($query);

			# Getting the result of the query
			if($result){
				# send a message to homepage
				$message = "Administrator with an email $temp[2] was successfully updated.";
			}else{
				$message .= "We have problem updating your record";
			}
		}
		return $message;
	}
	

	# ----------------------------------------------
	# SEND CONTACT US
	# ----------------------------------------------
	public function mpci_contact_us($data, $message, $attachment){
		# validate data.
		$errors = $this->mpci_validation($data);
		# if no errors
		if( empty($errors) ){
			# if not emty message
			if( !empty($message) ){
				# send message to administrator
				$message = $this->contact_us_mail($data, $message, $attachment);
				# if successfully sent
				if($message = "true"){
					$message = "Thank you for contacting us. We will be in touch with you very soon.";
				}
			}else{
				$message = 'You have no message.<br />';
			}
			
		}else{
			$message = $errors;
		}
		
		return $message;
	}


	# ------------------------------------------------------------------------
	# SEND FORGOT PASSWORD LINK
	# ------------------------------------------------------------------------
	public function forgot_password($current_url, $email_from){
		# Set a message for sign_up.
		$email_to 		 = $this->clean_string($email_from);
		$email_subject = "MPCI CORPORATE FORGOT PASSWORD SUPPORT";
		$mpci_code 		 = $this->generate_code();
		$_SESSION['forgot_password_code'] = $mpci_code;
		
		# message
		$email_message = '
			<html>
			<head>
				<title>'.$email_subject.'</title>
			</head>
			<body>
				<p>please visit the link below to reset your password:</p>
				<p>'.$current_url.'?passwordreset='.$mpci_code.'</p>
			</body>
			</html>
		';

		# To send HTML mail, the Content-type header must be set
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

		# create email headers
		$headers .= 'From: '			.$email_from."\r\n".
					'Reply-To: '		.$email_from."\r\n" .
					'X-Mailer: PHP/' 	. phpversion();

					# sent email.
		$message = mail($email_to, $email_subject, $email_message, $headers); 
		if($message){
			return "we've sent a link to your email to reset your password.";
		}

	}
	

	# ------------------------------------------------------------------------
	# This function will update the record of mpci corporate informations.
	# ------------------------------------------------------------------------
	public function update_info($id, $category, $title, $message){
		# escape string that may triger the sql query
		$id			  = $this->db->string_scape($id);
		$category	= $this->db->string_scape($category);
		$title	 	= $this->db->string_scape($title);
		$message 	= $this->db->string_scape($message);

		# update the table mpci_info
		$query 	 = "UPDATE mpci_info SET ID='$id',category='$category',title='$title',message='$message' WHERE ID='$id'";
		$result  = $this->db->mpci_query($query);
		if($result && $category != "term of use"){
			return $title.'Successfullu Updated!';
		}
	}
	

	# ------------------------------------------------------------------------
	# This method will update the data regarding product's price in the database
	# ------------------------------------------------------------------------
	public function price_table($price_data, $info){
		# decrypt the price data
		$price_data = $this->decrypt($price_data);
		# create a new values of array
		$result 	= $this->price_data_arrange_value($price_data, $info);
		# make a standard format for price
		$price 		= number_format($result['price'], 2, '.', ',');
		# make a standard format for tax
		$tax 		= number_format($result['tax'], 2, '.', ',');
		$result['size'] = $this->db->string_scape( $result['size'] );
		if($result == true){
			$query = "UPDATE mpci_price SET paper='".$result['paper']."', discription='".$result['description']."', price='$price', Tax='$tax', style='".$result['style']."', size='".$result['size']."', product='".$price_data['product']."' WHERE price_id='".$price_data['price_id']."'";
		}
		return $query;
	}
 
}# class end

?>