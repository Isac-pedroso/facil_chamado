<?php
class OrdemServico{
    private $id;
    private $id_usuario;
    private $tp_incidente;
    private $stt_os;
    private $descricao;
    private $observacao;
    public function __construct(){
        $this->stt_os = 1;
    }
    function getId(){
        return $this->id;
    }
    function setId($id){
        $this->id = $id;
    }
    function getIdUsuario(){
        return $this->id_usuario;
    }
    function setIdUsuario($id_usuario){
        $this->id_usuario = $id_usuario;
    }
    function getTpIncidente(){
        return $this->tp_incidente;
    }
    function setTpIncidente($tp_incidente){
        $this->tp_incidente = $tp_incidente;
    }
    function getSttOs(){
        return $this->stt_os;
    }
    function setSttOs($stt_os){
        $this->stt_os = $stt_os;
    }
    function getDescricao(){
        return $this->descricao;
    }
    function setDescricao($descricao){
        $this->descricao = $descricao;
    }
    function getObservacao(){
        return $this->observacao;
    }
    function setObservacao($observacao){
        $this->observacao = $observacao;
    }
}

?>