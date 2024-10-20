<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Inicial - Receitas</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="logo">Logo</div>
        <div class="menu-icon" onclick="toggleMenu()">&#9776;</div>
        <nav>
            <a href="#">Receitas</a>
            <a href="#">Livros</a>
        </nav>
        <div class="search-bar">
            <input type="text" placeholder="Pesquisar...">
        </div>
        <div class="user-area">
            <a href="./projetoads.view/colaborador_inicial.php">Aba do colaborador</a>
            <a href="./projetoads.view/login.php">Login</a>
        </div>
    </header>

    <div class="menu" id="side-menu">
        <ul>
            <li><a href="index.php">Página Inicial</a></li>
            <li class="toggle" onclick="toggleSubmenu('submenu-tipos')">Tipos de pratos</li>
            <ul id="submenu-tipos" class="submenu">
                <?php
                    $tipos = ['Tortas', 'Bolos', 'Doces e sobremesas', 'Carnes', 'Massas', 'Saladas', 'Peixes e Frutos do mar'];
                    foreach ($tipos as $tipo) {
                        echo "<li><a href='#'>{$tipo}</a></li>";
                    }
                ?>
            </ul>
            <br> <a href="index.php">Voltar</a>
        </ul>
    </div>

    <div class="content">
        <div class="arrows">
            <button>&larr;</button>
            <h1>Recomendações</h1>
            <button>&rarr;</button>
        </div>
        <div class="section-title">Recomendação de livros</div>
        <div class="recommendations">
            <div class="item">Livro 1</div>
            <div class="item">Livro 2</div>
            <div class="item">Livro 3</div>
            <div class="item">Livro 4</div>
            <div class="item">Livro 5</div>
            <div class="item">Livro 6</div>
        </div>
        <div class="section-title">Recomendação de receitas</div>
        <div class="recommendations">
            <div class="item">Receita 1</div>
            <div class="item">Receita 2</div>
            <div class="item">Receita 3</div>
            <div class="item">Receita 4</div>
            <div class="item">Receita 5</div>
            <div class="item">Receita 6</div>
        </div>
    </div>

    <script src="scripts.js"></script>
</body>
</html>
