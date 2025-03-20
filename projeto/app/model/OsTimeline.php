<?php

class OsTimeline{

    private $id;
    private $id_usuario;
    private $id_ordem_servico;
    private $mensagem;
    private $data;
    
    function getId(){
        return $this->id;
    }
    function setId($id){
        $this->id = $id;
    }
    function getIdOrdemServico(){
        return $this->id_ordem_servico;
    }
    function setIdOrdemServico($id_ordem_servico){
        $this->id_ordem_servico = $id_ordem_servico;
    }
    function getIdUsuario(){
        return $this->id_usuario;
    }
    function setIdUsuario($id_usuario){
        $this->id_usuario = $id_usuario;
    }
    function getMensagem(){
        return $this->mensagem;
    }
    function setMensagem($mensagem){
        $this->mensagem = $mensagem;
    }
    function getData(){
        return $this->data;
    }
    function setData($data){
        $this->data = $data;
    }

}

?>