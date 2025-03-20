<?php

include_once "../Model/TipoIncidente.php";
include_once "../dao/TipoIncidenteDAO.php";

$tipoIncidente = new TipoIncidente();
$tipoIncidenteDAO = new TipoIncidenteDAO();

//$acao = $_REQUEST['acao'];
$acao = "listar";
// Listar tipos de incidentes
if($acao == "listar"){
    echo json_encode( $tipoIncidenteDAO->listar());
}


?>