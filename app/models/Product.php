<?php
class Product {
    private $db;
    public function __construct() {
        /*Desabilitado pois a conexão no DB não precisa ser feito ao carregar literalmente todas páginas, adicionar no começo dos métodos necessários*/
        //$this->db = new Database;
    }

    public function create($product) {
        $this->db = new Database;
        $this->db->query(
            'INSERT INTO '.APPNAME.'.products
            (
                code,
                name,
                price,
                description
            ) 
            VALUES
            (   
                :code,
                :name,
                :price,
                :description
            )'
        );

        //Bind values
        $this->db->bind(':code', $product['code']);
        $this->db->bind(':name', $product['name']);
        $this->db->bind(':price', $product['price']);
        $this->db->bind(':description', $product['description']);

        //Execute function
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getProducts() {
        $this->db = new Database;

        $this->db->query('SELECT * FROM '.APPNAME.'.products');
        $this->db->execute();

        if($this->db->rowCount() > 0) {
            return $this->db->resultSet();
        } else {
            return false;
        }
    }

    public function getProductByCode($code) {
        $this->db = new Database;

        $this->db->query('SELECT * FROM '.APPNAME.'.products WHERE code = :code');
        $this->db->bind(':code', $code);
        $this->db->execute();

        if($this->db->rowCount() > 0) {
            return $this->db->single();
        } else {
            return false;
        }
    }

    public function getProductById($id) {
        $this->db = new Database;

        $this->db->query('SELECT * FROM '.APPNAME.'.products WHERE id = :id');
        $this->db->bind(':id', $id);
        $this->db->execute();

        if($this->db->rowCount() > 0) {
            return $this->db->single();
        } else {
            return false;
        }
    }

    public function updateProduct($product) {
        $this->db = new Database;

        $this->db->query(
            'UPDATE '.APPNAME.'.products
            SET code = :code,
                name = :name,
                price = :price,
                description = :description
            WHERE id = :id'
        );

        //Bind values
        $this->db->bind(':code', $product->code);
        $this->db->bind(':name', $product->name);
        $this->db->bind(':price', $product->price);
        $this->db->bind(':description', $product->description);
        $this->db->bind(':id', $product->id);

        $this->db->execute();

        //Execute function
        if ($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteProduct($product) {
        $this->db = new Database;
        $id = intval($product->id);

        $this->db->query('DELETE FROM '.APPNAME.'.products WHERE id = :id');
        $this->db->bind(':id', $id);
        $this->db->execute();

        if($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }
}
