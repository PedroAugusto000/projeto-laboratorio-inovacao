<?php
require_once '../../projetoads.controller/receita/RegistroReceitaController.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Receita</title>
    <link rel="stylesheet" href="../../../public/css/stylesRegistroEditar.css">

    <script>
        function autocomplete(input, url) {
            input.addEventListener("input", function() {
                fetch(url + '?query=' + input.value)
                    .then(response => response.json())
                    .then(data => {
                        const list = document.getElementById(input.id + "-list");
                        list.innerHTML = "";
                        data.forEach(item => {
                            const option = document.createElement("div");
                            option.textContent = item.nome;
                            option.addEventListener("click", () => {
                                input.value = item.nome;
                                list.innerHTML = "";
                            });
                            list.appendChild(option);
                        });
                    });
            });
        }

        document.addEventListener("DOMContentLoaded", function() {
            autocomplete(document.getElementById("nome_cozinheiro"), "buscar_colaboradores.php");
            autocomplete(document.getElementById("nome_degustador"), "buscar_colaboradores.php");
        });

            // Função para ajustar o tamanho do textarea automaticamente
    function autoResizeTextarea(textarea) {
        textarea.style.height = 'auto'; // Redefine a altura para calcular novamente
        textarea.style.height = textarea.scrollHeight + 'px'; // Ajusta a altura com base no conteúdo
    }

    // Seleciona todos os elementos do tipo textarea e aplica o ajuste automático
    document.addEventListener("DOMContentLoaded", function () {
        const textareas = document.querySelectorAll("textarea");
        textareas.forEach(textarea => {
            textarea.addEventListener("input", () => autoResizeTextarea(textarea));
            // Ajusta imediatamente ao carregar a página caso haja conteúdo pré-preenchido
            autoResizeTextarea(textarea);
        });
    });
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
        <span>Usuário</span>
        <a href="../../home/index.php" class="logout">Sair</a>
    </div>
</header>

<main>
    <div class="container">
        <h1>Registro de Receita</h1>
        <div class="form-section">
        <form action="../../projetoads.controller/receita/RegistroReceitaController.php" method="POST" enctype="multipart/form-data">
    <label for="nome">Nome</label>
    <input type="text" id="nome" name="nome" placeholder="Informe o nome da receita" required>

    <label for="categoria">Categoria</label>
    <select id="categoria" name="categoria" required>
        <option value="">Selecione uma categoria</option>
        <?php while ($row = $categorias->fetch_assoc()): ?>
            <option value="<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['nome_categoria']); ?></option>
        <?php endwhile; ?>
    </select>

    <label for="opiniao_degustador">Opinião Degustador</label>
    <textarea id="opiniao_degustador" name="opiniao_degustador" placeholder="Nota e opinião do degustador" required></textarea>

    <label for="ingredientes">Ingredientes</label>
    <textarea id="ingredientes" name="ingredientes" placeholder="-Ingrediente + quantidade + medida" required></textarea>

    <label for="modo_preparo">Modo de preparo</label>
    <textarea id="modo_preparo" name="modo_preparo" placeholder="1. Passo um" required></textarea>

    <label for="descricao">Descrição</label>
    <textarea id="descricao" name="descricao" placeholder="Descrição breve da receita" required></textarea>

    <label for="numero_porcoes">Número de porções</label>
    <input type="number" id="numero_porcoes" name="numero_porcoes" placeholder="Porções que a receita serve" required>

    <label for="nome_cozinheiro">Cozinheiro</label>
    <input type="text" id="nome_cozinheiro" name="nome_cozinheiro" placeholder="Nome do cozinheiro" required>

    <label for="nome_degustador">Degustador</label>
    <input type="text" id="nome_degustador" name="nome_degustador" placeholder="Nome do degustador" required>

    <label for="imagem_receita">Anexar imagem da receita</label>
    <input type="file" id="imagem_receita" name="imagem_receita" accept="image/*" required>

    <div class="register-btn-container">
        <button type="submit" class="register-btn">Cadastrar receita</button>
    </div>
    <a href="GerenciarReceitaView.php">Voltar</a>
</form>

        </div>
    </div>
</main>

</body>
</html>
