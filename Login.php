<?php

    //Establish connection to the database.
    include 'php/conn_db.php';
    //Keeps the connection until the session is over.
    session_start();


    $name = $email = $message = "";

    $username = test_input($_POST["username"]);
    $password = test_input($_POST["password"]);

    //Encrypt the password.
    $password = md5($password);

    //Check if username is valid.
    if(preg_match('/^[a-z0-9_]+$/i',$username))
    {
        //Variable that contains the query for PostgreSQL.
        $query = "SELECT username FROM users WHERE username='$username' and password='$password'";
        //Function that sends query to PostrgeSQL
        $return = pg_query($connection, $query);

        if($row = pg_fetch_row($return)){

            $_SESSION['username'] = $username;
        }
    }
    else
    {
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
