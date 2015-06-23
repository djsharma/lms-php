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
								$response = $this->update_lecture($requestURI[3]);
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
			echo "create_lecture\n";
			return;
		}

		//get all lectures for course_id 
		function get_lecture($course_id){
			echo "get_lecture\n";
			return;
		}


		//update the lecture 
		function update_lecture(){
			echo "update_lecture\n";
			return;	
		}


		//delete a lecture(){}
		function delete_lecture($lecture_id){
			echo "delete_lecture\n";
			return;
		}

	}

?>