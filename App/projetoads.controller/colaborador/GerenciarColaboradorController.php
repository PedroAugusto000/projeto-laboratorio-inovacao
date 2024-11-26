<?php
require '../../projetoads.model/colaborador/GerenciarColaboradorModel.php';

session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: ../../home/index.php');
    exit;
}

// Instância do Model
$model = new ColaboradorModel("localhost", "root", "", "AcervoReceitas");

// Obtém a lista de colaboradores
$colaboradores = $model->listarColaboradores();
if ($colaboradores === false) {
    die("Erro ao buscar colaboradores: " . $model->getConn()->error);
}
$nomeUsuario = $_SESSION['usuario'];
?>
