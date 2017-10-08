<?php
    require_once "dblogin.php";    
    require_once "functions.php";
    require_once "user_object.php";
    header("Access-Control-Allow-Origin: *");
    header('Content-type: application/json');
    
    session_start();
    
    
    // Create connection
    $conn = dbConnection();
    
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
    elseif ($cmd == "create_user") {
        try
        {
            // Implement password and security answer validation here
            $user = new UserObject($_POST[name], $_POST[password], $_POST[securityAnswer1], $_POST[securityAnswer2]);
            $response = insertUser($conn, $response, $user);
        }
        catch (Exception $e) {
            echo "caught exception at insertUser";
            $response["errmsg"] = "Something went wrong with insert user";
            $response["status"] = "ERROR";
        }
    }
    elseif ($cmd == "update_user") {
        // Change user password when they answer 2 security questions
        try 
        {
            $response = updateUser($conn, $response);
        }
        catch (Exception $e) 
        {
            echo "caught exception at updateUser";
            $response["errmsg"] = "Something went wrong with update user";
            $response["status"] = "ERROR";
        }
    }
    else // default with no valid cmd found
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
    
    echo json_encode($response);
    
    
    // get all snippets in the database
    function listAll($conn, $response)
    {
        $stmt = "select CreatorID, Username, Snippet_Data.LanguageID, LanguageName, SnippetID, Description, Code from Snippet_Data inner join User_Data on Snippet_Data.CreatorID = User_Data.UserID inner join Language_Data on Snippet_Data.LanguageID = Language_Data.LanguageID;";
        $result = mysqli_query($conn, $stmt);
        $snippet = array();
        $snippets = array();
        while($row = mysqli_fetch_assoc($result)) {
            $snippet["id"] = $row["SnippetID"];
            $snippet["creator"] = $row["Username"];
            $snippet["description"] = $row["Description"];
            $snippet["language"] = $row["LanguageName"];
            $snippet["code"] = $row["Code"];
            array_push($snippets, $snippet);
        }
        
        $response["status"] = "OK"; 
        $response["snippets"] = json_encode($snippets);
        
        return $response;
    }
    
    // Create user in the database.
    function insertUser($conn, $response, $user) {
        $stmt = $conn->prepare("INSERT INTO User_Data(Username, Password, SecurityAnswer1, SecurityAnswer2) VALUES(?, ?, ?, ?)");
        $stmt->bind_param("ssss", $user->getName(), $user->getPassword(), $user->getSecurityAnswer1(), $user->getSecurityAnswer2());
        $stmt->execute();
        
        $response["status"] = "OK";
        
        return $response;
    }
    
    function updateUser($conn, $response) {
        

        // Find user in database and change values according to $user object.
        $response["status"] = "OK";
        
        return $response;
    }
    
    // get documentation for snippets.php
    function showDocumentation($conn, $response)
    {
        $api_command_list = array();
        
        $api_command["name"] = "list";
        $api_command["description"] = "Provides a list of code snippets.";

        $api_command["name"] = "create_user";
        $api_command["description"] = "Insert a user into the database. Should only be used with the register user form.";
        
        $api_command["name"] = "update_user";
        $api_command["description"] = "Update a user's credentials in the database.";
        
        array_push($api_command_list, $api_command);
        
        $response["status"] = "OK";
        $response["api_command_list"] = $api_command_list;
        
        return $response;
    }
?>