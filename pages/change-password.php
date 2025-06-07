<?php

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['current-password'])) {
    $currentPassword = $_POST['current-password'];
    $newPassword = $_POST['new-password'];
    $confirmPassword = $_POST['new-password_confirmation'];
    $passwordChanged = false;
    $passwordErrors = [];
    
    if (empty($currentPassword)) {
        $passwordErrors[] = "É necessário introduzir a password atual.";
    }else if (empty($newPassword)) {
        $passwordErrors[] = "É necessário introduzir uma nova password.";
    }else if (strlen($newPassword) < 8) {
        $passwordErrors[] = "A nova password deve ter pelo menos 8 caracteres.";
    }else if ($newPassword !== $confirmPassword) {
        $passwordErrors[] = "As passwords não coincidem.";
    }
    
    if (empty($passwordErrors)) {
        $stmt = $db->prepare("SELECT password_hash FROM utilizadores WHERE id = ?");
        $stmt->bind_param("i", $user->id);
        $stmt->execute();
        $result = $stmt->get_result();
        $userData = $result->fetch_assoc();
        
        if (!testHash($currentPassword, $userData['password_hash'])) {
            $passwordErrors[] = "A password atual está incorreta.";
        } else {
            $hashedPassword = createHash($newPassword);
            
            $updatePassword = $db->prepare("UPDATE utilizadores SET password_hash = ? WHERE id = ?");
            $updatePassword->bind_param("si", $hashedPassword, $user->id);
            
            if ($updatePassword->execute()) {
                $passwordChanged = true;
            } else {
                $passwordErrors[] = "Erro ao atualizar a password: " . $db->error;
            }
        }
    }

    // display messages
    if (!empty($passwordErrors)) {
        foreach ($passwordErrors as $error) {
            addError($error);
        }
    } else {
        if ($passwordChanged){
            addSuccess("Palavra-passe alterada com sucesso!");

            $_SESSION['password_updated'] = true;
        }
    }
}

?>

<h3>Alterar password</h3>
<form method="post" action="" class="change-password">
    <h4>Password atual</h4>
    <input id="current-password" type="password" name="current-password">

    <h4>Nova password</h4>
    <input id="new-password" type="password" name="new-password">

    <h4>Confirmar password</h4>
    <input id="new-password_confirmation" type="password" name="new-password_confirmation">

    <div class="submit-button-wrapper">
        <input type="submit" value="Alterar">
    </div>
</form>