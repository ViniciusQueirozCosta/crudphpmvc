<?php
   require APPROOT . '/views/includes/head.php';
?>

<div class="top-nav">
    <?php
       require APPROOT . '/views/includes/navigation.php';
    ?>
</div>

<div class="container">
    <div class="wrapper-products">
        <?php
            if(!empty($data['productNotFoundMessage'])){
                ?>
                    <div class="successMessage">
                        <h4> <?= $data['productNotFoundMessage']?></h4>
                    </div>
                <?php
            }
        ?>
        <?php
            if(!empty($data['updateSuccess'])){
                ?>
                    <div class="successMessage">
                        <h4> <?= $data['updateSuccess']?></h4>
                    </div>
                <?php
            }
        ?>
        <?php
            if(!empty($data["deleteMessage"])){
                ?>
                    <div class="successMessage">
                        <h4> <?= $data["deleteMessage"]?></h4>
                    </div>
                <?php
            }
        ?>
        <div class="wrapper-buttons">
            <form action="products/create" method="get">
                <button> Criar novo produto</button>
            </form>
        </div>
        <h2>Produtos Cadastrados:</h2>
        <div class="products-table-wrapper">
            <table id="tableProducts" class="table stripe table-responsive">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Código</th>
                        <th>Nome</th>
                        <th>Preço</th>
                        <th>Descrição</th>
                        <th>Editar</th>
                        <th>Excluir</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        foreach($data['products'] as $product){
                            ?>
                                <tr>
                                    <td><?= $product->id?></td>
                                    <td><?= $product->code?></td>
                                    <td><?= $product->name?></td>
                                    <td><?= $product->price?></td>
                                    <td><?= $product->description?></td>
                                    <td><button class="btn btn-warning" onClick="btnEditarHandler(<?= $product->id?>)">Editar</button></td>
                                    <td><button class="btn btn-danger" onClick="btnExcluirHandler(<?= $product->id?>)">Excluir</button></td>
                                </tr>
                            <?php
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function btnEditarHandler(id){
        $('<form action="products/edit" method="POST"> <input type="text" name="id" value="'+id+'"> </form>').appendTo('body').submit();
    }

    function btnExcluirHandler(id){
        if(confirm("Deseja realmente excluir o produto?")){
            $('<form action="products/delete" method="POST"> <input type="text" name="id" value="'+id+'"> </form>').appendTo('body').submit();
        }
    }

    $(document).ready( function () {
        $('#tableProducts').DataTable();
    } );
</script>