<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $currentPassword = $_POST['current-password'] ?? '';
    $newPassword = $_POST['new-password'] ?? '';
    $confirmPassword = $_POST['new-password_confirmation'] ?? '';
    $passwordErrors = [];

    $userId = $_SESSION['user_id'];
    $q = "SELECT password_hash FROM utilizadores WHERE id = ?";
    $stmt = $db->prepare($q);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->bind_result($passwordHash);
    $stmt->fetch();
    $stmt->close();

    if (!testHash($currentPassword, $passwordHash)) {
        $passwordErrors[] = "A password atual está incorreta.";
    } else if (strlen($newPassword) < 6) {
        $passwordErrors[] = "A nova password deve ter pelo menos 6 caracteres.";
    } else if ($newPassword !== $confirmPassword) {
        $passwordErrors[] = "A confirmação da password não coincide.";
    }

    if (!empty($passwordErrors)) {
        foreach ($passwordErrors as $error) {
            addError($error);
        }
        header("Location: ?page=perfil&action=change-password");
        exit();
    } else {
        $newHash = createHash($newPassword);
        $update = $db->prepare("UPDATE utilizadores SET password_hash = ? WHERE id = ?");
        $update->bind_param("si", $newHash, $userId);
        if ($update->execute()) {
            addSuccess("Palavra-passe alterada com sucesso!");
            header("Location: ?page=perfil&action=change-password");
            exit();
        } else {
            addError("Erro ao atualizar a password: " . $db->error);
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