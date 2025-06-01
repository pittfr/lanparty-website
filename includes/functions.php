<?php
    function isActivePage($name) {
        global $page;
        return ($page == $name) ? "class='active'" : "";
    }

    function gameThumbnail ($file){
        $path = "assets/images/games/$file";
        return $path;
    }

    function getUserImage ($id){
        $path = "assets/images/users/$id.webp";
    }

    function msgSuccess ($m){
        $resp = "<li class='msg success'><span></span><p>$m</p></li>";
        return $resp;
    }

    function msgWarning ($m){
        $resp = "<li class='msg warning'><span></span><p>$m</p></li>";
        return $resp;
    }

    function msgError ($m){
        $resp = "<li class='msg error'><span></span><p>$m</p></li>";
        return $resp;
    }
?>