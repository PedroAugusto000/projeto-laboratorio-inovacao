<?php
require_once '../../projetoads.model/receita/GerenciarReceitaModel.php';

class ReceitaController {
    private $model;

    public function __construct() {
        $this->model = new ReceitaModel("localhost", "root", "", "AcervoReceitas");
    }

    public function listarReceitas() {
        $receitas = $this->model->getTodasReceitas();
        if (!$receitas) {
            die("Erro ao buscar receitas.");
        }
        return $receitas;
    }

    public function excluirReceita($id) {
        return $this->model->deletarReceita($id);
    }
}

$controller = new ReceitaController();

// Lógica de exclusão
if (isset($_GET["delete"]) && is_numeric($_GET["delete"])) {
    $id = intval($_GET["delete"]);

    if ($controller->excluirReceita($id)) {
        $_SESSION['mensagem'] = "Receita ID $id excluída com sucesso!";
    } else {
        $_SESSION['mensagem'] = "Erro ao excluir a receita ID $id.";
    }

    header("Location: ../../projetoads.view/receitas/GerenciarReceitaView.php");
    exit;
}

// Receitas para exibição na View
$receitas = $controller->listarReceitas();
