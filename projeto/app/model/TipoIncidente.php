<?php
class TipoIncidente{
    private $id;
    private $nome;
    function setId($id){
        $this->id = $id;
    }
    function getId(){
        return $this->id;
    }
    
    function setNome($nome){
        $this->nome = $nome;
    }
    function getNome(){
        return $this->nome;
    }   
}
?>