<?php
class Posts extends Controller {
    public function __construct() {
    }

    public function index() {
        $data = [
            'title' => 'Blog'
        ];

        $this->view('posts/index', $data);
    }

    public function posts() {
        $this->view('posts/index.php');
    }
}
?>