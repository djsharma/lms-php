<?php

include './modules/router.php';
include './modules/database.php';
include './modules/profile.php';
include './auth/auth.php';
include './auth/vendor/autoload.php';



/*

//temporary development	
	$db = new Db('localhost','root','root');
	$result = $db->execute("select * from profile");
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
    	printf("%s %s \n", $row["first_name"], $row["last_name"]);  
	}
	mysql_free_result($result);
	$db->close_db();
//temporary development ends here	
	


*/




	$requestURI=explode('/',$_SERVER['REQUEST_URI']);	
	
	$router = new Router($requestURI[2]);
	
		
	if(!($router->get_access())) {
		//echo "this should not get executed for authenticate\n";
		$fail_auth = array('messg' => 'AUTH_FAILED');
		echo json_encode($fail_auth);
		return;
	} 

	$router->dispatch($requestURI[2]);
	


?>
