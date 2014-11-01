<?php
	class Database{
		
//		private static $host = 'localhost';
//		private static $db = 'usdpco';
//		private static $dbuser = 'root';
//		private static $dbpassword = 'root';

        public static $host = 'localhost';
        public static $db = 'omsai_db';
        public static $dbuser = 'omsai_user';
        public static $dbpassword = '0msa!pa$$w0rd';

		public static function executeQuery($qry){
			
			date_default_timezone_set('Asia/Calcutta');
			
			mysql_connect(Database::$host, Database::$dbuser, Database::$dbpassword) or die(mysql_error());
			mysql_select_db(Database::$db);
			
			$result = mysql_query($qry) or die(mysql_error());		// returns true/false (insert, update, delete)
			
			return $result;
		}
		
		public static function executeQueryForID($qry){
			
			date_default_timezone_set('Asia/Calcutta');
							mysql_connect(Database::$host, Database::$dbuser, Database::$dbpassword) or die(mysql_error());
			mysql_select_db(Database::$db);
				
			$result = mysql_query($qry) or die(mysql_error());		// returns true/false (insert, update, delete)
				
			$id = mysql_insert_id();
			
			return $id;
		}
		
		public static function readData($qry){
			
			date_default_timezone_set('Asia/Calcutta');

			mysql_connect(Database::$host, Database::$dbuser, Database::$dbpassword) or die(mysql_error());
			mysql_select_db(Database::$db);
				
			$result = mysql_query($qry);		// returns collection of rows
				
			if(mysql_num_rows($result)>0)
				return $result;
			else
				return NULL;
		}
					
		public static function readSingleRow($qry){
			
			date_default_timezone_set('Asia/Calcutta');

			mysql_connect(Database::$host, Database::$dbuser, Database::$dbpassword) or die(mysql_error());
			mysql_select_db(Database::$db);
				
			$result = mysql_query($qry) or die(mysql_error());		
				
			if(mysql_num_rows($result)>0){
				$row = mysql_fetch_row($result);
				
				return $row;
			}
			else
				return NULL;
		}
						
		public static function dataExists($qry){
							
			date_default_timezone_set('Asia/Calcutta');
				
			mysql_connect(Database::$host, Database::$dbuser, Database::$dbpassword) or die(mysql_error());
			mysql_select_db(Database::$db);
				
			$result = mysql_query($qry) or die(mysql_error());		
				
			return mysql_num_rows($result)>0;		
		}
	}
?>