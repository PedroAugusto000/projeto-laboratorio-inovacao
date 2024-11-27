<?php
class ColaboradorModel {
    private $conn;

    public function __construct($host, $user, $password, $database) {
        $this->conn = new mysqli($host, $user, $password, $database);
        if ($this->conn->connect_error) {
            die("Falha na conexão: " . $this->conn->connect_error);
        }
    }

    public function rgExiste($rg) {
        $sql = "SELECT id FROM Colaboradores WHERE rg = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('s', $rg);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }

    public function usuarioExiste($usuario) {
        $sql = "SELECT id FROM Login WHERE usuario = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('s', $usuario);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }

    public function registrarUsuario($usuario, $senha, $nivel_permissao) {
        $sql = "INSERT INTO Login (usuario, senha, nivel_permissao) VALUES (?, MD5(?), ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('sss', $usuario, $senha, $nivel_permissao);
        return $stmt->execute();
    }

    public function registrarColaborador($dados) {
        $this->conn->begin_transaction();

        try {
            // Inserir colaborador
            $sqlColaborador = "INSERT INTO Colaboradores (nome, nome_fantasia, funcao, rg, data_ingresso, salario, referencias) 
                               VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmtColaborador = $this->conn->prepare($sqlColaborador);
            $stmtColaborador->bind_param(
                'sssssss',
                $dados['nome'],
                $dados['nome_fantasia'],
                $dados['funcao'],
                $dados['rg'],
                $dados['data_ingresso'],
                $dados['salario'],
                $dados['referencias']
            );
            $stmtColaborador->execute();

            // Inserir usuário
            $this->registrarUsuario($dados['usuario'], $dados['senha'], $dados['nivel_permissao']);

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollback();
            error_log("Erro ao registrar colaborador: " . $e->getMessage());
            return false;
        }
    }
}
