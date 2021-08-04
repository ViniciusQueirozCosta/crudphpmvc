<?php
class User {
    private $db;
    public function __construct() {
        /*Desabilitado pois a conexão no DB não precisa ser feito ao carregar literalmente todas páginas, adicionar no começo dos métodos necessários*/
        //$this->db = new Database;
    }

    public function register($data) {
        $this->db = new Database;
        $this->db->query(
            'INSERT INTO '.APPNAME.'.users
            (
                username,
                password,
                email,
                fullname
            ) 
            VALUES
            (   
                :username,
                :password,
                :email,
                :fullname
            )'
        );

        //Bind values
        $this->db->bind(':username', $data['username']);
        $this->db->bind(':password', $data['password']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':fullname', $data['fullname']);

        //Execute function
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function login($username, $password) {
        $this->db = new Database;
        $this->db->query('SELECT * FROM '.APPNAME.'.users WHERE username = :username');

        //Bind value
        $this->db->bind(':username', $username);

        $row = $this->db->single();

        $hashedPassword = $row->password;

        if (password_verify($password, $hashedPassword)) {
            return $row;
        } else {
            return false;
        }
    }

    //Find user by email. Email is passed in by the Controller.
    public function findUserByEmail($email) {
        $this->db = new Database;

        $this->db->query('SELECT * FROM '.APPNAME.'.users WHERE email = :email');
        $this->db->bind(':email', $email);
        $this->db->execute();

        //Check if email is already registered
        if($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function findUserByUserName($username) {
        $this->db = new Database;

        $this->db->query('SELECT * FROM '.APPNAME.'.users WHERE username = :username');
        $this->db->bind(':username', $username);
        $this->db->execute();

        if($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }
}
