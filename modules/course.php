<?php
	
	class Course{
		
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
				//get methode to be done to get courses 

				
				case 'GET': 
							//get courses details      GET /course/:course_id
							
							
							$requestURI = explode('/',$_SERVER['REQUEST_URI']);	
							if($requestURI[3]!=null){ //    POST /course
								
								$response = $this->get_course_details($requestURI[3]);
								return $response;
								break;
							}else{
								// GET /course
								//get all the  courses available to user       
								$response = $this->get_all_course();
								return $response;
								break;
							}	
							break;
				

				case 'POST':
							$requestURI = explode('/',$_SERVER['REQUEST_URI']);	
							if($requestURI[3]==null){ //    POST /course
								//create course
								$response = $this->create_course($_POST['title'],$_POST['details'],$_POST['start_date'],$_POST['end_date'],$_POST['profile_id']);
								return $response;
							}else{
							
								echo "ERROR_PARAM_FOUND";
								return $response;
								break;	
							}	
							break;
				
				case 'PUT':	
							
							$requestURI = explode('/',$_SERVER['REQUEST_URI']);	
							
							if($requestURI[3]!=null){   //  PUT /course/:course_id
								//update course
								$response = $this->update_course($requestURI[3],$parse_request['title'],$parse_request['details'],$parse_request['start_date'],$parse_request['end_date'],$parse_request['profile_id']);
								return $response;
							}else{
								//get all courses    PUT /course
								echo "ERROR_PARAM_NOTFOUND";
								return $response;
								break;
							}	
							break;			

							/*$response = $this->update_course($parse_request['first_name'],$parse_request['last_name'],$parse_request['email'],$parse_request['phno'],$parse_request['details'],$parse_request['password']);
							return $response;
							break;*/
				 
				case 'DELETE':
							//delete the course   DELETE /course/:course_id
							$requestURI = explode('/',$_SERVER['REQUEST_URI']);	
														
							if($requestURI[3]!=null){
								$response = $this->delete_course($requestURI[3]);
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


		function create_course($title, $details, $start_date, $end_date, $profileID_Inst){
			
			$sql_create_course = "insert into course values(null,'".$title."','".$details."',".$start_date.",".$end_date.",".$profileID_Inst.");";
			$result=$this->db->execute($sql_create_course);
			//echo $result;
			$response = array();
		
			if($result==true){
					$sql_course_id = "select course_id from course where title ='".$title."';";
					$result_course_id = $this->db->execute($sql_course_id);
					$row = mysql_fetch_array($result_course_id, MYSQL_ASSOC);
			
					$response['status'] = 'SUCCESS';
					$response['course_id']=$row['course_id'];
					return $response;
			}else{
					$response['status'] = 'FAILED';
					return $response;
			}
		}



		function update_course($course_id,$title, $details, $start_date, $end_date, $profileID_Inst){
			
			$sql_update_course = "update course set title = '".$title."', details = '".$details."', from_date = ".$start_date.", to_date = ".$end_date.", profile_id = ".$profileID_Inst." where course_id =".$course_id.";";
			//echo $sql_update_course;
			$result=$this->db->execute($sql_update_course);
			if($result==true){
				$response['status'] = 'SUCCESS';
				return $response;
			}else{
				$response['status'] = 'FAILED';
				return $response;
			}
		}



		function delete_course($course_id){
			// this is to be done later just keep in mind 
			echo "delete accessed\n";
			return;	
		}



		function get_all_course(){
			
			$sql_get_all_course = "select * from course;";
			$result=$this->db->execute($sql_get_all_course);
			$response = array();
			
			while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
    			
    			$data = array();
							
    			$data["course_id"] = $row["course_id"];
    			$data["title"] = $row["title"];
    			   			
    			$response[] = $data;
    		}

    		return $response;
		}



		function get_course_details($course_id){
			
			$sql_get_course_datails = "select * from course where course_id =".$course_id.";";
			$result = $this->db->execute($sql_get_course_datails);
			$response = array();
			$row = mysql_fetch_array($result, MYSQL_ASSOC);
			$response["course_id"] = $row["course_id"];
			$response["title"] = $row["title"];
			$response["details"] = $row["details"];
			$response["start_date"] = $row["from_date"];
			$response["end_date"] = $row["to_date"];
			$response["profile_id"] = $row["profile_id"];

			return $response;
		}

	}

?>