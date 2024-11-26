<?php
require_once '../../projetoads.model/livro/TodosLivrosModel.php';

class LivroController {
    private $model;

    public function __construct() {
        $this->model = new LivroModel("localhost", "root", "", "AcervoReceitas");
    }

    public function listarLivros() {
        $livros = $this->model->getTodosLivros();
        if (!$livros) {
            die("Erro ao buscar livros: " . $this->model->getConnectionError());
        }
        return $livros;
    }
}

// Instância do controller
$controller = new LivroController();

// Busca os livros para exibir na View
$livros = $controller->listarLivros();
