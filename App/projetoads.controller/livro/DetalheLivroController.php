<?php
require_once 'LivroModel.php';

class LivroController {
    private $model;

    public function __construct() {
        $this->model = new LivroModel("localhost", "root", "", "AcervoReceitas");
    }

    public function getLivroDetalhes($id) {
        if (!is_numeric($id)) {
            die("ID do livro inválido.");
        }
        $livro = $this->model->getLivroById($id);
        if (!$livro) {
            die("Livro não encontrado.");
        }
        return $livro;
    }

    public function getReceitasLivro($id) {
        return $this->model->getReceitasByLivroId($id);
    }
}

// Instância do controller
$controller = new LivroController();

// Recupera os dados para a View
if (isset($_GET['id'])) {
    $idLivro = intval($_GET['id']);
    $livro = $controller->getLivroDetalhes($idLivro);
    $receitas = $controller->getReceitasLivro($idLivro);
} else {
    die("ID do livro não fornecido.");
}
