<?php
    if($page == "login"){
        include "pages/user_login.php";
    }else{
        include "pages/$page.php";
    }
?>