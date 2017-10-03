<?php
    require_once 'dblogin.php';
    require_once 'user_object.php';
    
    function insertUser($user) {
        $conn = dbConnection();
        $stmt = $conn->prepare("INSERT INTO User_Data(Username, Password) VALUES(?, ?)");
        $stmt->bind_param("ss", $user->getName(), $user->getPassword());
        $stmt->execute();
    }
?>
