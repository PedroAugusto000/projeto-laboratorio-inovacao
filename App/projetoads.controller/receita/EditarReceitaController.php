<?php
require_once 'ReceitaModel.php';

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

// Instância do controller
$controller = new ReceitaController();

// Processa a lógica
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_GET['id'];
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

    if ($controller->atualizarReceita($id, $dados, $imagemBlob)) {
        echo "Receita atualizada com sucesso!";
    } else {
        echo "Erro ao atualizar receita!";
    }
}

// Dados para exibição na View
$id = $_GET['id'] ?? null;
$receita = $controller->getReceita($id);
$categorias = $controller->getCategorias();
