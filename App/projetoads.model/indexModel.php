<?php

class IndexModel {
    private $conn;

    public function __construct($host, $user, $password, $database) {
        $this->conn = new mysqli($host, $user, $password, $database);
        if ($this->conn->connect_error) {
            die("Falha na conexão: " . $this->conn->connect_error);
        }
    }

    public function getReceitasRecomendadas($limite = 3) {
        $sql = "SELECT id, nome, imagem_receita FROM receitas ORDER BY id DESC LIMIT ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $limite);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function getLivrosRecomendados($limite = 3) {
        $sql = "SELECT id, titulo, imagem FROM livros ORDER BY id DESC LIMIT ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $limite);
        $stmt->execute();
        return $stmt->get_result();
    }
    
    public function getCategoriasComReceitas($limitePorCategoria = 3) {
        $sql = "SELECT r.id, r.nome, r.imagem_receita, c.nome_categoria 
                FROM receitas r
                JOIN categorias c ON r.categoria = c.id
                ORDER BY c.nome_categoria, r.id";
        $result = $this->conn->query($sql);
    
        $categorias_receitas = [];
        while ($row = $result->fetch_assoc()) {
            $categorias_receitas[$row['nome_categoria']][] = [
                'id' => $row['id'],
                'nome' => $row['nome'],
                'imagem_receita' => $row['imagem_receita'] // Adiciona a imagem
            ];
        }
    
        // Limita o número de receitas por categoria
        foreach ($categorias_receitas as $categoria => $receitas) {
            $categorias_receitas[$categoria] = array_slice($receitas, 0, $limitePorCategoria);
        }
    
        return $categorias_receitas;
    }

    // Método para buscar receitas com base no termo de pesquisa
    public function searchReceitas($searchTerm) {
        $searchTerm = $this->conn->real_escape_string($searchTerm); // Protege contra SQL Injection
        $sql = "SELECT id, nome, imagem_receita FROM receitas WHERE nome LIKE ? ORDER BY id DESC";
        $stmt = $this->conn->prepare($sql);
        $searchTerm = "%" . $searchTerm . "%";
        $stmt->bind_param("s", $searchTerm);
        $stmt->execute();
        return $stmt->get_result();
    }

    // Método para buscar livros com base no termo de pesquisa
    public function searchLivros($searchTerm) {
        $searchTerm = $this->conn->real_escape_string($searchTerm); // Protege contra SQL Injection
        $sql = "SELECT id, titulo, imagem FROM livros WHERE titulo LIKE ? ORDER BY id DESC";
        $stmt = $this->conn->prepare($sql);
        $searchTerm = "%" . $searchTerm . "%";
        $stmt->bind_param("s", $searchTerm);
        $stmt->execute();
        return $stmt->get_result();
    }
}
