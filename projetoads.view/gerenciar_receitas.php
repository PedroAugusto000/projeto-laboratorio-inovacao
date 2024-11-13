<?php
// Conexão com o banco de dados
$conn = new mysqli("localhost", "root", "", "AcervoReceitas");

if (isset($_GET["delete"])) {
    $id = $_GET["delete"];
    $conn->query("DELETE FROM receitas WHERE id = $id");
    header("Location: gerenciar_receitas.php");
}

// Selecionar todas as receitas com o nome da categoria
$result = $conn->query("
    SELECT receitas.id, receitas.nome, categorias.nome_categoria AS categoria 
    FROM receitas 
    LEFT JOIN categorias ON receitas.categoria = categorias.id
");

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Receitas</title>
    <link rel="stylesheet" href="../css/stylesReceitas.css">
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
        <a href="colaborador_funcionarios.php">Funcionários</a>
    </nav>
    <div class="user-area">
        <span>Usuário</span>
        <a href="../index.php" class="logout">Sair</a>
    </div>
</header>

<main>
    <h1>Gerenciar Receitas</h1>

    <!-- Barra de busca com função de filtro -->
    <div class="search-bar">
        <input type="text" id="buscar-receita" placeholder="Buscar receita..." onkeyup="filtrarReceitas()">
    </div>

    <!-- Botão de registrar receita, agora abaixo da barra de busca -->
    <a href="registro_receita.php" class="register-btn" style="display: block; margin-top: 10px;">Registrar receita</a>

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
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row["id"]; ?></td>
                    <td><?php echo $row["nome"]; ?></td>
                    <td><?php echo $row["categoria"]; ?></td>
                    <td>
                        <a href="editar_receitas.php?id=<?php echo $row['id']; ?>">✏️</a>
                        <a href="gerenciar_receitas.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Tem certeza que quer deletar essa receita?')">🗑️</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

</main>

</body>
</html>
