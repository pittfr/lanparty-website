<?php
    $profilePicture = getUserImage($user->id, (bool)$user->image);

    $regDate = DateTime::createFromFormat('Y/m/d', $user->data_registo);
    $formatedDate = $regDate ? $regDate->format('d M, Y') : $user->data_registo;
?>

<div class='avatar'>
    <img src='<?php echo $profilePicture ?>' alt='<?php echo $user->username ?>'>
</div>

<div class='data'>
    <h4><?php echo $user->username ?></h4>
    <p>Registou-se a <span><?php echo $formatedDate ?></span></p>
</div>

<ul class='option-list'>
    <li>
        <a href="?page=perfil">Perfil</a>
    </li>
    <li>
        <a href="?page=perfil&action=change-password">Mudar password</a>
    </li>
    <li>
        <a href="?page=perfil&action=logout">Terminar sessão</a>
    </li>
</ul>