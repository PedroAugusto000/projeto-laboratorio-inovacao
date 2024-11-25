<?php
session_start();

class HomeColaboradorController {
    public function verificarSessao() {
        if (!isset($_SESSION['usuario'])) {
            header('Location: login.php');
            exit;
        }
    }

    public function getNomeUsuario() {
        return $_SESSION['usuario'];
    }
}

// Instância do Controller
$controller = new HomeColaboradorController();
$controller->verificarSessao();
$nomeUsuario = $controller->getNomeUsuario();
