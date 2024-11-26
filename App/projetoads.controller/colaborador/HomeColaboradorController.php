<?php
session_start();

class HomeColaboradorController {
    public function verificarSessao() {
        if (!isset($_SESSION['usuario'])) {
            header('Location: ../../projetoads.view/login/LoginView.php'); // Redireciona pra página de login se não estiver logado
            exit;
        }
    }

    public function getNomeUsuario() {
        return isset($_SESSION['usuario']) ? $_SESSION['usuario'] : 'Usuário Desconhecido';
    }
}

$controller = new HomeColaboradorController();
$controller->verificarSessao();

// Define a variável $nomeUsuario com o valor do nome do usuário
$nomeUsuario = $controller->getNomeUsuario();

?>
