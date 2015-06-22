<?php
 class Assessment{
 	private $profile_id = null;
 	
 	function _construct($profileID){
 		$this->profile_id = $profileID;
 	}

 	function dispatch($parse_request){

 		
		$method = $_SERVER['REQUEST_METHOD'];
			$response = array();
			$requestURI = null;
			switch ($method) {
						
				case 'GET': $requestURI = explode('/',$_SERVER['REQUEST_URI']);	
							if($requestURI[3]!=null){ //    GET /assessment/:course_id   get all the assessments available for course_id								
								$response = $this->get_assessment($requestURI[3]);
								return $response;
							}else{

								echo "ERROR_PARAM_NOTFOUND";
								return;
								break;
							}	
							break;
				


				case 'POST':
							$requestURI = explode('/',$_SERVER['REQUEST_URI']);	
							if($requestURI[3]!=null){ // POST /assessment/:course_id
								//create a assessment 
								$response = $this->create_assessment($_POST['assessment_name'],$_POST['descript'],$_POST['max_marks'],$_POST['weightage'],$_POST['date_of_assess'],$_POST['time_of_assess'],$_POST['duration'],$requestURI[3]);
								return $response;
							}else{
								echo "ERROR_PARAM_NOTFOUND";
								return;
								break;	
							}	
							break;
				
				case 'PUT':	
							
							$requestURI = explode('/',$_SERVER['REQUEST_URI']);	
							if($requestURI[3]!=null){   //  PUT /assessmen/:assessment_id update the assessment with assessment_id											
								$response = $this->update_assessment($parse_request['assessment_name'],$parse_request['descript'],$parse_request['max_marks'],$parse_request['weightage'],$parse_request['date_of_assess'],$parse_request['time_of_assess'],$parse_request['duration'],$requestURI[3]);
								return $response;
							}else{
								echo "ERROR_PARAM_NOTFOUND";
								return;
								break;
							}	
							break;			

							
				case 'DELETE':
							//delete assessment  DELETE /assessment/:assessment_id
							$requestURI = explode('/',$_SERVER['REQUEST_URI']);	
														
							if($requestURI[3]!=null){
								$response = $this->delete_assessment($requestURI[3]);
								return $response;
								break;
							}else{
								echo "ERROR_PARAM_NOTFOUND";
								return;
								break;
							}
							
				default: 	// error messege return 
							echo "error http method";
							break;
			}		



 	}


 	//  POST /assessment/:course_id
 	function create_assessment($assessment_name,$descript,$max_marks,$weightage,$date_of_assess,$time_of_assess,$duration,$course_id){
 		echo "create assessment\n";
 		return;
 	}
 	
 	//  PUT /assessment/:assessment_id
 	function update_assessment($assessment_name,$descript,$max_marks,$weightage,$date_of_assess,$time_of_assess,$duration,$assessment_id){
 		echo "update assessment\n";
 		return;
 	}

 	//  DELETE /assessment/:assessment_id
 	function delete_assessment($assessment_id){
 		echo "delete assessment\n";
 		return;
 	}
 	

 	//  GET /assessment/:course_id
 	function get_assessment($course_id){
 		echo "get assessment\n";
 		return;
 	}


 }

?>