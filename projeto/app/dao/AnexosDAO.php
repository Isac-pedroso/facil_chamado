<?php
include_once "../config/database/Conexaobd.php";
include_once "../Model/Anexos.php";


class AnexosDAO{
    public function create(Anexos $anexos){
        try{
            $conn = new Conexaobd();

            $sql = "INSERT INTO os_anexos (id, id_ordem_servico, nome, nm_code)
                    VALUES (null, :id_ordem_servico, :nome, :nm_code)";

            $commit = $conn->getConexao()->prepare($sql);
            $commit->bindValue(":id_ordem_servico", $anexos->getIdOrdemServico());
            $commit->bindValue(":nome", $anexos->getNome());
            $commit->bindValue(":nm_code", $anexos->getNmCode());

            if($commit->execute()){
                return true;
            }else{
                throw new Exception("Erro ao cadastrar o anexo !");
            }
        }catch(Exception $e){
            echo $e->getMessage();
            return false;
        }
    }
    public function delete(Anexos $anexos){
        $conn = new Conexaobd();;
        $sql = "DELETE FROM os_anexos WHERE id = :id";
        $commit = $conn->getConexao()->prepare($sql);
        $commit->bindValue(":id",$anexos->getId());
        if($commit->execute()){
            return true;
        }else{
            return false;
        }
    }
    public function listar(Anexos $anexos){
        $conn = new Conexaobd();
        $sql = "SELECT * FROM os_anexos WHERE id_ordem_servico = :id_ordem_servico";
        $commit = $conn->getConexao()->prepare($sql);
        $commit->bindValue(":id_ordem_servico", $anexos->getIdOrdemServico());
        $commit->execute();
        $response = $commit->fetchAll(PDO::FETCH_ASSOC);
        return $response;
    }

    public function buscarPorId(Anexos $anexos){
        $conn = new Conexaobd();
        $sql = "SELECT * FROM os_anexos WHERE id_ordem_servico = :id_ordem_servico AND id = :id";
        $commit = $conn->getConexao()->prepare($sql);
        $commit->bindValue(":id", $anexos->getId());
        $commit->bindValue(":id_ordem_servico", $anexos->getIdOrdemServico());
        $commit->execute();
        
        return $commit->fetch(PDO::FETCH_ASSOC);
    }
}

?>