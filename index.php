<?php

include './auth/vendor/autoload.php';
include './modules/router.php';
include './modules/database.php';
include './modules/profile.php';
include './auth/auth.php';
include './modules/course.php';
include './modules/lecture.php';
include './modules/authenticate.php';
include './modules/forum.php';

	$authenticate = new Authenticate();
	
	if($authenticate->get_access()) {
		$authenticate->get_response();
		$profile_id=$authenticate->get_token();
		$router = new Router($profile_id);	
		$router->dispatch();
			
	}else{
		$authenticate->get_response();
	}


	


?>
