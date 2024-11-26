<?php
require '../../projetoads.model/colaborador/ExcluirColaboradorModel.php';
session_start();

$controller = new ColaboradorModel("localhost", "root", "", "AcervoReceitas");

// Verifica se o ID foi passado
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);

    if ($controller->excluirColaborador($id)) {
        $_SESSION['mensagem'] = "Colaborador ID $id excluído com sucesso!";
    } else {
        $_SESSION['mensagem'] = "Erro ao excluir o colaborador ID $id. Verifique se ele existe.";
    }
} else {
    $_SESSION['mensagem'] = "ID inválido ou não informado.";
}

// Redireciona de volta para a página de gerenciamento
header('Location: ../../projetoads.view/colaborador/GerenciarColaboradorView.php');
exit;
