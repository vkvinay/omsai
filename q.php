<?php
    $q = mysql_escape_string($_REQUEST ['q']);

    include("modal/database.php");

    mysql_connect(Database::$host, Database::$dbuser, Database::$dbpassword) or die(mysql_error());
    mysql_select_db(Database::$db);

    $result = mysql_query($qry) or die(mysql_error());		// returns true/false (insert, update, delete)

    return $result;
?>