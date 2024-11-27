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
    // Validar que todos os campos obrigatórios estão preenchidos
    if (
        empty($_POST["nome"]) || empty($_POST["categoria"]) || empty($_POST["ingredientes"]) || 
        empty($_POST["modo_preparo"]) || empty($_POST["descricao"]) || 
        empty($_POST["numero_porcoes"]) || empty($_POST["nome_cozinheiro"]) || 
        empty($_POST["nome_degustador"]) || !isset($_FILES["imagem_receita"])
    ) {
        echo "Erro: Todos os campos são obrigatórios!";
        exit;
    }

    // Validar que o número de porções é numérico
    if (!is_numeric($_POST["numero_porcoes"])) {
        echo "Erro: O campo Número de Porções deve conter apenas números!";
        exit;
    }

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

    $imagemBlob = file_get_contents($_FILES["imagem_receita"]["tmp_name"]);

    if ($controller->cadastrarReceita($dados, $imagemBlob)) {
        header("Location: ../../projetoads.view/receitas/GerenciarReceitaView.php?status=sucesso");
        exit;
    } else {
        echo "Erro ao cadastrar receita!";
    }
}


// Categorias para a View
$categorias = $controller->getCategorias();
