<?php
// Inicia uma nova sessão ou retoma a existente
session_start();

$erro = ''; //Só pra armazer mensagem de erro, caso tenha

//Vai ver se tem mensagem de erro na variável
if (isset($_SESSION['erro'])) {
    // Se houver, armazena essa mensagem na variável $erro
    $erro = $_SESSION['erro'];
    // Remove a mensagem de erro da sessão, para que ela não seja exibida novamente no próximo acesso
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

            <!-- Exibe uma mensagem de erro se a variável $erro não estiver vazia -->
            <?php if (!empty($erro)): ?>
                <p style="color: red;"><?php echo($erro); ?></p> <!-- Mostra a mensagem de erro em vermelho -->
            <?php endif; ?>

            <br> <a href="../index.php">Voltar</a>
        </form>
    </div>
</body>
</html>
