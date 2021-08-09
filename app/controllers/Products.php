<?php
class Products extends Controller {
    public function __construct() {
        $this->productModel = $this->model('Product');
    }

    public function create(){
        $data = [
            'code' => '',
            'name' => '',
            'price' => '',
            'description' => '',
            'codeError' => '',
            'nameError' => '',
            'priceError' => '',
            'descriptionError' => '',
            'createSuccess' => ''
        ];

        /*Check if user is logged in*/
        if(!isLoggedIn()){
            $this->view('accessDenied', []);
            return;
        }

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'code' => trim($_POST['code']),
                'name' => trim($_POST['name']),
                'price' => $_POST['price'],
                'description' => trim($_POST['description']),
                'codeError' => '',
                'nameError' => '',
                'priceError' => '',
                'descriptionError' => '',
                'createSuccess' => ''
            ];

            $textValidation = "/^[a-zA-Z0-9]*$/";

            if(empty($data['code'])){
                $data['codeError'] = 'Por favor, digite o código do produto.';
            } else if(!preg_match($textValidation, $data['code'])){
                $data['codeError'] = 'Código pode conter somente letras e números.';
            } else if(  $this
                        ->productModel
                        ->getProductByCode($data['code'])
                        !== false ){
                $data['codeError'] = 'Código de produto já cadastrado';
            }

            if(empty($data['name'])){
                $data['nameError'] = 'Por favor, digite o nome do produto.';
            }

            if(empty($data['price'])){
                $data['priceError'] = 'Por favor, informe o valor do produto.';
            } else if(!is_numeric($data['price'])){
                $data['priceError'] = 'Valor do produto inválido.';
            } else if($data['price'] <= 0){
                $data['priceError'] = 'Valor do produto deve ser maior que zero.';
            }

            if(empty($data['description'])){
                $data['descriptionError'] = 'Por favor, digite a descrição do produto.';
            }

            if( empty($data['codeError'])
                && empty($data['nameError'])
                && empty($data['priceError'])
                && empty($data['descriptionError'])){
                if($this->productModel->create($data)){
                    $data['createSuccess'] = 'Produto cadastrado com sucesso!';
                }
                else{
                    die('Something went wrong.');
                }
            }
        }
        $this->view('products/create', $data);
    }

    public function edit(){

        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["id"])){
            $data = [
                'id' => trim($_POST['id']),
                'code' => '',
                'name' => '',
                'price' => '',
                'description' => '',
                'productNotFoundMessage' => '',
                'codeError' => '',
                'nameError' => '',
                'priceError' => '',
                'descriptionError' => '',
                'updateSuccess' => ''
            ];
            
            if(isset($_POST["code"], $_POST["name"], $_POST["price"], $_POST["description"])){
                /* Edit the product */
                $data["code"] = trim($_POST['code']);
                $data["name"] = trim($_POST['name']);
                $data["price"] = $_POST['price'];
                $data["description"] = trim($_POST['description']);

                $textValidation = "/^[a-zA-Z0-9]*$/";

                if(empty($data['code'])){
                    $data['codeError'] = 'Por favor, digite o código do produto.';
                } else if(!preg_match($textValidation, $data['code'])){
                    $data['codeError'] = 'Código pode conter somente letras e números.';
                }

                $oldProduct = $this->productModel->getProductByCode($data['code']);
                
                /*Check if code is going to not change to this current product*/
                if( $oldProduct !== false ){
                    /*if it's the same product id, no problem in updating to same code; else throws error*/
                    if($oldProduct->id !== $data['id']){
                        $data['codeError'] = 'Código de produto já cadastrado';
                    }
                } 
    
                if(empty($data['name'])){
                    $data['nameError'] = 'Por favor, digite o nome do produto.';
                } else if(!preg_match($textValidation, $data['name'])){
                    $data['nameError'] = 'Nome do produto pode conter somente letras e números.';
                }
    
                if(empty($data['price'])){
                    $data['priceError'] = 'Por favor, informe o valor do produto.';
                } else if(!is_numeric($data['price'])){
                    $data['priceError'] = 'Valor do produto inválido.';
                } else if($data['price'] <= 0){
                    $data['priceError'] = 'Valor do produto deve ser maior que zero.';
                }
    
                if(empty($data['description'])){
                    $data['descriptionError'] = 'Por favor, digite a descrição do produto.';
                }
                
                if( empty($data['codeError'])
                    && empty($data['nameError'])
                    && empty($data['priceError'])
                    && empty($data['descriptionError'])){

                    $product = new stdClass;
                    $product->id = $data["id"];
                    $product->code = $data["code"];
                    $product->name = $data["name"];
                    $product->price = $data["price"];
                    $product->description = $data["description"];

                    $this->productModel->updateProduct($product);
                    $data['updateSuccess'] = 'Produto editado com sucesso!';

                    $this->view('products/index', $data);
                    return ;
                }
            } else {
                /*display current product info*/
                $product = $this->productModel->getProductById($data["id"]);
                if(!$product){
                    $data["productNotFoundMessage"] = "Produto não encontrado!";
                    $this->view('products/index', $data);
                    return ;
                } else {
                    $data["code"] = $product->code;
                    $data["name"] = $product->name;
                    $data["price"] = $product->price;
                    $data["description"] = $product->description;
                }
            }

            $this->view('products/edit', $data);
        }
    }

    public function delete() {
        $data = [
            'id' => '',
            'deleteMessage' => 'Ocorreu um erro ao deletar o produto'
        ];

        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["id"])){
            $data["id"] = $_POST["id"];

            $product = $this->productModel->getProductById($data["id"]);

            if( $product !== false){
                if($this->productModel->deleteProduct($product)){
                    $data["deleteMessage"] = "Produto deletado com sucesso";
                }
            }

        }
        
        $this->index($data);
    }

    public function index($data = false) {
        
        if(!$data){
            $data = [
                'products' => []
            ];    
        } else {
            $data['products'] = [];
        }
        
        $data["products"] = $this->productModel->getProducts();

        $this->view('products/index', $data);
    }
}
?>