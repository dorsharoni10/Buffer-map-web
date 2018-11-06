<?php
    //Establish connection to the database.
    include 'conn_db.php';

    //Variable that contains the query for PostgreSQL.
    $query = "SELECT attraction.id, lat, lng, id_category FROM location INNER JOIN attraction on location.id = attraction.id_location";

    //Function that sends query to PostrgeSQL.
    $return = pg_query($connection, $query);

    //Echo the variables returned from the query to javascript variable data.
    while($row = pg_fetch_row($return))
    {

        echo $row[0].","; //id
        echo $row[1].","; //lat
        echo $row[2].","; //lag
        echo $row[3].","; //id_category

    }

    //Close the connection to the database.
    pg_close($connection);
?>
