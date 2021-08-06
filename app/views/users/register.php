<?php
   require APPROOT . '/views/includes/head.php';
?>

<div class="top-nav">
    <?php
       require APPROOT . '/views/includes/navigation.php';
    ?>
</div>

<div class="container">
    <div class="wrapper-login">
        <h2>Registrar</h2>

            <form
                id="register-form"
                method="POST"
                action="<?php echo URLROOT; ?>/users/register"
                >
            <input type="text" placeholder="Nome de Usuário *" name="username">
            <span class="invalidFeedback">
                <?php echo $data['usernameError']; ?>
            </span>

            <input type="text" placeholder="Nome Completo *" name="fullname">
            <span class="invalidFeedback">
                <?php echo $data['fullnameError']; ?>
            </span>

            <input type="email" placeholder="E-mail *" name="email">
            <span class="invalidFeedback">
                <?php echo $data['emailError']; ?>
            </span>

            <input type="password" placeholder="Senha *" name="password">
            <span class="invalidFeedback">
                <?php echo $data['passwordError']; ?>
            </span>

            <input type="password" placeholder="Confirmar Senha *" name="confirmPassword">
            <span class="invalidFeedback">
                <?php echo $data['confirmPasswordError']; ?>
            </span>

            <button id="submit" type="submit" value="submit">Cadastrar</button>

            <p class="options">Já possui uma conta? <a href="<?php echo URLROOT; ?>/users/login">Fazer login.</a></p>
        </form>
    </div>
</div>
