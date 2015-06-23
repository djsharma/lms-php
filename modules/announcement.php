<?php

	class Announcement{

		private $profile_id=null;
		private $db = null;

		function __construct($database,$profileID){
			$this->profile_id = $profileID;
			$this->db = $database;
		}

		function dispatch(){
			$method = $_SERVER['REQUEST_METHOD'];
			$response = array();
			$requestURI = null;
			switch ($method) {
						
				case 'GET': $requestURI = explode('/',$_SERVER['REQUEST_URI']);	
							if($requestURI[3]!=null){ //    GET /announcement/:course_id
								$response = $this->get_announcement($requestURI[3]);
								return $response;
							}else{

								echo "ERROR_PARAM_NOTFOUND\n";
								return;
								break;
							}	
							break;
				


				case 'POST':
							$requestURI = explode('/',$_SERVER['REQUEST_URI']);	
							if($requestURI[3]!=null){ 
							// POST /announcement/:course_id
						
								$response = $this->create_announcement($_POST['announcement_text'],$_POST['date'],$this->profile_id,$requestURI[3]);
								return $response;
							}else{
								echo "ERROR_PARAM_NOTFOUND\n";
								return;
								break;	
							}	
							break;
				
				
							
				case 'DELETE':
							//delete submission  DELETE /announcement/:announcement_id
							$requestURI = explode('/',$_SERVER['REQUEST_URI']);	
														
							if($requestURI[3]!=null){
								$response = $this->delete_announcement($requestURI[3]);
								return $response;
								break;
							}else{
								echo "ERROR_PARAM_NOTFOUND\n";
								return;
								break;
							}
							
				default: 	// error messege return 
							echo "error http method";
							break;
			}	
		}

		// POST /announcement/:course_id
		function create_announcement($announcement_text,$date,$profileID,$course_id){
			echo "create announcement\n";
			return;
		}
		// GET /announcement/:course_id
		function get_announcement($course_id){
			echo "get announcement\n";
			return;
		}
		//DELETE /announcement/:announcement_id
		function delete_announcement($announcement_id){
			echo "delete announcement\n";
			return;
		}
	}

?>