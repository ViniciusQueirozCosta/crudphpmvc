<?php
class Users extends Controller {
    public function __construct(){
        $this->userModel = $this->model('User');
    }

    public function register(){
        $data = [
            'username' => '',
            'password' => '',
            'email' => '',
            'fullname' => '',
            'confirmPassword' => '',
            'usernameError' => '',
            'emailError' => '',
            'passwordError' => '',
            'confirmPasswordError' => '',
            'fullnameError' => '',
            'createSuccess' => ''
        ];

      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // Sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

              $data = [
                'username' => trim($_POST['username']),
                'password' => trim($_POST['password']),
                'email' => trim($_POST['email']),
                'fullname' => trim($_POST['fullname']),
                'confirmPassword' => trim($_POST['confirmPassword']),
                'usernameError' => '',
                'emailError' => '',
                'passwordError' => '',
                'confirmPasswordError' => '',
                'fullnameError' => '',
                'createSuccess' => ''
            ];

            $nameValidation = "/^[a-zA-Z0-9]*$/";
            $passwordValidation = "/^(.{0,7}|[^a-z]*|[^\d]*)$/i";

            if(empty($data['username'])){
                $data['usernameError'] = 'Por favor, digite o usuário.';
            } else if(!preg_match($nameValidation, $data['username'])){
                $data['usernameError'] = 'Nome pode conter somente letras e números.';
            } else if( $this->userModel->findUserByUserName($data['username']) ){
                $data['usernameError'] = 'Nome de usuário já cadastrado';
            }

            if(empty($data['email'])){
                $data['emailError'] = 'Por favor, preencha o e-mail.';
            } elseif(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
                $data['emailError'] = 'Por favor, insira um e-mail válido.';
            } else {
                //Check if email exists.
                if($this->userModel->findUserByEmail($data['email'])){
                $data['emailError'] = 'E-mail já cadastrado.';
                }
            }

            if(empty($data['password'])){
              $data['passwordError'] = 'Por favor, preencha a senha.';
            } elseif(strlen($data['password']) < 7){
              $data['passwordError'] = 'A senha deve ter ao mínimo 8 caracteres';
            } elseif(preg_match($passwordValidation, $data['password'])){
              $data['passwordError'] = 'A senha deve conter ao mínimo um número.';
            }

            if(empty($data['confirmPassword'])){
                $data['confirmPasswordError'] = 'Por favor, confirme a senha.';
            } else {
                if($data['password'] != $data['confirmPassword']){
                $data['confirmPasswordError'] = 'As senhas digitadas são diferentes, favor digitar a mesma senha nos campos.';
                }
            }

            if(empty($data['fullname'])){
                $data['fullnameError'] = 'Por favor, preencher o nome completo.';
            }

            if( empty($data['usernameError'])
                && empty($data['emailError'])
                && empty($data['passwordError'])
                && empty($data['confirmPasswordError'])
                && empty($data['fullnameError'])){

                // Hash password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                //Register user from model function
                if($this->userModel->register($data)){
                    $data['createSuccess'] = 'Usuário cadastrado com sucesso!';
                    //Redirect to the login page
                    header('location: ' . URLROOT . '/users/login?createSuccess='.$data['createSuccess']);
                } else {
                    die('Something went wrong.');
                }
            }
        }
        $this->view('users/register', $data);
    }

    public function login(){
        $data = [
            'title' => 'Login page',
            'username' => '',
            'password' => '',
            'usernameError' => '',
            'passwordError' => ''
        ];

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            //Sanitize post data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'username' => trim($_POST['username']),
                'password' => trim($_POST['password']),
                'usernameError' => '',
                'passwordError' => '',
            ];

            if(empty($data['username'])){
                $data['usernameError'] = 'Por favor, digite o usuário.';
            }


            if(empty($data['password'])){
                $data['passwordError'] = 'Por favor, digite a senha.';
            }


            if(empty($data['usernameError']) && empty($data['passwordError'])){

                $loggedInUser = $this->userModel->login($data['username'], $data['password']);

                if($loggedInUser){
                    $this->createUserSession($loggedInUser);
                } else {
                    $data['passwordError'] = 'Usuário ou senha incorretos. Tente novamente';

                    $this->view('users/login', $data);
                }
            }

        } else {
            $data = [
                'username' => '',
                'password' => '',
                'fullname' => '',
                'usernameError' => '',
                'passwordError' => ''
            ];
        }
        $this->view('users/login', $data);
    }

    public function createUserSession($user){
        $_SESSION['user_id'] = $user->id;
        $_SESSION['fullname'] = $user->fullname;
        $_SESSION['username'] = $user->username;
        $_SESSION['email'] = $user->email;
        header('location:' . URLROOT . '/pages/index');
    }

    public function logout(){
        unset($_SESSION['user_id']);
        unset($_SESSION['username']);
        unset($_SESSION['fullname']);
        unset($_SESSION['email']);
        header('location:' . URLROOT . '/users/login');
    }
}
