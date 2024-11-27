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
    <link rel="stylesheet" href="../../../public/css/stylesGerenciar.css">
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

<script>
    function filtrarReceitas() {
        let input = document.getElementById('buscar-receita').value.toLowerCase(); // Captura o texto de busca
        let receitas = document.querySelectorAll('#receitas-lista tr'); // Seleciona todas as linhas da tabela

        receitas.forEach((receita) => {
            let colunas = receita.querySelectorAll('td'); // Todas as colunas da linha
            let encontrou = false;

            // Verifica cada coluna da linha
            colunas.forEach((coluna) => {
                if (coluna.innerText.toLowerCase().includes(input)) {
                    encontrou = true; // Marca como encontrado se o texto de busca estiver presente
                }
            });

            // Mostra ou oculta a linha com base no resultado da busca
            receita.style.display = encontrou ? '' : 'none';
        });
    }

    // Vincula a função ao evento 'keyup' do campo de busca
    document.getElementById('buscar-receita').addEventListener('keyup', filtrarReceitas);
</script>

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
                            <a href="EditarReceitaView.php?id=<?php echo $row['id']; ?>">&#x270E;</a>
                            <a href="GerenciarReceitaView.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Tem certeza que quer deletar essa receita?')">&#x1F5D1;</a>
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
