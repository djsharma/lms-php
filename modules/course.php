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
								$response = $this->update_course($requestURI[3]);
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
			echo "create_course";
			return;
		}

		function update_course($course_id){
			echo "update_course";
			return;
		}

		function delete_course($course_id){
			echo "delete_course";
			return;
		}

		function get_all_course(){
			echo "get_all_course";
			return;
		}

		function get_course_details($course_id){
			echo "get_course_details";
			return;
		}

	}

?>