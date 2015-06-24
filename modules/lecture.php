<?php
	
	class Lecture{
		private $profile_id = null;
		private $db = null;

		function __construct($database,$profileID){
			$this->profile_id = $profileID;
			$this->db = $database;
		}

		function dispatch($parse_request){

			$method = $_SERVER['REQUEST_METHOD'];
			$response = array();
			$requestURI = null;
			switch ($method) {
						
				
				case 'GET': $requestURI = explode('/',$_SERVER['REQUEST_URI']);	
							
							if($requestURI[3]!=null){   //  PUT /lecture/:course_id //get all the lectures for this course_id
								//get lectures
								$response = $this->get_lecture($requestURI[3]);
								return $response;
							}else{
								
								echo "ERROR_PARAM_NOTFOUND";	
								break;			
							}	
							break;			


				case 'POST':
							$requestURI = explode('/',$_SERVER['REQUEST_URI']);	
							//create lecture    POST /lecture/:course_id
							if($requestURI[3]!=null){
								$response = $this->create_lecture($_POST['link'],$_POST['details'],$_POST['posted'],$requestURI[3]);
								return $response;	
								break;
							}else{
								echo "ERROR_PARAM_NOTFOUND";
								break;
							}
							break;			
							
				case 'PUT':	
							
							$requestURI = explode('/',$_SERVER['REQUEST_URI']);	
							
							if($requestURI[3]!=null){   
								//update lecture with lecture_id
								// PUT /lecture/:lecture_id
								$response = $this->update_lecture($parse_request['link'],$parse_request['details'],$parse_request['posted'],$requestURI[3]);
								return $response;
							}else{
								
								echo "ERROR_PARAM_NOTFOUND";	
								break;			
							}	
							break;			

				case 'DELETE':
							//delete the lecture   DELETE /lecture/:lecture_id
							$requestURI = explode('/',$_SERVER['REQUEST_URI']);	
														
							if($requestURI[3]!=null){
								$response = $this->delete_lecture($requestURI[3]);
								return $response;
								break;
							}else{
								echo "ERROR_PARAM_NOTFOUND";
								return $response;
								break;
							}
							
				default: 	// error messege return 
							echo "error http method";
							break;
			}
		}


		// create lecture  
		function create_lecture($link,$details,$posted,$course_id){
			
			$sql_create_lecture = "insert into lecture values(null,".$course_id.",'".$link."',".$posted.",'".$details."');";
			$result=$this->db->execute($sql_create_lecture);
			//echo $result;
			$response = array();
		
			if($result==true){
					$response['status'] = 'SUCCESS';
					return $response;
			}else{
					$response['status'] = 'FAILED';
					return $response;
			}
			/*echo "create_lecture\n";
			return;*/
		}

		//get all lectures for course_id 
		function get_lecture($course_id){
			$sql_get_lecture = "select * from lecture where course_id = ".$course_id.";";
			//echo $sql_get_lecture;
			$result=$this->db->execute($sql_get_lecture);
			$response = array();
			while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
    			
    			$data = array();
							
    			$data["lecture_id"] = $row["lecture_id"];
    			$data["link"] = $row["link"];
    			$data["posted_on"] = $row["posted_on"];
    			$data["details"] = $row["details"];
    			   			
    			$response[] = $data;
    		}
    		return $response;	
			/*echo "get_lecture\n";*/
		}


		//update the lecture/:lecture_id 
		function update_lecture($link,$details,$posted,$lecture_id){

			$sql_update_lecture = "update lecture set link = '".$link."', details = '".$details."',posted_on = ".$posted." where lecture_id = ".$lecture_id.";";
			//echo $sql_update_lecture;
			$result=$this->db->execute($sql_update_lecture);
			//echo $result;
			$response = array();
		
			if($result==true){
					$response['status'] = 'SUCCESS';
					return $response;
			}else{
					$response['status'] = 'FAILED';
					return $response;
			}

			/*echo "update_lecture\n";
			return;	*/
		}


		//delete a lecture(){}
		function delete_lecture($lecture_id){
			//delete code to be written later
			echo "delete_lecture\n";
			return;
		}

	}

?>