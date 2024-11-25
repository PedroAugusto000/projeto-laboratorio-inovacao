<?php
class ReceitaModel {
    private $conn;

    public function __construct($host, $user, $password, $database) {
        $this->conn = new mysqli($host, $user, $password, $database);
        if ($this->conn->connect_error) {
            die("Falha na conexão: " . $this->conn->connect_error);
        }
    }

    public function getCategorias() {
        $sql = "SELECT id, nome_categoria FROM categorias";
        return $this->conn->query($sql);
    }

    public function cadastrarReceita($dados, $imagemBlob) {
        $sql = "INSERT INTO receitas (nome, categoria, opiniao_degustador, ingredientes, modo_preparo, descricao, numero_porcoes, nome_cozinheiro, nome_degustador, imagem_receita) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param(
            "sssssssssb",
            $dados['nome'], $dados['categoria'], $dados['opiniao_degustador'], $dados['ingredientes'],
            $dados['modo_preparo'], $dados['descricao'], $dados['numero_porcoes'], $dados['nome_cozinheiro'],
            $dados['nome_degustador'], $imagemBlob
        );
        $stmt->send_long_data(9, $imagemBlob);
        return $stmt->execute();
    }
}
