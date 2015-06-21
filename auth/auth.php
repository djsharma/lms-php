
<?php


	class Auth{

		private $key = "default";
		private $profile_id = null;

		function __construct(){
			$this->key = "PRODUCTIONKEY";
		}

		function get_profile_id(){
			return $this->profile_id;
		}
		

		function get_token($profileID){


			$token = array();
			$token['profile_id'] = $profileID;
			$jwt = JWT::encode($token, $this->key);
			return $jwt; //token
		

		}

		function verify_token($jwt){
			
			try{
				
				if(!empty($this->key)){
					
					$decoded = JWT::decode($jwt, $this->key ,array('HS256'));
					$this->profile_id = $decoded->profile_id; 
					return $decoded->profile_id; 
				}
				return null;			

			}catch(Exception $e){
				return null;
			}
						
		}

	}

?>
