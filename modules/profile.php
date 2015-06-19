<?php

class Profile{
	function __construct(){
			//temporary development	
			$db = new Db('localhost','root','root');
			$result = $db->execute("select * from profile");
			while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
    			printf("%s %s \n", $row["first_name"], $row["last_name"]);  
			}
			mysql_free_result($result);
			$db->close_db();
			//temporary development ends here	
	}


	function handle_request(){
		echo "handled request\n";
	}


}

?>