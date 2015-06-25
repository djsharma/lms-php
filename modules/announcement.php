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
			$sql_create_announcement = "insert into announcement values(null,".$course_id.",'".$announcement_text."',".$date.");";
			$result = $this->db->execute($sql_create_announcement);
			$response = array();
		
			if($result==true){
				$response['status'] = 'SUCCESS';
				return $response;
			}else{
				$response['status'] = 'FAILED';
				return $response;
			}

			/*echo "create announcement\n";
			return;*/
		}
		// GET /announcement/:course_id
		function get_announcement($course_id){
			$sql_get_announcement = "select * from announcement where course_id = ".$course_id.";";
			$result = $this->db->execute($sql_get_announcement);
			$response = array();
			while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
    			
    			$data = array();
				$data["course_id"] = $row["course_id"];			
    			$data["announcement"] = $row["announcement"];
    			$data["date"] = $row["date"];
    			   			   			
    			$response[] = $data;
    		}
    		return $response;
			
			/*echo "get announcement\n";
			return;*/
		}
		//DELETE /announcement/:announcement_id
		function delete_announcement($announcement_id){
			// this is to be done later just keep in mind
			echo "delete announcement\n";
			return;
		}
	}

?>