<?php
    // Including the file we are testing.
    require_once '../php/user_object.php';

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
        $testData = getNameTest($testData);
        $testData = setPasswordTest($testData);
        $testData = getPasswordTest($testData);
        
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
    function setNameTest($testData) {
        $expected = "Tom Petty";
        
        $user = new UserObject("testname", "testpass");
        $user->setName($expected);
        if($user->getName() !== $expected) {
            $testData["testPassed"] = false;
            $errorMessage = "Test 'setNameTest' failed (expected '%s', but got '%s')<br>";
            $errorMessage = sprintf($errorMessage, $expected, $user->getName());
            array_push($testData["testErrors"], $errorMessage);
        }
        return $testData;
    }
    
    function getNameTest($testData) {
        $expected = "testname";

        $user = new UserObject($expected, "testpass");
        if ($user->getName() !== $expected) {
            $testData["testPassed"] = false;
            $errorMessage = "Test 'getNameTest' failed (expected '%s', but got '%s')<br>";
            $errorMessage = sprintf($errorMessage, $expected, $user->getName());
            array_push($testData["testErrors"], $errorMessage);
        }
        return $testData;
    }
    
    function setPasswordTest($testData) {
        $expected = "heartbreaker";

        $user = new UserObject("testname", "testpass");
        $user->setPassword($expected);
        if($user->getPassword() !== $expected) {
            $testData["testPassed"] = false;
            $errorMessage = "Test 'setPasswordTest' failed (expected '%s', but got '%s')<br>";
            $errorMessage = sprintf($errorMessage, $expected, $user->getPassword());
            array_push($testData["testErrors"], $errorMessage);
        }
        return $testData;
    }
    
    function getPasswordTest($testData) {
        $expected = "testpass";

        $user = new UserObject("testname", $expected);
        if ($user->getPassword() !== $expected) {
            $testData["testPassed"] = false;
            $errorMessage = "Test 'getPasswordTest' failed (expected '%s', but got '%s')<br>";
            $errorMessage = sprintf($errorMessage, $expected, $user->getPassword());
            array_push($testData["testErrors"], $errorMessage);
        }
        return $testData;
    }
    /* End tests. */
?>