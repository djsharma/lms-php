
<?php


class Router{
	
	
	private $access = false;
	private $parse_request = array(); //useful only for delete and put request
	private $profile_id = null;




	function _construct($profileID){
		$this->profile_id = $profileID;
		
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
									$profile = new Profile($this->profile_id);
									$response = $profile->dispatch($this->parse_request);
									echo "profile accessed\n";
									echo $response;
									break;

			case 'authenticate' : 	
									//echo $this->authenticate();
									//echo "authenticate accessed\n";
									break;

			case 'course' : 		
									$course = new Course($this->profile_id);
									$response = $course->dispatch($this->parse_request);
									echo "\ncourse accessed\n";
									//echo $response;
									break;

			case 'lecture' : 		
									$lecture = new Lecture($this->profile_id);
									$response = $lecture->dispatch($this->parse_request);
									echo "\nlecture accessed\n";
									//echo $response;
									break;
			
			case 'topic' :			
									$forum = new Forum($this->profile_id);
									$response = $forum->dispatch($this->parse_request);
									echo "\nforum accessed\n";
									break;	

			case 'comment':			
									$comment = new Comment($this->profile_id);
									$response = $comment->dispatch($this->parse_request);
									echo "comment accessed\n";
									break;
			case 'assessment':		
									$assessment = new Assessment($this->profile_id);
									$response = $assessment->dispatch($this->parse_request);
									echo "assessment accessed\n";
			case 'submission':		
									$submission = new Submission($this->profile_id);
									$response = $submission->dispatch($this->parse_request);
									echo "submission accessed\n";
			case 'announcement':																													
									$announcement = new Announcement($this->profile_id);
									$response = $announcement->dispatch($this->parse_request);
									echo "announcement accessed\n";
		}		
	}


}

?>




