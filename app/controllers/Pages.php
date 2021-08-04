<?php
class Pages extends Controller {
    public function __construct() {
    }

    public function index() {
        $data = [
            'title' => 'Home page'
        ];

        $this->landing('index', $data);
    }

    public function landing() {
        $this->view('index');
    }
}
?>