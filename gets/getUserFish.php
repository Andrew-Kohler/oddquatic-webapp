<?php
    // Connection details for our server - where to find it, which database we want to open, and the username/password for it
    $serverName = "oddquatic-db-server-333.database.windows.net"; 
    $connectionOptions = array(
        "Database" => "oddquatic-resourcedb-333", 
        "Uid" => "CloudSAe6d5ed3e", 
        "PWD" => "xojoannaxo33+" 
    );

    //Establishes the connection, print errors if it's a miss
    $conn = sqlsrv_connect($serverName, $connectionOptions);
    if( $conn === false ) {
     die( print_r( sqlsrv_errors(), true));
    }

    $secretKey = "Kongllelujah"; // Secret key to allow for match test
    $realHash = md5($_POST['username'] . $secretKey); // Make an MD5 hash with the given data - it should match up to the hash

    // If our hash matches, our keys match, and we have verified that the request came from a legitimate client and we can proceed with retrieval
    if($realHash == $_POST['hash'] ) { 
        $params = [$_POST['username']];

        // So first within here, we need to check if the username is actually real. If it's not, we provide nothing!
        $tsql = "SELECT UserID
                FROM dbo.Users
                WHERE UserName = ?";
        $getResults= sqlsrv_query($conn, $tsql, $params); 

        if ($getResults == FALSE) { 
            echo (serialize(sqlsrv_errors()));
        }

        else if(sqlsrv_fetch($getResults) == null) // If we find no results, we just add this user to the database and return nothing
            {
            $tsql = "INSERT INTO dbo.Users
                VALUES(?, 0)";
            $getResults= sqlsrv_query($conn, $tsql, $params); 
            if ($getResults == FALSE)
                echo (serialize(sqlsrv_errors()));
            }
        else {
        // This query uses a subquery to first determine UserID from UserName, and then uses the recovered UserID 
            $tsql= "SELECT FishID, FishName, FishScale, FishColor, UserID
                FROM dbo.Fish
                WHERE UserID =
                    (SELECT UserID
                    FROM dbo.Users
                    WHERE UserName = ?)";
            $getResults= sqlsrv_query($conn, $tsql, $params); 
            if ($getResults == FALSE)
                echo (serialize(sqlsrv_errors()));

            // Echo back each found row formatted as JSON
            while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
                // We now return the User ID as part of the fish data :D
                $data = ['id' => $row['FishID'], 'name' => $row['FishName'], 'scale' => $row['FishScale'],'color' => $row['FishColor'], 'userID' => $row['UserID']];
                header('Content-Type: application/json');
                echo json_encode($data) . ','; // Additional formatting to help Unity parse the data
            }
        }
    } 
    else{
        echo "Hashes don't match, security breach"; // A little dramatic and not especially useful, but still true!
    }