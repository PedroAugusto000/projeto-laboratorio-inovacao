<?php
session_start();

class HomeColaboradorController {
    public function verificarSessao() {
        if (!isset($_SESSION['usuario'])) {
            header('Location: ../../projetoads.view/login/LoginView.php'); 
        }
    }

    public function getNomeUsuario() {
        return isset($_SESSION['usuario']) ? $_SESSION['usuario'] : 'Usuário Desconhecido';
    }
}

$controller = new HomeColaboradorController();
$controller->verificarSessao();

$nomeUsuario = $controller->getNomeUsuario();

?>
