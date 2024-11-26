<?php
require_once '../../projetoads.model/receita/RegistroReceitaModel.php';

class ReceitaController {
    private $model;

    public function __construct() {
        $this->model = new ReceitaModel("localhost", "root", "", "AcervoReceitas");
    }

    public function getCategorias() {
        return $this->model->getCategorias();
    }

    public function cadastrarReceita($dados, $imagemBlob) {
        return $this->model->cadastrarReceita($dados, $imagemBlob);
    }
}

// Instância do controller
$controller = new ReceitaController();

// Lógica de cadastro
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    if ($controller->cadastrarReceita($dados, $imagemBlob)) {
        header("Location: ../../projetoads.view/receitas/GerenciarReceitaView.php?status=sucesso");
        exit;
    } else {
        echo "Erro ao cadastrar receita!";
    }
}

// Categorias para a View
$categorias = $controller->getCategorias();
