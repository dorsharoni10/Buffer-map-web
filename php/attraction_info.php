<?php
    //Establish connection to the database.
    include 'conn_db.php';

    $id = "";
    //Gets the id from javascript.
    $id = $_POST["id"];

    //Variables that contain the query for PostgreSQL.
    $locationNameqQuery = "select name, street, house_number from attraction inner join location on attraction.id = location.id where attraction.id = ". $id .";";
    $pictureQuery = "select path from picture where id_attraction = " . $id . ";";

    //Function that sends query to PostrgeSQL
    $locationName = pg_query($connection, $locationNameqQuery);
    $picture = pg_query($connection, $pictureQuery);

    //Echo the variables returned from the query to javascript variable data.
    while($row = pg_fetch_row($locationName))
    {
        echo $row[0].","; //name
        echo $row[1].","; //street
        echo $row[2].","; //house_number
    }

    while($row = pg_fetch_row($picture))
    {
        echo $row[0]; //pic
    }

    //Close the connection to the database.
    pg_close($connection);
?>
