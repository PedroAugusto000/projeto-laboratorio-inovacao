<?php
class LivroModel {
    private $conn;

    public function __construct($host, $user, $password, $database) {
        $this->conn = new mysqli($host, $user, $password, $database);
        if ($this->conn->connect_error) {
            die("Falha na conexão: " . $this->conn->connect_error);
        }
    }

    public function cadastrarLivro($titulo, $isbn, $descricao, $imagemBlob) {
        $stmt = $this->conn->prepare("INSERT INTO livros (titulo, isbn, descricao, imagem) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssb", $titulo, $isbn, $descricao, $imagemBlob);
        $stmt->send_long_data(3, $imagemBlob);
        $stmt->execute();
        $livroId = $stmt->insert_id;
        $stmt->close();
        return $livroId;
    }

    public function vincularReceitas($livroId, $receitasSelecionadas) {
        $stmt = $this->conn->prepare("INSERT INTO livros_receitas (livro_id, receita_id) VALUES (?, ?)");
        foreach ($receitasSelecionadas as $receitaId) {
            $stmt->bind_param("ii", $livroId, $receitaId);
            $stmt->execute();
        }
        $stmt->close();
    }

    public function listarReceitas() {
        return $this->conn->query("SELECT id, nome FROM receitas");
    }
}
