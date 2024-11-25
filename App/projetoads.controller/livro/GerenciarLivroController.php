<?php
require_once 'LivroModel.php';

class LivroController {
    private $model;

    public function __construct() {
        $this->model = new LivroModel("localhost", "root", "", "AcervoReceitas");
    }

    public function listarLivros($termoBusca = '') {
        return $this->model->buscarLivros($termoBusca);
    }

    public function excluirLivro($id) {
        if ($id) {
            $this->model->deletarLivro($id);
            header("Location: gerir_livros.php");
            exit;
        }
    }
}

// Instância do controller
$controller = new LivroController();

// Processa a exclusão
if (isset($_GET["delete"])) {
    $controller->excluirLivro($_GET["delete"]);
}

// Busca os livros
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
$livros = $controller->listarLivros($searchTerm);
