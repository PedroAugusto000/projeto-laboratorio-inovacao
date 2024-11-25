<?php
require '../projetoads.model/ColaboradorModel.php';
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

// Instância do Model
$model = new ColaboradorModel("localhost", "root", "", "AcervoReceitas");

// Obtém a lista de colaboradores
$colaboradores = $model->listarColaboradores();
$nomeUsuario = $_SESSION['usuario'];
