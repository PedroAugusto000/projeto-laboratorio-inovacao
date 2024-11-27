<?php
require '../../projetoads.controller/colaborador/RegistroColaboradorController.php';

if (!isset($_SESSION['nivel_permissao']) || !in_array($_SESSION['nivel_permissao'], ['root', 'Administrador'])) {
    header('Location: ../../home/index.php'); // Redireciona se não for autorizado
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Colaborador</title>
    <link rel="stylesheet" href="../../../public/css/stylesRegistroEditar.css">
    <script>
    function formatRG(input) {
            let value = input.value.replace(/\D/g, ''); // Remove qualquer coisa que não seja número
            value = value.replace(/(\d{1})(\d{3})(\d{3})/, '$1.$2.$3'); // Formata pro padrão 0.000.000
            input.value = value;
        }   

        function formatSalary(input) {
            let value = input.value.replace(/\D/g, '');
            value = (value / 100).toFixed(2).replace('.', ',');
            value = "R$ " + value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            input.value = value;
        }
    </script>
</head>
<body>
    <header>
        <div class="logo-container">
            <a href="../../home/index.php">REGISTRO</a>
        </div>
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

    <h2>Registro Colaborador</h2>

    <?php if (isset($_SESSION['mensagem'])): ?>
    <div class="alert">
        <?php echo htmlspecialchars($_SESSION['mensagem']); ?>
        <?php unset($_SESSION['mensagem']);?>
    </div>
    <?php endif; ?>

    <div class="form-todo">
        <form action="RegistroColaboradorView.php" method="post" class="form-registro">
            <div>
                <label for="nome">Nome</label>
                <input type="text" id="nome" name="nome" placeholder="Informe o nome..." required>
            </div>
            <div>
                <label for="nome_fantasia">Possui nome fantasia?</label>
                <input type="text" id="nome_fantasia_input" name="nome_fantasia_input" placeholder="Informe o nome fantasia..." disabled>
                <input type="checkbox" id="nome_fantasia" name="nome_fantasia" onclick="document.getElementById('nome_fantasia_input').disabled = !this.checked;">
            </div>
            <div>
                <label for="funcao">Função</label>
                <select id="funcao" name="funcao" required>
                    <option value="">Selecione a função</option>
                    <option value="Desenvolvedor">Desenvolvedor</option>
                    <option value="Cozinheiro">Cozinheiro</option>
                    <option value="Degustador">Degustador</option>
                    <option value="Editor">Editor</option>
                </select>
            </div>
            <div>
                <label for="rg">RG</label>
                <input type="text" id="rg" name="rg" oninput="formatRG(this)" placeholder="0.000.000" required>
            </div>
            <div>
                <label for="data_ingresso">Data de ingresso</label>
                <input type="date" id="data_ingresso" name="data_ingresso" required>
            </div>
            <div>
                <label for="salario">Salário</label>
                <input type="text" id="salario" name="salario" oninput="formatSalary(this)" placeholder="R$ 0,00" required>
            </div>
            <div>
                <label for="referencias">Referências (Opcional)</label>
                <textarea id="referencias" name="referencias" placeholder="Trabalhou no restaurante Oro no RJ..."></textarea>
            </div>
            <div>
                <label for="usuario">Nome de Usuário</label>
                <input type="text" id="usuario" name="usuario" placeholder="Informe o nome de usuário..." required>
            </div>
            <div>
                <label for="senha">Senha</label>
                <input type="password" id="senha" name="senha" placeholder="Informe a senha..." required>
            </div>
            <button type="submit" class="register-btn">Registrar</button>
            <a href="GerenciarColaboradorView.php">Voltar</a>
        </form>
    </div>
</body>
</html>
