<?php
require '../../projetoads.model/colaborador/EditarColaboradorModel.php';

class ColaboradorController {
    private $model;

    public function __construct() {
        $this->model = new ColaboradorModel("localhost", "root", "", "AcervoReceitas");
    }

    public function getColaborador($id) {
        return $this->model->getColaboradorById($id);
    }

    public function atualizarColaborador($dados) {
        return $this->model->atualizarColaborador($dados);
    }
}

// Lógica de edição e atualização
session_start();
$controller = new ColaboradorController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dados = [
        'id' => $_POST['id'],
        'nome' => $_POST['nome'],
        'nome_fantasia' => $_POST['nome_fantasia_input'] ?? null,
        'funcao' => $_POST['funcao'],
        'rg' => $_POST['rg'],
        'data_ingresso' => $_POST['data_ingresso'],
        'salario' => $_POST['salario'],
        'referencias' => $_POST['referencias'] ?? null,
    ];

    // Remover R$, vírgulas e outros caracteres não numéricos no salário
    $salario = $dados['salario'];
    $salario = preg_replace('/[^0-9]/', '', $salario); // Remove tudo que não for número
    $dados['salario'] = $salario / 100; // Divide por 100 para corrigir os centavos

    // Verifica se a senha foi alterada
    if (!empty($_POST['senha'])) {
        $dados['senha'] = md5($_POST['senha']); // Encripta a senha com MD5
    }

    // Atualiza os dados do colaborador
    if ($controller->atualizarColaborador($dados)) {
        $_SESSION['mensagem'] = "Colaborador atualizado com sucesso!";
    } else {
        $_SESSION['mensagem'] = "Erro ao atualizar colaborador!";
    }

    header('Location: ../../projetoads.view/colaborador/GerenciarColaboradorView.php');
    exit;
}

// Carrega os dados para edição
$id = $_GET['id'] ?? '';
if (!$id) {
    die("ID do colaborador não informado!");
}
$colaborador = $controller->getColaborador($id);
if (!$colaborador) {
    die("Colaborador não encontrado!");
}
