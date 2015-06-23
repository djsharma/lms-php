<?php

class Profile{

	private $profile_id = null;
	private $db = null;

	/*function __construct($profileID){

			$this->profile_id = $profileID;
			
			//temporary development	
			$db = new Db('localhost','root','root');
			$result = $db->execute("select * from profile");
			while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
    			printf("%s %s \n", $row["first_name"], $row["last_name"]);  
			}
			mysql_free_result($result);
			$db->close_db();
			//temporary development ends here	
	
	}*/

	function __construct($database,$profileID){
		$this->profile_id = $profileID;
		$this->db = $database;
	}


	function dispatch($parse_request){

		
		$method = $_SERVER['REQUEST_METHOD'];
		$response = array();
		switch ($method) {
						
			case 'GET': // get the user profile by profile_id 
						//    /profile/:profile_id 
						$requestURI = explode('/',$_SERVER['REQUEST_URI']);	
						if($requestURI[3]!=null){
							$response = $this->get_profile($requestURI[3]);
							return $response;	
							break;
						}else{
							echo "ERROR_PARAM_NOTFOUND";
							return;
						}
						
			case 'POST'://create a profile
						//   /profile
						$requestURI = explode('/',$_SERVER['REQUEST_URI']);	
						$response = $this->create_profile($_POST['first_name'],$_POST['last_name'],$_POST['email'],$_POST['phno'],$_POST['details'],$_POST['password']);
						return $response;
						break;
			
			case 'PUT':	//update profile
						//   /profile/:profile_id
						$requestURI = explode('/',$_SERVER['REQUEST_URI']);	
						if($requestURI[3]!=null){
							$response = $this->update_profile($requestURI[3],$parse_request['first_name'],$parse_request['last_name'],$parse_request['email'],$parse_request['phno'],$parse_request['details'],$parse_request['password']);
							return $response;
							break;
			 			}else{
							echo "ERROR_PARAM_NOTFOUND";
							return;
						}
						

			case 'DELETE'://delete the profile 
						//  /profile/:profile_id
						$requestURI = explode('/',$_SERVER['REQUEST_URI']);	
						if($requestURI[3]!=null){
							$response = $this->delete_profile($requestURI[3]);
							return $response;
							break;
						}else{
							echo "ERROR_PARAM_NOTFOUND";
							break;
						}
						break;


			default: 	// error messege return 
						
						break;
		}

	}

	function create_profile($first_name,$last_name,$email,$phno,$details,$password){
		
		echo "\nprofile created\n";
	}	

	function get_profile($profileID){
		
		
			
			$result=$this->db->execute("select * from profile");
			
			//$result = $bind->execute("select * from profile");
			while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
    			printf("%s %s \n", $row["first_name"], $row["last_name"]);  
			}
			mysql_free_result($result);
			
		 	
		
		echo "\nget profile\n";
		echo $profileID;
		echo "\n";
	}

	function delete_profile($profileID){
		echo "\nprofile deleted\n";
		echo $profileID;
		echo "\n";
	}

	function update_profile($profileID,$first_name,$last_name,$email,$phno,$details,$password){
		
		echo "\nprofile updated\n";
	}


}

?>