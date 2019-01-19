<?php 
# Project Name: MPCI-CORPORATE
# Discription:	MPCI-CORPORATE is new division of Midtown Printing Company Incorporated (MPCI) for creative task.
# Developer:	Fil Elman
# Version:		mpci-corporate 1.0
# Website:		www.mpcicorporate.com
# copyright:	@Copyright 2014

# this will prevent from direct accessing of  this file
if( count(get_included_files()) == 1) die("Error, Contact webtoprint.midtown.com.ph");

class mpci_database {
	public $mysqli;
	
	public function __construct($db_server, $db_username, $db_password, $db_database){
		$this->mysqli = new mysqli($db_server,$db_username,$db_password,$db_database);
	}

	public function mpci_query($query){
		return $this->mysqli->query($query);
	}
	
	public function string_scape($tring){
		return $this->mysqli->real_escape_string($tring);
	}

	public function mpci_query_close(){
		return $this->mysqli->close();
	}
}
?>