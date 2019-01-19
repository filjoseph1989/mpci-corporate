<?php /*
Project Name: 	MPCI-CORPORATE
Description:	MPCI-CORPORATE is new division of Midtown Printing Company Incorporated (MPCI) for creative task.
Developer:		Fil Elman
Version:		mpci-corporate 1.0
Website:		www.mpcicorporate.com
copyright:		@Copyright 2014*/

# note: $this->db and $this->crypt is declare in class model
# and can be use un this class.
# this will prevent from direct accessing of  this file
if( count(get_included_files()) == 1) die("Error, Contact webtoprint.midtown.com.ph");

class mpci_mailer extends mpci_evaluate{
    
	#-----------------------------------------------------------
	# This method is use to send email to client/user who signed
	# up to mpci corporate.
	#-----------------------------------------------------------
	public function sign_up_mail($AdminEmail, $email, $con_code){
		# Difinition of variables:
		# $AdminEmail - is email address of the mpci corporate administrator
		# $email - is email address of the mpci corporate user/client
		# $con_code - a code generated which will be sent to user/client email address
		# to confirm the email address he/she provided.
		
		$html_message = '
			<!DOCTYPE html>
			<html>
			<head>
			  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
			  <title>MPCI CORPORATE EMAIL CONFIRMATION</title>
			</head>
			<body>
			  <div style="width: 640px; font-family: Arial, Helvetica, sans-serif; font-size: 11px;">
				<h1>MPCI CORPORATE EMAIL CONFIRMATION.</h1>
				<div align="center">
					<h2>your mpci corporate confirmation code is: <font color="green">'.$con_code.'</font></h2>
				</div>
				<p>This email is auto generated by webtoprint server do not reply.</p>
			  </div>
			</body>
			</html>
		';

		# open the content.html
		$myfile = fopen("mpci-model/contents.html", "w") or die("Unable to open file!");
		# write the jquery to file.
		fwrite($myfile, $html_message);
		# close file writting
		fclose($myfile);

		# Set who the message is to be sent from
		$this->mail->setFrom('fil@webtoprint.midtown.com.ph', 'MPCI-CORPORATE');
		# Set an alternative reply-to address
		$this->mail->addReplyTo($AdminEmail, 'MPCI-CORPORATE');
		# Set who the message is to be sent to
		$this->mail->addAddress($email, 'MPCI-CORPORATE');
		# Set the subject line
		$this->mail->Subject = "MPCI CORPORATE EMAIL CONFIRMATION";
		# Read an HTML message body from an external file, convert referenced images to embedded,
		# convert HTML into a basic plain-text alternative body
		$this->mail->msgHTML(file_get_contents('mpci-model/contents.html'), dirname(__FILE__));

		# send the message, check for errors
		if(!$this->mail->Send()) {
			return "false";
		} else {
			return "true";
		}		
	}
	
	# contact us
	public function contact_us_mail($data, $message, $attachment){
		# break the data.
		$data = explode("/",$data);
		# email message
		$html_message = '
			<!DOCTYPE html>
			<html>
			<head>
			  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
			  <title>MPCI CORPORATE CONTACT US MESSAGE</title>
			</head>
			<body>
			  <div style="width: 640px; font-family: Arial, Helvetica, sans-serif; font-size: 11px;">
				<h1>MESSAGE FROM MPCI CORPORATE CONTACT US</h1>
				'.$message.'
			  </div>
			</body>
			</html>
		';

		# FILE
		# open the content.html
		$myfile = fopen("mpci-model/contents.html", "w") or die("Unable to open file!");
		# write the jquery to file.
		fwrite($myfile, $html_message);
		# close file writting
		fclose($myfile);
		
		# contactors name.
		$contact_name = $data[0].' '.$data[1];
		# email recipient
		$query = "SELECT * FROM mpci_admin";
		# submit query to mysql
		$result = $this->db->mpci_query($query);
		# email recipient
		$email_to = "";
		$failed   = "";
		while($obj = $result->fetch_object()){
			$email_to = $this->decrypt($obj->email);
			# Set who the message is to be sent from
			$this->mail->setFrom('contact_us@webtoprint.midtown.com.ph', $contact_name);
			# Set who the message is to be sent to
			$this->mail->addAddress($email_to, '');
			# Set the subject line
			$this->mail->Subject = "MPCI CORPORATE CONTACT US";
			# Read an HTML message body from an external file, convert referenced images to embedded,
			# convert HTML into a basic plain-text alternative body
			$this->mail->msgHTML(file_get_contents('mpci-model/contents.html'), dirname(__FILE__));
			# email attachment 
			$this->mail->AddAttachment($attachment);   
			# send the message, check for errors
			if(!$this->mail->Send()) {
				$failed =  "false";
				break;
			} else {
				$failed =  "true";
			}		
		}# while end
		
		return $failed;
	}
	
	public function send_users_mail($AdminEmail, $email, $name, $subject, $message){
		# set up a mail to
		$email_to = $this->clean_string($email);
		# set up a subject message
		$email_subject = $subject;
		# set up a message body <html>
		$email_message = '
			<html>
			<head>
				<title>'.$email_subject.'</title>
			</head>
			<body>
				'.$message.'
			</body>
			</html>
			';

		# open the content.html
		$myfile = fopen("mpci-model/contents.html", "w") or die("Unable to open file!");
		# write the jquery to file.
		fwrite($myfile, $email_message);
		# close file writting
		fclose($myfile);

		# Set who the message is to be sent from
		$this->mail->setFrom('noreply@webtoprint.midtown.com.ph', 'MPCI-CORPORATE');
		# Set who the message is to be sent to
		$this->mail->addAddress($email_to, '');
		# Set the subject line
		$this->mail->Subject = $email_subject;
		# Read an HTML message body from an external file, convert referenced images to embedded,
		# convert HTML into a basic plain-text alternative body
		$this->mail->msgHTML(file_get_contents('mpci-model/contents.html'), dirname(__FILE__));
		# send the message, check for errors
		if(!$this->mail->Send()) {
			return "Failed to send the message!";
		} else {
			return "Message successfully send to $email_to!";
		}		
	
	}

}# class end.

?>