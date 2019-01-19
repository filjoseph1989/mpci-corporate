<?php /*
Project Name: 	MPCI-CORPORATE
Discription:	MPCI-CORPORATE is new division of Midtown Printing Company Incorporated (MPCI) for creative task.
Developer:		Fil Elman
Version:		mpci-corporate 1.0
Website:		www.mpcicorporate.com
copyright:		@Copyright 2014*/

# this will prevent from direct accessing of  this file
if( count(get_included_files()) == 1) die("Error, Contact webtoprint.midtown.com.ph");

class mpci_safe {

	public function encrypt($encrypt,$key){
		$encrypt 	= serialize($encrypt);
		$iv 		= mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC), MCRYPT_DEV_URANDOM);
		$key 		= pack('H*', $key);
		$mac 		= hash_hmac('sha256', $encrypt, substr(bin2hex($key), -32));
		$passcrypt 	= mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $encrypt.$mac, MCRYPT_MODE_CBC, $iv);
		$encoded 	= base64_encode($passcrypt).'|'.base64_encode($iv);
		return $encoded;	
	}

	public function decrypt($decrypt,$key){
		$decrypt 	= explode('|', $decrypt);
		if(isset($decrypt[0])){	
			$decoded = base64_decode($decrypt[0]);
		}
		if(isset($decrypt[1])){	
			$iv	= base64_decode($decrypt[1]);
		}
		if(isset($iv) && strlen($iv)!== mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC)){
			return false; 
		}
		$key = pack('H*', $key);
		if(isset($iv)){
			$decrypted 	= trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $decoded, MCRYPT_MODE_CBC, $iv));
		}
		if(isset($decrypted)){
			$mac 		= substr($decrypted, -64);
			$decrypted 	= substr($decrypted, 0, -64);
			$calcmac 	= hash_hmac('sha256', $decrypted, substr(bin2hex($key), -32));
			if($calcmac	!==	$mac){ 
				return false; 
			}
			$decrypted = unserialize($decrypted);
			return $decrypted;
		}
	}
}// class end.

?>