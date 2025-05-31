<?php
    function isActivePage($name) {
        global $page;
        return ($page == $name) ? "class='active'" : "";
    }

    function gameThumbnail ($file){
        $path = "assets/images/games/$file";
        return $path;
    }
?>