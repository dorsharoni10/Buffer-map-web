<?php

    //Php code that creates a connection to the database.

    $dbname="dbname = GIS";
    $dbhost="host = 127.0.0.1";
    $dbport="port = 5432";
    $dbusername="user = postgres";
    $dbpassword="password = 1234";

    $connection = pg_connect("$dbhost $dbport $dbname $dbusername $dbpassword");
?>
