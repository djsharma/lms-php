<?php
 class Assessment{
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
								$response = $this->create_assessment($_POST['assessment_name'],$_POST['details'],$_POST['max_marks'],$_POST['weightage'],$_POST['date_of_assess'],$_POST['time_of_assess'],$_POST['duration'],$requestURI[3]);
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
								$response = $this->update_assessment($parse_request['assessment_name'],$parse_request['details'],$parse_request['max_marks'],$parse_request['weightage'],$parse_request['date_of_assess'],$parse_request['time_of_assess'],$parse_request['duration'],$requestURI[3]);
								
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
		$sql_create_assessment = "insert into assessment values(null,".$course_id.",'".$assessment_name."','".$descript."',".$max_marks.",".$weightage.",".$date_of_assess.",".$duration.");"; 		
		$result = $this->db->execute($sql_create_assessment);
		$response = array();
		
		if($result==true){
				$response['status'] = 'SUCCESS';
				return $response;
		}else{
				$response['status'] = 'FAILED';
				return $response;
		}

 		/*echo "create assessment\n";
 		return;*/
 	}
 	
 	//  PUT /assessment/:assessment_id
 	function update_assessment($assessment_name,$descript,$max_marks,$weightage,$date_of_assess,$time_of_assess,$duration,$assessment_id){
		$sql_update_assessment = "update assessment set assessment_name = '".$assessment_name."',details = '".$descript."', max_marks =".$max_marks.", weightage =".$weightage.", date_of_assess = ".$time_of_assess.", duration = ".$duration." where assessment_id = ".$assessment_id.";";
		$result = $this->db->execute($sql_update_assessment);
		$response = array();
		
		if($result==true){
				$response['status'] = 'SUCCESS';
				return $response;
		}else{
				$response['status'] = 'FAILED';
				return $response;
		}
 	}



 	//  GET /assessment/:course_id
 	function get_assessment($course_id){
 		$sql_get_assessments = "select * from assessment where course_id = ".$course_id.";";
 		$result = $this->db->execute($sql_get_assessments);
 		$response = array();

 		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
    			
    			$data = array();
				$data["assessment_id"] = $row["assessment_id"];			
    			$data["assessment_name"] = $row["assessment_name"];
    			$data["details"] = $row["details"];
    			$data["max_marks"] = $row["max_marks"];
    			$data["weightage"] = $row["weightage"];
    			$data["date_of_assess"] = $row["date_of_assess"];
    			$data["duration"] = $row["duration"];
    			   			   			
    			$response[] = $data;
    	}
    	return $response;


 		/*echo "get assessment\n";
 		return;*/
 	}

 	//  DELETE /assessment/:assessment_id
 	function delete_assessment($assessment_id){
 		//delete to be written later just keep in mind to do that	
 		echo "delete assessment\n";
 		return;
 	}
 	
 }

?>