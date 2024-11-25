<?php
require_once 'ReceitaModel.php';

class ReceitaController {
    private $model;

    public function __construct() {
        $this->model = new ReceitaModel("localhost", "root", "", "AcervoReceitas");
    }

    public function listarReceitas() {
        return $this->model->getTodasReceitas();
    }

    public function excluirReceita($id) {
        return $this->model->deletarReceita($id);
    }
}

// Instância do controller
$controller = new ReceitaController();

// Lógica de exclusão
if (isset($_GET["delete"])) {
    $id = $_GET["delete"];
    if ($controller->excluirReceita($id)) {
        header("Location: gerenciar_receitas.php");
        exit();
    } else {
        echo "Erro ao deletar receita.";
    }
}

// Receitas para exibição na View
$receitas = $controller->listarReceitas();
