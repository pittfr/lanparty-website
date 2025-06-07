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
<form method="post" action="" class="change-info">
    <div>
        <h5>Nome</h5>   
        <input type="text" name="nome" value="<?php echo $user->username ?>">
    </div>
    <div>
        <h5>Imagem</h5>
        <div class="image-input-wrapper">
            <input id="image" type="file" name="image" accept="image/*" value="null">
            <label id="image-label" for="image">Foto de perfil</label>
            <div class="input-append">
                <label for="image"><small>Escolher Imagem</small></label>
            </div>
        </div>
    </div>
    <div id="image-preview">
        <img src="" alt="Image preview">
        <button type="button" id="remove-image">×</button>
    </div>
    <div class="submit-button-wrapper">
        <input type="submit" value="Guardar Alterações">
    </div>
</form>