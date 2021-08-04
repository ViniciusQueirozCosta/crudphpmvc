<nav class="top-nav">
    <ul>
        <li>
            <a href="<?php echo URLROOT; ?>/index">Início</a>
        </li>
        <li>
            <a href="<?php echo URLROOT; ?>/why">Objetivo</a>
        </li>
        <li>
            <a href="<?php echo URLROOT; ?>/posts">Blog</a>
        </li>
        <li>
            <a href="<?php echo URLROOT; ?>/about">Sobre mim</a>
        </li>
        <li class="btn-login">
            <?php if(isset($_SESSION['user_id'])) : ?>
                <a href="<?php echo URLROOT; ?>/users/logout">Sair</a>
            <?php else : ?>
                <a href="<?php echo URLROOT; ?>/users/login">Entrar</a>
            <?php endif; ?>
        </li>
    </ul>
</nav>
