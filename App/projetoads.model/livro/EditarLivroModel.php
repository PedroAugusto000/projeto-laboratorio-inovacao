<?php
class LivroModel {
    private $conn;

    public function __construct($host, $user, $password, $database) {
        $this->conn = new mysqli($host, $user, $password, $database);
        if ($this->conn->connect_error) {
            die("Falha na conexão: " . $this->conn->connect_error);
        }
    }

    public function getLivroById($livroId) {
        $stmt = $this->conn->prepare("SELECT titulo, isbn, imagem FROM livros WHERE id = ?");
        $stmt->bind_param("i", $livroId);
        $stmt->execute();
        $result = $stmt->get_result();
        $livro = $result->fetch_assoc();
        $stmt->close();
        return $livro;
    }

    public function getReceitasByLivroId($livroId) {
        $receitas = [];
        $result = $this->conn->query("SELECT receita_id FROM livros_receitas WHERE livro_id = $livroId");
        while ($row = $result->fetch_assoc()) {
            $receitas[] = $row['receita_id'];
        }
        return $receitas;
    }

    public function getReceitas() {
        return $this->conn->query("SELECT id, nome FROM receitas");
    }

    public function atualizarLivro($livroId, $titulo, $isbn, $imagemBlob = null) {
        if ($imagemBlob) {
            $stmt = $this->conn->prepare("UPDATE livros SET titulo = ?, isbn = ?, imagem = ? WHERE id = ?");
            $stmt->bind_param("ssbi", $titulo, $isbn, $imagemBlob, $livroId);
            $stmt->send_long_data(2, $imagemBlob);
        } else {
            $stmt = $this->conn->prepare("UPDATE livros SET titulo = ?, isbn = ? WHERE id = ?");
            $stmt->bind_param("ssi", $titulo, $isbn, $livroId);
        }
        $stmt->execute();
        $stmt->close();
    }

    public function atualizarReceitasLivro($livroId, $receitasSelecionadas) {
        $this->conn->query("DELETE FROM livros_receitas WHERE livro_id = $livroId");
        if (!empty($receitasSelecionadas)) {
            $stmt = $this->conn->prepare("INSERT INTO livros_receitas (livro_id, receita_id) VALUES (?, ?)");
            foreach ($receitasSelecionadas as $receitaId) {
                $stmt->bind_param("ii", $livroId, $receitaId);
                $stmt->execute();
            }
            $stmt->close();
        }
    }
}
