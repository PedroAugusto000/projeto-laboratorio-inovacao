<?php
session_start(); // Sessão iniciada para acessar $_SESSION['erro']
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../../../public/css/stylesLogin.css">
</head>
<body>
    <div class="login-container">
        <h2 id="text-login">Login</h2>
        <div class="login">
            <form action="../../projetoads.controller/login/LoginController.php" method="post">
                <div>
                    <label for="usuario">Usuário:</label>
                    <input type="text" id="usuario" name="usuario" required>
                </div>

                <div>
                    <label for="senha">Senha:</label>
                    <input type="password" id="senha" name="senha" required>
                </div>

                <button type="submit" id="button-login">Logar</button>

                <!-- Exibição da mensagem de erro -->
                <?php if (!empty($_SESSION['erro'])): ?>
                    <p class="error-message"><?php echo htmlspecialchars($_SESSION['erro']); ?></p>
                    <?php unset($_SESSION['erro']); // Remove o erro após exibir ?>
                <?php endif; ?>

                <a href="../../home/index.php">Voltar</a>
            </form>
        </div>
    </div>
</body>
</html>
