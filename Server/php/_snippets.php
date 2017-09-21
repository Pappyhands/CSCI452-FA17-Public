<?php
header("Access-Control-Allow-Origin: *");
header('Content-type: application/json');

session_start();


// Create connection
$conn = new mysqli($db_hostname, $db_username, $db_password, $db_database, $db_port);

// Check connection
if ($conn->connect_error)
{
    die("Connection failed: " . $conn->connect_error);
} 

// Definition for init_response() function is in functions.php
$response = initResponse();

$cmd = getValue("cmd", "docs");
 
if ($cmd == "list")
{
    try 
    {
        $response = listAll($conn, $response);
    }
    catch (Exception $e)
    {
        echo "caught exception at listAll";
        $response["errmsg"] = "Something went wrong with snippets list";
        $response["status"] = "ERROR";
    }
} 
else // default with no cmd found
{
    try
    {
        $response = showDocumentation($conn, $response);
    }
    catch (Exception $e)
    {
        $response["errmsg"] = "Something went wrong with snippets documentation";
        $response["status"] = "ERROR";
    }
}
// else // invalid 'cmd' parameter
// {
//     $response["errmsg"] = "Invalid cmd value";
//     $response["status"] = "ERROR";
// }

echo json_encode($response);


// get all snippets in the database
function listAll($conn, $response)
{
    $stmt = "SELECT * FROM Snippet_Data INNER JOIN User_Data AS Users ON Users.UserID=Snippet_Data.CreatorID";
    $result = mysqli_query($conn, $stmt);
    $snippet = array();
    $snippets = array();
    while($row = mysqli_fetch_assoc($result)) {
        $snippet["id"] = $row["SnippetID"];
        $snippet["creator"] = $row["Username"];
        $snippet["description"] = $row["Description"];
        $snippet["language"] = $row["Language"];
        array_push($snippets, $snippet);
    }    
    
    $response["status"] = "OK"; 
    $response["snippets"] = json_encode($snippets);
    
    return $response;
}

// get documentation for snippets.php
function showDocumentation($conn, $response)
{
    $api_command_list = array();
    
    $api_command["name"] = "list";
    $api_command["description"] = "Provides a list of code snippets.";
    array_push($api_command_list, $api_command);
    
    $response["status"] = "OK";
    $response["api_command_list"] = $api_command_list;
    
    return $response;
}
?>