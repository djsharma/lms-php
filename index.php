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
include './modules/comment.php';
include './modules/assessment.php';
include './modules/submission.php';
include './modules/announcement.php';
include './modules/registration.php';



	$db = new Db('localhost','root','root');

	
	$authenticate = new Authenticate($db);
	


	if($authenticate->get_access()) {
		
		$authenticate->get_response();
		
		$profile_id=$authenticate->get_profile_id(); // replaced from get_token();
		
		$router = new Router($db,$profile_id);

		$router->dispatch();
			
	}else{
		$authenticate->get_response();
	}

	$db->close_db();
	


?>
