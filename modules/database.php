<?php
 
 /*	class to handle database connection that is persistent. 
 	provide functions to access databases.
*/

 	class Db{

 		private $connection;

 		function __construct($server , $user , $password){
 			 		
 			 		$this->connection = mysql_connect($server, $user, $password);
					if (!$this->connection) {
    								die('Could not connect: ' . mysql_error());
					}
					//echo "Connected successfully\n";
					$dbhandle = mysql_select_db("lms_php",$this->connection);
					if(!$dbhandle){
									die('handle table not working : ' . mysql_error());
					}
		}	

 		
 		function execute($query){


 				$result = mysql_query($query);
 				return $result;
 			
 		}	

 		
 		function close_db(){
				mysql_close($this->connection);
				return; 			
 		}


 		function get_profile_id($email,$password){
 			return;
 		}

 	}


?>