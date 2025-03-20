<?php

class User{
    private $id;
    private $nome;
    private $dt_nascimento;
    private $email;
    private $telefone;
    private $whatsapp;
    private $senha;
    private $email_confirm;
    private $cdEmailConfirm;
    private $id_estado;
    private $id_cidade;

    public function __construct(){
        $this->email_confirm = 0;
    }

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

    function setDtNascimento($dt_nascimento){
        $this->dt_nascimento = $dt_nascimento;
    }
    function getDtNascimento(){
        return $this->dt_nascimento;
    }
    function setEmail($email){
        $this->email = $email;
    }
    function getEmail(){
        return $this->email;
    }
    
    function setTelefone($telefone){
        $this->telefone = $telefone;
    }
    function getTelefone(){
        return $this->telefone;
    }
    
    function setWhatsapp($whatsapp){
        $this->whatsapp = $whatsapp;
    }
    function getWhatsapp(){
        return $this->whatsapp;
    }

    function setSenha($senha){
        $this->senha = $senha;
    }
    function getSenha(){
        return $this->senha;
    }
    function setCdEmailConfirm($cdEmailConfirm){
        $this->cdEmailConfirm = $cdEmailConfirm;
    }
    function getCdEmailConfirm(){
        return $this->cdEmailConfirm;
    }
    function setEmailConfirm($email_confirm){
        $this->email_confirm = $email_confirm;
    }
    function getEmailConfirm(){
        return $this->email_confirm;
    }
    function setIdEstado($id_estado){
        $this->id_estado = $id_estado;
    }
    function getIdEstado(){
        return $this->id_estado;
    }
    function setIdCidade($id_cidade){
        $this->id_cidade = $id_cidade;
    }
    function getIdCidade(){
        return $this->id_cidade;
    }
}


?>