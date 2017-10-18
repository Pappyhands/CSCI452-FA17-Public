<?php
    // Including the file we are testing.
    require_once "../php/dblogin.php";    
    require_once "../php/functions.php";
    require_once "../php/user_object.php";
    
    session_start();
    
    // Create connection
    $conn = dbConnection();
    
    // Check connection
    if ($conn->connect_error){
        
        die("Connection failed: " . $conn->connect_error);
        
    } 

    // Run the file.
    executeTest();
    
    function executeTest() {
        // Initialize testData array (did all tests pass?, what errors have we hit?)
        $testData = [
            "testPassed" => true,
            "testErrors" => []
        ];
        
        // Run tests
        $testData = setNameTest($testData);
        $testData = listAllTest($testData);
        $testData = createUserTest($testData);
        $testData = recoverUserTest($testData);
        $testData = loginUserTest($testData);
        $testData = getUserSessionTest($testData);
        $testData = showDocumentationTest($testData);
        $testData = verifyCreateUserInputsTest($testData);
        $testData = verifyResetPasswordInputsTest($testData);
        $testData = verifyLoginUserInputsTest($testData);
        $testData = insertUserTest($testData);
        $testData = findUserTest($testData);
        $testData = updateUserTest($testData);
        
        
        
    
    
        // Output status
        echo "<h1>";
        if ($testData["testPassed"] === true) {
            echo "CmdTest passed!<br>";
        } else {
            echo "CmdTest failed:<br>";
            for ($i = 0; $i < count($testData["testErrors"]); $i++) {
                $format = " - %s";
                echo sprintf($format, $testData["testErrors"][$i]);
            }
        }
        echo "</h1>";
    }
    
    /* Begin tests for methods in user_object.php. */
    
    function setNameTest($testData) {
        $expected = "Tom Petty";
        
        $user = new UserObject("testname", "testpass", "testanswer1", "testanswer2");
        $user->setName($expected);
        if($user->getName() !== $expected) {
            $testData["testPassed"] = false;
            $errorMessage = "Test 'setNameTest' failed (expected '%s', but got '%s')<br>";
            $errorMessage = sprintf($errorMessage, $expected, $user->getName());
            array_push($testData["testErrors"], $errorMessage);
        }
        return $testData;
    }
    
    function listAllTest($testData) {
        
        
        $stmt = "SELECT CreatorID, Username, Snippet_Data.LanguageID, LanguageName, SnippetID, Description, Code FROM Snippet_Data INNER JOIN User_Data ON Snippet_Data.CreatorID = User_Data.UserID INNER JOIN Language_Data ON Snippet_Data.LanguageID = Language_Data.LanguageID;";

        
        
        $testData = [
            "testPassed" => true,
            "testErrors" => []
        ];
        
        return $testData;
    }
    
    function createUserTest($testData) {
         $testData = [
            "testPassed" => true,
            "testErrors" => []
        ];
        
        return $testData;
    }
    
    function recoverUserTest($testData) {
         $testData = [
            "testPassed" => true,
            "testErrors" => []
        ];
        
        return $testData;
    }
    
    function loginUserTest($testData) {
         $testData = [
            "testPassed" => true,
            "testErrors" => []
        ];
        
        return $testData;
    }
    
    function getUserSessionTest($testData) {
         $testData = [
            "testPassed" => true,
            "testErrors" => []
        ];
        
        return $testData;
    }
    
    function showDocumentationTest($testData) {
         $testData = [
            "testPassed" => true,
            "testErrors" => []
        ];
        
        return $testData;
    }
    
    function verifyCreateUserInputsTest($testData) {
         $testData = [
            "testPassed" => true,
            "testErrors" => []
        ];
        
        return $testData;
    }
    
    function verifyResetPasswordInputsTest($testData) {
         $testData = [
            "testPassed" => true,
            "testErrors" => []
        ];
        
        return $testData;
    }
    
    function verifyLoginUserInputsTest($testData) {
         $testData = [
            "testPassed" => true,
            "testErrors" => []
        ];
        
        return $testData;
    }
    
    
    
    function insertUserTest($testData) {
         $testData = [
            "testPassed" => true,
            "testErrors" => []
        ];
        
        return $testData;
    }
    
    function findUserTest($testData) {
         $testData = [
            "testPassed" => true,
            "testErrors" => []
        ];
        
        return $testData;
    }
    
    function updateUserTest($testData) {
         $testData = [
            "testPassed" => true,
            "testErrors" => []
        ];
        
        return $testData;
    }
    
    /* End tests. */
?>