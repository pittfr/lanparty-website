<?php
    function createHash($password){
        $hash = password_hash($password, PASSWORD_DEFAULT);
        return $hash;
    }

    function testHash($password, $hash){
        $b = password_verify($password, $hash);
        return $b;
    }
?>