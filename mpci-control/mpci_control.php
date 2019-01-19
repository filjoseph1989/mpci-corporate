<?php /*
Project Name: 	MPCI-CORPORATE
Description:	MPCI-CORPORATE is new division of Midtown Printing Company Incorporated (MPCI) for creative task.
Developer:		Fil Elman
Version:		mpci-corporate 1.0
Website:		www.mpcicorporate.com
copyright:		@Copyright 2014*/

# this will prevent from direct accessing of  this file
if( count(get_included_files()) == 1) die("Error, Contact webtoprint.midtown.com.ph");

require("mpci-control/mpci_includes.php");
require("mpci-control/mpci_process.php");
require("mpci-control/mpci_extended.php");
require("mpci-model/mpci_model.php");
require("mpci-model/mpci_verification.php");

class mpci_control extends mpci_extended {
	protected $model;
	protected $email;
	protected $abspath;
	
	
	# ----------------------------------
	# constructors
	# ----------------------------------
	public function __construct($config){
		# create an object model
		$this->model   = new mpci_model($config);
		# create an admin email
		$this->email   = $config["ADMIN_EMAIL"];
		# create an absolute path.
		$this->abspath = $config["MPCI_PATH"];
	}
	
	
    # ----------------------------------------------------------------------------------------------
	# Method that display mpci corporate contents in the home page such of the following,
	# slider, featured products, about us etc. 
	# ----------------------------------------------------------------------------------------------
	public function mpci_content($url, $option){
		# ----------------------------------------
		# ALLOWABLE TAGS
	    # ----------------------------------------
		$allowedTags ='<p><strong><em><u><h1><h2><h3><h4><h5><h6><img>';
		$allowedTags.='<li><ol><ul><span><div><br><ins><del>'; 
		
		$data    = "";
		$admin   = "";
		$message = "";
		
		# initial blank id, title and page.
		$id 		= "";
		$title 		= "";
		$category 	= "";

	    # ----------------------------------------
		# PRINT DIV
	    # ----------------------------------------
		echo '<div id="mpci-main" class="mpci-float-left mpci-background" >';
		
	    # ----------------------------------------
		# MESSAGE
		# this will display any message generated 
		# after the process.
		# ----------------------------------------
		if(isset($_GET['message'])){
			$this->mpci_message($_GET['message']);
		}


	    # ----------------------------------------
		# FORGOT PASSWORD FORM
		# when the user/admin click the forgot password
		# this will be true.
	    # ----------------------------------------
		if(isset($_GET['forgot'])){
			# display the form mpci_forgot_password.php
			# class mpci_include.php
			$this->mpci_forgot_password();
		}
		

		# ------------------------------------
		# FORGOT PASSWORD
		# this will update the database
		# ------------------------------------
		if(isset($_POST['change_password'])){
			$password  = $_POST['mpci_new_password'];
			$cpassword = $_POST['mpci_con_password'];
			$error_message = "";
			
			if(isset($password) && isset($cpassword)){
				$length = strlen(password);
				
				# verify if has a character
				if(empty($password) || empty($cpassword)){
					$error_message .= 'The Password field was empty.<br/>';		
				}else
				
				# Verify if it is 8-20 character.
				if($length < 8 || $length > 20){
					$error_message .= 'The Password must have 8-20 characters long.<br/>';			
				}else
				
				# verify if the password and confirmation password match
				if($password != $cpassword){
					$error_message .= 'The Password and confirmation password doesn\'t match.<br/>';
				}
			}

			if(empty( $error_message )){
				$email  = $_SESSION['forgot_password_email'];
				$password = $this->model->encrypt($password);
				$query  = "UPDATE mpci_users SET password='$password' WHERE email='$email'";
				$result = $this->model->model_query($query);
				if($result){
					$this->mpci_message("successfully change your password");
					$_SESSION['forgot_password_email'] = "";
					$_SESSION['forgot_password_code'] = "";
				}
			}else{
				$this->mpci_message( $error_message );
			}
		}


		# ------------------------------------
		# FORGOT PASSWORD
		# this will allow user/admin to reset
		# or change their password forgotten.
		# ------------------------------------
		if(isset($_GET['passwordreset'])){
			if( strcmp( $_SESSION['forgot_password_code'], $_GET['passwordreset']) == 0 ){
				# show a form for password and confirmation password
				# filename: mpci_password_reset.php
				# class mpci_include
				$this->forgot_password();
			}
		}


		# ------------------------------------
		# FORGOT PASSWORD
		# check and sent a link to email regarding
		# the forgot password request.
		# ------------------------------------
		if(isset($_POST['forgot_password'])){
			# Recieve an email address.
			$email  = $_POST['forgot_password'];
			# Create a query for mcpi_users.
			$query  = "SELECT * FROM mpci_users";
			# submit the query to mysql.
			$result = $this->model->model_query($query);
			# Get the email if registered
			$email  = $this->model->isregister("", $result, $email);
			# if there is email fetched
			if(!empty($email)){
				# send a password reset link to the given email.
				$message = $this->model->forgot_password($url, $email);
				# Tell the user to visit his/her email.
				$this->mpci_message($message);
			}else{
				$this->mpci_message("we could not find your email $email in our database.");
			}
		}


    # ----------------------------------------
		# OPTION's
		# this will display the meaning of captcha
		# ----------------------------------------
		if(!is_array($option)){
			$this->display_captcha($option);
		}


	    # ----------------------------------------
		# MPCI_VERIFICATION
		# this will update the status of the admin/user
	    # ----------------------------------------
		if(isset($_POST['mpci_verification'])){
			# Recieve the code from form
			$code   = $this->model->model_string_scape($_POST['mpci_verification']);
			
			# ----------------------------------------
			# verification for admin email
			# ----------------------------------------
			$query  = "SELECT * FROM mpci_admin WHERE verification='$code' and status='0'";
			$result = $this->model->model_query($query);
			$email  = $this->model->isregister("", $result, "");
			if(!empty($email)){
				$query  = "UPDATE mpci_admin SET status='1' WHERE verification='$code'";
				$result = $this->model->model_query($query);
				if($result){
					$email = $email . " successfully verified.";
					$this->mpci_message($email);
				}
			}

			# ----------------------------------------
			# verification for users email
			# ----------------------------------------
			$query  = "SELECT * FROM mpci_users WHERE verification='$code' and status='0'";
			$result = $this->model->model_query($query);
			$email  = $this->model->isregister("", $result, "");
			if(!empty($email)){
				$query  = "UPDATE mpci_users SET status='1' WHERE verification='$code'";
				$result = $this->model->model_query($query);
				if($result){
					$email = $email . " successfully verified.";
					$this->mpci_message($email);
				}
			}
		}


		# ----------------------------------------
		# SAVING THE ADDITIONAL SITE INFORMATION.
		# Not yet finish programming
		# message generated here will be used back to the editor.
		# ----------------------------------------
		if(isset($_POST['mpci-information-save'])) {
			# recieve the information submitted from the text editor.
			$message = strip_tags(stripslashes($_POST['elm1']),$allowedTags);
			# notify that the new information was successfully save in database. 
			$this->mpci_message("message save");
		}
		
		
		# ----------------------------------------
		# SAVING THE UPDATED SITE INFORMATION.
		# message also generated here will be use again to the text editor(tinymce)
		# ----------------------------------------
		if(isset($_POST['mpci-information-update'])) {
			$id 	    = htmlspecialchars($_POST['site-id']);
			$category = htmlspecialchars($_POST['site-category']);
			$title	  = htmlspecialchars($_POST['site-title']);
			$message  = strip_tags(stripslashes($_POST['elm1']),$allowedTags);
			
			# update the database information.
			$update	  = $this->model->update_info($id, $category, $title, $message);
			
			# retrieve the records back.
			$result	  = $this->model->model_query("SELECT * FROM mpci_info");
			
			# display the results.
			if(strcmp($category,"term of use") == 0){
				$this->mpci_info($result,$category);
			}else{
				$this->mpci_message($update);
			}
		}
		
		
		# ----------------------------------------
		# UPDATE ADMIN DATA
		# this will update the record of administrator
		# ----------------------------------------
		if(isset($_POST['update_submit'])) {

			# initialization.
    		$first_name = htmlspecialchars($_POST['first_name']);
    		$last_name 	= htmlspecialchars($_POST['last_name']);
    		$email 		= htmlspecialchars($_POST['update_email']);
    		$password 	= htmlspecialchars($_POST['password']);
    		$c_password	= htmlspecialchars($_POST['c_password']);
			
			# make all data in one statement
			$data    = $first_name .'/'. $last_name .'/'. $email .'/'. $password .'/'. $c_password;
			# submit data to update.
			$message = $this->model->mpci_update_admin($data);
			$data	.= "/update";
			

			# Display the resulting message.
			$this->mpci_message($message);
		}

		
		# ----------------------------------------
		# ADD ADMIN
		# this will add the administrator's data into
		# database.
		# ----------------------------------------
		if(isset($_POST['admin_submit'])) {
			# initialization.
			$first_name = htmlspecialchars($_POST['first_name']);
			$last_name 	= htmlspecialchars($_POST['last_name']);
			$email 		  = htmlspecialchars($_POST['email']);
			$password 	= htmlspecialchars($_POST['password']);
			$c_password	= htmlspecialchars($_POST['c_password']);

			# Check if sign-up form are not empty
			if(	!empty($first_name) || 
				!empty($last_name)  ||
				!empty($email)      || 
				!empty($password)   || 
				!empty($c_password) ){

				# make all data in one statement
				$data    = $first_name .'/'. $last_name .'/'. $email .'/'. $password .'/'. $c_password;
				# submit the data into sign-up
				$message = $this->model->mpci_signup("admin",$data);
				# break the message.
				$temp	 = explode("/",$message);
				# determine if successful in process
				if(isset($temp[1]) && $temp[1] == "successful"){
					# make a message for the user.
					$message  = "Successfully registered.<br/>";
					$message .= "We sent a confirmation code to $temp[0], to verify your email address|mpci_confirmation";
					$this->mpci_message($message);
					# empty the data to prevent sending it back to sign-up form.
					$data = "";
				}
				# if has invalid or any errors
				else{
					$this->mpci_message($message);
				}
			}else{
				$this->mpci_message("You need to fill up all required text field.<br/>");
			}
			
		}

        
		# ----------------------------------------
		# ADD ADMINISTRATOR
		# this will display a add administrator form 
		# ----------------------------------------
		if(	isset($_GET['addadmin'])){
			$this->mpci_admin("addadmin", "", "", "", "", $url, $data);
		}
		

		# ----------------------------------------
		# UPDATE ADMINISTRATOR
		# this will display a table, list of administrator.
		# ----------------------------------------
		if(	isset($_GET['adminlist'])){
			# submit a query to mysql database.
			$result = $this->model->model_query("SELECT * FROM mpci_admin");

			# pass the result, to display all admin records.
			# value of $_GET['adminlist'] is "adminlist"
			$this->mpci_admin($_GET['adminlist'], "", "", "", $result, "", "");
		}

		
		# ----------------------------------------
		# UPDATE ADMINISTRATOR
		# this will display administrator's info into
		# a form
		# ----------------------------------------
		if( isset($_GET['adminupdate']) ){
			$temp = explode("/",$data);
			if(isset($temp[5]) && $temp[5] == "update"){
				# encrypt the info and pass to temp
				$temp = $this->model->encrypt($data);
				# empty the data again
				$data = "";
			}else{
				# pass the encrypted info to temp.
				$temp = $_GET['adminupdate'];
			}
			
			$temp = $this->model->decrypt($temp);
			$temp = explode("/",$temp);
			if(isset($temp[5]) && $temp[5]== "update"){
				# temp[0] is first name
				# temp[1] is last name
				# temp[2] is email
				# temp[5] is "update"
				$this->mpci_admin($temp[5], $temp[2], $temp[0], $temp[1], "", $url, "");
			}else{
				# temp[0] is update
				# temp[1] is email
				# temp[2] is first name
				# temp[3] is last name
				$this->mpci_admin($temp[0], $temp[1], $temp[2], $temp[3], "", $url, "");
			}
		}


		# ----------------------------------------
		# DELETE ADMINISTRATOR
		# this will delete the record of the admin
		# in the database.
		# ----------------------------------------
		if( isset($_GET['remove']) ){
			# decrypt the encrypted data.
			$temp = $this->model->decrypt($_GET['remove']);
			# break the value of temp;
			$temp = explode("/",$temp);
			
			# pass to remove admin, $temp[1] is email
			$message = $this->remove_admin($temp[1], "get");
			
			# if the message return is "adminlist" make it an option
			# for mpci_admin() else show a message.
			if($message == "adminlist"){
				$temp[0] = $message;
			}else{
				$this->mpci_message($message);
			}

			# show the updated list excluding the deleted email.
			$result = $this->model->model_query("SELECT * FROM mpci_admin");
			# display administrator's area.
			$this->mpci_admin($temp[0], $temp[1], "", "", $result, $url, "");
		}
		

		# ----------------------------------------
		# SEND EMAIL TO USER
		# this will send email to registered client
		# ----------------------------------------
		if(isset($_POST['indi_user_submit'])){
			$error_message = "";
			$email = $_POST['indi_user_email'];
			$name  = $_POST['indi_user_name'];
			$subject = $_POST['indi_user_subject'];
			$message = $_POST['elm1'];
			
			if(!preg_match("/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/",$email)){
				$error_message .= 'The Email Address you have entered does not appear to be valid.<br />';
			}			
			if(!preg_match("/^[A-Za-z .'-]+$/",$name)){
				$error_message .= 'The Name you have entered does not appear to be valid.<br />';
			}			
			if(empty($message)){
				$error_message .= 'You have empty message.<br />';
			}			
			if(empty($error_message)){
				$this->model->send_users_mail($this->email, $email, $name, $subject, $message);
			}else{
				$this->mpci_message($error_message);
			}			
		}


		# ----------------------------------------
		# REQUEST SEND EMAIL TO ADMIN
		# this will compose a message for admin
		# ----------------------------------------
		if( isset($_POST['admin_indi_sendemail']) ){
			$email_info = $this->model->decrypt($_POST['email_info']);
			$admininfo = array($email_info['email'], $email_info['first_name'], $email_info['last_name']);
			$message = $this->send_email_user($admininfo);
			$this->mpci_message($message);
		}


		# ----------------------------------------
		# REQUEST SEND EMAIL TO USER
		# this will compose a message for client
		# ----------------------------------------
		if( isset($_POST['user_indi_sendemail']) ){
			$email = $this->model->decrypt($_POST['user_indi_email']);
			$name  = $this->model->decrypt($_POST['user_indi_name']);
			$lname = $this->model->decrypt($_POST['user_indi_lname']);
			$userinfo = array($email, $name, $lname);
			$message = $this->send_email_user($userinfo);
			$this->mpci_message($message);
		}


		# ----------------------------------------
		# DELETE USER
		# this will delete the record of the user
		# in the database.
		# ----------------------------------------
		if( isset($_POST['user_indi_delete']) ){
			# decrypt the encrypted email.
			$temp = $this->model->decrypt($_POST['user_indi_email']);
			# pass the email to 
			$message = $this->remove_admin($temp,"post");
			# if the message return is "adminlist" make it an option
			# for mpci_admin() else show a message.
			if($message == "adminlist"){
				$temp[0] = $message;
			}else{
				$this->mpci_message($message);
			}
		}


		# ----------------------------------------
		# SHOW ADMIN LIST
		# this will display a table, the list of administrator.
		# ----------------------------------------
		if(	isset($_GET['showadmin'])){
			# decrypt the data fron mpci_showadmin_individual.php
			$show_admin_list = $this->model->decrypt($_GET['showadmin']);
			# submit to
			$this->mpci_admin("showadmin_individual", "", "", "", "", "", $show_admin_list);
		}

		
		# ----------------------------------------
		# DISPLAY LIST OF USERS
		# this will display the record of the user
		# from the database.
		# ----------------------------------------
		if( isset($_GET['showuserlist']) ){
			# decrypt the array submitted from mpci_showuser.php
			$showuserlist = $this->model->decrypt($_GET['showuserlist']);
			
			# if remove_no is set in mpci_message.php
			if(isset($_POST['remove_no'])){
				$this->mpci_admin("showuser_individual", "", "", "", "", "", $showuserlist);
			}else
			
			# if remove_yes is set in mpci_message.php
			if(isset($_POST['remove_yes'])){
				# get the value of remove_email from mpci_message.php
				$temp = $_POST['remove_email'];
				# submit to remove_admin function in mpci_process.php
				$message = $this->remove_admin($temp,"post");
				# display message
				$this->mpci_message($message);
			}
			
			# just display the user's list
			else{
				$this->mpci_admin("showuser_individual", "", "", "", "", "", $showuserlist);
			}
			
		}


		# ----------------------------------------
		# SHOW USER LIST
		# this will display a table, the list of clients.
		# ----------------------------------------
		if(	isset($_GET['showuser'])){
			# $_GET['showuser'] value is "showuser"
			$showuser = $_GET['showuser'];
			# If the value of $_GET['showuser'] is "showuser"
			# this condition will validate the input
			if($showuser == "showuser"){
				$result  = $this->model->model_query("SELECT * FROM mpci_users");
				$this->mpci_admin($showuser, "", "", "", $result, "", "");
			}
		}

		
		# ----------------------------------------
		# EDIT THE SITE INFORMATION
		# this will display an editor for site information
		# ----------------------------------------
		if(	isset($_GET['editinfo'])){
			$result  = $this->model->model_query("SELECT * FROM mpci_info");
			$this->mpci_admin("editinfo", "", "", "", $result, "", "");
		}


		# ----------------------------------------
		# CONTACT US
		# this will send a email message to mpci corporate administrator.
		# ----------------------------------------
		if(isset($_POST['contact-us'])) {
    		$first_name 	= htmlspecialchars($_POST['first_name']);
    		$last_name 		= htmlspecialchars($_POST['last_name']);
    		$email_from 	= htmlspecialchars($_POST['contact_email']);
    		$telephone 		= htmlspecialchars($_POST['telephone']);
			$captcha		= $_POST['captcha'];
    		$message 		= $_POST['elm1'];

			# email attachment
			# ----------------------------------------------------------------------------------
			$attachment = "";
			$errors = "";
			# name of the attachment.
			$name = basename($_FILES["attachment_file"]["name"]);
			# validation
			if( !empty($name) ){
				# get the extension of attachment
				$type_of_uploaded_file = substr($name, strrpos($name, '.') + 1);
				# size of the attachment in kilobytes
				$size_of_uploaded_file = $_FILES["attachment_file"]["size"]/1024;
				# size in megabytes
				$size_of_uploaded_file = $size_of_uploaded_file/1024;
				# set allowed sized in megabytes.
				$max_allowed_file_size = 10;
				# set allowable file extension.
				$allowed_extensions = array("jpg", "jpeg", "gif", "bmp", "zip", "pdf", "png");

				# validations of size
				if($size_of_uploaded_file > $max_allowed_file_size ){
					$errors = "<br/> Size of file should be less than $max_allowed_file_size<br/>";
				}			

				# validate the file extension
				$allowedtxt = "false";
				for( $i = 0; $i < sizeof($allowed_extensions); $i++){
					# compare extension
					if( strtolower($allowed_extensions[$i]) == strtolower($type_of_uploaded_file)){
						$allowedtxt = "true";
						break;
					}
				}
				if($allowedtxt == "false"){
					$errors .= "<br/>The uploaded file is not supported file type. ".
					"Only the following file types are supported: ".implode(',',$allowed_extensions);
				}
				
				
				# transfer the file to server upload folder and get the path if no errors
				if( empty($errors) ){
					# copy the temp. uploaded file to uploads folder
					$tmp_path = $_FILES["attachment_file"]["tmp_name"];
					# move the temporary file of the upload to mpci-upload folder
					move_uploaded_file( $tmp_path, "mpci-upload/".$name);
					# attachment path
					$attachment = "mpci-upload/".$name;
				}
			}

			# get the length of the telephone.
			# can be 7 or 11
			$tel_length = strlen($telephone);
			# make all data in one statement
			if($tel_length == 7){
				$data = $first_name .'/'. $last_name .'/'. $email_from .'/password/password/address/city/0000/'. $telephone .'/09124918787/'. $captcha;
			}
			if($tel_length == 11){
				$data = $first_name .'/'. $last_name .'/'. $email_from .'/password/password/address/city/0000/1234567/'.$telephone.'/'. $captcha;
			}
			
			# Check if sign-up form are not empty
			if(	!empty($first_name) || 
				!empty($last_name)  ||
				!empty($email_from) || 
				!empty($telephone)  ||
				!empty($captcha)
			){
				if( !empty($errors) ){
					$msg = $errors;
				}else{
					# send a message
					$msg = $this->model->mpci_contact_us($data, $message, $attachment);
				}
			}else{
				$msg = $errors;
				$msg .= "<br/>You need to fill up the contact form";
			}
			
			# delete file uploaded to the server.
			if (file_exists($attachment)) {
				unlink($attachment);
			}
			
			# display a message.
			$this->mpci_message($msg);
		}


		# ----------------------------------------
		# SIGN UP PROCESS
		# ----------------------------------------
		if(isset($_POST['signup_submit'])) {
			
			# initialization
			$first_name = htmlspecialchars($_POST['first_name']);
			$last_name 	= htmlspecialchars($_POST['last_name']);
			$email 		= htmlspecialchars($_POST['email']);
			$password 	= htmlspecialchars($_POST['password']);
			$c_password	= htmlspecialchars($_POST['c_password']);
			$address	= htmlspecialchars($_POST['address']);
			$city		= htmlspecialchars($_POST['city']);
			$zipcode	= htmlspecialchars($_POST['zipcode']);
			$telephone	= htmlspecialchars($_POST['telephone']);
			$mobile		= htmlspecialchars($_POST['mobile']);
			$captcha	= $_POST['captcha'];
			
			# Check if sign-up form are not empty
			if(	!empty($first_name) || 
				!empty($last_name)  ||
				!empty($email)      || 
				!empty($password)   || 
				!empty($c_password) ||
				!empty($address)    ||
				!empty($city)       ||
				!empty($zipcode)    ||
				!empty($telephone)  ||
				!empty($mobile)		||
				!empty($captcha))    {
				# make all data in one statement
				$data    = $first_name .'/'. $last_name .'/'. $email .'/'. $password .'/'. $c_password .'/'. $address .'/'. $city .'/'. $zipcode .'/'. $telephone .'/'. $mobile .'/'. $captcha;
				# submit the data into sign-up
				$message = $this->model->mpci_signup("user",$data);
				# break the message.
				$temp	 = explode("/",$message);
				# determine if successful in process
				if(isset($temp[1]) && $temp[1] == "successful"){
					# make a message for the user.
					$message  = "Successfully registered.<br/>";
					$message .= "We sent a confirmation code to $temp[0], to verify your email address|mpci_confirmation";
					$this->mpci_message($message);
					# empty the data to prevent sending it back to sign-up form.
					$data = "";
				}
				# if has invalid or any errors
				else{
					$this->mpci_message($message);
				}
			}else{
				$this->mpci_message("You need to fill up all required text field.<br/>");
			}
			
		}
		

	    # ----------------------------------------
		# CHANGE THE TITLE OF THE CATEGORY 
		# this will UPDATE the title of the category under a particular products
		# ----------------------------------------
		if(isset($_POST['new_title_submit'])){
			$message = "";
			# decrypt the encrypted $_POST['new_title_data']
			$new_title = $this->model->decrypt($_POST['new_title_data']);

			# validate the new filename
			$result = $this->model->validate_folder_filename($_POST['new_title']);

			# when the filename is valid
			if($result == "true"){
				# path to old directory
				$old_dir = strtolower($new_title['product_category'])."/".$new_title['product_name'];
				# path for new directory
				$new_dir = strtolower($new_title['product_category'])."/".$_POST['new_title'];
				# use for checking directories
				$new_dir_check = "mpci-view/images/products/$new_dir";
				$old_dir_exist = "mpci-view/images/products/$old_dir";
				
				# check the given title already exist
				# --------------------------------------------------------------------
				# make a query for checking if the filename is recorded in the database
				$query = "SELECT * FROM mpci_".strtolower($new_title['product_category']);
				# submit the query to mysql
				$result = $this->model->model_query($query);
				# search the given title if it's already in the database
				if($result){
					while($obj = $result->fetch_object()){
						if($obj->product == $_POST['new_title']){
							$message = $_POST['new_title']." category may already exist";
						}
					}
				}
				
				# if the message is empty, no found problem in new title
				if(empty($message)){
					# update the image filename
					$image_filename = explode('/',$new_title['image_filename']);

					# determine first if the image displayed in the category if default
					if($image_filename[0] == "default.png" || $image_filename[0] == "Default.png"){
						$image_filename = "Default.png";
					}
					# else edit the given filename
					else{
						$image_filename = $image_filename[0].'/'.$_POST['new_title'].'/'.$image_filename[2];
					}

					# make a query
					$query = "UPDATE mpci_".strtolower($new_title['product_category'])." SET product='".$_POST['new_title']."', image='".$image_filename."' WHERE id='".$new_title['product_id']."'";
					# submit the query to mysql
					$result = $this->model->model_query($query);
					# a query to update mpci_product
					$query = "UPDATE mpci_products SET product_name='".$_POST['new_title']."' WHERE product_name='".$new_title['product_name']."'";

					# submit the query to mysql
					$result = $this->model->model_query($query);
					if($result){
						# make a message
						$message = "Successfully change the name of the category.";
					}

					# check if the new filename is a directory, rename if not
					if(!is_dir($new_dir_check) && is_dir($old_dir_exist)){
						# rename the old folder
						rename($old_dir_exist, $new_dir_check);
						# make a message
						$message = "Successfully change the name of the category.";
					}
				}else{
					$message = "The title you give already exist";
				}
				# if end
			}else {
				$message = "The title you give is invalid!";
			}

			# a message
			$this->mpci_message($message);
		}



    # ----------------------------------------
		# ADD NEW CATEGORY
		# this will add new box of category for the particular product
		# ----------------------------------------
		if(isset($_POST['new_category_submit'])){
			$message = "";
			# decrypt the data sent from mpci_product.php requesting to add a new category.
			$new_box = $this->model->decrypt($_POST['new_box']);
			# check if there's a given new title for the new category
			if(!empty($_POST['new_category'])){
				# get the title of the new category
				$new_category = $_POST['new_category'];
				# get the current product id of the product
				$product_id = $new_box['product_id'];
				# increment the value of the given id
				$product_new_id = $product_id + 1;
				# validate the new category
				$result = $this->model->validate_folder_filename($new_category);
				# if the folder name is valid
				if($result == "true"){
					# check if the new title given is already in the database
					$query = "SELECT product FROM mpci_".strtolower($new_box["product_category"])." WHERE product = '$new_category'";
					$result = $this->model->model_query($query);
					$row = $result->num_rows;
					if($row == 0){
						# Add the new title in the database
						$query = "INSERT INTO mpci_".strtolower($new_box["product_category"])." (id, product, image, price, addbox) VALUES ('$product_new_id', '$new_category', 'default.png', '00.00', 'yes')";
						$result = $this->model->model_query($query);
						if($result){
							$message = "Successfully added new category for ".$new_box["product_category"];
						}else{
							$message = "Failed to add new category";
						}
						# this prevent the plus sign to display in previous categories
						$query = "UPDATE mpci_".strtolower($new_box["product_category"])." SET addbox='no' WHERE id='$product_id'";
						$result  = $this->model->model_query($query);
						$product_id = "";
					}else{
						$message = "The title already exist!";
					}
				}else{
					$message = "Invalid filename for a new category";
				}
			}else{
				$message = "You don't have a title for a new category";
			}
			$this->mpci_message($message);
		}
		
		
	    # ----------------------------------------
		# CHANGE PRICE
		# this will UPDATE the pricing in the featured area
		# ----------------------------------------
		if(isset($_POST['new_price_save'])){
			# Assign the decrypted array submitted from mpci_product.php
			$product_data  = $this->model->decrypt($_POST['mpci_product_option']);
			$product_id    = $product_data["product_id"];
			$product_price = $_POST['new_price'];
			$table_name    = "mpci_".strtolower($product_data["product_category"]);
			$price_data    = array(
				# product table
				"db_table" => $table_name, 
				# product id
				"product_id" => $product_id, 
				# product new price
				"product_price" => $product_price
			);
			$message = $this->set_new_price($price_data);
			$this->mpci_message($message);
		}
		# Option for setting new featured product price
		# ---------------------------------------------
		if(isset($_POST['new_price_submit'])){
			# decrypt the info from mpci_product about new price update
			$product_data = $this->model->decrypt($_POST['mpci_product_option']);
			# get the product id
			$product_id    = $product_data['product_id'];
			# get the new price
			$product_price = $_POST['new_price'];
			# define the table name like mpci_business_cards
			$table_name    = "mpci_" . strtolower($product_data["product_category"]);	
			# create an array
			$price_data    = array(
				# product table
				"db_table" => $table_name, 
				# product id
				"product_id" => $product_id, 
				# product new price
				"product_price" => $product_price
			);
			$message = $this->set_new_price($price_data);
			$this->mpci_message($message);
		}
		
		
    # ----------------------------------------
		# UPDATE FEATURE IMAGES
		# this will UPDATE the images display in the featured area
		# ----------------------------------------
		if(isset($_POST['feature_upload_file'])){
			# Get the name of the product
			$product_name = $_POST['product_query'];
			# file
			$file = "mpci_file";
			
			# check if the given filename already exist
			if (file_exists("mpci-view/images/products/" . $_FILES[$file]["name"])) {
				$message = $_FILES[$file]["name"] . " already exists. ";
			}else {
				# separate the extension and the name of the image
				# this variable is use in making a thumbnails
				# -----------------------------------------------------
				if(!empty($_FILES[$file]["name"])){				
					$img  = explode('.', $_FILES[$file]["name"]);
					$extension  = strtolower($img[1]);
				}

				# Check the supported extension
				# --------------------------------------------------------------------
				if(in_array($extension , array('jpg','jpeg', 'gif', 'png', 'bmp'))){
					# make a thumbnail filename
					$img_fileName  = $img[0].time().'_Thumb.'.$extension;
					# create an array
					$thumbnail = array(
						# path of the image temp file
						"filename"  => $_FILES[$file]["tmp_name"],
						# image extension
						"extension" => $extension,
						# a name product directory where an image will go
						"product_directory"	=> "products",
						# a category of a certain product where the image will be save
						"mpci_product_category" => $_POST['mpci_sample_category'],
						# the filename of the image
						"img_fileName" => $img_fileName,
						# the mysql table name
						"product_name" => $product_name
					);
					
					# make a thumbnail image
					$query = $this->model->make_thumbnail($thumbnail);
				
					# submit query to mysql
					$result = $this->model->model_query($query);
					# display a message for successful query
					if($result){
						$message = "Successfully updated the featured image";
					}else{
						$message = "Failed to update featured image";
					}
				}else{
					$message = "working";//"File extension is not supported.";
				}
			
			}
			
			# Display the generate messages
			$this->mpci_message($message);
		}


    # ----------------------------------------
		# UPDATE PRODUCT IMAGES
		# this will UPDATE the images display in the featured under a particular product
		# ----------------------------------------
		if(isset($_POST['upload_file'])){
			# Assign the decrypted array submitted from mpci_product.php
			$product_data = $this->model->decrypt($_POST['mpci_product_option']);
			# process the image from file upload.
			$message = $this->upload_file_in_product_group($product_data, $_FILES["mpci_file"]["name"], $_FILES["mpci_file"]["tmp_name"]);
			# display the resulting output after the image is process
			$this->mpci_message($message);
		}


		# ----------------------------------------
		# MESSAGE
		# ----------------------------------------
		if(isset($option["message"]) ){
			$this->mpci_message($option["message"]);
		}
		

		# ----------------------------------------
		# load login form but hidden
		# ----------------------------------------
		$this->mpci_login();
		
		
		# ----------------------------------------
		# INSERT NEW PRICE TO MPCI_PRICE
		# ----------------------------------------
		if(isset($_POST['new-price-table-submit'])){
			#	"product"		=> $price_data['product'],
			#	"last_row"		=> $price_data['last_row']
			
			# decrypt the price_data from mpci_new_set_price.php
			$price_data = $this->model->decrypt($_POST['price_data']);
			$product    = $price_data['product'];
			# Arrange data in as an array
			$price_data = array(
				"paper" 	  => array($_POST['paper'], "alphanumeric"),
				"description" => array($_POST['discription'], "alphanumeric"),
				"price" 	  => array($_POST['price'], "float"),
				"tax" 		  => array($_POST['tax'], "float"),
				"style" 	  => array($_POST['style'], "letters"),
				"size" 		  => array($_POST['size'], "letterinteger")
			);
			
			# Generate an identification(id)
			$new_id = $this->model->generate_price_id();
			
			# create a new object for verification and verify $price_data
			$verification = new mpci_verification($price_data);
			$message = $verification->price_verification();
			if($message == "true"){
				# formalize the number format
				$price = number_format($price_data['price'][0], 2, '.', ',');
				# determine the tax
				$tax   = $price_data['price'][0] * 0.12;
				# formalize the tax number format
				$tax   = number_format($tax, 2, '.', ',');
				# make a query
				$query = "INSERT INTO mpci_price(price_id, paper, discription, price, Tax, style, size, product) VALUES ('$new_id', '".$price_data['paper'][0]."', '".$price_data['description'][0]."', '".$price."', '".$tax."', '".$price_data['style'][0]."', '".$price_data['size'][0]."', '".$product."')";
				# submit to mysql
				$result = $this->model->model_query($query);
				# determine result
				if($result){
					$message = "Successfully added new price data.";
					$this->mpci_message( $message );
				}
			}else{
				$this->mpci_message( $message );
			}
			
			$price_data = "";
		}
		
		
		# ----------------------------------------
		# UPDATE THE PRICE TABLE IN THE DATABASE
		# ----------------------------------------
		if(isset($_POST['price-table-submit'])){
			$info = array(
				"paper" 	  => array($_POST['paper'], "alphanumeric"),
				"discription" => array($_POST['discription'], "alphanumeric"),
				"price" 	  => array($_POST['price'], "float"),
				"tax" 		  => array($_POST['tax'], "float"),
				"style" 	  => array($_POST['style'], "letters"),
				"size" 		  => array($_POST['size'], "letterinteger")
			);
			
			# create a new object for verification and verify $info
			$verification = new mpci_verification($info);
			$message = $verification->price_verification();
			
			if($message == "true"){
				# make a database query base on the data given $_POST['price_data'], $info
				$query 	= $this->model->price_table($_POST['price_data'], $info);
				# submit the query to database.
				$result = $this->model->model_query($query);
				if($result){
					$message = "Successfully updated price table";
				}else{
					$message = "Unsuccessfully updated the price table";				
				}
				# display message.
				$this->mpci_message($message);				
			}else{
				$this->mpci_message( $message );
			}
			
			# delete info value and unset
			$info = "";
		}
		

	    # ----------------------------------------
		# REMOVE SELECTED ITEM
		# this will remove the selected items inside the folder
		# of a particular category
		# ----------------------------------------
		if(isset($_POST['confirm_delete_box'])){
			$message = "";
			# Receive the file list from form
			$box = $_POST['box']; 
			# decrypt the remove_path
			$remove_path = $this->model->decrypt($_POST['remove_path']);
			
			# extract the product name from $remove_path.
			$product_name = explode('/',$remove_path);
			if(isset($product_name[4])){
				$product_name = $product_name[4];
			}

			# Loop through the list of selected files
			while (list ($key,$img) = @each ($box)) {
				# define the path to be remove
				$path = $remove_path."/".$img;
				$thumb = explode("_",$img);
				if(isset($thumb[2])){
					$thumb = explode(".",$thumb[2]);
				}
				if($thumb[0] == "thumb"){
					# decrypt the value of product_category
					$category = $this->model->decrypt($_POST['product_category']);
					
					# rename the folder which is in the path
					$path02 = explode('/',$path);
					$path02 = $path02[3].'/'.$path02[4].'/'.$path02[5];
					
					# check if the file exist in the database
					$query = "SELECT * FROM mpci_".strtolower($category['product_category'])." WHERE image = '".$path02."'";
					$result = $this->model->model_query($query);
					$row = $result->num_rows;
					if($row == 1){
						# update the file in the database in it exist
						$query = "UPDATE mpci_".strtolower($category['product_category'])." SET image='Default.png' WHERE id='".$category['product_id']."'";
						$result = $this->model->model_query($query);
					}
				}

				# make a query to update the mpci_product
				$query = "DELETE FROM mpci_products WHERE product_image='$img' AND product_name='".$product_name."'";
				# submit the query to mysql
				$result = $this->model->model_query($query);
				if($result){
					# check if the file realy exist
					if(file_exists ( $path )){
						unlink($path);
						# create a message
						$message .= "Deleted file $img<br/>";
					}
				}
			}# end of while

			# reempty the value of $product_name
			$product_name = "";
			
			$this->mpci_message($message);
		}
		

		# ----------------------------------------
		# ADMIN AREA
		# ----------------------------------------
		if(	isset($_GET['admin'])){
			# include html for admin
			$this->mpci_admin($_GET['admin'], "", "", "", "", $url, "");
		}else

		
	    # -----------------------------------------------
		# REMOVE ONE CATEGORY OF THE PRODUCT
		# this will remove one category belong to product
		# -----------------------------------------------
		if(isset( $_GET['remove_category'] )){
			# decrypt the $_GET['remove_category']
			$remove_category = $this->model->decrypt($_GET['remove_category']);
			
			# if the no is not clicked in remove confirmation.
			if(!isset($_POST['no_remove_category'])){
				# checking if adding new category is not set to avoid deleting newly added category.
				if(!isset($_POST['new_category_submit']) && !isset($_POST['new_title_submit'])){
					/* 
					Check if the $_GET['upload_file'] is set to avoid displaying 
					the list of images inside the directory to be deleted while 
					uploading new image in a category.
					# ------------------------------------------------------------*/
					if(!isset($_POST['upload_file'])){
						# determine the number of rows it contains in the database
						# -------------------------------------------------------
						$query = "SELECT * FROM mpci_".strtolower($remove_category["product_category"]);
						$result = $this->model->model_query($query);
						$rows	= $result->num_rows;
						#---------------------------

						# make a path to the directory of a category
						$product_dir = "mpci-view/images/products/".strtolower($remove_category["product_category"])."/".$remove_category["product_name"];
						# determine the filename if it is a directory.
						$result = is_dir($product_dir);
						# if directory
						if($result == true){
							# look inside the directory if it has an item(s)
							$list  = scandir($product_dir); 
								
							# check if it contain an item(s) and display to the admin
							if(count($list) >= 3){
								# encrypt the data the path of the directory
								$product_dir = $this->model->encrypt($product_dir);
								# encrypt the array of filenames in the directory
								$list = $this->model->encrypt($list);
								# display the list of items inside the foler
								$this->remove_product_list($list, $product_dir, $remove_category);
							}else{
								# at least greater than one row in the database
								# for the admin able to add new category.
								if($rows > 1){
									if(isset($_POST['yes_remove_category'])){
										# if the admin click "yes" to really remove a category.
										$message = $this->remove_directory_extn($remove_category, $product_dir);
										# display a message.
										$this->mpci_message($message);
									}else{
										# display the confirmation message.
										$this->mpci_remove_confirmation($remove_category['product_name']);
									}
								}else{
									$message = "You cannot remove the ".$remove_category["product_name"]." category because it's the only category.<br/>";
									$message .= "Try add new category and then remove this category again.";
									# display a message
									$this->mpci_message($message);
								}
							}
						}
						
						# if not yet a directory
						else{
							# at least greater than one row in the database
							# for the admin able to add new category.
							if($rows > 1){
								if(isset($_POST['yes_remove_category'])){
									# if the admin click "yes" to really remove a category.
									$message = $this->remove_directory_extn($remove_category);
									# display a message.
									$this->mpci_message($message);
								}else{
									# display the confirmation message.
									$this->mpci_remove_confirmation($remove_category['product_name']);
								}
							}else{
								$message = "You cannot remove the ".$remove_category["product_name"]." category because it's the only category.<br/>";
								$message .= "Try add new category and then remove this category again.";
								# display a message.
								$this->mpci_message($message);
							}
						}
					}
				}
			}
		}else


		# ----------------------------------------
		# SITE UPDATE <editor>
		# this will update the site information
		# ----------------------------------------
		if(	isset($_GET['site_update'])){
			$temp = $this->model->decrypt($_GET['site_update']);
			# break down the information. 
			if($temp){
				$temp = explode("/",$temp);
			}else{
				$this->mpci_message("mpci corporate has encounter an error");
			}

			$result  = $this->model->model_query("SELECT * FROM mpci_info");
			
			# get site information from database base on the give ID
			if(isset($temp[1])){
				$message = $this->model->display_info($temp[1], $temp[0], $result);
			}
			
			# assign the site information to the editor
			$this->mpci_editor($temp[1], $temp[2], $temp[3], $message, $temp[0]);
		}else


		# ----------------------------------------
		# DISPLAY THE TERM OF USE.
		# ----------------------------------------
		if(isset($_GET['term']) && $_GET['term'] == "termofuse"){
			$results = $this->model->model_query("SELECT * FROM mpci_info");
			$this->mpci_info($results,"term of use");
		}else


		# ----------------------------------------
		# DISPLAY CONTACT US FORM
		# ----------------------------------------
		if(isset($_GET['contact']) && $_GET['contact'] == "contact"){
      # var data is the information submitted previously in contact us
			$option = $_GET['contact'].'/'.$data;
			$this->mpci_editor("", "", "", $message, $option);
		}else


		# ----------------------------------------
		# DISPLAY SIGNUP FORM.
		# ----------------------------------------
		if(isset($_GET['signup'])){
			$this->mpci_signup($data);
			$data="";
		}else{
			# Display the Slider if the following are not set
			if( 
				!isset($_GET['option']) &&
				!isset($_GET['display_product']) &&
				!isset($_GET['product']) &&
				!isset($_GET['remove_category']) &&
				!isset($_GET['large_display']) &&
				!isset($_GET['price_row_delete'])
			){
				$results = $this->model->model_query("SELECT * FROM mpci_slider");
				$this->mpci_slider($results);
			}
		}
		

		DEF:
		
		
		# ----------------------------------------
		# DELETE ROW IN A PRICE TABLE
		# ----------------------------------------
		# ask for confirmation to delete
		if(isset($_POST['price_row_delete'])){
			# decrypt price_row_data
			$price_data = $this->model->decrypt($_POST['price_row_data']);
			# unset to prevent from asking again the remove confirmation.
			unset($_GET['price_row_delete']);
			# if option is yes
			if($_POST['price_row_delete'] == "yes"){
				# get the product id
				$row_price_id = $price_data['price_id'];
				# combine paper and description
				$confirmation = $price_data['paper'] .' '. $price_data['description'].' ';
				# create a query
				$query = "DELETE FROM mpci_price WHERE price_id='$row_price_id'";
				# submitted 
				$result = $this->model->model_query($query);
				if($result){
					$message = "Successfully remove $confirmation";
				}
				$this->mpci_message($message);
			}
			# print the category
			$title = str_replace('_',' ',$price_data['product']);
			$query = "SELECT name FROM mpci_left WHERE name='$title'";
			$result = $this->model->model_query($query);
			while($obj = $result->fetch_object()){
				$title = $obj->name;
			}
			$this->mpci_title($title);
			# make a query for a product
			$query = $this->model->evaluate($price_data['product']);
			# submit query to mysql
			$results = $this->model->model_query($query[1]);
			# display the list of products 
			$this->mpci_productlist($this->abspath, $results, $query[0]);
			# determine the number of rows affected
			$query = "SELECT * FROM mpci_price WHERE product='".$price_data['product']."'";
			$results = $this->model->model_query($query);
			$number_rows = $results->num_rows;					
			# display the price table
			$this->mpci_price($results, $price_data['product'], $number_rows);
		}else
		
		if(isset($_GET['price_row_delete'])){
			# decrypt data submitted.
			$price_data = $this->model->decrypt($_GET['price_row_delete']);
			# combine paper and description
			$confirmation = $price_data['paper'] .' '. $price_data['description'].' ';
			# display the confirm for the request to delete a row.
			if(!isset($_POST['new-price-table-submit']) && !isset($_POST['price-table-submit'])){
				$this->mpci_remove_price_row_confirmation($confirmation, $_GET['price_row_delete']);
			}
			# print the category
			$title = str_replace('_',' ',$price_data['product']);
			$query = "SELECT name FROM mpci_left WHERE name='$title'";
			$result = $this->model->model_query($query);
			while($obj = $result->fetch_object()){
				$title = $obj->name;
			}
			$this->mpci_title($title);
			# make a query for a product
			$query = $this->model->evaluate($price_data['product']);
			# submit query to mysql
			$results = $this->model->model_query($query[1]);
			# display the list of products 
			$this->mpci_productlist($this->abspath, $results, $query[0]);
			# determine the number of rows affected
			$query = "SELECT * FROM mpci_price WHERE product='".$price_data['product']."'";
			$results = $this->model->model_query($query);
			$number_rows = $results->num_rows;					
			# display the price table
			$this->mpci_price($results, $price_data['product'], $number_rows);
		}else
		
		
	    # ----------------------------------------
		# DISPLAY LARGE IMAGE
		# ----------------------------------------
		if(isset($_GET['large_display'])){
			$link = $this->model->decrypt($_GET['large_display']);
			$this->display_large_images($link);
		}else
		

	    # ----------------------------------------
		# DISPLAY PRODUCT FROM CATEGORY
		# this will display all the product from a category
		# ----------------------------------------
		if(isset($_GET['display_product'])){
			# decrypt the data in $_GET['display_product']
			$display_product = $this->model->decrypt($_GET['display_product']);
			# make a path to the directory of a category
			$product_dir = "mpci-view/images/products/".strtolower($display_product["product_category"])."/".$display_product["product_name"];
			# make a query for mysql by product name or by directory
			$query = "SELECT * FROM mpci_products WHERE product_name='".$display_product["product_name"]."' AND product_category='".$display_product["product_category"]."'";
			# submit to the mysql
			$result = $this->model->model_query($query);
			# count the number of rows result after query
			$rows	= $result->num_rows;
			if($rows >= 1){
				# display title
				$this->mpci_title( $title );
				# show a message
				$this->mpci_message("List of images within this category");
				# display the product
				$this->display_products($result, $product_dir, $display_product);
			}else{
				# generate a mysql query using the name of the product.
				$query  = $this->model->evaluate($display_product["product_category"]);
				# submit the mysql query to mysql.
				$result = $this->model->model_query($query[1]);
				# make a header
				$title = str_replace('_',' ', $display_product["product_category"]);
				# display title
				$this->mpci_title( $title );
				# show a message
				$this->mpci_message("No image(s) found.");
				# display the list of products 
				$this->mpci_productlist($this->abspath, $result, $display_product["product_category"]);
			}
			unset($_GET['display_product']);
		}else
		

		# ----------------------------------------
		# PRODUCTS.
		# ----------------------------------------
		if(isset($_GET['product'])){
			$result = $this->model->decrypt($_GET['product']);
			$result[0] = str_replace("_"," ",$result[0]);
			$message = $result[0].": ".$result[1];
			$this->mpci_title($message);
			$this->product_design($result);
		
		}else


		# ----------------------------------------
		# REMOVE ONE CATEGORY OF THE PRODUCTS 
		# ----------------------------------------
		if(isset( $_GET['remove_category'] )){
			# decrypt the $remove_category
			$remove_category = $this->model->decrypt($_GET['remove_category']);
			# generate a mysql query using the name of the product.
			$query  = $this->model->evaluate($remove_category["product_category"]);
			# submit the mysql query to mysql.
			$result = $this->model->model_query($query[1]);
			# make a header
			$title = str_replace('_',' ', $remove_category["product_category"]);
			# display title
			$this->mpci_title( $title );
			# display the list of products 
			$this->mpci_productlist($this->abspath, $result, $remove_category["product_category"]);
		}else
		

		/**
		 * Display the products categories
		 * Value of $_GET['option'] is Name of the product
		 * @param string $_GET['option']
		 */
		if(isset($_GET['option'])){
			# if the option is not empty
			if(!empty($_GET['option'])){
				# check the value of option
				$result = $this->model->validate_product_category($_GET['option']);
				# if the value of option is okay
				if($result == "okay"){

					# $query is an array 
					# Composed of the name of the product (e.g Business_Cards)
					# and Mysql query statement base on the given product name
					$result = $this->model->evaluate($_GET['option']);

					# Trim any underscore at both end (e.g _business_cards_) 
					# and convert to lower-case letters
					$product = $this->model->convert_to_lower($result[0]); 

					# print the title of the category
					$this->mpci_title($_GET['option']);

					# submit query to mysql
					$results = $this->model->model_query($result[1]);

					# display images
					$this->mpci_productlist($this->abspath, $results, $result[0]);					
					$this->mpci_upload_design();

					# determine the number of rows affected
					$query = "SELECT * FROM mpci_price WHERE product='$product'";
					$results = $this->model->model_query($query);
					$number_rows = $results->num_rows;					

					# display the price table
					$this->mpci_price($results, $product, $number_rows);
				}
				else{
					unset($_GET['option']);
					goto DEF;
				}
			}
		}else{
			# Display the title of the 
			$this->mpci_title("Our Products");
			$results = $this->model->model_query("SELECT * FROM mpci_sample");
			$this->mpci_featured($results,"sample");
			$results = $this->model->model_query("SELECT * FROM mpci_info");
			$this->mpci_info($results, "site information");
		}
		

		# ----------------------------------------
		# THE FOOTER INFORMATION
		# ----------------------------------------
		if(!isset($_GET['product'])){
			$this->mpci_location();
		}
		

		# ----------------------------------------
		# PRINT THE END DIV
		# ----------------------------------------
		echo '</div>';
		
	}

}# class end

?>
