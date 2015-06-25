<?php

	class Registration{
		private $profile_id = null;
		private $db = null;
		function __construct($database,$profileID){
			$this->db = $database;
			$this->profile_id = $profileID;
		}

		function dispatch(){
			$method = $_SERVER['REQUEST_METHOD'];
			$response = array();
			$requestURI = null;

			switch ($method) {
				case 'POST':	
								// POST /register/:course_id
								$requestURI = explode('/',$_SERVER['REQUEST_URI']);	
								
								if($requestURI[3]!=null){
									$response = $this->register($requestURI[3]);
									return $response;
								}else{
									$response = array();
									$response['status'] = 'PARAM_NOTFOUND';
									return $response;
								} 
								break;
				case 'DELETE':  
								// DELETE /register/: course_id
								$requestURI = explode('/',$_SERVER['REQUEST_URI']);	
								
								if($requestURI[3]!=null){
									$response = $this->deregister($requestURI[3]);
									return $response;
								}else{
									$response = array();
									$response['status'] = 'PARAM_NOTFOUND';
									return $response;
								} 
								break;
				

				default:		# code
								break;
			}
		}

		function register($course_id){
			//check if already registered and if not then only register for the course
			$sql_register = "insert into register values(".$course_id.",".$this->profile_id.");";
			$result=$this->db->execute($sql_register);
			$response = array();
		
			if($result==true){
				$response['status'] = 'SUCCESS';
				return $response;
			}else{
				$response['status'] = 'FAILED';
				return $response;
			}
		}

		function deregister($course_id){
			//deregistration means removel from the entry.
			$sql_deregister = "delete from register where course_id = ".$course_id." and profile_id = ".$this->profile_id.";";
			$result=$this->db->execute($sql_deregister);
			$response = array();
		
			if($result==true){
				$response['status'] = 'SUCCESS';
				return $response;
			}else{
				$response['status'] = 'FAILED';
				return $response;
			}
		}

	}


?>