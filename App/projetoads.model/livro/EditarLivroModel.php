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
        $stmt = $this->conn->prepare("SELECT receita_id FROM livros_receitas WHERE livro_id = ?");
        $stmt->bind_param("i", $livroId);
        $stmt->execute();
        $result = $stmt->get_result();
        $receitas = [];
        while ($row = $result->fetch_assoc()) {
            $receitas[] = $row['receita_id'];
        }
        $stmt->close();
        return $receitas;
    }

    public function getReceitas() {
        $result = $this->conn->query("SELECT id, nome FROM receitas");
        if (!$result) {
            die("Erro ao buscar receitas: " . $this->conn->error);
        }
        return $result;
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
        if (!$stmt->execute()) {
            error_log("Erro ao atualizar livro ID $livroId: " . $stmt->error);
        }
        $stmt->close();
    }

    public function atualizarReceitasLivro($livroId, $receitasSelecionadas) {
        $stmtDelete = $this->conn->prepare("DELETE FROM livros_receitas WHERE livro_id = ?");
        $stmtDelete->bind_param("i", $livroId);
        $stmtDelete->execute();
        $stmtDelete->close();

        if (!empty($receitasSelecionadas)) {
            $stmtInsert = $this->conn->prepare("INSERT INTO livros_receitas (livro_id, receita_id) VALUES (?, ?)");
            foreach ($receitasSelecionadas as $receitaId) {
                $stmtInsert->bind_param("ii", $livroId, $receitaId);
                if (!$stmtInsert->execute()) {
                    error_log("Erro ao vincular receita ID $receitaId ao livro ID $livroId: " . $stmtInsert->error);
                }
            }
            $stmtInsert->close();
        }
    }
}
