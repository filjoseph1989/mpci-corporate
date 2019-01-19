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

# Mpci URL for local
define('MPCI_URL', 'http://'.$_SERVER['HTTP_HOST'].'/mpcicorporate');
# Mpci URL for online
# define('MPCI_URL', 'http://'.$_SERVER['HTTP_HOST'].'/');

# make an array of configuration.
$config = array(
	# server name
	"DB_SERVER"   => "localhost",
	# database username
	"DB_USERNAME" => "root",
	# database password
	"DB_PASSWORD" => "",
	# database name
	"DB_DATABASE" => "mismpci_webtoprint",
	# administrator email
	"ADMIN_EMAIL" => "fil@marketing.midtown.com.ph",
	# file main path
	"MPCI_PATH"   => dirname( __FILE__ )
);


?>
