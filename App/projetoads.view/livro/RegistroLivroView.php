<?php
require_once '../../projetoads.controller/livro/RegistroLivroController.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Livro</title>
    <link rel="stylesheet" href="../../../public/css/stylesLivros.css">
</head>
<body>

<header>
    <div class="logo-container">
        <a href="#">Logo</a>
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

    <div class="form-container">
        <form action="../../projetoads.controller/livro/RegistroLivroController.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="titulo">Título do Livro:</label>
                <input type="text" id="titulo" name="titulo" required>
            </div>

            <div class="form-group">
                <label for="isbn">ISBN:</label>
                <input type="text" id="isbn" name="isbn" pattern="\d{13}" title="ISBN deve ter 13 dígitos" placeholder="Somente números">
            </div>

            <div class="form-group">
                <label for="descricao">Descrição:</label>
                <textarea id="descricao" name="descricao" rows="4" placeholder="Escreva uma descrição para o livro"></textarea>
            </div>

            <div class="form-group">
                <label for="imagem">Imagem do Livro:</label>
                <input type="file" id="imagem" name="imagem" accept="image/*">
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
                    <?php while ($row = $receitas->fetch_assoc()): ?>
                        <tr>
                            <td><input type="checkbox" name="receitas[]" value="<?php echo htmlspecialchars($row['id']); ?>"></td>
                            <td><?php echo htmlspecialchars($row['nome']); ?></td>
                        </tr>
                    <?php endwhile; ?>
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
