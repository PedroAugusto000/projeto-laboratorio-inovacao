<?php
require_once '../../projetoads.model/livro/GerenciarLivroModel.php';

class LivroController {
    private $model;

    public function __construct() {
        $this->model = new LivroModel("localhost", "root", "", "AcervoReceitas");
    }

    public function listarLivros($termoBusca = '') {
        return $this->model->buscarLivros($termoBusca);
    }

    public function excluirLivro($id) {
        if (is_numeric($id)) {
            $this->model->deletarLivro($id);
            header("Location: ../../projetoads.view/livro/GerenciarLivroView.php");
            exit;
        } else {
            die("ID inválido.");
        }
    }
}

// Instância do controller
$controller = new LivroController();

// Processa a exclusão
if (isset($_GET["delete"]) && is_numeric($_GET["delete"])) {
    $controller->excluirLivro($_GET["delete"]);
}

// Busca os livros
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
$livros = $controller->listarLivros($searchTerm);