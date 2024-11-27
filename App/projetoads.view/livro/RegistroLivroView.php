<?php
require_once '../../projetoads.controller/livro/RegistroLivroController.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Livro</title>
    <link rel="stylesheet" href="../../../public/css/stylesRegistroEditar.css">
    <script>
        function validarFormulario(event) {
            const receitasSelecionadas = document.querySelectorAll('input[name="receitas[]"]:checked');
            if (receitasSelecionadas.length < 2) {
                alert("Você deve selecionar ao menos duas receitas.");
                event.preventDefault(); // Impede o envio do formulário
                return false;
            }
        }
    </script>
</head>
<body>
<header>
    <div class="logo-container">
        <a href="../../home/index.php">REGISTRO</a>
    </div>
    <nav>
        <a href="../livro/GerenciarLivroView.php">Livros</a>
        <a href="../receitas/GerenciarReceitaView.php">Receitas</a>
        <a href="../colaborador/GerenciarColaboradorView.php">Funcionários</a>
    </nav>
    <div class="user-area">
        <span>Usuário</span>
        <a href="../../home/index.php" class="logout">Sair</a>
    </div>
</header>

<main>
    <h1>Registrar Novo Livro</h1>
    <?php if (!empty($errorMessage)): ?>
        <div class="error-message"><?php echo htmlspecialchars($errorMessage); ?></div>
    <?php endif; ?>

    <?php if (!empty($errorMessage)): ?>
        <div class="error-message"><?php echo htmlspecialchars($errorMessage); ?></div>
    <?php endif; ?>

    <div class="form-container">
        <form action="../../projetoads.controller/livro/RegistroLivroController.php" method="post" enctype="multipart/form-data" onsubmit="return validarFormulario(event)">
            <div class="form-group">
                <label for="titulo">Título do Livro:</label>
                <input type="text" id="titulo" name="titulo" required>
            </div>

            <div class="form-group">
                <label for="isbn">ISBN:</label>
                <input type="text" id="isbn" name="isbn" pattern="\d{13}" title="ISBN deve ter 13 dígitos" placeholder="Somente números" required>
            </div>

            <div class="form-group">
                <label for="descricao">Descrição:</label>
                <textarea id="descricao" name="descricao" rows="4" placeholder="Escreva uma descrição para o livro" required></textarea>
            </div>

            <div class="form-group">
                <label for="imagem">Imagem do Livro:</label>
                <input type="file" id="imagem" name="imagem" accept="image/*" required>
            </div>

            <h3>Vincular Receitas</h3>
            <table>
                <thead>
                    <tr>
                        <th></th>
                        <th>Receita</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($receitas && $receitas->num_rows > 0): ?>
                        <?php while ($row = $receitas->fetch_assoc()): ?>
                            <tr>
                                <td><input type="checkbox" name="receitas[]" value="<?php echo htmlspecialchars($row['id']); ?>"></td>
                                <td><?php echo htmlspecialchars($row['nome']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="2">Nenhuma receita disponível para vincular.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <div class="action-bar">
                <button type="submit" class="register-btn">Salvar Livro</button>
            </div>
        </form>
    </div>
</main>
</body>
</html>
