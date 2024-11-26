<?php
require '../../projetoads.model/colaborador/RegistroColaboradorModel.php';

class ColaboradorController {
    private $model;

    public function __construct() {
        $this->model = new ColaboradorModel("localhost", "root", "", "AcervoReceitas");
    }

    public function registrarColaborador($dados) {
        return $this->model->registrarColaborador($dados);
    }
}

// Inicia sessão
session_start();
$controller = new ColaboradorController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dados = [
        'nome' => $_POST['nome'],
        'nome_fantasia' => isset($_POST['nome_fantasia']) ? $_POST['nome_fantasia_input'] : null,
        'funcao' => $_POST['funcao'],
        'rg' => $_POST['rg'],
        'data_ingresso' => $_POST['data_ingresso'],
        'salario' => str_replace(['R$', ',', '.'], ['', '.', ''], $_POST['salario']),
        'referencias' => $_POST['referencias']
    ];

    if ($controller->registrarColaborador($dados)) {
        $_SESSION['mensagem'] = "Colaborador registrado com sucesso!";
        header('Location: ../../projetoads.view/colaborador/RegistroColaboradorView.php');
        exit;
    } else {
        $_SESSION['mensagem'] = "Erro ao registrar colaborador!";
        header('Location: ../../projetoads.view/colaborador/RegistroColaboradorView.php');
        exit;
    }
}

?>

