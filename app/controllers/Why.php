<?php
class Why extends Controller {
    public function __construct() {
    }

    public function index() {
        $data = [
            'title' => 'Blog'
        ];

        $this->why('posts', $data);
    }

    public function why() {
        $this->view('why');
    }
}
?>