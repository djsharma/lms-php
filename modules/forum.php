<?php

	class Forum{

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
							if($requestURI[3]==null){ //    GET /topic   get all the topics available
								//create course
								$response = $this->get_topic();
								return $response;
							}else{

								echo "ERROR_PARAM_FOUND";
								return;
								break;
							}	
							break;
				


				case 'POST':
							$requestURI = explode('/',$_SERVER['REQUEST_URI']);	
							if($requestURI[3]==null){ //    POST /topic   create a topic
								//create a topic 
								$response = $this->create_topic($_POST['topic'],$_POST['text'],$this->profile_id);
								return $response;
							}else{
								echo "ERROR_PARAM_FOUND";
								return;
								break;	
							}	
							break;
				
				case 'PUT':	
							
							$requestURI = explode('/',$_SERVER['REQUEST_URI']);	
							if($requestURI[3]!=null){   //  PUT /topic/:topic_id update the topic with topic_id
								//update course
								$response = $this->update_topic($parse_request['topic'],$parse_request['text'],$requestURI[3]);
								return $response;
							}else{
								echo "ERROR_PARAM_NOTFOUND";
								return;
								break;
							}	
							break;			

							
				case 'DELETE':
							//delete the course   DELETE /topic/:topic_id
							$requestURI = explode('/',$_SERVER['REQUEST_URI']);	
														
							if($requestURI[3]!=null){
								$response = $this->delete_topic($requestURI[3]);
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

		// POST /topic
		function create_topic($topic,$text,$profileID){
			echo "create topic";
			return;
		}

		// get all the topics /topic/: 	
		function get_topic(){
			echo "get topic";
			return;
		}

		// PUT /topic/:topic_id
		function update_topic($topic,$text,$topic_id){
			echo "update topic";
			return;
		}
		// DELETE /topic/:topic_id
		function delete_topic($topic_id){
			echo "delete topic";
			return;
		}

	}

?>