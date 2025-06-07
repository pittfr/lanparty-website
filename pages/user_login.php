<div class="container">
    <?php
        $e = $_POST['email'] ?? null;
        $p = $_POST['password'] ?? null;

        if(is_null($e) || is_null($p)){
            require "user_login_form.php";
        }else{
            $q = "SELECT id, username, email, password_hash, tipo FROM utilizadores WHERE email = '$e' LIMIT 1";
            $procura = $db->query($q);
            if(!$procura){
                // erro ao aceder a base de dados
            }else{
                if($procura->num_rows > 0){

                    $reg = $procura->fetch_object();

                    if(testHash($p, $reg->password_hash)){
                        echo "<h1>Password válida</h1>";
                        $_SESSION['user_id'] = $reg->id;
                        $_SESSION['username'] = $reg->username;
                        $_SESSION['tipo'] = $reg->tipo;
                        header("Location: ?page=home");
                    }else{
                        echo "<h1>Password inválida</h1>";
                    }
                    
                }else{
                    echo "<h1>Email inválido</h1>";
                }
                
                
            }
        }
    ?>
</div>