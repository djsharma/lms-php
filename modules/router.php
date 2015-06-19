
<?php


class Router{
	
	
	private $access = false;
	


	public function __construct($request)
	{
		$this->access = false;
		//erlier posithion of auth declaration and defination was here//
		$auth = new Auth();
		
		//check if authenticate is called the pass the request as true 
		if(strcmp($request,'authenticate') == 0) {
			$this->access = true; 
			//echo "authenticate_done\n"; 

			return;
		}

		//else check for authentication of token if failed set access as false
		//echo "authenticate not define\n";
		
		/*if(is_null($auth->verify_token($_POST['token']))){
			echo "failed verification here\n";
			$this->access = false;
			return;
		}
		*/
		$method = $_SERVER['REQUEST_METHOD'];
		$token = null;
		switch ($method) {
			case 'POST':
						$token = $_POST['token'];
						break;
			
			case 'GET':
						$token = $_GET['token'];	
						break;
			
			case 'DELETE':
						parse_str(file_get_contents("php://input"),$post_vars);
						$token = $post_vars['token'];
						break;
			
			case 'PUT':
						parse_str(file_get_contents("php://input"),$put_vars);
						$token = $put_vars['token'];
						break;
						
			default:
						//default null
						break;
		}

		$verify_result = $auth->verify_token($token);	

		if(is_null($verify_result)){
			//echo "failed verification here\n";
			$this->access = false;
			return;	
		}	

		//authntication successful
		$this->access = true;
		return;

	} 


	function authenticate(){
		$auth = new Auth();
		$token = $auth->get_token(123);		
		$response_array = array('token' => $token);
		return $response_array['token'];
	}


	//match with all the uri and use the file name provided 
	// these are last points to send json data
	function dispatch($req_module){
		$auth = new Auth();
		switch($req_module){
			case 'profile' : 
							$profile = new Profile();
							$response = $profile->handle_request();
							echo "profile accessed\n";
							break;

			case 'authenticate' : 	
									echo $this->authenticate();
									echo "authenticate accessed\n";
									break;				
		}
	}




	function get_access(){
		if(!empty($this->access)){
			return $this->access;
		}
		return false;
	}


}

?>
