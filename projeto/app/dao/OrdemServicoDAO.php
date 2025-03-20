<?php

include_once "../config/database/Conexaobd.php";
include_once "../controller/OrdemServicoController.php";
include_once "../Model/OrdemServico.php";

class OrdemServicoDAO extends Conexaobd
{
    public function create(OrdemServico $ordemServico)
    {

        try {
            $conn = $this->getConexao();
            $sql = "INSERT INTO ordem_servico (id, id_usuario, tp_incidente, stt_os, descricao, observacao)
                VALUE (null, :id_usuario, :tp_incidente, :stt_os, :descricao, :observacao)";
            $commit = $conn->prepare($sql);
            $commit->bindValue(":id_usuario", $ordemServico->getIdUsuario());
            $commit->bindValue(":tp_incidente", $ordemServico->getTpIncidente());
            $commit->bindValue(":stt_os", $ordemServico->getSttOs());
            $commit->bindValue(":descricao", $ordemServico->getDescricao());
            $commit->bindValue(":observacao", $ordemServico->getObservacao());

            if ($commit->execute()) {
                $ordemServico->setId($conn->lastInsertId());
                return true;
            }
        } catch (Exception $e) {
            return false;
        }
    }
    public function update(OrdemServico $ordemServico)
    {
        $conn = new Conexaobd();
        $sql = "UPDATE ordem_servico SET tp_incidente = :tp_incidente, stt_os = :stt_os, descricao = :descricao, observacao = :observacao WHERE id = :id";
        $commit = $conn->getConexao()->prepare($sql);
        $commit->bindValue(":id", $ordemServico->getId());
        $commit->bindValue(":tp_incidente", $ordemServico->getTpIncidente());
        $commit->bindValue(":stt_os", $ordemServico->getSttOs());
        $commit->bindValue(":descricao", $ordemServico->getDescricao());
        $commit->bindValue(":observacao", $ordemServico->getObservacao());

        if ($commit->execute()) {
            return true;
        } else {
            return false;
        }

    }
    public function delete($idOrdemServico)
    {
        $conn = new Conexaobd();
        $sql = "DELETE FROM ordem_servico WHERE id = :id";
        $commit = $conn->getConexao()->prepare($sql);
        $commit->bindValue(":id", $idOrdemServico);
        if ($commit->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public function buscarPorId(OrdemServico $ordemServico)
    {
        try {
            $conn = new Conexaobd();
            $sql = "SELECT * FROM ordem_servico WHERE id = :id";
            $commit = $conn->getConexao()->prepare($sql);
            $commit->bindValue(":id", $ordemServico->getId());
            $commit->execute();
            if ($commit->fetch(PDO::FETCH_ASSOC)) {
                return true;
            } else {
                throw new Exception("Ordem de servico não localizada !");
            }
        } catch (Exception $e) {
            echo json_encode(
                [
                    'msg' => $e->getMessage(),
                    'code' => 400,
                ]
            );
            return false;
        }
    }
    public function buscarDadosPorId(OrdemServico $ordemServico)
    {
        $conn = new Conexaobd();
        $sql = "SELECT os.id, os.id_usuario, ti.nome, os.stt_os, os.descricao, os.observacao
                FROM ordem_servico os 
                INNER JOIN tipo_incidente ti ON os.tp_incidente = ti.id WHERE os.id = :id AND os.id_usuario = :id_usuario";
        $commit = $conn->getConexao()->prepare($sql);
        $commit->bindValue(":id", $ordemServico->getId());
        $commit->bindValue(":id_usuario", $ordemServico->getIdUsuario());
        $commit->execute();
        return $commit->fetch(PDO::FETCH_ASSOC);
    }
    public function filtrarTodos(OrdemServico $ordemServico)
    {
        $conn = new Conexaobd();
        $sql = 'SELECT os.id, os.id_usuario, ti.nome, os.stt_os, os.descricao, os.observacao
                FROM ordem_servico os
                INNER JOIN tipo_incidente ti ON os.tp_incidente = ti.id WHERE tp_incidente = :tp_incidente AND stt_os = :stt_os AND id_usuario = :id_usuario';
        $commit = $conn->getConexao()->prepare($sql);
        $commit->bindValue(':id_usuario', $ordemServico->getIdUsuario());
        $commit->bindValue(':tp_incidente', $ordemServico->getTpIncidente());
        $commit->bindValue(':stt_os', $ordemServico->getSttOs());
        $commit->execute();
        return $commit->fetchAll(PDO::FETCH_ASSOC);
    }
    public function filtrarPorTp(OrdemServico $ordemServico)
    {
        $conn = new Conexaobd();
        $sql = 'SELECT os.id, os.id_usuario, ti.nome, os.stt_os, os.descricao, os.observacao
                FROM ordem_servico os
                INNER JOIN tipo_incidente ti ON os.tp_incidente = ti.id WHERE tp_incidente = :tp_incidente AND id_usuario = :id_usuario';
        $commit = $conn->getConexao()->prepare($sql);
        $commit->bindValue(':id_usuario', $ordemServico->getIdUsuario());
        $commit->bindValue(':tp_incidente', $ordemServico->getTpIncidente());
        $commit->execute();
        return $commit->fetchAll(PDO::FETCH_ASSOC);
    }
    public function filtrarPorStt(OrdemServico $ordemServico)
    {
        $conn = new Conexaobd();
        $sql = 'SELECT os.id, os.id_usuario, ti.nome, os.stt_os, os.descricao, os.observacao
                FROM ordem_servico os
                INNER JOIN tipo_incidente ti ON os.tp_incidente = ti.id WHERE stt_os = :stt_os AND id_usuario = :id_usuario';
        $commit = $conn->getConexao()->prepare($sql);
        $commit->bindValue(':id_usuario', $ordemServico->getIdUsuario());
        $commit->bindValue(':stt_os', $ordemServico->getSttOs());
        $commit->execute();
        return $commit->fetchAll(PDO::FETCH_ASSOC);
    }
    public function listar(OrdemServico $ordemServico)
    {
        $conn = new Conexaobd();
        $sql = 'SELECT os.id, os.id_usuario, ti.nome, os.stt_os, os.descricao, os.observacao
                FROM ordem_servico os
                INNER JOIN tipo_incidente ti ON os.tp_incidente = ti.id WHERE id_usuario = :id_usuario';
        $commit = $conn->getConexao()->prepare($sql);
        $commit->bindValue(':id_usuario', $ordemServico->getIdUsuario());
        $commit->execute();
        return $commit->fetchAll(PDO::FETCH_ASSOC);
    }
    public function listarPorId(OrdemServico $ordemServico)
    {
        $conn = new Conexaobd();
        $sql = "SELECT * FROM ordem_servico WHERE id = :id";
        $commit = $conn->getConexao()->prepare($sql);
        $commit->bindValue(":id", $ordemServico->getId());
        $commit->execute();
        return $commit->fetch(PDO::FETCH_ASSOC);
    }
    public function carregaId()
    {
        $conn = new Conexaobd();
        $sql = "SELECT id FROM ordem_servico order by id DESC LIMIT 1";
        $commit = $conn->getConexao()->query($sql);
        return $commit->fetch();
    }
}

?>