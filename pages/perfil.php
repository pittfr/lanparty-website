<?php
    if(isset($_GET['action']) && $_GET['action'] == 'logout') {
        logout();
        header("Location: ?page=home");
        exit();
    }

    $userId = $_SESSION['user_id'];
    
    $q = "SELECT * FROM `utilizadores` WHERE id='$userId' LIMIT 1";

    $procura = $db->query($q);

    if(!$procura || $procura->num_rows == 0){
        header("Location: ?page=home");
    }else{
        $user = $procura->fetch_object();
    }
?>

<div class="container">
    <h2 class="title">Perfil</h2>
    <div class="user-panel">
        <div class='user-about'>
            <?php
                include "pages/profile_about.php";
            ?>
        </div>

        <div class="user-menu">
            <?php
                if(isset($_GET['action']) && $_GET['action'] == 'change-password'){
                    include "pages/change-password.php";
                }else{
                    include "pages/profile_menu.php";
                }
            ?>
        </div>
    </div>
</div>