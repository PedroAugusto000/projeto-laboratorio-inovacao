<?php
// Inicia uma nova sessão ou resume a existente para manter as informações do usuário
session_start();
require '../projetoads.model/db-conexao.php'; 

// Verificação se o usuário está logado
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

// Se o usuário está logado, captura o nome do usuário
$nomeUsuario = $_SESSION['usuario'];
$sql = "SELECT id, nome, funcao, rg, data_ingresso FROM Colaboradores";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Colaboradores</title>
    <link rel="stylesheet" href="../css/stylesColaborador_funcionarios.css">
    <script>
        function filtrarColaboradores() {
            let input = document.getElementById('buscar-colaborador').value.toLowerCase();
            let colaboradores = document.querySelectorAll('#colaboradores-lista tr');

            colaboradores.forEach((colaborador) => {
                let nomeColaborador = colaborador.querySelector('td:nth-child(3)').innerText.toLowerCase();
                colaborador.style.display = nomeColaborador.includes(input) ? '' : 'none';
            });
        }
    </script>
</head>
<body>
    <header>
        <div class="logo">Logo</div>
        <nav>
            <a href="gerir_livros.php">Livros</a>
            <a href="gerenciar_receitas.php">Receitas</a>
            <a href="colaborador_funcionarios.php">Funcionários</a>
        </nav>
        <div class="user-area">
            <span class="user-icon">&#x1F464;</span>
            <span><?php echo($nomeUsuario); ?></span>
            <a href="../index.php" class="logout" title="Sair">&#x27A1;</a>
        </div>
    </header>
    <main>
        <h2>Gerenciar Colaboradores</h2>

        <!-- Barra de pesquisa -->
        <div class="search-bar">
            <input type="text" id="buscar-colaborador" placeholder="Pesquisar..." onkeyup="filtrarColaboradores()">
        </div>

        <!-- Botão de registrar colaborador -->
        <a href="registro_colaborador.php" class="register-btn" style="display: block; margin-top: 10px;">Registrar colaborador</a>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Função</th>
                    <th>Nome</th>
                    <th>RG</th>
                    <th>Data de Ingresso</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody id="colaboradores-lista">
                <?php if ($result->num_rows > 0): ?> 
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo($row['id']); ?></td>
                            <td><?php echo($row['funcao']); ?></td>
                            <td><?php echo($row['nome']); ?></td>
                            <td><?php echo($row['rg']); ?></td>
                            <td><?php echo date('d/m/Y', strtotime($row['data_ingresso'])); ?></td>
                            <td>
                                <a href="editar_colaborador.php?id=<?php echo $row['id']; ?>" title="Editar">&#x270E;</a>
                                <a href="../projetoads.controller/ExcluirColaboradorController.php?id=<?php echo $row['id']; ?>" title="Excluir" onclick="return confirm('Tem certeza que quer excluir esse colaborador?')">&#x1F5D1;</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">Nenhum colaborador cadastrado.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>
</body>
</html>

<?php
$conn->close();
?>
