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
        if (!$stmt) {
            die("Erro ao preparar consulta: " . $this->conn->error);
        }

        $stmt->bind_param("sssb", $titulo, $isbn, $descricao, $imagemBlob);
        if ($imagemBlob) {
            $stmt->send_long_data(3, $imagemBlob);
        }
        if (!$stmt->execute()) {
            if ($this->conn->errno == 1062) { // Código de erro para chave duplicada
                throw new Exception("O ISBN já está registrado no sistema.");
            }
            throw new Exception("Erro ao cadastrar livro: " . $stmt->error);
        }

        $livroId = $stmt->insert_id;
        $stmt->close();
        return $livroId;
    }

    public function vincularReceitas($livroId, $receitasSelecionadas) {
        $stmt = $this->conn->prepare("INSERT INTO livros_receitas (livro_id, receita_id) VALUES (?, ?)");
        if (!$stmt) {
            die("Erro ao preparar consulta: " . $this->conn->error);
        }

        foreach ($receitasSelecionadas as $receitaId) {
            $stmt->bind_param("ii", $livroId, $receitaId);
            if (!$stmt->execute()) {
                error_log("Erro ao vincular receita $receitaId ao livro $livroId: " . $stmt->error);
            }
        }
        $stmt->close();
    }

    public function listarReceitas() {
        $result = $this->conn->query("SELECT id, nome FROM receitas");
        if (!$result) {
            error_log("Erro ao buscar receitas: " . $this->conn->error);
            return null;
        }
        return $result;
    }
}
