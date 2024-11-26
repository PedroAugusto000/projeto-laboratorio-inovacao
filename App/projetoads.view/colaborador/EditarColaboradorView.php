<?php
require '../../projetoads.controller/colaborador/EditarColaboradorController.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Colaborador</title>   
    <link rel="stylesheet" href="../../../public/css/stylesRegistro_colaborador.css">
</head>
<body>
    <header>
        <div class="logo">Logo</div>
        <nav>
            <a href="../livro/GerenciarLivroView.php">Livros</a>
            <a href="../receitas/GerenciarReceitaView.php">Receitas</a>
            <a href="../colaborador/GerenciarColaboradorView.php">Funcionários</a>
        </nav>
        <div class="user-area">
            <span class="user-icon">&#x1F464;</span>
            <span><?php echo htmlspecialchars($_SESSION['usuario'] ?? 'Usuário'); ?></span>
            <a href="../../home/index.php" class="logout" title="Sair">&#x27A1;</a>
        </div>
    </header>

    <h2>Editar Colaborador</h2>

    <div class="form-todo">
        <form action="../../projetoads.controller/colaborador/EditarColaboradorController.php" method="post" class="form-registro">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($colaborador['id']); ?>">
            <div>
                <label for="nome">Nome</label>
                <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($colaborador['nome']); ?>" required>
            </div>
            <div>
                <label for="nome_fantasia">Possui nome fantasia?</label>
                <input type="text" id="nome_fantasia_input" name="nome_fantasia_input" value="<?php echo htmlspecialchars($colaborador['nome_fantasia'] ?? ''); ?>">
            </div>
            <div>
                <label for="funcao">Função</label>
                <input type="text" id="funcao" name="funcao" value="<?php echo htmlspecialchars($colaborador['funcao']); ?>" required>
            </div>
            <div>
                <label for="rg">RG</label>
                <input type="text" id="rg" name="rg" value="<?php echo htmlspecialchars($colaborador['rg']); ?>" required>
            </div>
            <div>
                <label for="data_ingresso">Data de ingresso</label>
                <input type="date" id="data_ingresso" name="data_ingresso" value="<?php echo htmlspecialchars($colaborador['data_ingresso']); ?>" required>
            </div>
            <div>
                <label for="salario">Salário</label>
                <input type="text" id="salario" name="salario" value="<?php echo htmlspecialchars($colaborador['salario']); ?>" required>
            </div>
            <div>
                <label for="referencias">Referências (Opcional)</label>
                <textarea id="referencias" name="referencias"><?php echo htmlspecialchars($colaborador['referencias'] ?? ''); ?></textarea>
            </div>
            <button type="submit" class="register-btn">Atualizar</button>
            <a href="../colaborador/GerenciarColaboradorView.php">Voltar</a>
        </form>
    </div>
</body>
</html>
