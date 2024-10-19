<div id="notification-area">
    <?= displayAlert(); ?>
</div>

<div class="loading">
    <div></div>
</div>

<div id="overlay"></div>

<header>
    <img src="/assets/img/logo.png" alt="Logo del sito ECOM" class="header__logo">

    <?php if (isLogged()): ?>
        <i class="fas fa-bars header__btn" id="menuButton"></i>

        <nav class="header__navbar" id="menu">
            <a href="/shop">Shop</a>
            <a href="/user">Profilo</a>
            <a href="/orders">Ordini</a>
            <a href="/cart">Carrello</a>

            <?php if (isSeller()): ?>
                <a href="/books">Vendite</a>
            <?php endif; ?>

            <a href="/api/logout.php">Esci</a>
        </nav>
    <?php endif; ?>
</header>

<!-- 

QUI FINISCE header.php

-->