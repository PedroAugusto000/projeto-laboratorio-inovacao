<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../css/stylesLogin.css">
    <style>
        /* Estilos principais da tela de login */
        body {
            background-color: #f3f3f3;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            position: relative;
            width: 300px;
            background-color: #ffffff;
            padding: 40px 20px 20px; /* Espaço adicional no topo para o título */
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        #text-login {
            position: absolute;
            top: -20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #ffffff;
            padding: 0 10px;
            font-size: 1.5em;
            color: #232f3e;
            font-weight: bold;
        }

        .login {
            text-align: center;
        }

        label {
            display: block;
            color: #232f3e;
            font-weight: bold;
            margin-bottom: 5px;
            text-align: left;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }

        #button-login {
            background-color: #ff9900;
            color: white;
            font-weight: bold;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-size: 1em;
        }

        #button-login:hover {
            background-color: #e48f00;
        }

        a {
            color: #232f3e;
            text-decoration: none;
            font-weight: bold;
            display: inline-block;
            margin-top: 15px;
        }

        a:hover {
            color: #ff9900;
        }

        /* Estilo para mensagem de erro */
        .error-message {
            color: red;
            font-size: 0.9em;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2 id="text-login">Login</h2>
        <div class="login">
            <form action="../projetoads.controller/loginController.php" method="post">
                <div>
                    <label for="usuario">Usuário:</label>
                    <input type="text" id="usuario" name="usuario" required>
                </div>

                <div>
                    <label for="senha">Senha:</label>
                    <input type="password" id="senha" name="senha" required>
                </div>

                <button type="submit" id="button-login">Logar</button>

                <!-- Exibe uma mensagem de erro se a variável $erro não estiver vazia -->
                <?php if (!empty($erro)): ?>
                    <p class="error-message"><?php echo($erro); ?></p>
                <?php endif; ?>

                <a href="../index.php">Voltar</a>
            </form>
        </div>
    </div>
</body>
</html>
