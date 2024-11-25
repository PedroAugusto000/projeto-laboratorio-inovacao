<?php
class ColaboradorModel {
    private $conn;

    public function __construct($host, $user, $password, $database) {
        $this->conn = new mysqli($host, $user, $password, $database);
        if ($this->conn->connect_error) {
            die("Falha na conexão: " . $this->conn->connect_error);
        }
    }

    public function registrarColaborador($dados) {
        $sql = "INSERT INTO Colaboradores (nome, nome_fantasia, funcao, rg, data_ingresso, salario, referencias) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param(
            'sssssss',
            $dados['nome'],
            $dados['nome_fantasia'],
            $dados['funcao'],
            $dados['rg'],
            $dados['data_ingresso'],
            $dados['salario'],
            $dados['referencias']
        );
        return $stmt->execute();
    }
}
