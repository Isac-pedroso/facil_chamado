<?php

include_once "../dao/OsContatosDAO.php";
include_once "../Model/OsContatos.php";

$osContatosDAO = new OsContatosDAO();
$acao = $_REQUEST['acao'];
//$acao = "listar";
if($acao == 'listar'){
    if(isset($_POST['id_os'])){
        $id_os = $_POST['id_os'];
    }
    if(isset($_REQUEST['id_os'])){
        $id_os = $_REQUEST['id_os'];
    }
    $osContatos = new OsContatos();
    $osContatos->setIdOrdemServico($id_os);
    echo json_encode($osContatosDAO->listar($osContatos));
}

?>