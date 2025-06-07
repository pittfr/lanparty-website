<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $passwordConfirmation = $_POST['password-confirmation'] ?? '';
    
    $errors = [];
    
    if (strlen($username) < 3) {
        $errors[] = "O nome de utilizador deve ter pelo menos 3 caracteres.";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Por favor insira um email válido.";
    } else if (strlen($password) < 6) {
        $errors[] = "A password deve ter pelo menos 6 caracteres.";
    } else if ($password !== $passwordConfirmation) {
        $errors[] = "As passwords não coincidem.";
    }
    
    if (empty($errors)) {
        $checkUser = $db->prepare("SELECT id FROM utilizadores WHERE email = ? LIMIT 1");
        $checkUser->bind_param("s", $email);
        $checkUser->execute();
        $checkUser->store_result();
        
        if ($checkUser->num_rows > 0) {
            $errors[] = "Já existe uma conta com este email.";
        }
        $checkUser->close();
    }
    
    if (empty($errors)) {
        $passwordHash = createHash($password);
        $dataRegisto = date('Y/m/d');
        
        $insertUser = $db->prepare("INSERT INTO utilizadores (username, email, password_hash, tipo, data_registo) VALUES (?, ?, ?, 'membro', ?)");
        $insertUser->bind_param("ssss", $username, $email, $passwordHash, $dataRegisto);
        
        if ($insertUser->execute()) {
            $getUser = $db->prepare("SELECT id, username, tipo FROM utilizadores WHERE email = ? LIMIT 1");
            $getUser->bind_param("s", $email);
            $getUser->execute();
            $reg = $getUser->get_result()->fetch_object();
            

            $_SESSION['user_id'] = $reg->id;
            $_SESSION['username'] = $reg->username;
            $_SESSION['tipo'] = $reg->tipo;

            addSuccess("Conta criada com sucesso.");
            $getUser->close();
            header("Location: ?page=home");
            exit();
        } else {
            $errors[] = "Erro ao criar conta: " . $db->error;
        }
        $insertUser->close();
    }
    
    if (!empty($errors)) {
        foreach ($errors as $error) {
            addError($error);
        }
        header("Location: ?page=register");
        exit();
    }
}
?>

<div class="container">
    <div class="register-wrapper">
        <h2>Registar</h2>
        <form action="" method="post">
            <input placeholder="Username" type="text" name="username" id="username" size="30" value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>">
            <input placeholder="Email" type="email" name="email" id="email" size="100" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
            <input placeholder="Password" type="password" name="password" id="password" size="100">
            <input placeholder="Confirmar Password" type="password" name="password-confirmation" id="password-confirmation" size="100">
    
            <input type="submit" value="Registar">
            <p>Já tens uma conta?</p>
            <a href="?page=login">Entrar</a>
        </form>
    </div>
</div>