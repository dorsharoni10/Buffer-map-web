<?php

    //Establish connection to the database.
    include 'php/conn_db.php';

	  $username1 = $psw1 = $email1 = "";

    $username1 = test_input($_POST["username1"]);
    $psw1 = test_input($_POST["psw1"]);
    $email1 = test_input($_POST["email1"]);
    echo $email1;

    //Check if username is valid.
    if(preg_match('/^[a-z0-9_]+$/i',$username1))
    {
        $psw1 = md5($psw1);
        if (!filter_var($email1, FILTER_VALIDATE_EMAIL))
        {

        }
        else
        {
            //Variable that contains the query for PostgreSQL.
            $query = "insert into users (id , username , email , password , notification , credibility , active , deleted) values (default , '$username1' , '$email1' , '$psw1' , 'true' , 'true' , 'true' , 'true')";
            //Function that sends query to PostrgeSQL.
            $return = pg_query($connection, $query);
        }
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
