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
        $testData = setSecurityAnswer1Test($testData);
        $testData = getSecurityAnswer1Test($testData);
        $testData = setSecurityAnswer2Test($testData);
        $testData = getSecurityAnswer2Test($testData);
        
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
    
    function getNameTest($testData) {
        $expected = "testname";

        $user = new UserObject($expected, "testpass", "testanswer1", "testanswer2");
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

        $user = new UserObject("testname", "testpass", "testanswer1", "testanswer2");
        $user->setPassword($expected);
        if (!password_verify($expected, $user->getPassword())) {
            $testData["testPassed"] = false;
            $errorMessage = "Test 'setPasswordTest' failed<br>";
            array_push($testData["testErrors"], $errorMessage);
        }
        return $testData;
    }
    
    function getPasswordTest($testData) {
        $expected = "testpass";

        $user = new UserObject("testname", $expected, "testanswer1", "testanswer2");
        if (!password_verify($expected, $user->getPassword())) {
            $testData["testPassed"] = false;
            $errorMessage = "Test 'getPasswordTest' failed<br>";
            array_push($testData["testErrors"], $errorMessage);
        }
        return $testData;
    }
    
    function setSecurityAnswer1Test($testData) {
        $expected = "nixonsback";
        
        $user = new UserObject("testname", "testpassword", "AROOOOOOO", "testanswer2");
        $user->setSecurityAnswer1($expected);
        if (!password_verify($expected, $user->getSecurityAnswer1())) {
            $testData["testPassed"] = false;
            $errorMessage = "Test 'setSecurityAnswer1Test' failed (expected '%s', but got '%s'<br>";
            $errorMessage = sprintf($errorMessage, $expected, $user->getSecurityAnswer1());
            array_push($testData["testErrors"], $errorMessage);
        }
        return $testData;
    }
    
    function getSecurityAnswer1Test($testData) {
        $expected = "benderbendingrodriguez";
        
        $user = new UserObject("testname", "testpassword", $expected, "testanswer2");
        if (!password_verify($expected, $user->getSecurityAnswer1())) {
            $testData["testPassed"] = false;
            $errorMessage = "Test 'getSecurityAnswer1Test' failed (expected '%s', but got '%s'<br>";
            $errorMessage = sprintf($errorMessage, $expected, $user->getSecurityAnswer1());
            array_push($testData["testErrors"], $errorMessage);
        }
        return $testData;
    }
    
    function setSecurityAnswer2Test($testData) {
        $expected = "BadaBing";
        
        $user = new UserObject("testname", "testpassword", "testanswer1", "BadaBoom");
        $user->setSecurityAnswer2($expected);
        if (!password_verify($expected, $user->getSecurityAnswer2())) {
            $testData["testPassed"] = false;
            $errorMessage = "Test 'setSecurityAnswer2Test' failed (expected '%s', but got '%s'<br>";
            $errorMessage = sprintf($errorMessage, $expected, $user->getSecurityAnswer2());
            array_push($testData["testErrors"], $errorMessage);
        }   
        return $testData;

    }
    
    function getSecurityAnswer2Test($testData) {
        $expected = "MrStrutsLilOlMan";
        
        $user = new UserObject("testname", "testpassword", "testanswer1", $expected);
        if (!password_verify($expected, $user->getSecurityAnswer2())) {
            $testData["testPassed"] = false;
            $errorMessage = "Test 'getSecurityAnswer2Test' failed (expected '%s', but got '%s'<br>";
            $errorMessage = sprintf($errorMessage, $expected, $user->getSecurityAnswer2());
            array_push($testData["testErrors"], $errorMessage);
        }        
        return $testData;
    }
    /* End tests. */
?>