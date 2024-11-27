<?php
require '../../projetoads.model/colaborador/RegistroColaboradorModel.php';

session_start();

if (!isset($_SESSION['nivel_permissao']) || !in_array($_SESSION['nivel_permissao'], ['root', 'Administrador'])) {
    $_SESSION['mensagem'] = "Você não tem permissão para realizar esta ação.";
    header('Location: ../../projetoads.view/colaborador/GerenciarColaboradorView.php');
    exit;
}

class ColaboradorController {
    private $model;

    public function __construct() {
        $this->model = new ColaboradorModel("localhost", "root", "", "AcervoReceitas");
    }

    public function rgExiste($rg) {
        return $this->model->rgExiste($rg);
    }

    public function usuarioExiste($usuario) {
        return $this->model->usuarioExiste($usuario);
    }

    public function registrarColaborador($dados) {
        return $this->model->registrarColaborador($dados);
    }
}

$controller = new ColaboradorController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dados = [
        'nome' => $_POST['nome'],
        'nome_fantasia' => isset($_POST['nome_fantasia']) ? $_POST['nome_fantasia_input'] : null,
        'funcao' => $_POST['funcao'],
        'rg' => $_POST['rg'],
        'data_ingresso' => $_POST['data_ingresso'],
        'salario' => str_replace(['R$', ',', '.'], ['', '.', ''], $_POST['salario']),
        'referencias' => $_POST['referencias'],
        'usuario' => $_POST['usuario'],
        'senha' => $_POST['senha'],
        'nivel_permissao' => ($_POST['funcao'] === 'Administrador') ? 'Administrador' : 'Usuario'
    ];

    // Verifica se o RG já existe
    if ($controller->rgExiste($dados['rg'])) {
        $_SESSION['mensagem'] = "Erro: O RG já está cadastrado!";
        header('Location: ../../projetoads.view/colaborador/RegistroColaboradorView.php');
        exit;
    }

    // Verifica se o usuário já existe
    if ($controller->usuarioExiste($dados['usuario'])) {
        $_SESSION['mensagem'] = "Erro: O nome de usuário já está em uso!";
        header('Location: ../../projetoads.view/colaborador/RegistroColaboradorView.php');
        exit;
    }

    if ($controller->registrarColaborador($dados)) {
        $_SESSION['mensagem'] = "Colaborador registrado com sucesso!";
        header('Location: ../../projetoads.view/colaborador/GerenciarColaboradorView.php');
        exit;
    } else {
        $_SESSION['mensagem'] = "Erro ao registrar colaborador!";
        header('Location: ../../projetoads.view/colaborador/RegistroColaboradorView.php');
        exit;
    }
}
