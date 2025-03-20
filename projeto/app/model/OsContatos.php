<?php

class OsContatos{
    private $id;
    private $id_ordem_servico;
    private $nome;
    private $numero;

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
    function getNome(){
        return $this->nome;
    }
    function setNome($nome){
        $this->nome = $nome;
    }
    function getNumero(){
        return $this->numero;
    }
    function setNumero($numero){
        $this->numero = $numero;
    }
}

?>