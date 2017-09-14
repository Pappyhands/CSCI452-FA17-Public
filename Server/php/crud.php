<?php
require_once('functions.php');
require_once('dblogin.php');

session_start();
header("Access-Control-Allow-Origin: *");

// Create connection
$conn = new mysqli($db_hostname, $db_username, $db_password, $db_database, $db_port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$cmd = getValue("cmd", "");
if ($cmd == "create")
{
    $response = create($conn);
    header('Content-type: application/json');
    echo json_encode($response);
}
else if ($cmd == "read")
{
    $response = read($conn);
    header('Content-type: application/json');
    echo json_encode($response);
}
else if ($cmd == "update")
{
    $response = update($conn);
    header('Content-type: application/json');
    echo json_encode($response);
}
else if ($cmd == "delete")
{
    $response = delete($conn);
    header('Content-type: application/json');
    echo json_encode($response);
}
else if ($cmd == "list")
{
    $response = listAll($conn);
    header('Content-type: application/json');
    echo json_encode($response);
}
else // unknown commad so list all supported commands
{
  echo
  "
    <pre>
    
        // documentatiom for commads goes here...
        
    </pre>
  ";
}

// insert a new object
function create($conn)
{
    // code goes here...

    // add anything you want to the response JSON...
    $response["status"] = "OK"; 
    
    return $response;
}

// select an object
function read($conn)
{
    // code goes here...
    
    // add anything you want to the response JSON...
    $response["status"] = "OK"; 

    return $response;
}

// update an object
function update($conn)
{
    // code goes here...
    
    // add anything you want to the response JSON...
    $response["status"] = "OK"; 

    return $response;
}

// delete an object
function delete($conn)
{
    // code goes here...
    
    // add anything you want to the response JSON...
    $response["status"] = "OK"; 

    return $response;
}

// select a collection of objects based on some criteria
function listAll($conn)
{

    // add anything you want to the response JSON...
    $response["status"] = "OK"; 

    return $response;
}