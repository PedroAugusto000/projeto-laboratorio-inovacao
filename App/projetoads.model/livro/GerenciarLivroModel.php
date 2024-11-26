<?php

class LivroModel {
    private $conn;

    public function __construct($host, $user, $password, $database) {
        $this->conn = new mysqli($host, $user, $password, $database);
        if ($this->conn->connect_error) {
            die("Falha na conexão: " . $this->conn->connect_error);
        }
    }

    public function buscarLivros($termoBusca = '') {
        $query = "SELECT id, isbn, titulo FROM livros";
        if (!empty($termoBusca)) {
            $query .= " WHERE titulo LIKE ? OR isbn LIKE ?";
            $stmt = $this->conn->prepare($query);
            $termoBusca = '%' . $termoBusca . '%';
            $stmt->bind_param("ss", $termoBusca, $termoBusca);
            $stmt->execute();
            return $stmt->get_result();
        }
        return $this->conn->query($query);
    }

    public function deletarLivro($id) {
        $stmt = $this->conn->prepare("DELETE FROM livros WHERE id = ?");
        if (!$stmt) {
            die("Erro ao preparar a consulta: " . $this->conn->error);
        }
        $stmt->bind_param("i", $id);
        if (!$stmt->execute()) {
            error_log("Erro ao deletar livro ID $id: " . $stmt->error);
        }
        $stmt->close();
    }
}
