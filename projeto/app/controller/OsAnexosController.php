<?php

include_once "../Model/Anexos.php";
include_once "../dao/AnexosDAO.php";

$osAnexosDAO = new AnexosDAO();

$acao = $_REQUEST['acao'];
if ($acao == 'listar') {
    if (isset($_POST['id_os'])) {
        $id_os = $_POST['id_os'];
    }
    if (isset($_REQUEST['id_os'])) {
        $id_os = $_REQUEST['id_os'];
    }
    $osAnexos = new Anexos();
    $osAnexos->setIdOrdemServico($id_os);
    echo json_encode($osAnexosDAO->listar($osAnexos));
}
if($acao == 'buscarPorId'){
    $osAnexos = new Anexos();
    $osAnexos->setId($_POST['id']);
    $osAnexos->setIdOrdemServico($_POST['id_os']);
    echo json_encode($osAnexosDAO->buscarPorId($osAnexos));
}
?>