<?php
    // Including the file we are testing.
    require_once "../php/dblogin.php";    
    require_once "../php/functions.php";
    require_once "../php/user_object.php";
    require_once "../php/commands.php";
    header("Access-Control-Allow-Origin: *");
    header('Content-type: application/json');
    
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
        // $testData = setNameTest($testData); // just an example test from UserObjectsTest
        
        $testData = listAllTest($testData);
        $testData = createUserTest($testData);
        $testData = recoverUserTest($testData);
        $testData = loginUserTest($testData);
        $testData = getUserSessionTest($testData);
        $testData = endUserSessionTest($testData);
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
            echo "UserObjectTest passed!<br>";
        } else {
            echo "UserObjectTest failed:<br>";
            for ($i = 0; $i < count($testData["testErrors"]); $i++) {
                $format = " - %s";
                echo sprintf($format, $testData["testErrors"][$i]);
            }
        }
        echo "</h1>";
    }
    
    /* Begin tests for methods in user_object.php. */
    
    // just an example test from UserObjectsTest
    // function setNameTest($testData) {
    //     $expected = "Tom Petty";
        
    //     $user = new UserObject("testname", "testpass", "testanswer1", "testanswer2");
    //     $user->setName($expected);
    //     if($user->getName() !== $expected) {
    //         $testData["testPassed"] = false;
    //         $errorMessage = "Test 'setNameTest' failed (expected '%s', but got '%s')<br>";
    //         $errorMessage = sprintf($errorMessage, $expected, $user->getName());
    //         array_push($testData["testErrors"], $errorMessage);
    //     }
    //     return $testData;
    // }
   
    function listAllTest($testData){
        
        // grab response used in test.
        $response = initResponse();
        
        //$expected = 
        echo implode( ',', listAll($conn, $response));
        if(listAll($conn, $response) !== $expected) {// fix these
            $testData["testPassed"] = false;
            $errorMessage = "Test 'listAllTest' failed (expected '%s', but got '%s')<br>";
            $errorMessage = sprintf($errorMessage, $expected, $TESTVAR);
            array_push($testData["testErrors"], $errorMessage);
        }
        return $testData;
    }

    function createUserTest($testData){
        
        // grab response used in test.
        $response = initResponse();
        
        //TESE GOES HERE
        
        
        if($TESTVAR !== $expected) {// fix these
            $testData["testPassed"] = false;
            $errorMessage = "Test 'createUserTest' failed (expected '%s', but got '%s')<br>";
            $errorMessage = sprintf($errorMessage, $expected, $TESTVAR);
            array_push($testData["testErrors"], $errorMessage);
        }
        return $testData;
    }
    
    function recoverUserTest($testData){
        
        // grab response used in test.
        $response = initResponse();
        
        //TESE GOES HERE
        
        
        if($TESTVAR !== $expected) {// fix these
            $testData["testPassed"] = false;
            $errorMessage = "Test 'recoverUserTest' failed (expected '%s', but got '%s')<br>";
            $errorMessage = sprintf($errorMessage, $expected, $TESTVAR);
            array_push($testData["testErrors"], $errorMessage);
        }
        return $testData;
    }
    
    
    function loginUserTest($testData){
        
        // grab response used in test.
        $response = initResponse();
        
        //TESE GOES HERE
        
        
        if($TESTVAR !== $expected) {// fix these
            $testData["testPassed"] = false;
            $errorMessage = "Test 'loginUserTest' failed (expected '%s', but got '%s')<br>";
            $errorMessage = sprintf($errorMessage, $expected, $TESTVAR);
            array_push($testData["testErrors"], $errorMessage);
        }
        return $testData;
    }
    
    function getUserSessionTest($testData){
        
        // grab response used in test.
        $response = initResponse();
        
        //TESE GOES HERE
        
        
        if($TESTVAR !== $expected) {// fix these
            $testData["testPassed"] = false;
            $errorMessage = "Test 'getUserSessionTest' failed (expected '%s', but got '%s')<br>";
            $errorMessage = sprintf($errorMessage, $expected, $TESTVAR);
            array_push($testData["testErrors"], $errorMessage);
        }
        return $testData;
    }
    
    function endUserSessionTest($testData){
        
        // grab response used in test.
        $response = initResponse();
        
        //TESE GOES HERE
        
        
        if($TESTVAR !== $expected) {// fix these
            $testData["testPassed"] = false;
            $errorMessage = "Test 'endUserSessionTest' failed (expected '%s', but got '%s')<br>";
            $errorMessage = sprintf($errorMessage, $expected, $TESTVAR);
            array_push($testData["testErrors"], $errorMessage);
        }
        return $testData;
    }
    
    function showDocumentationTest($testData){
        
        // grab response used in test.
        $response = initResponse();
        
        //TESE GOES HERE
        
        
        if($TESTVAR !== $expected) {// fix these
            $testData["testPassed"] = false;
            $errorMessage = "Test 'showDocumentationTest' failed (expected '%s', but got '%s')<br>";
            $errorMessage = sprintf($errorMessage, $expected, $TESTVAR);
            array_push($testData["testErrors"], $errorMessage);
        }
        return $testData;
    }
    
    function verifyCreateUserInputsTest($testData){
        
        // grab response used in test.
        $response = initResponse();
        
        //TESE GOES HERE
        
        
        if($TESTVAR !== $expected) {// fix these
            $testData["testPassed"] = false;
            $errorMessage = "Test 'verifyCreateUserInputsTest' failed (expected '%s', but got '%s')<br>";
            $errorMessage = sprintf($errorMessage, $expected, $TESTVAR);
            array_push($testData["testErrors"], $errorMessage);
        }
        return $testData;
    }
    
    function verifyResetPasswordInputsTest($testData){
        
        // grab response used in test.
        $response = initResponse();
        
        //TESE GOES HERE
        
        
        if($TESTVAR !== $expected) {// fix these
            $testData["testPassed"] = false;
            $errorMessage = "Test 'verifyResetPasswordInputsTest' failed (expected '%s', but got '%s')<br>";
            $errorMessage = sprintf($errorMessage, $expected, $TESTVAR);
            array_push($testData["testErrors"], $errorMessage);
        }
        return $testData;
    }
    
    function verifyLoginUserInputsTest($testData){
        
        // grab response used in test.
        $response = initResponse();
        
        //TESE GOES HERE
        
        
        if($TESTVAR !== $expected) {// fix these
            $testData["testPassed"] = false;
            $errorMessage = "Test 'verifyLoginUserInputsTest' failed (expected '%s', but got '%s')<br>";
            $errorMessage = sprintf($errorMessage, $expected, $TESTVAR);
            array_push($testData["testErrors"], $errorMessage);
        }
        return $testData;
    }
    
    function insertUserTest($testData){
        
        // grab response used in test.
        $response = initResponse();
        
        //TESE GOES HERE
        
        
        if($TESTVAR !== $expected) {// fix these
            $testData["testPassed"] = false;
            $errorMessage = "Test 'insertUserTest' failed (expected '%s', but got '%s')<br>";
            $errorMessage = sprintf($errorMessage, $expected, $TESTVAR);
            array_push($testData["testErrors"], $errorMessage);
        }
        return $testData;
    }
    
    function findUserTest($testData){
        
        // grab response used in test.
        $response = initResponse();
        
        //TESE GOES HERE
        
        
        if($TESTVAR !== $expected) {// fix these
            $testData["testPassed"] = false;
            $errorMessage = "Test 'findUserTest' failed (expected '%s', but got '%s')<br>";
            $errorMessage = sprintf($errorMessage, $expected, $TESTVAR);
            array_push($testData["testErrors"], $errorMessage);
        }
        return $testData;
        
    }
    
    function updateUserTest($testData){
        
        // grab response used in test.
        $response = initResponse();
        
        //TESE GOES HERE
        
        
        if($TESTVAR !== $expected) {// fix these
            $testData["testPassed"] = false;
            $errorMessage = "Test 'updateUserTest' failed (expected '%s', but got '%s')<br>";
            $errorMessage = sprintf($errorMessage, $expected, $TESTVAR);
            array_push($testData["testErrors"], $errorMessage);
        }
        return $testData;
    }
    
   
    /* End tests. */
?>