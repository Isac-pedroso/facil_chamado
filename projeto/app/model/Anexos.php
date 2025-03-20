<?php

class Anexos
{
    private $id;
    private $id_ordem_servico;
    private $nome;
    private $nm_code;
    function setId($id)
    {
        $this->id = $id;
    }
    function getId()
    {
        return $this->id;
    }
    function setIdOrdemServico($id_ordem_servico)
    {
        $this->id_ordem_servico = $id_ordem_servico;
    }
    function getIdOrdemServico()
    {
    return $this->id_ordem_servico;
    }
    function setNome($nome)
    {
        $this->nome = $nome;
    }
    function getNome()
    {
        return $this->nome;
    }
    
    function setNmCode($nm_code)
    {
        $this->nm_code = $nm_code;
    }
    function getNmCode()
    {
        return $this->nm_code;
    }

}

?>