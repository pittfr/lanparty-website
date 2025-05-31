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
            <li class="sign-in">
                <a href="#">Sign In</a>
            </li>
        </ul>
    </nav>
</header>