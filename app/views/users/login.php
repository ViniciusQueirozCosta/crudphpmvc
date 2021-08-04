<?php
   require APPROOT . '/views/includes/head.php';
?>

<div class="navbar">
    <?php
       require APPROOT . '/views/includes/navigation.php';
    ?>
</div>

<div class="container-login">
    <?php
        if(!empty($_GET['createSuccess'])){
            ?>
                <div class="successMessage">
                    <h4> <?= $_GET['createSuccess']?></h4>
                </div>
            <?php
        }
    ?>
    <div class="wrapper-login">
        <h2>Entrar</h2>

        <form action="<?php echo URLROOT; ?>/users/login" method ="POST">
            <input type="text" placeholder="Nome de Usuário *" name="username">
            <span class="invalidFeedback">
                <?= $data['usernameError'] ?>
            </span>

            <input type="password" placeholder="Senha *" name="password">
            <span class="invalidFeedback">
                <?= $data['passwordError'] ?>
            </span>

            <button id="submit" type="submit" value="submit">Entrar</button>

            <p class="options">Não criou uma conta ainda? <a href="<?= URLROOT ?>/users/register">Criar conta.</a></p>
        </form>
    </div>
</div>
