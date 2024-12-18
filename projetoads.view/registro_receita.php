<?php
// Conexão com o banco de dados
$conn = new mysqli("localhost", "root", "", "AcervoReceitas");

// Checa conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Consulta pra pegar as categorias
$sqlCategorias = "SELECT id, nome_categoria FROM categorias";
$resultCategorias = $conn->query($sqlCategorias);

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"];
    $categoria = $_POST["categoria"];
    $opiniao_degustador = $_POST["opiniao_degustador"];
    $ingredientes = $_POST["ingredientes"];
    $modo_preparo = $_POST["modo_preparo"];
    $descricao = $_POST["descricao"];
    $numero_porcoes = $_POST["numero_porcoes"];
    $nome_cozinheiro = $_POST["nome_cozinheiro"];
    $nome_degustador = $_POST["nome_degustador"];

    // Verifica se uma imagem foi enviada
    if (isset($_FILES["imagem_receita"]) && $_FILES["imagem_receita"]["error"] == 0) {
        $imagem_receita = file_get_contents($_FILES["imagem_receita"]["tmp_name"]);
    } else {
        $imagem_receita = null;
    }

    // Insere a receita no banco de dados
    $sql = "INSERT INTO receitas (nome, categoria, opiniao_degustador, ingredientes, modo_preparo, descricao, numero_porcoes, nome_cozinheiro, nome_degustador, imagem_receita)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssssb", $nome, $categoria, $opiniao_degustador, $ingredientes, $modo_preparo, $descricao, $numero_porcoes, $nome_cozinheiro, $nome_degustador, $imagem_receita);
    $stmt->send_long_data(9, $imagem_receita);

    if ($stmt->execute()) {
        echo "Receita cadastrada com sucesso!";
    } else {
        echo "Erro: " . $conn->error;
    }

    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Receita</title>
    <link rel="stylesheet" href="../css/stylesRegistroReceitas.css">
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
    </script>
</head>
<body>

<header>
    
    <div class="logo-container">
        <a href="#">Logo</a>
    </div>
    
    <nav>
        <a href="#">Livros</a>
        <a href="gerenciar_receitas.php">Receitas</a>
        <a href="#">Funcionários</a>
    </nav>
    <div class="user-area">
        <span>Usuário</span>
        <a href="#" class="logout">Sair</a>
    </div>
</header>

<main>
    <div class="container">
        <h1>Registro de Receita</h1>
        <div class="form-section">
            <form action="registro_receita.php" method="POST" enctype="multipart/form-data">
                <label for="nome">Nome</label>
                <input type="text" id="nome" name="nome" placeholder="Informe o nome da receita" required>

                <!-- Campo de Categoria como uma lista suspensa -->
                <label for="categoria">Categoria</label>
                <select id="categoria" name="categoria" required>
                    <option value="">Selecione uma categoria</option>
                    <?php while ($rowCategoria = $resultCategorias->fetch_assoc()): ?>
                        <option value="<?php echo $rowCategoria['id']; ?>"><?php echo htmlspecialchars($rowCategoria['nome_categoria']); ?></option>
                    <?php endwhile; ?>
                </select>

                <label for="opiniao_degustador">Opinião Degustador</label>
                <textarea id="opiniao_degustador" name="opiniao_degustador" placeholder="Nota e opinião do degustador"></textarea>

                <label for="ingredientes">Ingredientes</label>
                <textarea id="ingredientes" name="ingredientes" placeholder="-Ingrediente + quantidade + medida"></textarea>

                <label for="modo_preparo">Modo de preparo</label>
                <textarea id="modo_preparo" name="modo_preparo" placeholder="1. Passo um"></textarea>

                <label for="descricao">Descrição</label>
                <textarea id="descricao" name="descricao" placeholder="Descrição breve da receita"></textarea>

                <label for="numero_porcoes">Número de porções</label>
                <input type="text" id="numero_porcoes" name="numero_porcoes" placeholder="Porções que a receita serve">

                <label for="nome_cozinheiro">Cozinheiro</label>
                <input type="text" id="nome_cozinheiro" name="nome_cozinheiro" placeholder="Nome do cozinheiro">
                <div id="nome_cozinheiro-list" class="autocomplete-list"></div>

                <label for="nome_degustador">Degustador</label>
                <input type="text" id="nome_degustador" name="nome_degustador" placeholder="Nome do degustador">
                <div id="nome_degustador-list" class="autocomplete-list"></div>

                <!-- Campo para upload da imagem -->
                <label for="imagem_receita">Anexar imagem da receita</label>
                <input type="file" id="imagem_receita" name="imagem_receita" accept="image/*">

                <div class="register-btn-container">
                    <button type="submit" class="register-btn">Cadastrar receita</button>
                </div>
                <a href="gerenciar_receitas.php">Voltar</a>

                
            </form>
        </div>
    </div>
</main>

</body>
</html>
