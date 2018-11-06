<?php

    //Establish connection to the database.
    include 'php/conn_db.php';

    $name = $email = $message = "";

    //Gets the name, email, message from javascript.
    $name = test_input($_POST["name"]);
    $email = test_input($_POST["email"]);
    $message = test_input($_POST["message"]);

    //Check if the email is valid.
    if(preg_match('/^[a-z0-9_]+[@]+[a-z]+[.]+[a-z]+$/i',$email) || preg_match('/^[a-z0-9_]+[@]+[a-z]+[.]+[a-z]+[.]+[a-z]+$/i',$email))
    {
        //PosgtreSQL Query Syntax passed to variable '$sql'
        $query = "insert into inbox_sender (id, name, email, content, date, time) values (default, '$name', '$email', '$message', current_date, current_time)";

        //Function that sends query to PostrgeSQL
        $return = pg_query($connection, $query);
    }
    else
    {

        $data = 'unsuccessfull validation';
        exit();
    }

    //PHP safety functions
    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);

        return $data;
    }

    //Close the connection to the database.
    pg_close($connection);
?>
