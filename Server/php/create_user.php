<?php
    require_once 'user_object.php';
    require_once 'dbcommands.php';
    //$sPrime is the hashed user password.
    $sPrime = password_hash($_POST[password], PASSWORD_DEFAULT);
    $user = new UserObject($_POST[name], $sPrime);
    insertUser($user);
?>