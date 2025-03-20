<?php

include_once "../Model/OsContatos.php";
include_once "../config/database/Conexaobd.php";

class OsContatosDAO
{
    public function create(OsContatos $osContatos)
    {
        try {
            $conn = new Conexaobd();
            $sql = "INSERT INTO os_contatos (id, id_ordem_servico, nome, numero)
                VALUES (null, :id_ordem_servico, :nome, :numero)";
            $commit = $conn->getConexao()->prepare($sql);
            $commit->bindValue(":id_ordem_servico", $osContatos->getIdOrdemServico());
            $commit->bindValue(":nome", $osContatos->getNome());
            $commit->bindValue(":numero", $osContatos->getNumero());
            if ($commit->execute()) {
                return true;
            } else {
                throw new Exeption("Erro ao cadastrar contato !");
            }

        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }

    }
    public function delete(OsContatos $osContatos)
    {
        $conn = new Conexaobd();
        $sql = "DELETE FROM os_contatos WHERE id = :id";
        $commit = $conn->getConexao()->prepare($sql);
        $commit->bindValue(":id", $osContatos->getId());
        if ($commit->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public function update(OsContatos $osContatos)
    {
        $conn = new Conexaobd();
        $sql = "UPDATE os_contatos SET nome = :nome, numero = :numero WHERE id = :id";
        $commit = $conn->getConexao()->prepare($sql);
        $commit->bindValue(":id", $osContatos->getId());
        $commit->bindValue(":nome", $osContatos->getNome());
        $commit->bindValue(":numero", $osContatos->getNumero());
        if ($commit->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public function listar(OsContatos $osContatos)
    {
        $conn = new Conexaobd();
        $sql = "SELECT * FROM os_contatos WHERE id_ordem_servico = :id_ordem_servico";
        $commit = $conn->getConexao()->prepare($sql);
        $commit->bindValue(":id_ordem_servico", $osContatos->getIdOrdemServico());
        $commit->execute();
        $response = $commit->fetchAll(PDO::FETCH_ASSOC);
        return $response;
    }
}

?>