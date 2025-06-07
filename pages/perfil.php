<?php
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
        <?php
            $profilePicture = getUserImage($user->id, $user->image);

            $regDate = DateTime::createFromFormat('Y/m/d', $user->data_registo);
            $formatedDate = $regDate ? $regDate->format('d M, Y') : $user->data_registo;
        ?>

        <div class='user-about'>
            <div class='avatar'>
                <img src='<?php echo $profilePicture ?>' alt='<?php echo $user->username ?>'>
            </div>

            <div class='data'>
                <h4><?php echo $user->username ?></h4>
                <p>Registou-se a <span><?php echo $formatedDate ?></span></p>
            </div>

            <ul class='option-list'>
                <li class='active'>
                    <input type='radio' name='menu' id='profile-option'>
                    <label for='profile-option'>Perfil</label>
                </li>
                <li>
                    <input type='radio' name='menu' id='change-password-option'>
                    <label for='change-password-option'>Mudar Password</label>
                </li>
                <li>
                    <form action='logout.php' method='post'>
                        <button id='logout-button' type='submit' class='logout-button'></button>
                    </form>
                    <label for='logout-button'>Terminar sessão</label>
                </li>
            </ul>
        </div>

        <div class="user-menu">
            <div id="change-info-content" class="menu-content active">
                <?php
                    include "pages/change_info_menu.php";
                ?>
            </div>
            <div id="change-password-content" class="menu-content">
                <?php
                    include "pages/change_password_menu.php";
                ?>
            </div>
        </div>
    </div>
</div>