<div class="container">
    <?php
        $u = $_POST['username'] ?? null;
        $p = $_POST['password_hash'] ?? null;

        if(is_null($u) || is_null($p)){
            require "user_login_form.php";
        }else{
            echo "Dados ja inseridos...";
        }
    ?>
</div>