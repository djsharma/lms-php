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
								$response = $this->submit_assessment($_POST['submission_date'],$requestURI[3],$this->profile_id);
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
			$sql_get_submissions = "select * from submission where assessment_id = ".$assessment_id.";";
			$result = $this->db->execute($sql_get_submissions);

			$response = array();

 			while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
    			
    			$data = array();
				$data["submission_id"] = $row["submission_id"];			
    			$data["profile_id"] = $row["profile_id"];
    			$data["submission_date"] = $row["submission_date"];
    			   			   			
    			$response[] = $data;
    		}
    		return $response;
		} //get submissions for assessment_id
		

		function submit_assessment($submission_date,$assessment_id,$profileID){
			
			$sql_submit_assessment = "insert into submission values(null,".$assessment_id.",".$profileID.",".$submission_date.");";
			$result = $this->db->execute($sql_submit_assessment);
			$response = array();
		
			if($result==true){
				$response['status'] = 'SUCCESS';
				return $response;
			}else{
				$response['status'] = 'FAILED';
				return $response;
			}
		}//submit an assignment for assessment_id
		

		function delete_submission($submission_id){
			// this is to be done later just keep in mind
			echo "delete submission\n";
			return;
		}// delete a submission with submission_id 
	}

?>