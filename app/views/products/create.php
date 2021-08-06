<?php
   require APPROOT . '/views/includes/head.php';
?>

<div class="top-nav">
    <?php
       require APPROOT . '/views/includes/navigation.php';
    ?>
</div>

<div class="container">
    <div class="wrapper-create-product">
        <h2>Cadastrar Novo Produto</h2>

            <form
                id="create-product-form"
                method="POST"
                action="<?php echo URLROOT; ?>/products/create"
                >
            <input type="text" placeholder="Código do Produto *" name="code">
            <span class="invalidFeedback">
                <?php echo $data['codeError']; ?>
            </span>

            <input type="text" placeholder="Nome do Produto *" name="name">
            <span class="invalidFeedback">
                <?php echo $data['nameError']; ?>
            </span>

            <input type="number" placeholder="Preço *" name="price" step=".01">
            <span class="invalidFeedback">
                <?php echo $data['priceError']; ?>
            </span>

            <input type="text" placeholder="Descrição do produto *" name="description">
            <span class="invalidFeedback">
                <?php echo $data['descriptionError']; ?>
            </span>

            <button id="submit" type="submit" value="submit">Cadastrar</button>
        </form>
    </div>
</div>
