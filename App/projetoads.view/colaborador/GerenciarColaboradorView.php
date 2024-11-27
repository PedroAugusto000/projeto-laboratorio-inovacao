<?php
require_once '../../projetoads.controller/colaborador/GerenciarColaboradorController.php';

?>
<!DOCTYPE html>

<?php if (isset($_SESSION['nivel_permissao']) && in_array($_SESSION['nivel_permissao'], ['root', 'Administrador'])): ?>
    <!--<a href="../colaborador/RegistroColaboradorView.php" class="register-btn" style="display: block; margin-top: 10px;">Registrar colaborador</a>-->
<?php endif; ?>

<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Colaboradores</title>
    <link rel="stylesheet" href="../../../public/css/stylesGerenciar.css">
    <script>
    function filtrarColaboradores() {
        let input = document.getElementById('buscar-colaborador').value.toLowerCase();
        let colaboradores = document.querySelectorAll('#colaboradores-lista tr');

        colaboradores.forEach((colaborador) => {
            let colunas = colaborador.querySelectorAll('td');
            let encontrou = false;

            colunas.forEach((coluna) => {
                if (coluna.innerText.toLowerCase().includes(input)) {
                    encontrou = true;
                }
            });

            colaborador.style.display = encontrou ? '' : 'none';
        });
    }
    </script>
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
            <span class="user-icon">&#x1F464;</span>
            <span><?php echo htmlspecialchars($nomeUsuario ?? 'Usuário'); ?></span>
            <a href="../../home/index.php" class="logout" title="Sair">&#x27A1;</a>
        </div>
    </header>
    <main>
        <h2>Gerenciar Colaboradores</h2>

        <div class="search-bar">
            <input type="text" id="buscar-colaborador" placeholder="Pesquisar..." onkeyup="filtrarColaboradores()">
        </div>

        <a href="../colaborador/RegistroColaboradorView.php" class="register-btn" style="display: block; margin-top: 10px;">Registrar colaborador</a>

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
                 <?php if ($colaboradores && $colaboradores->num_rows > 0): ?>
                     
        <?php while ($row = $colaboradores->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['id']); ?></td>
                <td><?php echo htmlspecialchars($row['funcao']); ?></td>
                <td><?php echo htmlspecialchars($row['nome']); ?></td>
                <td>
                    <?php 
                    // Formata o RG no padrão brasileiro
                    $rg_formatado = preg_replace('/(\d{1})(\d{3})(\d{3})/', '$1.$2.$3', $row['rg']);
                    echo htmlspecialchars($rg_formatado);
                    ?>
                </td>
                <td><?php echo date('d/m/Y', strtotime($row['data_ingresso'])); ?></td>
                <td>
                    <?php if (isset($_SESSION['nivel_permissao']) && in_array($_SESSION['nivel_permissao'], ['root', 'Administrador'])): ?>
                        <a href="../../projetoads.view/colaborador/EditarColaboradorView.php?id=<?php echo $row['id']; ?>" title="Editar">&#x270E;</a>
                        <a href="../../projetoads.controller/colaborador/ExcluirColaboradorController.php?id=<?php echo $row['id']; ?>" title="Excluir" onclick="return confirm('Tem certeza que quer excluir esse colaborador?')">&#x1F5D1;</a>
                    <?php else: ?>
                        <span title="Sem permissão">&#x1F6AB;</span> <!-- Ícone de bloqueio -->
                    <?php endif; ?>
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
