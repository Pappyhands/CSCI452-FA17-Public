<?php
    // Test still under construction
    require_once '../php/user_object.php';

    executeTest();
    
    function executeTest() {
        $testPassed = true;
        $testPassed = setNameTest();
        $testPassed = getNameTest();
        $testPassed = setPasswordTest();
        $testPassed = getPasswordTest();
        if ($testPassed === true) {
            echo "<br>UserObjectTest passed!";
        } else {
            echo "<br>UserObjectTest failed!";
        }
    }
    
    function setNameTest() {
        $user = new UserObject("testname", "testpass");
        $user->setName("Tom Petty");
        if($user->getName() !== "Tom Petty") {
            $testPassed = false;
            echo "<br>Failed to set user name in function 'setNameTest'";
        }
        return $testPassed;
    }
    
    function getNameTest() {
        $user = new UserObject("testname", "testpass");
        if ($user->getName() !== "testname") {
            $testPassed = false;
            echo "<br>Failed to obtain user name in function 'getNameTest'";
        }
        return $testPassed;
    }
    
    function setPasswordTest() {
        $user = new UserObject("testname", "testpass");
        $user->setPassword("heartbreaker");
        if($user->getPassword() !== "heartbreaker") {
            $testPassed = false;
            echo "<br>Failed to set password in function 'setPasswordTest'";
        }
        return $testPassed;
    }
    
    function getPasswordTest() {
        $user = new UserObject("testname", "testpass");
        if ($user->getPassword() !== "testpass") {
            $testPassed = false;
            echo "<br>Failed to obtain password in function 'getPasswordTest'";
        }
        return $testPassed;
    }
?>