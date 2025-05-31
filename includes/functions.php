<?php
    function isActivePage($name) {
        global $page;
        return ($page == $name) ? "class='active'" : "";
    }

?>