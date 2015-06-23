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
							if($requestURI[3]!=null){ //    GET /comment   get all the comment available for topic_id
								// comment for topic_id
								$response = $this->get_comment($requestURI[3]);
								return $response;
							}else{

								echo "ERROR_PARAM_NOTFOUND";
								return;
								break;
							}	
							break;
				


				case 'POST':
							$requestURI = explode('/',$_SERVER['REQUEST_URI']);	
							if($requestURI[3]!=null){ // POST /comment/:topic_id
								//create a comment 
								$response = $this->create_comment($_POST['comment'],$requestURI[3],$this->profile_id);
								return $response;
							}else{
								echo "ERROR_PARAM_NOTFOUND";
								return;
								break;	
							}	
							break;
				
				case 'PUT':	
							
							$requestURI = explode('/',$_SERVER['REQUEST_URI']);	
							if($requestURI[3]!=null){   //  PUT /comment/:comment update the comment with comment_id								//update course
							
								$response = $this->update_comment($parse_request['comment'],$requestURI[3]);
								return $response;
							}else{
								echo "ERROR_PARAM_NOTFOUND";
								return;
								break;
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
								echo "ERROR_PARAM_NOTFOUND";
								return;
								break;
							}
							
				default: 	// error messege return 
							echo "error http method";
							break;
			}		

	}

	function get_comment($topicID){
		echo "comment displayed\n";
		return;
	}

	function create_comment($comment,$topic_id){
		echo "create comment\n";
		echo $comment;
		return;
	}

	function update_comment($comment,$commentID){
		echo "update comment\n";
		echo $comment;
		return;
	}

	function delete_comment($commentID){
		echo "delete comment\n";
		return;
	}
}

?>