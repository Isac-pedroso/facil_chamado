<?php

include_once "../config/database/Conexaobd.php";
include_once "../model/OsTimeline.php";

class OsTimelineDAO{
    public function create(OsTimeline $osTimeline){
        $conn = new Conexaobd();
        $sql = "INSERT INTO os_timeline (id, id_usuario, id_ordem_servico, mensagem, data)
               VALUES (null, :id_usuario, :id_ordem_servico, :mensagem, :data)";
        $commit = $conn->getConexao()->prepare($sql);
        $commit->bindValue(":id_usuario", $osTimeline->getIdUsuario());
        $commit->bindValue(":id_ordem_servico", $osTimeline->getIdOrdemServico());
        $commit->bindValue(":mensagem", $osTimeline->getMensagem());
        $commit->bindValue(":data", $osTimeline->getData());
        if($commit->execute()){
            return true;
        }else{
            return false;
        }
    }
    public function listar(OsTimeline $osTimeline){
        $conn = new Conexaobd();   
        $sql = "SELECT t.id, u.nome, t.id_ordem_servico, t.mensagem, t.data FROM os_timeline t
                INNER JOIN usuario u ON t.id_usuario = u.id
                WHERE id_ordem_servico = :id_ordem_servico";
        $commit= $conn->getConexao()->prepare($sql);
        $commit->bindValue(":id_ordem_servico", $osTimeline->getIdOrdemServico());
        $commit->execute();
        $response = $commit->fetchAll(PDO::FETCH_ASSOC);

        $dadosTimeLine = array();

        foreach($response as $itens){
            array_push($dadosTimeLine, 
                [
                    'id'=>$itens['id'],
                    'nm_usuario'=>$itens['nome'],
                    'id_ordem_servico'=> $itens['id_ordem_servico'],
                    'mensagem'=>$itens['mensagem'],
                    'data'=>$itens['data']
                ]);
        }
        return $dadosTimeLine;
    }
}

?>