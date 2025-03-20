<?php

class Conexaobd{
    
    private $username = 'root';
    private $senha = '';
    public static $conn;

    private function __construction(){

    }
    public static function getConexao(){
        try{
            self::$conn = new PDO('mysql:host=localhost; dbname=facil_chamado', 'root', 'Isacao@12');
            //self::$conn = new PDO('mysql:host=localhost; dbname=facil_chamado', 'root', '');
            self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$conn->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_EMPTY_STRING);

            return self::$conn;  
        }catch(PDOException $e){
            echo 'ERROR: '. $e->getMessage();
        }
    }
}
/*$conn = new Conexaobd();
$sql = "INSERT INTO usuario (id,nome,email,telefone,whatsapp,dt_nascimento)
            VALUES (2, 'teste', 'teste', 'teste', 'teste', 'teste')";
$prepare = $conn->getConexao()->prepare($sql);
$prepare->execute();*/



?>