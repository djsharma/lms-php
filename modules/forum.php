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
								//echo $_POST['topic'];
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
			
			$sql_create_topic = "insert into forum values(null,".$profileID.",'".$topic."','".$text."');";
			//echo $sql_create_topic;
			$result=$this->db->execute($sql_create_topic);
			//echo $result;
			$response = array();
			

			if($result==true){
					$response['status'] = 'SUCCESS';
					return $response;
			}else{
					$response['status'] = 'FAILED';
					return $response;
			}


			/*echo "create topic";
			return;*/
		}

		// get all the topics GET /topic/ 	
		function get_topic(){
			
			$sql_get_topic = "select * from forum;";
			$result=$this->db->execute($sql_get_topic);
			$response = array();
			
			while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
    			
    			$data = array();
							
    			$data["topic_id"] = $row["topic_id"];
    			$data["topic"] = $row["topic"];
    			$data["profile_id"] = $row["profile_id"];
    			$data["details"] = $row["details"];
    			   			
    			$response[] = $data;
    		}
    		return $response;

			/*echo "get topic";
			return;*/
		}

		// PUT /topic/:topic_id
		function update_topic($topic,$text,$topic_id){
			$sql_update_topic = "update forum set topic = '".$topic."',details = '".$text."' where topic_id = ".$topic_id.";";
			$result=$this->db->execute($sql_update_topic);
			//echo $result;
			$response = array();
		
			if($result==true){
					$response['status'] = 'SUCCESS';
					return $response;
			}else{
					$response['status'] = 'FAILED';
					return $response;
			}

			//echo $sql_update_topic;
			
			/*echo "update topic";
			return;*/
		}
		// DELETE /topic/:topic_id
		function delete_topic($topic_id){
			//delete to be done later cascaded way
			echo "delete topic";
			return;
		}

	}

?>