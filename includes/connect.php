<?php
    $db = new mysqli("localhost", "root", "", "lanparty");

    if($db->connect_errno){
        die();
    }
?>