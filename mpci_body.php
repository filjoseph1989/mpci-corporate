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
	
# ------------------------------------
# require configuration
# ------------------------------------
require( dirname( __FILE__ ) . '/mpci_configuration.php');


# ------------------------------------
# include the mpci-control.php.
# ------------------------------------
require( dirname( __FILE__ ) . '/mpci-control/mpci_control.php');


# ------------------------------------
# create a new class controller.
# ------------------------------------
$mpci_control = new mpci_control($config);


# ------------------------------------
# reset the session of login.
# ------------------------------------
if(!isset($_SESSION['loggedin'])){
	$_SESSION['loggedin'] = false;
	$_SESSION['admin']    = false;
	$_SESSION['user']	  = false;
}


# ------------------------------------
# if the user click the logout button.
# ------------------------------------
if(isset($_GET['logout'])){
	$_SESSION['loggedin'] = false;
	$_SESSION['admin'] 	  = false;
	session_destroy();
}


# ------------------------------------
# no option for mpci_content()
# ------------------------------------
$option = "";


# ------------------------------------
# if the user fill up the login form.
# ------------------------------------
if(isset($_POST['login_submit'])){
    # submit the username and password
    # and get a get back the user's name from the successfull login.
	$username = $mpci_control->corporate_login( $_REQUEST['login_email'], $_REQUEST['login_password'], MPCI_URL );
	
	# Check if the return is admin
	if( $username['status'] == "admin" ){
		# if the Remember me is checked, it will create a cookie.
		if(isset($_POST['login_remember'])){
			setcookie("username", $username['username'], time()+7600, "/", ".webtoprint.midtown.com.ph"); 
		}
		
		$_SESSION['name'] = $username['username'];
			
		# enable the session for login.
		$_SESSION['loggedin'] = true;

		# set session as admin.
		$_SESSION['admin']	  = true;	
	}else

	# Check if the return is user.
	if( $username['status'] == "user" ){
		# if the Remember me is checked, it will create a cookie.
		if(isset($_POST['login_remember'])){
			setcookie("username", $username['username'], time()+7600, "/", ".webtoprint.midtown.com.ph"); 
		}
		
		$_SESSION['name'] = $username['username'];

		# enable the session for login.
		$_SESSION['loggedin'] = true;

		# set session as user.
		$_SESSION['user']	  = true;	
	}

	# redirect to homepage
	$option = array(
		"message" => $username['username']
	);
	
}


# ------------------------------------
# if captcha image is click, then set option.
# ------------------------------------
if(isset($_GET['captcha'])){
	$option = $_GET['captcha'];
}


# ------------------------------------
# display the left side
# ------------------------------------
$mpci_control->mpci_left();


# ------------------------------------
# dispplay the top area.
# ------------------------------------
$mpci_control->mpci_top(MPCI_URL);


# ------------------------------------
# display the content.
# ------------------------------------
$mpci_control->mpci_content(MPCI_URL, $option);

?>
