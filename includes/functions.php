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

    function logout (){
        unset($_SESSION['user_id']);
        unset($_SESSION['username']);
        unset($_SESSION['tipo']);
    }

    function addMessage($message, $type) {
        if(!isset($_SESSION['messages'])) {
            $_SESSION['messages'] = [];
        }
        $_SESSION['messages'][] = [
            'text' => $message,
            'type' => $type
        ];
    }

    function addSuccess($message) {
        addMessage($message, 'success');
    }

    function addWarning($message) {
        addMessage($message, 'warning');
    }

    function addError($message) {
        addMessage($message, 'error');
    }

    function displayMessages() {
        $output = '';
        
        if(isset($_SESSION['messages']) && !empty($_SESSION['messages'])) {
            foreach($_SESSION['messages'] as $message) {
                switch($message['type']) {
                    case 'success':
                        $output .= msgSuccess($message['text']);
                        break;
                    case 'warning':
                        $output .= msgWarning($message['text']);
                        break;
                    case 'error':
                        $output .= msgError($message['text']);
                        break;
                }
            }
            
            $_SESSION['messages'] = [];
        }
        
        return $output;
    }
?>