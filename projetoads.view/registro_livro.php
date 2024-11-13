<?php
// Conexão com o banco de dados
$conn = new mysqli("localhost", "root", "", "AcervoReceitas");

// Checa conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Verificar se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST['titulo'];
    $isbn = !empty($_POST['isbn']) ? $_POST['isbn'] : null;
    $descricao = $_POST['descricao']; // Novo campo de descrição
    $receitasSelecionadas = $_POST['receitas'];
    $imagemBlob = null;

    // Verifica se o ISBN tem 13 dígitos
    if ($isbn && !preg_match("/^\d{13}$/", $isbn)) {
        die("ISBN inválido. Deve ter 13 dígitos.");
    }

    // Verificar se um arquivo de imagem foi enviado
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == UPLOAD_ERR_OK) {
        $imagemBlob = file_get_contents($_FILES['imagem']['tmp_name']);  // Lê o conteúdo binário do arquivo
    }

    // Inserir o livro na tabela 'livros' com o novo campo descrição e a imagem como BLOB
    $stmt = $conn->prepare("INSERT INTO livros (titulo, isbn, descricao, imagem) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssb", $titulo, $isbn, $descricao, $imagemBlob);
    $stmt->send_long_data(3, $imagemBlob);  // Envia o dado BLOB corretamente
    $stmt->execute();
    $livroId = $stmt->insert_id; // Pega o ID do livro recém-inserido
    $stmt->close();

    // Inserir cada receita selecionada na tabela de relacionamento (ex: 'livros_receitas')
    if (!empty($receitasSelecionadas)) {
        $stmt = $conn->prepare("INSERT INTO livros_receitas (livro_id, receita_id) VALUES (?, ?)");
        foreach ($receitasSelecionadas as $receitaId) {
            $stmt->bind_param("ii", $livroId, $receitaId);
            $stmt->execute();
        }
        $stmt->close();
    }

    // Redirecionar para a página principal (index.php) após o registro
    header("Location: ../index.php");
    exit();
}

// Selecionar todas as receitas para exibir na lista com checkbox
$result = $conn->query("SELECT id, nome FROM receitas");

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Livro</title>
    <link rel="stylesheet" href="../css/stylesLivros.css">
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
        <a href="#">Funcionários</a>
    </nav>
    <div class="user-area">
        <span>Usuário</span>
        <a href="../index.php" class="logout">Sair</a>
    </div>
</header>


<main>
    <h1>Registrar Novo Livro</h1>

    <!-- Container do formulário -->
    <div class="form-container">
        <form action="registro_livro.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="titulo">Título do Livro:</label>
                <input type="text" id="titulo" name="titulo" required>
            </div>

            <div class="form-group">
                <label for="isbn">ISBN:</label>
                <input type="text" id="isbn" name="isbn" pattern="\d{13}" title="ISBN deve ter 13 dígitos">
            </div>

            <div class="form-group">
                <label for="descricao">Descrição:</label>
                <textarea id="descricao" name="descricao" rows="4" placeholder="Escreva uma descrição para o livro"></textarea>
            </div>

            <div class="form-group">
                <label for="imagem">Imagem do Livro:</label>
                <input type="file" id="imagem" name="imagem" accept="image/*">
            </div>

            <!-- Botões e Barra de Busca -->
            <div class="action-bar">
                <button type="submit" class="register-btn">Salvar Livro</button>
                <input type="text" id="buscar-receita" placeholder="Buscar receita..." onkeyup="filtrarReceitas()">
            </div>

            <!-- Lista de receitas com checkbox -->
            <table>
                <thead>
                    <tr>
                        <th></th>
                        <th>Receita</th>
                    </tr>
                </thead>
                <tbody id="receitas-lista">
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><input type="checkbox" name="receitas[]" value="<?php echo $row['id']; ?>"></td>
                            <td><?php echo htmlspecialchars($row["nome"]); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </form>
    </div>
</main>

