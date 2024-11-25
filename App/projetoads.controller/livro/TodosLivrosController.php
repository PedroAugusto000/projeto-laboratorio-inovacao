<?php
require_once 'LivroModel.php';

class LivroController {
    private $model;

    public function __construct() {
        $this->model = new LivroModel("localhost", "root", "", "AcervoReceitas");
    }

    public function listarLivros() {
        return $this->model->getTodosLivros();
    }
}

// Instância do controller
$controller = new LivroController();

// Busca os livros para exibir na View
$livros = $controller->listarLivros();
