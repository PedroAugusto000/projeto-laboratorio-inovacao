<?php
require_once 'ReceitaModel.php';

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
        "opiniao_degustador" => $_POST["opiniao_degustador"],
        "ingredientes" => $_POST["ingredientes"],
        "modo_preparo" => $_POST["modo_preparo"],
        "descricao" => $_POST["descricao"],
        "numero_porcoes" => $_POST["numero_porcoes"],
        "nome_cozinheiro" => $_POST["nome_cozinheiro"],
        "nome_degustador" => $_POST["nome_degustador"]
    ];

    $imagemBlob = isset($_FILES["imagem_receita"]["tmp_name"]) && $_FILES["imagem_receita"]["error"] == 0
        ? file_get_contents($_FILES["imagem_receita"]["tmp_name"])
        : null;

    if ($controller->cadastrarReceita($dados, $imagemBlob)) {
        echo "Receita cadastrada com sucesso!";
    } else {
        echo "Erro ao cadastrar receita!";
    }
}

// Categorias para a View
$categorias = $controller->getCategorias();
