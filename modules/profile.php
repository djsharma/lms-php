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
		$sql_create_profile = "insert into profile values(null,'".$first_name."','".$last_name."','".$email."',".$phno.",'".$details."','".$password."');";	
		$result=$this->db->execute($sql_create_profile);
		$response = array();
		
		if($result==true){
			$sql_profile_id = "select profile_id from profile where email='".$email."'and password='".$password."';";
			$result_profile_id = $this->db->execute($sql_profile_id);
			$row = mysql_fetch_array($result_profile_id, MYSQL_ASSOC);
			
			$response['status'] = 'SUCCESS';
			$response['profile_id']=$row['profile_id'];
			return $response;
		}else{
			$response['status'] = 'FAILED';
			return $response;
		}
	}	


	function get_profile($profileID){
		
		$sql_get_profile = "select * from profile where profile_id ='".$profileID."';";
		$result=$this->db->execute($sql_get_profile);
		$response = array();
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
    		
			
    			$response["first_name"] = $row["first_name"];
    			$response["last_name"] = $row["last_name"];
    			$response["email"] = $row["email"];
    			$response["phno"] = $row["phno"];
    			$response["details"] = $row["details"];
    			$response["password"] = $row["password"];
    	}

    	return $response;
	}

	function delete_profile($profileID){
		
		/*$sql_delete_profile = "update profile set valid = 0 where profile_id = ".$profileID.";";
		$result=$this->db->execute($sql_delete_profile);
		$response = array();
		
		if($result==true){
			$response['status'] = 'SUCCESS';
			return $response;
		}else{
			$response['status'] = 'FAILED';
			return $response;
		}*/

		echo "delete accessed\n";
	}

	function update_profile($profileID,$first_name,$last_name,$email,$phno,$details,$password){
		$sql_update_profile = "update profile set valid = 0, first_name = '".$first_name."', last_name = '".$last_name."', email = '".$email."', phno = ".$phno.", details ='".$details."', password = '".$password."' where profile_id = ".$profileID.";";
		$result=$this->db->execute($sql_update_profile);
		if($result==true){
			$response['status'] = 'SUCCESS';
			return $response;
		}else{
			$response['status'] = 'FAILED';
			return $response;
		}
		//echo "\nprofile updated\n";
	}


}

?>