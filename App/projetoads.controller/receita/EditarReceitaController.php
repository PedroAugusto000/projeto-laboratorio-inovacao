<?php
require_once '../../projetoads.model/receita/EditarReceitaModel.php';

class ReceitaController {
    private $model;

    public function __construct() {
        $this->model = new ReceitaModel("localhost", "root", "", "AcervoReceitas");
    }

    public function getReceita($id) {
        return $this->model->getReceitaById($id);
    }

    public function getCategorias() {
        return $this->model->getCategorias();
    }

    public function atualizarReceita($id, $dados, $imagemBlob) {
        return $this->model->atualizarReceita($id, $dados, $imagemBlob);
    }
}

session_start();
$controller = new ReceitaController();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_GET['id'] ?? null;

    if (!$id) {
        die("ID da receita não fornecido.");
    }

    $dados = [
        "nome" => $_POST["nome"],
        "categoria" => $_POST["categoria"],
        "opiniao_degustador" => $_POST["opiniao_degustador"] ?? null,
        "ingredientes" => $_POST["ingredientes"] ?? null,
        "modo_preparo" => $_POST["modo_preparo"] ?? null,
        "descricao" => $_POST["descricao"] ?? null,
        "numero_porcoes" => $_POST["numero_porcoes"] ?? null,
        "nome_cozinheiro" => $_POST["nome_cozinheiro"] ?? null,
        "nome_degustador" => $_POST["nome_degustador"] ?? null
    ];

    $imagemBlob = isset($_FILES["imagem_receita"]["tmp_name"]) && $_FILES["imagem_receita"]["error"] == 0
        ? file_get_contents($_FILES["imagem_receita"]["tmp_name"])
        : null;

    if (!is_numeric($_POST["numero_porcoes"])) {
        echo "Erro: O campo Número de Porções deve conter apenas números!";
        exit;
    }

    if ($controller->atualizarReceita($id, $dados, $imagemBlob)) {
        $_SESSION['mensagem'] = "Receita atualizada com sucesso!";
    } else {
        $_SESSION['mensagem'] = "Erro ao atualizar receita.";
    }

    header("Location: ../../projetoads.view/receitas/GerenciarReceitaView.php");
    exit;
}

$id = $_GET['id'] ?? null;
$receita = $controller->getReceita($id);
$categorias = $controller->getCategorias();
?>
