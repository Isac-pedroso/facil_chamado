<?php

include_once "../model/OsTimeline.php";
include_once "../dao/OsTimelineDAO.php";

$osTimelineDAO = new OsTimelineDAO();
$acao = $_REQUEST['acao'];
if($acao == 'listar'){
    $osTimeline = new OsTimeline();
    $osTimeline->setIdOrdemServico($_POST['id_os']);

    echo json_encode($osTimelineDAO->listar($osTimeline));
}

?>
