<?php
session_start();
$erro = '';
if (isset($_SESSION['erro'])) {
    $erro = $_SESSION['erro'];
    unset($_SESSION['erro']); // Remove a mensagem de erro após exibi-la
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../css/stylesLogin.css">
</head>
<body>
    <h2 id="text-login">Login</h2>

    <div class="login">
        <form action="../projetoads.controller/loginController.php" method="post">
            <div>
                <label for="usuario">Usuário:</label>
                <input type="text" id="usuario" name="usuario" required>
            </div> <br>

            <div>
                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" required>
            </div> <br>

            <button type="submit" id="button-login">Logar</button>

            <?php if (!empty($erro)): ?>
                <p style="color: red;"><?php echo htmlspecialchars($erro); ?></p>
            <?php endif; ?>

            <br> <a href="../index.php">Voltar</a>
        </form>
    </div>
</body>
</html>
