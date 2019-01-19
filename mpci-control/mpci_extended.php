<?php /*
Project Name: 	MPCI-CORPORATE
Description:	MPCI-CORPORATE is new division of Midtown Printing Company Incorporated (MPCI) for creative task.
Developer:		Fil Elman
Version:		mpci-corporate 1.0
Website:		www.mpcicorporate.com
copyright:		@Copyright 2014*/

# class for other mpci corporate controls
# 1. corporate_login

# this will prevent from direct accessing of  this file
if( count(get_included_files()) == 1) die("Error, Contact webtoprint.midtown.com.ph");

class mpci_extended extends mpci_process{

    /**
	# Method use for logging in.
    # --------------------------------------------------
    */
	public function corporate_login( $email, $password ){
	    # initiate empty message.
	    $message = "";
	    
	    # Check if email and password if not empty.
	    if(!empty($email) && !empty($password)){
    		# Submit the email and password to process login in class model.
    		$message = $this->model->login( $email, $password);
	    }else{
	        $message = "Empty login form.";
	    }
        
        # retun the username. or the error message.
		return $message;
	}
	

    # -----------------------------------------------------------------------
	# Method use to display left side
    # -----------------------------------------------------------------------
	public function mpci_left(){
		$query   = "SELECT * FROM mpci_left";
		$results = $this->model->model_query($query);
		$this->mpci_left_left($results);
	}
	

    # -----------------------------------------------------------------------
	# Method use to display top menu.
    # -----------------------------------------------------------------------
	public function mpci_top($current_url){
		# include file mpci_top for top division.
		include_once ('mpci-view/mpci_top.php');
	}
	
}

?>