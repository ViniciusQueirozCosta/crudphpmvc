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
        if(!isset($_SESSION["user_id"])){
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
            
            var_dump($this->productModel);

            if( empty($data['codeError'])
                && empty($data['nameError'])
                && empty($data['priceError'])
                && empty($data['descriptionError'])){
                if($this->productModel->create($data)){
                    $data['createSuccess'] = 'Produto cadastrado com sucesso!';
                    header('location: ' . URLROOT . '/products/create?createSuccess='.$data['createSuccess']);
                    die();
                }
                else{
                    die('Something went wrong.');
                }
            }
        }
        $this->view('products/create', $data);
    }

    public function index() {
        $this->view('products/index');
    }
}
?>