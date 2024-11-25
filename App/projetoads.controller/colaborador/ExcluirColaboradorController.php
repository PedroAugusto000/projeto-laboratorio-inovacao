<?php
require '../projetoads.model/ColaboradorModel.php';
session_start();

$controller = new ColaboradorModel("localhost", "root", "", "AcervoReceitas");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    if ($controller->excluirColaborador($id)) {
        $_SESSION['mensagem'] = "Colaborador excluído com sucesso!";
    } else {
        $_SESSION['mensagem'] = "Erro ao excluir colaborador!";
    }

    header('Location: ../projetoads.view/colaborador_funcionarios.php');
    exit;
} else {
    header('Location: ../projetoads.view/colaborador_funcionarios.php');
    exit;
}
