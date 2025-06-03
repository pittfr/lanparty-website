<header class="primary-header">

    <button class="mobile-nav-toggle" aria-controls="primary-navigation" aria-expanded="false">
        <span class="sr-only">Menu</span>
    </button>

    <div class="logo-container">
        <a href="?page=home">
            <img src="assets/images/lanparty-logo.png" alt="" class="logo">
        </a>
    </div>

    <nav>
        <ul data-visible="false" id="primary-navigation" class="nav-links">
            <li <?php echo isActivePage("home"); ?>>
                <a href="?page=home">Início</a>
            </li>
            <li <?php echo isActivePage("torneios"); ?>>
                <a href="?page=torneios">Torneios</a>
            </li>
            <li <?php echo isActivePage("staff"); ?>>
                <a href="?page=staff">Staff</a>
            </li>
            <?php
                if(empty($_SESSION['user_id'])){
                    echo "<li class='sign-in'>";
                    echo "<a href='?page=login'>Iniciar sessão</a>";
                    echo "</li>";
                }else{
                    $userId = $_SESSION['user_id'];
                    $profilePicture = getUserImage($userId);
                    echo "<li class='profile'>";
                    echo "<a href='?page=profile'><img src='$profilePicture' alt='Profile'></a>";
                    echo "</li>";
                }
            ?>
        </ul>
    </nav>
</header>