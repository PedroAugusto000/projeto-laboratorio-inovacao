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
        $result = $this->conn->query($sql);

        if (!$result) {
            die("Erro ao buscar categorias: " . $this->conn->error);
        }

        return $result;
    }

    // Método para buscar colaboradores por função
    public function getColaboradoresPorFuncao($funcao) {
        $sql = "SELECT nome FROM colaboradores WHERE funcao = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $funcao);
        $stmt->execute();
        $result = $stmt->get_result();
        $colaboradores = [];
        while ($row = $result->fetch_assoc()) {
            $colaboradores[] = $row['nome'];
        }
        return $colaboradores;
    }

    public function cadastrarReceita($dados, $imagemBlob) {
        $sql = "INSERT INTO receitas 
                (nome, categoria, opiniao_degustador, ingredientes, modo_preparo, descricao, numero_porcoes, nome_cozinheiro, nome_degustador, imagem_receita) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            die("Erro ao preparar consulta: " . $this->conn->error);
        }

        $stmt->bind_param(
            "sssssssssb",
            $dados['nome'], $dados['categoria'], $dados['opiniao_degustador'], $dados['ingredientes'],
            $dados['modo_preparo'], $dados['descricao'], $dados['numero_porcoes'], $dados['nome_cozinheiro'],
            $dados['nome_degustador'], $imagemBlob
        );

        if ($imagemBlob) {
            $stmt->send_long_data(9, $imagemBlob);
        }

        $executado = $stmt->execute();

        if (!$executado) {
            error_log("Erro ao cadastrar receita: " . $stmt->error);
        }

        $stmt->close();
        return $executado;
    }
}


