<?php
   require APPROOT . '/views/includes/head.php';
?>

<div class="top-nav">
    <?php
       require APPROOT . '/views/includes/navigation.php';
    ?>
</div>

<div class="container">
    <?php
        if(!empty($_GET['editSuccess'])){
            ?>
                <div class="successMessage">
                    <h4> <?= $_GET['editSuccess']?></h4>
                </div>
            <?php
        }
    ?>
    <div class="wrapper-create-product">
        <div class="wrapper-buttons">
            <form action="../products/index" method="get">
                <button> Voltar</button>
            </form>
        </div>
        <h2>Editar o produto</h2>
        <h4>(Produto id: <?= $data['id']?>)</h4>
            <form
                id="create-product-form"
                method="POST"
                action="../products/index"
                >
            <input  type="hidden"
                name="id"
                value="<?= $data['id']?>">

            <input  type="text"
                    placeholder="Código do Produto *"
                    name="code"
                    value="<?= $data['code']?>">
            <span class="invalidFeedback">
                <?=$data['codeError']?>
            </span>

            <input  type="text"
                    placeholder="Nome do Produto *"
                    name="name"
                    value="<?= $data['name']?>">
            <span class="invalidFeedback">
                <?=$data['nameError']?>
            </span>

            <input  type="number"
                    placeholder="Preço *"
                    name="price"
                    step=".01"
                    value="<?=$data['price']?>">
            <span class="invalidFeedback">
                <?=$data['priceError']?>
            </span>

            <input  type="text"
                    placeholder="Descrição do produto *"
                    name="description"
                    value="<?=$data['description']?>">
            <span class="invalidFeedback">
                <?=$data['descriptionError']?>
            </span>

            <button id="submit" type="submit" value="submit">Confirmar</button>
        </form>
    </div>
</div>
