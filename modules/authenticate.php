<?php

 class Authenticate{
 	private $access = null;
 	private $token = null;
 	private $profile_id = null;
 	private $db =null;

 	function __construct($database){
 	;
 		$this->access = false;
 		$this->db = $database;
 		$this->authenticate();
 	}
 	
 	//take decisions for /authenticate and do whole processing here
 	////////////////////////////////////////////////////////////////
 	function authenticate(){

 		$auth = new Auth();
 		
 		$requestURI=explode('/',$_SERVER['REQUEST_URI']);
 		//check if authenticate is called the pass the request as true 
		if(strcmp($requestURI[2],'authenticate') == 0) {
			
			//echo "authenticate_done\n";
			//get the profile_id checked here by using email and password form the post request
			if($_SERVER['REQUEST_METHOD']=='POST'){
				//profile_id removed from database by checking the email and password from the post request
				//get database object from index.php 
				//use db object to get profile_id. pass this profile id to get the token 
				//execute the query here.
				$this->token = $auth->get_token(123);
				$this->access = true; 
				return;
			}else{
				
				$this->access = false; 
				return;
			}			
		return;			
		}

		
 		$headers = array();
		$headers = apache_request_headers();
		$this->token = $headers['token'];


		$verify_result = $auth->verify_token($this->token);	
		if(is_null($verify_result)){
			
			$this->access = false;
			return;	
		}	

		//authntication successful
		$this->profile_id = $verify_result;
		
		$this->access = true;
		return;

 	}
 	



 	/////////////////////////////////////////////////////////////////
 	function get_access(){
 		return $this->access;
 	}

 	function get_token(){
 		return $this->token;
 	}


 	function get_response(){

 		$requestURI=explode('/',$_SERVER['REQUEST_URI']);
 		
 		if(strcmp($requestURI[2],'authenticate') == 0) {
			if($this->access==null){echo "AUTH_FAILED\n";return;}
			echo $this->get_token();
			echo "\n";
			return;			
		}else{
			if($this->access==null){echo "AUTH_FAILED_X\n";return;}
			return;
		}
 		
 	}





 	function get_profile_id(){
 		return $this->profile_id;
 	}

 }


?>