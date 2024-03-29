
<?php


class Router{
	
	
	private $access = false;
	private $parse_request = array(); //useful only for delete and put request
	private $profile_id = null;
	private $db = null;



	public function __construct($db,$profileID){

		$this->profile_id = $profileID;
		$this->db = $db;
		
	}


	//match with all the uri and use the file name provided 
	// these are last points to send json data
	function dispatch(){

		
				

		parse_str(file_get_contents("php://input"),$this->parse_request);
		

		$requestURI=explode('/',$_SERVER['REQUEST_URI']);	
		$req_module = $requestURI[2];
		$auth = new Auth();
		
		switch($req_module){
			case 'profile' : 
									$profile = new Profile($this->db,$this->profile_id);
									$response = $profile->dispatch($this->parse_request);
									header('Content-type: application/json');
									echo json_encode($response);

									//echo "profile accessed\n";
									//echo $response;
									break;

			case 'authenticate' : 	
									//echo $this->authenticate();
									//echo "authenticate accessed\n";
									break;

			case 'course' : 		
									$course = new Course($this->db,$this->profile_id);
									$response = $course->dispatch($this->parse_request);
									header('Content-type: application/json');
									echo json_encode($response);

									//echo "\ncourse accessed\n";
									//echo $response;
									break;

			case 'lecture' : 		
									$lecture = new Lecture($this->db,$this->profile_id);
									$response = $lecture->dispatch($this->parse_request);
									header('Content-type: application/json');
									echo json_encode($response);
									/*echo "\nlecture accessed\n";*/
									//echo $response;
									break;
			
			case 'topic' :			
									$forum = new Forum($this->db,$this->profile_id);
									$response = $forum->dispatch($this->parse_request);
									header('Content-type: application/json');
									echo json_encode($response);
									/*echo "\nforum accessed\n";
									break;	*/
									break;

			case 'comment':			
									$comment = new Comment($this->db,$this->profile_id);
									$response = $comment->dispatch($this->parse_request);
									header('Content-type: application/json');
									echo json_encode($response);
									break;
			case 'assessment':		
									$assessment = new Assessment($this->db,$this->profile_id);
									$response = $assessment->dispatch($this->parse_request);
									header('Content-type: application/json');
									echo json_encode($response);
									break;
			case 'submission':		
									$submission = new Submission($this->db,$this->profile_id);
									$response = $submission->dispatch($this->parse_request);
									header('Content-type: application/json');
									echo json_encode($response);
									break;
			case 'announcement':																													
									$announcement = new Announcement($this->db,$this->profile_id);
									$response = $announcement->dispatch($this->parse_request);
									header('Content-type: application/json');
									echo json_encode($response);
									break;
			
			
			case 'register':		$register = new Registration($this->db,$this->profile_id);
									$response = $register->dispatch($this->parse_request);
									header('Content-type: application/json');
									echo json_encode($response);
									break;
										

			default:				$response = array();
									$response['status'] = 'ERROR_SERVICE_NOTFOUND';
									header('Content-type: application/json');
									echo json_encode($response);
									break;
			
										
		}		
	}


}

?>




