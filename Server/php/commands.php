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
    if ($conn->connect_error){
        
        die("Connection failed: " . $conn->connect_error);
        
    } 
    
    // Definition for init_response() function is in functions.php
    $response = initResponse();
    
    $cmd = getValue("cmd", "docs");
    
    // 'case' will run its code block if switch argument '$cmd' matches the given case, i.e. "list"
    // i.e. "in the case that $cmd matches given string 'list', run the given block of code"
    // if no cases are met, the default case will run
    try {
        switch ($cmd) {
            case "list":
                $response = listAll($conn, $response);
                break;
            case "create_user":
                $response = createUser($conn, $response);
                break;
            case "update_user":
                $response = recoverUser($conn, $response);
                break;
            case "login_user":
                $response = loginUser($conn, $response);
                break;
            case "get_user_session":
                $response = getUserSession($conn, $response);
                break;
            case "logout_user":
                $response = endUserSession($conn, $response);
                break;
            case "create_snippet";
                $response = createSnippet($conn, $response);
                break;
            case "list_languages";
                $response = listLanguages($conn, $response);
                break;
            default:
                $response = showDocumentation($conn, $response);
                break;
        }
        $response["status"] = "OK";
    } catch (Exception $e) {
        $response["errmsg"] = $e->getMessage();
        $response["status"] = "ERROR";
    } finally {
        echo json_encode($response);
    }
    
    // get all snippets in the database
    function listAll($conn, $response) {
        $stmt = "SELECT CreatorID, Username, Snippet_Data.LanguageID, LanguageName, SnippetID, Description, Code FROM Snippet_Data INNER JOIN User_Data ON Snippet_Data.CreatorID = User_Data.UserID INNER JOIN Language_Data ON Snippet_Data.LanguageID = Language_Data.LanguageID;";
        $result = mysqli_query($conn, $stmt);
        $snippet = array();
        $snippets = array();
        while ($row = mysqli_fetch_assoc($result)) {
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
    
    function listLanguages($conn, $response) {
        $stmt = "SELECT LanguageID, LanguageName FROM Language_Data";
        $result = mysqli_query($conn, $stmt);
        $language = array();
        $languages = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $language["id"] = $row["LanguageID"];
            $language["language_name"] = $row["LanguageName"];
            array_push($languages, $language);
        }
        
        $response["status"] = "OK"; 
        $response["languages"] = json_encode($languages);
        
        return $response;
    }
    
    function createUser($conn, $response) {
        if (verifyCreateUserInputs($conn, $_POST[name], $_POST[password], $_POST[confirmPassword])) {
            $user = new UserObject(null, $_POST[name], password_hash($_POST[password], PASSWORD_BCRYPT), password_hash($_POST[securityAnswer1], PASSWORD_BCRYPT), password_hash($_POST[securityAnswer2], PASSWORD_BCRYPT));
            $response = insertUser($conn, $response, $user);
            return $response;
        }
    }
    
    function recoverUser($conn, $response) {
        $user = verifyResetPasswordInputs($conn, $_POST[name], $_POST[newPassword], $_POST[verifyNewPassword], $_POST[securityAnswer1], $_POST[securityAnswer2]);
        $response = updateUser($conn, $user, $_POST[newPassword]);   
        return $response;
    }
    
    function loginUser($conn, $response) {
        $user = verifyLoginUserInputs($conn, $_POST[name], $_POST[password]);
        session_start();
        $_SESSION["username"] = $user->getName();
        $response["username"] = $user->getName();
        
        return $response;
    }
    
    function getUserSession($conn, $response) {
        if (isset($_SESSION["username"])) {
            $response["username"] = $_SESSION["username"];
        } else {
            throw new Exception("No user is logged in.");
        }
        return $response;
    }
   
    // This function allows the user to log out. 
    function endUserSession($conn, $response){
        $response["username"] = $_SESSION["username"];
        session_destroy();//native to php
      
        return $response;
    }
    
    // get documentation for snippets.php
    function showDocumentation($conn, $response) {
        $api_command_list = array();
        
        $api_command["name"] = "list";
        $api_command["description"] = "Provides a list of code snippets.";

        $api_command["name"] = "create_user";
        $api_command["description"] = "Insert a user into the database. Should only be used with the register user form.";
        
        $api_command["name"] = "update_user";
        $api_command["description"] = "Update a user's credentials in the database.";
        
        $api_command["name"] = "create_snippet";
        $api_command["description"] = "Inserts a new snippet into the database";
        
        array_push($api_command_list, $api_command);
        
        $response["status"] = "OK";
        $response["api_command_list"] = $api_command_list;
        
        return $response;
    }
    
// Verify inputs
    
    function verifyCreateUserInputs($conn, $username, $password, $confirmPassword) {
        // preg_match matches a regular expression (regex) against a string. In this case, make sure the password is good.
        // Returns 1 if the string passes, 0 if not, and false if an error occurs.
        
        // checks to see if the user already exist. 10/22/17
        $findUserResponse = findUser($conn, $username);
        if ($findUserResponse["user"]->getName() != null) {
            throw new Exception("A user with that name already exists");
        }
        if (preg_match("/(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.{8,})/", $password) != 1) {
            throw new Exception("Password not secure enough. Have at least 8 characters, composing of at least 1 upper and lowercase character, 1 number and 1 symbol.");
        }
        // Checks to see if the passwords match for Create User. 10/22/17 
        if ($password != $confirmPassword) {
            throw new Exception("Password doesn't match its confirmation");
        }
        
        return true;
    }
    
    function verifyResetPasswordInputs($conn, $username, $resetPass, $resetPassConfirm, $answer1, $answer2) {
        $user = null; // Will only be set if findUser finds a user.
        $findUserResponse = findUser($conn, $username);
        if ($findUserResponse["user"]->getName() != null) {
            $user = $findUserResponse["user"];
        } else {
            throw new Exception("A user with that name wasn't found.");
        }
        if ($resetPass != $resetPassConfirm) {
            throw new Exception("Passwords don't match.");
        }
        if (!password_verify($answer1, $user->getSecurityAnswer1())) {
            throw new Exception("The answer to the first security question is incorrect.");
        }
        if (!password_verify($answer2, $user->getSecurityAnswer2())) {
            throw new Exception("The answer to the second security question is incorrect.");
        }
        // preg_match matches a regular expression (regex) against a string. In this case, make sure the password is good.
        // Returns 1 if the string passes, 0 if not, and false if an error occurs.
        if (preg_match("/(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.{8,})/", $resetPass) != 1) {
            throw new Exception("Password not secure enough. Have at least 8 characters, composing of at least 1 upper and lowercase character, 1 number and 1 symbol.");
        }
        return $user;
    }
    
    function verifyLoginUserInputs($conn, $username, $password) {
        $user = null; // Will only be set if findUser finds a user.
        $findUserResponse = findUser($conn, $username);
        if ($findUserResponse["user"]->getName() != null) {
            $user = $findUserResponse["user"];
        } else {
            throw new Exception("A user with that name wasn't found.");
        }
        if (!password_verify($password, $user->getPassword())) {
            throw new Exception("This is not the correct password.");
        }
        return $user;
    }
    
     
    
    
// Prepared statement functions
    
    function insertUser ($conn, $response, $user) {
        $stmt = $conn->prepare("INSERT INTO User_Data(Username, Password, SecurityAnswer1, SecurityAnswer2) VALUES(?, ?, ?, ?);");
        $stmt->bind_param("ssss", $user->getName(), $user->getPassword(), $user->getSecurityAnswer1(), $user->getSecurityAnswer2());
        $stmt->execute();
        $stmt->close();
        
        $response["username"] = $user->getName();
        $response["status"] = "OK";
        
        return $response;
    }
    
    function findUser ($conn, $username) {
        $stmt = $conn->prepare("SELECT UserID, Username, Password, SecurityAnswer1, SecurityAnswer2 FROM User_Data WHERE Username = ?;");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($id, $name, $pass, $answer1, $answer2);
        $stmt->fetch();
        $user = new UserObject($id, $name, $pass, $answer1, $answer2);
        $stmt->close();
        
        $response["user"] = $user;
        $response["status"] = "OK";
        
        return $response;
    }
        
    function updateUser($conn, $user, $newPass) {
        $stmt = $conn->prepare("UPDATE User_Data SET Password = ? WHERE Username = ?;");
        $stmt->bind_param("ss", password_hash($newPass, PASSWORD_BCRYPT), $user->getName());
        $stmt->execute();
        $stmt->close();

        $response["user"] = $user->getName();
        $response["status"] = "OK";
        
        return $response;
    }
    
    function createSnippet($conn, $response) {
        $creatorID = findUser($conn, $_SESSION["username"])["user"]->getID();
        $languageID = $_POST[language];
        $description = $_POST[snippetName];
        $code = $_POST[snippetText];
        
        if ($code != "" && $code != null && $description != "" && $description != null) {
            $stmt = $conn->prepare("INSERT INTO Snippet_Data(CreatorID, LanguageID, Description, Code) VALUES (?,?,?,?);");
            $stmt->bind_param("iiss", $creatorID, $languageID, $description, $code);
            $stmt->execute();
            $stmt->close();
        } else {
            throw new Exception("required field left blank");
        }
        
        $response["status"] = "OK";
        return $response;
    }    
?>