<?php

	class Submission{
		private $profile_id = null;
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
							if($requestURI[3]!=null){ //    GET /submission/:assessment_id  get all the assessments available for course_id								
								$response = $this->get_submission($requestURI[3]);
								return $response;
							}else{

								echo "ERROR_PARAM_NOTFOUND";
								return;
								break;
							}	
							break;
				


				case 'POST':
							$requestURI = explode('/',$_SERVER['REQUEST_URI']);	
							if($requestURI[3]!=null){ // POST /submission/:assessment_id
								//submit an assessment
								$response = $this->submit_assessment($_POST['submission_date'],$_POST['assessment_id'],$this->profile_id,$requestURI[3]);
								return $response;
							}else{
								echo "ERROR_PARAM_NOTFOUND";
								return;
								break;	
							}	
							break;
				
				
							
				case 'DELETE':
							//delete submission  DELETE /submission/:submission_id
							$requestURI = explode('/',$_SERVER['REQUEST_URI']);	
														
							if($requestURI[3]!=null){
								$response = $this->delete_submission($requestURI[3]);
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
		function get_submission($assessment_id){
			echo "get submission\n";
			return;
		} //get submissions for assessment_id
		function submit_assessment($submission_date,$assessment_id,$profileID,$assessment_id){
			echo "submit assessment\n";
			return;
		}//submit an assignment for assessment_id
		function delete_submission($submission_id){
			echo "delete submission\n";
			return;
		}// delete a submission with submission_id 
	}

?>