<?php
    $db_hostname = getenv('IP');
    $db_username = getenv('C9_USER');
    $db_password = '';
    $db_database = 'SnippetGoodDatabase';
    $db_port = 3306;
    
    // Create connection
    $conn = new mysqli($db_hostname, $db_username, $db_password, $db_database, $db_port);
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>