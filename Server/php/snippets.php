 
<?php
require_once "functions.php";
require_once 'dblogin.php';

// session_start();
// header("Access-Control-Allow-Origin: *");

// Create connection
$conn = new mysqli($db_hostname, $db_username, $db_password, $db_database, $db_port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$cmd = getValue("cmd", "list");
 
if ($cmd == "list")
{
    $response = listAll($conn);
    // header('Content-type: application/json');
    echo json_encode($response);
}
else // unknown commad so list all supported commands
{
  echo
  "
    <pre>
    
        The only supported command for snippets is list.
        
    </pre>
  ";
}
// select a collection af objects based on some criteria
function listAll($conn)
{

    $stmt = "SELECT * FROM Snippet_Data";
    $result = mysqli_query($conn, $stmt);
    $snippet = array();
    $snippets = array();
    while($row = mysqli_fetch_assoc($result)) {
        $snippet["id"] = $row["SnippetID"];
        $snippet["creator"] = $row["CreatorID"];
        $snippet["description"] = $row["Description"];
        $snippet["language"] = $row["Language"];
        array_push($snippets, $snippet);
    }    
    
    
    // add anything you want to the response JSON...
    $response["status"] = "OK"; 
    $response["snippets"] = json_encode($snippets);
    
    return $response;
}
?>