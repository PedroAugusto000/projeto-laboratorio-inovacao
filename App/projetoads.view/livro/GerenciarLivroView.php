<?php
session_start();
require_once '../../projetoads.controller/livro/GerenciarLivroController.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Livros</title>
    <link rel="stylesheet" href="../../../public/css/stylesGerenciar.css">
</head>
<body>

<header>
    <div class="logo-container">
        <a href="../../home/index.php">GERENCIAMENTO</a>
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
    <h1>Gerenciar Livros</h1>
    <div class="search-bar">
    <form onsubmit="return false;"> <!-- Impede o reload da página -->
        <input type="text" name="search" placeholder="Buscar por ID, ISBN ou Título..." autocomplete="off">
    </form>
</div>
    <a href="RegistroLivroView.php" class="register-btn" style="display: block; margin-top: 10px;">Registrar livro</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>ISBN</th>
                <th>Título</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($livros && $livros->num_rows > 0): ?>
                <?php while ($row = $livros->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row["id"]); ?></td>
                        <td><?php echo htmlspecialchars($row["isbn"]); ?></td>
                        <td><?php echo htmlspecialchars($row["titulo"]); ?></td>
                        <td>
                            <a href="EditarLivroView.php?id=<?php echo $row['id']; ?>">&#x270E;</a>
                            <a href="GerenciarLivroView.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Tem certeza que quer deletar esse livro?')">&#x1F5D1;</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">Nenhum livro encontrado.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</main>


<script>
    function filtrarLivros() {
        let input = document.querySelector('input[name="search"]').value.toLowerCase(); // Captura o valor do campo de busca
        let livros = document.querySelectorAll('tbody tr'); // Todas as linhas da tabela

        livros.forEach((livro) => {
            let colunas = livro.querySelectorAll('td'); // Todas as colunas de uma linha
            let encontrou = false;

            colunas.forEach((coluna) => {
                if (coluna.innerText.toLowerCase().includes(input)) {
                    encontrou = true; // Marca como encontrado se houver correspondência
                }
            });

            livro.style.display = encontrou ? '' : 'none'; // Mostra ou oculta a linha
        });
    }

    // Vincula a função ao evento 'keyup' do campo de busca
    document.querySelector('input[name="search"]').addEventListener('keyup', filtrarLivros);
</script>

</body>
</html>