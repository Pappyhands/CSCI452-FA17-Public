<?php
require_once "../php/dblogin.php";    
require_once "../php/functions.php";
require_once "../php/user_object.php";
require_once "../php/commands.php";

echo "\n\n";


function listAllTest($conn, $testData) {
    $response = initResponse();
    $response = listAll($conn, $response);
    
    // Check for successful request
    if ($response["status"] !== "OK") {
        $testData["testPassed"] = false;
        array_push($testData["testErrors"], $response["errmsg"]);
    }
    
    
    // Check if snippets JSON can be decoded
    $decoded = json_decode($response["snippets"]);
    if (!isset($decoded)) {
        $testData["testPassed"] = false;
        $errorMessage = "Snippet JSON could not be decoded";
        array_push($testData["testErrors"], $errorMessage);
        return $testData;
    }
    
    if (!isset($decoded[0]->id)) {
        $testData["testPassed"] = false;
        $errorMessage = "Snippet JSON is empty";
        array_push($testData["testErrors"], $errorMessage);
    }
    
    return $testData;
}

function createUserTest($conn, $testData) {
    $response = initResponse();
    $_POST["name"] = $testData["testName"];
    $_POST["password"] = $testData["testPassword"];
    $_POST["confirmPassword"] = $_POST["password"];
    $_POST["securityAnswer1"] = $testData["testQuestion1"];
    $_POST["securityAnswer2"] = $testData["testQuestion2"];

    
    $response = createUser($conn, $response);
    
    // Check for successful request
    if ($response["status"] !== "OK") {
        $testData["testPassed"] = false;
        array_push($testData["testErrors"], $response["errmsg"]);
    }
    
    if ($response["username"] !== $testData["testName"]) {
        $testData["testPassed"] = false;
        $errorMessage = "User was not created properly";
        array_push($testData["testErrors"], $errorMessage);
    }
    
    return $testData;
}

function recoverUserTest($conn, $testData) {
    $response = initResponse();
    $testData["testPassword"] = "TestRecoverPass123";

    $_POST["name"] = $testData["testName"];
    $_POST["newPassword"] = $testData["testPassword"];
    $_POST["verifyNewPassword"] = $_POST["newPassword"];
    $_POST["securityAnswer1"] = $testData["testQuestion1"];
    $_POST["securityAnswer2"] = $testData["testQuestion2"];
    
    $response = recoverUser($conn, $response);
    
    if ($response["status"] !== "OK") {
        $testData["testPassed"] = false;
        array_push($testData["testErrors"], $response["errmsg"]);
    }
    
    if ($response["user"] !== $testData["testName"]) {
        $testData["testPassed"] = false;
        $errorMessage = "Username was altered in recovery message";
        array_push($testData["testErrors"], $errorMessage);      
    }
    
    
    return $testData;
}

function loginUserTest($conn, $testData) {
    $response = initResponse();
    $_POST["name"] = $testData["testName"];
    $_POST["password"] = $testData["testPassword"];
    
    $response = loginUser($conn, $response);
    
    if ($response["errmsg"] !== "") {
        $testData["testPassed"] = false;
        array_push($testData["testErrors"], $response["errmsg"]);        
    }
    
    if ($response["username"] !== $testData["testName"]) {
        $testData["testPassed"] = false;
        $errorMessage = "Something went wrong login";
        array_push($testData["testErrors"], $errorMessage);      
    }
    
    return $testData;
}

function deleteSnippetTest($conn, $testData){
    
}

function updateSnippetTest($conn, $testData){
    /*
    Insert hardcoded snipppet
    change it
    check to see if change was made to inserted snippet
    */
    
   /* $response = initResponse();
    $_POST["snippetID"] = $testData["testSnippetID"];
    $_POST["code"] = $testData["code"];
    
    $response = updateSnippet($conn, $response);
    
    if ($response)*/
}


function executeTests() {
    echo "Beginning Tests\n";

    $conn = dbConnection();
    if ($conn->connect_error) {
        die("Connection failed: ". $conn->connect_error());
    }

    $testData = [
      "testPassed" => true,
      "testErrors" => [],
      "testName" => "Test Username".rand(),
      // test name has random number appended so test can be ran multiple times
      "testPassword" => "TestPassword123",
      "testQuestion1" => "city",
      "testQuestion2" => "mom"
    ];
    
    $testData = listAllTest($conn, $testData);
    $testData = createUserTest($conn, $testData);
    $testData = recoverUserTest($conn, $testData);
    $testData = loginUserTest($conn, $testData);
    
    
    session_destroy();
    echo "Tests complete. ";
    if ($testData["testPassed"]) {
        echo "SUCCESS\n";
    } else {
        echo "FAILURE\n";
        $size = count($testData["testErrors"]);
        for ($i = 0; $i < $size; $i++) {
            echo "Error ".$i.": ".$testData["testErrors"][$i]."\n";
        }
    }
    echo "\n";
}

executeTests();
?>
