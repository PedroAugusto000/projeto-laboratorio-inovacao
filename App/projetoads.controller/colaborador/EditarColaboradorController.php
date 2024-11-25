<?php
require '../projetoads.model/ColaboradorModel.php';

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
        'salario' => str_replace(['R$', ',', '.'], ['', '.', ''], $_POST['salario']),
        'referencias' => $_POST['referencias']
    ];

    if ($controller->atualizarColaborador($dados)) {
        $_SESSION['mensagem'] = "Colaborador atualizado com sucesso!";
    } else {
        $_SESSION['mensagem'] = "Erro ao atualizar colaborador!";
    }

    header('Location: ../projetoads.view/colaborador_funcionarios.php');
    exit;
}

// Carrega os dados para edição
$id = $_GET['id'] ?? '';
$colaborador = $controller->getColaborador($id);