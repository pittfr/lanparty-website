<?php
    session_start();

    if(!isset($_SESSION['username'])){
        $_SESSION['user_id'] = "";
        $_SESSION['username'] = "";
        $_SESSION['tipo'] = "";
    }

    function createHash($password){
        $hash = password_hash($password, PASSWORD_DEFAULT);
        return $hash;
    }

    function testHash($password, $hash){
        $b = password_verify($password, $hash);
        return $b;
    }
?>