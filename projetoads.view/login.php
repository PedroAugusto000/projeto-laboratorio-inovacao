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
    <form action="login.php" method="post">

        <div>
            <label for="email">Usuário:</label>
            <input type="usuario" id="usuario" name="usuario" required>
        </div> <br>

        <div>
            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required>
        </div> <br>


        <button type="submit" id="button-login">Logar</button>

        <br> <a href="../index.php">Voltar</a>

</div>

    </form>
</body>
</html>