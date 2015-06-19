
<?php


	class Auth{

		 private $key = "default";
		

		function __construct(){
			$this->key = "PRODUCTIONKEY";
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
					//echo $decoded->profile_id; 
					return $decoded->profile_id; 
				}
				//echo "flow here\n";
				return null;			

			}catch(Exception $e){
				//echo "catch exe";
				return null;
			}
						
		}

	}

?>
