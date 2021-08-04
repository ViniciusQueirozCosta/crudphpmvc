<?php
class About extends Controller {
    public function __construct() {
    }

    public function index() {
        $data = [
            'title' => 'Sobre'
        ];

        $this->view('about', $data);
    }

    public function about() {
        $this->view('about');
    }
}
?>