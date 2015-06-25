<?php

class Comment{

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
							if($requestURI[3]!=null){ //    GET /comment/:topic_id   get all the comment available for topic_id
								// comment for topic_id
								$response = $this->get_comment($requestURI[3]);
								return $response;
							}else{

								$response['status'] = 'ERROR_PARAM_NOTFOUND';
								return $response;		
							}	
							break;
				


				case 'POST':
							$requestURI = explode('/',$_SERVER['REQUEST_URI']);	
							if($requestURI[3]!=null){ // POST /comment/:topic_id
								//create a comment 
								$response = $this->create_comment($_POST['comment'],$requestURI[3],$this->profile_id);
								return $response;
							}else{
								$response['status'] = 'ERROR_PARAM_NOTFOUND';
								return $response;		
							}	
							break;
				
				case 'PUT':	
							
							$requestURI = explode('/',$_SERVER['REQUEST_URI']);	
							if($requestURI[3]!=null){   //  PUT /comment/:comment update the comment with comment_id								//update course
							
								$response = $this->update_comment($parse_request['comment'],$requestURI[3]);
								return $response;
							}else{
								$response['status'] = 'ERROR_PARAM_NOTFOUND';
								return $response;		
							}	
							break;			

							
				case 'DELETE':
							//delete comment  DELETE /comment/:comment_id
							$requestURI = explode('/',$_SERVER['REQUEST_URI']);	
														
							if($requestURI[3]!=null){
								$response = $this->delete_comment($requestURI[3]);
								return $response;
								break;
							}else{
								$response['status'] = 'ERROR_PARAM_NOTFOUND';
								return $response;		
							}
							
				default: 	// error messege return 
							$response['status'] = 'ERROR_SERVICE_NOTFOUND';
							return $response;
							break;
			}		
	}

	function get_comment($topicID){
		$sql_get_comments = "select * from comment where topic_id = ".$topicID.";";
		$result = $this->db->execute($sql_get_comments);
		$response = array();
			
			while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
    			
    			$data = array();
				$data["comment_id"] = $row["comment_id"];			
    			$data["profile_id"] = $row["profile_id"];
    			$data["topic_id"] = $row["topic_id"];
    			$data["comment"] = $row["comment"];
    			   			   			
    			$response[] = $data;
    		}
    		return $response;

		/*echo "comment displayed\n";
		return;*/
	}

	function create_comment($comment,$topic_id,$profileID){
		$sql_create_comment = "insert into comment values(null,".$profileID.",".$topic_id.",'".$comment."');";
		
		$result=$this->db->execute($sql_create_comment);
			//echo $result;
			$response = array();
			
			if($result==true){
					$response['status'] = 'SUCCESS';
					return $response;
			}else{
					$response['status'] = 'FAILED';
					return $response;
			}
		/*echo "create comment\n";
		echo $comment;
		return;*/
	}

	function update_comment($comment,$commentID){
		
		$sql_edit_comment = "update comment set comment = '".$comment."' where comment_id = ".$commentID.";";
		$result = $this->db->execute($sql_edit_comment);
		$response = array();
		
		if($result==true){
				$response['status'] = 'SUCCESS';
				return $response;
		}else{
				$response['status'] = 'FAILED';
				return $response;
		}
	}

	function delete_comment($commentID){
		// delete to be done later just keep in mind
		echo "delete comment\n";
		return;
	}
	
}

?>