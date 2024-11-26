<?php
session_start();
require_once '../../projetoads.controller/receita/GerenciarReceitaController.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Receitas</title>
    <link rel="stylesheet" href="../../../public/css/stylesReceitas.css">
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
    <h1>Gerenciar Receitas</h1>

    <div class="search-bar">
        <input type="text" id="buscar-receita" placeholder="Buscar receita..." onkeyup="filtrarReceitas()">
    </div>

    <a href="RegistroReceitaView.php" class="register-btn" style="display: block; margin-top: 10px;">Registrar receita</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Categoria</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody id="receitas-lista">
            <?php if ($receitas && $receitas->num_rows > 0): ?>
                <?php while ($row = $receitas->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row["id"]); ?></td>
                        <td><?php echo htmlspecialchars($row["nome"]); ?></td>
                        <td><?php echo htmlspecialchars($row["categoria"]); ?></td>
                        <td>
                            <a href="EditarReceitaView.php?id=<?php echo $row['id']; ?>">✏️</a>
                            <a href="GerenciarReceitaView.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Tem certeza que quer deletar essa receita?')">🗑️</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">Nenhuma receita cadastrada.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</main>

</body>
</html>
