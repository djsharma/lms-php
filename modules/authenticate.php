<?php

 class Authenticate{
 	private $access = null;
 	private $token = null;
 	private $profile_id = null;
 	private $db =null;
 	private $profile_response = null;

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
				//-----------------------------------------------------------CHECK IN DB-------------------------------------------------------------------------------------
				
				$email = $_POST['email'];
				$password = md5($_POST['password']);
				$sql_authenticate = "select * from profile where email = '".$email."' and password = '".$password."';";
				//echo $sql_authenticate;
				$result = $this->db->execute($sql_authenticate);
				
				$row = mysql_fetch_array($result, MYSQL_ASSOC);
 				//echo $row['profile_id'];
 				
 				if($row == null ){echo "result here null";$this->access = false; return;} // send this in json format
 				 				//echo $row['password'];
 				$this->profile_id = $row['profile_id'];						
				//------------------------------------------------------------------------------------------------------------------------------------------------- 					

				//profile_id removed from database by checking the email and password from the post request
				//get database object from index.php 
				//use db object to get profile_id. pass this profile id to get the token 
				//execute the query here.
				$this->token = $auth->get_token($this->profile_id);
				$this->access = true; 
				return;
			}else{
				//echo "caught here";
				$this->access = false; 
				return;
			}			
		return;			
		}
		//-------------------------------------------CREATE PROFILE-------------------------------------------------------------------------
		
		if((strcmp($requestURI[2],'profile')==0 )&& (strcmp($_SERVER['REQUEST_METHOD'],'POST')==0)){
			/*call profile class directly here and solve the issue here only.
			no need to go through dispatcher in profile and through router.
			make sure to stop access of create profile from dispatcher of profile.php*/
			
			$profile = new Profile($this->db,$this->profile_id);
			$requestURI = explode('/',$_SERVER['REQUEST_URI']);	
			$this->profile_response = $profile->create_profile($_POST['first_name'],$_POST['last_name'],$_POST['email'],$_POST['phno'],$_POST['details'],md5($_POST['password']));
			$this->access = false;
			return;
		}
		//--------------------------------------------------------------------------------------------------------------------
 		
 		$headers = array();
		$headers = apache_request_headers();
		//$this->token = $headers['token'];
		global $_COOKIE;
		$this->token = $_COOKIE['token'];

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
 		$response = array();

 		//do not give access to /profile and in reponse give the profile_id and status success. check profile_status first
 		if( strcmp($requestURI[2],'profile')==0  && strcmp($_SERVER['REQUEST_METHOD'],'POST')==0 ) {
 			
 			header('Content-type: application/json');
			echo json_encode($this->profile_response);
 			return;
 		}
 		//----------------------------------------------------------------------------------------------------------------
 		
 		if(strcmp($requestURI[2],'authenticate') == 0) {
			if($this->access==null){
					//echo "AUTH_FAILED\n";
					$response['status'] = 'AUTH_FAILED_one';
					header('Content-type: application/json');
					echo json_encode($response);
					return;
			}// send this in json
			/*echo $this->get_token(); //send this in json format
			echo "\n";
			*/
			$response['status'] = 'AUTH_SUCCESS';
			$response['token'] = $this->get_token();
			header('Content-type: application/json');
			//header('token: '.$this->get_token());
			$expire = time()+60*60*24*30;
			setcookie('token',$this->get_token(),$expire,'/','',false,false);
			echo json_encode($response);
			return;			
		}else{
			if($this->access==null){
				//echo "AUTH_FAILED_X\n";
				$response['status'] = 'AUTH_FAILED_two';
				header('Content-type: application/json');
				echo json_encode($response);
				return;
			} // send this in json
			return;
		}
 	}


 	function get_profile_id(){
 		return $this->profile_id;
 	}

 }


?>