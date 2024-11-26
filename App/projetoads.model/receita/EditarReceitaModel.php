<?php
class ReceitaModel {
    private $conn;

    public function __construct($host, $user, $password, $database) {
        $this->conn = new mysqli($host, $user, $password, $database);
        if ($this->conn->connect_error) {
            die("Falha na conexão: " . $this->conn->connect_error);
        }
    }

    public function getReceitaById($id) {
        $sql = "SELECT * FROM receitas WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            die("Erro ao preparar consulta: " . $this->conn->error);
        }

        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $receita = $result->fetch_assoc();
        $stmt->close();

        return $receita ?: null;
    }

    public function getCategorias() {
        $result = $this->conn->query("SELECT id, nome_categoria FROM categorias");

        if (!$result) {
            error_log("Erro ao buscar categorias: " . $this->conn->error);
            die("Erro ao buscar categorias.");
        }

        return $result;
    }

    public function atualizarReceita($id, $dados, $imagemBlob = null) {
        if ($imagemBlob) {
            $sql = "UPDATE receitas SET nome=?, categoria=?, opiniao_degustador=?, ingredientes=?, modo_preparo=?, descricao=?, numero_porcoes=?, nome_cozinheiro=?, nome_degustador=?, imagem_receita=? WHERE id=?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param(
                "ssssssssssi",
                $dados['nome'], $dados['categoria'], $dados['opiniao_degustador'], $dados['ingredientes'],
                $dados['modo_preparo'], $dados['descricao'], $dados['numero_porcoes'], $dados['nome_cozinheiro'],
                $dados['nome_degustador'], $imagemBlob, $id
            );
            $stmt->send_long_data(9, $imagemBlob);
        } else {
            $sql = "UPDATE receitas SET nome=?, categoria=?, opiniao_degustador=?, ingredientes=?, modo_preparo=?, descricao=?, numero_porcoes=?, nome_cozinheiro=?, nome_degustador=? WHERE id=?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param(
                "sssssssssi",
                $dados['nome'], $dados['categoria'], $dados['opiniao_degustador'], $dados['ingredientes'],
                $dados['modo_preparo'], $dados['descricao'], $dados['numero_porcoes'], $dados['nome_cozinheiro'],
                $dados['nome_degustador'], $id
            );
        }

        $executado = $stmt->execute();
        if (!$executado) {
            error_log("Erro ao atualizar receita: " . $stmt->error);
        }

        $stmt->close();
        return $executado;
    }
}
