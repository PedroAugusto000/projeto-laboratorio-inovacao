<?php
require_once '../../projetoads.model/receita/DetalheReceitaModel.php';

class ReceitaController {
    private $model;

    public function __construct() {
        $this->model = new ReceitaModel("localhost", "root", "", "AcervoReceitas");
    }

    public function getDetalhesReceita($id) {
        if (!is_numeric($id)) {
            die("ID de receita inválido.");
        }
        $receita = $this->model->getReceitaById($id);
        if (!$receita) {
            die("Receita não encontrada.");
        }
        return $receita;
    }
}

// Instância do controller
$controller = new ReceitaController();

// Recupera os dados da receita para exibir na View
if (isset($_GET['id'])) {
    $idReceita = intval($_GET['id']);
    $receita = $controller->getDetalhesReceita($idReceita);
} else {
    die("ID de receita não fornecido.");
}
