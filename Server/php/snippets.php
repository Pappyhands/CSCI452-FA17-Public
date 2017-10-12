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
    
    // 'case' will run its code block if switch argument '$cmd' matches the given case, i.e. "list"
    // i.e. "in the case that $cmd matches given string 'list', run the given block of code"
    // if no cases are met, the default case will run
    switch($cmd) {
        case "list":
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
            break;
            
        case "create_user":
            try
            {
                if (verifyCreateUserInputs($_POST[password])) {
                    $user = new UserObject($_POST[name], $_POST[password], $_POST[securityAnswer1], $_POST[securityAnswer2]);
                    $response = insertUser($conn, $response, $user);
                } else {
                    $response["errmsg"] = "Password not secure enough. Have at least 8 characters, composing of at least 1 upper and lowercase character, 1 number and 1 symbol.";
                    $response["status"] = "ERROR";
                }
            }
            catch (Exception $e) {
                echo "caught exception at insertUser";
                $response["errmsg"] = "Something went wrong with insert user";
                $response["status"] = "ERROR";
            }
            break;
            
        case "update_user":
            // Change user password when they answer 2 security questions.
            try 
            {
                $user = null; // Will only be set if findUser finds a user.
                $findUserResponse = findUser($conn, $_POST[name]);
                if ($findUserResponse["status"] == "OK") {
                    $user = $findUserResponse["user"];
                } else {
                    $response["status"] = "ERROR";
                    $response["errmsg"] = "Incorrect information entered.";
                }
                // Check validity of input fields before running functionality.
                if (verifyResetPasswordInputs($user, $_POST[newPassword], $_POST[verifyNewPassword], $_POST[securityAnswer1], $_POST[securityAnswer2])) {
                    // Update user in the database.
                    $response = updateUser($conn, $user, $_POST[newPassword]);                
                } else {
                    $response["status"] = "ERROR";
                    $response["errmsg"] = "Incorrect information entered.";
                }
            }
            catch (Exception $e) 
            {
                echo "caught exception at updateUser";
                $response["errmsg"] = "Something went wrong with update user";
                $response["status"] = "ERROR";
            }
            break;
            
        default:
            try
            {
                $response = showDocumentation($conn, $response);
            }
            catch (Exception $e)
            {
                $response["errmsg"] = "Something went wrong with snippets documentation";
                $response["status"] = "ERROR";
            }
            break;
    }

    echo json_encode($response);
    
    // get all snippets in the database
    function listAll($conn, $response)
    {
        $stmt = "SELECT CreatorID, Username, Snippet_Data.LanguageID, LanguageName, SnippetID, Description, Code FROM Snippet_Data INNER JOIN User_Data ON Snippet_Data.CreatorID = User_Data.UserID INNER JOIN Language_Data ON Snippet_Data.LanguageID = Language_Data.LanguageID;";
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
        $stmt = $conn->prepare("INSERT INTO User_Data(Username, Password, SecurityAnswer1, SecurityAnswer2) VALUES(?, ?, ?, ?);");
        $stmt->bind_param("ssss", $user->getName(), $user->getPassword(), $user->getSecurityAnswer1(), $user->getSecurityAnswer2());
        $stmt->execute();
        $stmt->close();
        
        $response["status"] = "OK";
        
        return $response;
    }
    
    // Find user in the database given a username.
    function findUser($conn, $username) {
        $stmt = $conn->prepare("SELECT Username, Password, SecurityAnswer1, SecurityAnswer2 FROM User_Data WHERE Username = %s;");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($name, $pass, $answer1, $answer2);
        $stmt->fetch();
        $user = new UserOject($name, $pass, $answer1, $answer2);
        $stmt->close();
        
        $response["user"] = $user;
        $response["status"] = "OK";
        
        return $response;
    }
    
    // Verify valid credentials of user info for creating a new user
    function verifyCreateUserInputs($password) {
        // preg_match matches a regular expression (regex) against a string. In this case, make sure the password is good.
        // Returns 1 if the string passes, 0 if not, and false if an error occurs.
        if (preg_match("/(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.{8,})/", $password) != 1) {
            return false;
        }
        return true;
    }
    
    // Verify valid credentials of user info for resetting password
    function verifyResetPasswordInputs($user, $resetPass, $resetPassConfirm, $answer1, $answer2) {
        if ($resetPass != $resetPassConfirm) {
            return false;
        }
        if (!password_verify($user->getSecurityAnswer1(), answer1)) {
            return false;
        }
        if (!password_verify($user->getSecurityAnswer2(), answer2)) {
            return false;
        }
        // preg_match matches a regular expression (regex) against a string. In this case, make sure the password is good.
        // Returns 1 if the string passes, 0 if not, and false if an error occurs.
        if (preg_match("/(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.{8,})/", $resetPass) != 1) {
            return false;
        }
        return true;
    }

    function updateUser($conn, $user, $newPass) {
        $stmt = $conn->prepare("UPDATE User_Data SET Password = ? WHERE Username = ?;");
        $stmt->bind_param("ss", password_hash($newPass, PASSWORD_DEFAULT), $user->getName());
        $stmt->execute();
        $stmt->close();

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