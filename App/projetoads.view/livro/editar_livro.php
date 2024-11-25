<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Livro</title>
    <link rel="stylesheet" href="../css/stylesLivros.css">
</head>
<body>

<header>
    <nav>
        <a href="#">Logo</a>
        <a href="gerir_livros.php">Livros</a>
        <a href="gerenciar_receitas.php">Receitas</a>
        <a href="#">Funcionários</a>
    </nav>
    <div class="user-area">
        <span>Usuário</span>
        <a href="../index.php" class="logout">Sair</a>
    </div>
</header>

<main>
    <h1>Editar Livro</h1>

    <form action="editar_livro.php?id=<?php echo $livroId; ?>" method="post" enctype="multipart/form-data">
        <label for="titulo">Título do Livro:</label>
        <input type="text" id="titulo" name="titulo" value="<?php echo htmlspecialchars($livro['titulo']); ?>" required><br><br>

        <label for="isbn">ISBN (opcional):</label>
        <input type="text" id="isbn" name="isbn" value="<?php echo htmlspecialchars($livro['isbn']); ?>"><br><br>

        <label for="imagem">Imagem do Livro:</label>
        <input type="file" id="imagem" name="imagem" accept="image/*"><br><br>
        <?php if ($livro['imagem']): ?>
            <p>Imagem atual:</p>
            <img src="data:image/jpeg;base64,<?php echo base64_encode($livro['imagem']); ?>" alt="Imagem do Livro" width="100px" height="150px">
        <?php endif; ?>
        <br><br>

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
                        <td>
                            <input type="checkbox" name="receitas[]" value="<?php echo $row['id']; ?>" <?php echo in_array($row['id'], $receitasSelecionadas) ? 'checked' : ''; ?>>
                        </td>
                        <td><?php echo htmlspecialchars($row["nome"]); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <button type="submit" class="register-btn">Salvar Alterações</button>
    </form>

</main>

</body>
</html>