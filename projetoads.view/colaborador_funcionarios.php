<?php
// Inicia uma nova sessão ou resume a existente para manter as informações do usuário
session_start();
require '../projetoads.model/db-conexao.php'; 

//Mesma coisa do outro código, só verificação se o usuário tá logado
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

//Se o cara estiver logado: (Sem o else explicito, não é necessário)
$nomeUsuario = $_SESSION['usuario']; //Vai pegar o nome do usuário
$sql = "SELECT id, nome, funcao, rg, data_ingresso FROM Colaboradores"; // Consulta SQL para buscar todos os colaboradores do banco de dados
$result = $conn->query($sql); //Executa a consulta e armazena o resultado
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Colaboradores</title>
    <link rel="stylesheet" href="../css/stylesColaborador_funcionarios.css">
</head>
<body>
    <header>
        <div class="logo">Logo</div>
        <nav>
            <a href="#">Livros</a>
            <a href="gerenciar_receitas.php">Receitas</a>
            <a href="#">Funcionários</a>
        </nav>
        <div class="user-area">
            <span class="user-icon">&#x1F464;</span>
            <span><?php echo($nomeUsuario); ?></span>
            <a href="../index.php" class="logout" title="Sair">&#x27A1;</a>
        </div>
    </header>
    <main>
        <h2>Gerenciar Colaboradores</h2>
        <div class="search-bar">
            <input type="text" placeholder="Pesquisar..." />
        </div>
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
            <tbody>

                <?php if ($result->num_rows > 0): //Aqui ele só vai ver se a consulta tem reusltado?> 
                    <?php while ($row = $result->fetch_assoc()): //Loop pelos resultados usando fetch_assoc() para criar uma linha na tabela para cada colaborador?>
                        <tr>
                            <td><?php echo($row['id']); ?></td>
                            <td><?php echo($row['funcao']); ?></td>
                            <td><?php echo($row['nome']); ?></td>
                            <td><?php echo($row['rg']); ?></td>
                            <td><?php echo date('d/m/Y', strtotime($row['data_ingresso'])); ?></td>
                            <td>
                                <a href="editar_colaborador.php?id=<?php echo $row['id']; ?>" title="Editar">&#x270E;</a>
                                <a href="../projetoads.controller/ExcluirColaboradorController.php?id=<?php echo $row['id']; ?>" title="Excluir">&#x1F5D1;</a>
                            </td>
                        </tr>
                    <?php endwhile; ?> <!--Fim da repetição do while-->
                <?php else: ?> <!--Vai escapar do if e mostrar caso não encontre nenhum resultado na consulta-->
                    <tr>
                        <td colspan="6">Nenhum colaborador cadastrado.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <a href="registro_colaborador.php">Registrar colaborador</a>
    </main>
</body>
</html>

<?php
$conn->close(); // Fecha a conexão com o banco de dados (Boa prática, fica gravado)
?>
