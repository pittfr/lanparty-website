<?php
    function isActivePage($name) {
        global $page;
        return ($page == $name) ? "class='active'" : "";
    }

    function gameThumbnail ($file){
        $path = "assets/images/games/$file";
        return $path;
    }

    function getUserImage ($id, $hasImage=null){
        $imagePath = "assets/images/users/$id.webp";
        $defaultPath = "assets/images/users/default.webp";
        
        if($hasImage === false) {
            return $defaultPath;
        } else if($hasImage === true) {
            return $imagePath;
        }
        
        if(file_exists($_SERVER['DOCUMENT_ROOT'] . '/' . $imagePath)) {
            return $imagePath;
        } else {
            return $defaultPath;
        }
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