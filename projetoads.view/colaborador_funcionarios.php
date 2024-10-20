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
            <a href="#">Receitas</a>
            <a href="#">Funcionários</a>
        </nav>
        <div class="user-area">
            <span class="user-icon">&#x1F464;</span>
            <span>Usuário</span>
            <a href="#" class="logout" title="Sair">&#x27A1;</a>
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
                <tr>
                    <td>12345</td>
                    <td>Cozinheiro</td>
                    <td>Pedro Augusto Moura de Oliveira</td>
                    <td>1.234.567</td>
                    <td>17/04/2024</td>
                    <td>
                        <a href="#" title="Editar">&#x270E;</a>
                        <a href="#" title="Excluir">&#x1F5D1;</a>
                    </td>
                </tr>
            </tbody>
        </table>

        <a href="registro_colaborador.php">Registrar colaborador</a>
        <!--<button class="register-btn">Registrar colaborador</button>-->
    </main>
</body>
</html>
