<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Livro</title>
    <link rel="stylesheet" href="../css/stylesLivros.css">
    <script>
        function filtrarReceitas() {
            let input = document.getElementById('buscar-receita').value.toLowerCase();
            let receitas = document.querySelectorAll('#receitas-lista tr');

            receitas.forEach((receita) => {
                let nomeReceita = receita.querySelector('td:nth-child(2)').innerText.toLowerCase();
                receita.style.display = nomeReceita.includes(input) ? '' : 'none';
            });
        }
    </script>
</head>
<body>

<header>
    <div class="logo-container">
        <a href="#">Logo</a>
    </div>
    <nav>
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
    <h1>Registrar Novo Livro</h1>

    <div class="form-container">
        <form action="registro_livro.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="titulo">Título do Livro:</label>
                <input type="text" id="titulo" name="titulo" required>
            </div>

            <div class="form-group">
                <label for="isbn">ISBN:</label>
                <input type="text" id="isbn" name="isbn" pattern="\d{13}" title="ISBN deve ter 13 dígitos">
            </div>

            <div class="form-group">
                <label for="descricao">Descrição:</label>
                <textarea id="descricao" name="descricao" rows="4" placeholder="Escreva uma descrição para o livro"></textarea>
            </div>

            <div class="form-group">
                <label for="imagem">Imagem do Livro:</label>
                <input type="file" id="imagem" name="imagem" accept="image/*">
            </div>

            <div class="action-bar">
                <button type="submit" class="register-btn">Salvar Livro</button>
                <input type="text" id="buscar-receita" placeholder="Buscar receita..." onkeyup="filtrarReceitas()">
            </div>

            <table>
                <thead>
                    <tr>
                        <th></th>
                        <th>Receita</th>
                    </tr>
                </thead>
                <tbody id="receitas-lista">
                    <?php while ($row = $receitas->fetch_assoc()): ?>
                        <tr>
                            <td><input type="checkbox" name="receitas[]" value="<?php echo $row['id']; ?>"></td>
                            <td><?php echo htmlspecialchars($row['nome']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </form>
    </div>
</main>

</body>
</html>
