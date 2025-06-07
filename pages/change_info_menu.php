<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newName = trim($_POST['nome']);
    $nameChanged = false;
    $imageChanged = false;
    $errors = [];
    
    if ($newName !== $user->username) {
        if (strlen($newName) < 3) {
            $errors[] = "O nome deve ter pelo menos 3 caracteres.";
        }else{
            $updateName = $db->prepare("UPDATE utilizadores SET username = ? WHERE id = ?");
            $updateName->bind_param("si", $newName, $user->id);
            
            if ($updateName->execute()) {
                $nameChanged = true;
                $user->username = $newName;
            } else {
                $errors[] = "Erro ao atualizar o nome: " . $db->error;
            }
        }
    }
    
    if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $maxSize = 10 * 1024 * 1024; // 10MB
        
        if (!in_array($_FILES['image']['type'], $allowedTypes)) {
            $errors[] = "Apenas imagens são permitidas (JPEG, PNG, GIF, WEBP).";
        } elseif ($_FILES['image']['size'] > $maxSize) {
            $errors[] = "A imagem não pode ter mais de 10MB.";
        } else {
            $uploadDir = 'assets/images/users/';
            
            $imagePath = $_FILES['image']['tmp_name'];
            $destPath = $uploadDir . $user->id . '.webp';
            
            $imageInfo = getimagesize($imagePath);
            $sourceWidth = $imageInfo[0];
            $sourceHeight = $imageInfo[1];

            switch ($imageInfo['mime']) {
                case 'image/jpeg':
                    $sourceImage = imagecreatefromjpeg($imagePath);
                    break;
                case 'image/png':
                    $sourceImage = imagecreatefrompng($imagePath);
                    break;
                case 'image/gif':
                    $sourceImage = imagecreatefromgif($imagePath);
                    break;
                case 'image/webp':
                    $sourceImage = imagecreatefromwebp($imagePath);
                    break;
            }
            
            $targetImage = imagecreatetruecolor(256, 256);
            
            imagealphablending($targetImage, false);
            imagesavealpha($targetImage, true);
            $transparent = imagecolorallocatealpha($targetImage, 0, 0, 0, 127);
            imagefilledrectangle($targetImage, 0, 0, 256, 256, $transparent);
            
            if ($sourceWidth > $sourceHeight) {
                $squareSize = $sourceHeight;
                $offsetX = ($sourceWidth - $squareSize) / 2;
                $offsetY = 0;
            } else {
                $squareSize = $sourceWidth;
                $offsetX = 0;
                $offsetY = ($sourceHeight - $squareSize) / 2;
            }
            
            imagecopyresampled(
                $targetImage, $sourceImage,
                0, 0, $offsetX, $offsetY,
                256, 256, $squareSize, $squareSize
            );
            
            // save as WebP
            if (imagewebp($targetImage, $destPath, 90)) {
                $updateImage = $db->prepare("UPDATE utilizadores SET image = 1 WHERE id = ?");
                $updateImage->bind_param("i", $user->id);
                
                if ($updateImage->execute()) {
                    $imageChanged = true;
                } else {
                    $errors[] = "Erro ao atualizar a informação da imagem: " . $db->error;
                }
            } else {
                $errors[] = "Erro ao salvar a imagem.";
            }
            
            // free up memory
            imagedestroy($sourceImage);
            imagedestroy($targetImage);
        }
    }
    
    // display messages
    if (!empty($errors)) {
        foreach ($errors as $error) {
            addError($error);
        }
    } else {
        if ($nameChanged || $imageChanged) {
            addSuccess("Alterações guardadas com sucesso!");
            
            $_SESSION['profile_updated'] = true;
            
            header("Location: ?page=perfil");
            exit();
        }
    }
}
?>

<h3>As minhas informações</h3>
<div class="info">
    <div class="info-row">
        <span>Nome:</span>
        <p><?php echo $user->username ?></p>
    </div>
    <div class="info-row">
        <span>Email:</span>
        <p><?php echo $user->email ?></p>
    </div>
</div>
<h3>Alterar</h3>
<form method="post" action="" class="change-info" enctype="multipart/form-data">
    <div>
        <h5>Nome</h5>   
        <input type="text" name="nome" value="<?php echo $user->username ?>">
    </div>
    <div>
        <h5>Imagem</h5>
        <div class="image-input-wrapper">
            <input id="image" type="file" name="image" accept="image/*">
            <label id="image-label" for="image">Foto de perfil</label>
            <div class="input-append">
                <label for="image"><small>Escolher Imagem</small></label>
            </div>
        </div>
    </div>
    <div id="image-preview" <?php if($user->image) echo 'class="active"'; ?>>
        <img src="<?php echo getUserImage($user->id, (bool)$user->image) . '?v=' . time(); ?>" alt="Image preview">
        <button type="button" id="remove-image">×</button>
    </div>
    <div class="submit-button-wrapper">
        <input type="submit" value="Guardar Alterações">
    </div>
</form>