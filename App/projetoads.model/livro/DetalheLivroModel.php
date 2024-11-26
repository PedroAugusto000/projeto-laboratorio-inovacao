<?php
class LivroModel {
    private $conn;

    public function __construct($host, $user, $password, $database) {
        $this->conn = new mysqli($host, $user, $password, $database);
        if ($this->conn->connect_error) {
            die("Falha na conexão: " . $this->conn->connect_error);
        }
    }

    public function getLivroById($id) {
        $stmt = $this->conn->prepare("SELECT titulo, isbn, descricao, imagem FROM livros WHERE id = ?");
        if (!$stmt) {
            error_log("Erro ao preparar consulta: " . $this->conn->error);
            return null;
        }
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $livro = $result->fetch_assoc();
        $stmt->close();
        return $livro;
    }

    public function getReceitasByLivroId($id) {
        $stmt = $this->conn->prepare("SELECT r.id, r.nome, r.ingredientes, r.modo_preparo FROM receitas r
                                      JOIN livros_receitas lr ON r.id = lr.receita_id
                                      WHERE lr.livro_id = ?");
        if (!$stmt) {
            error_log("Erro ao preparar consulta: " . $this->conn->error);
            return [];
        }
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $receitas = [];
        while ($row = $result->fetch_assoc()) {
            $receitas[] = $row;
        }
        $stmt->close();
        return $receitas;
    }
}
