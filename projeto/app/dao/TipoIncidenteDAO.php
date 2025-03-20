<?php

include_once "../config/database/Conexaobd.php";
include_once "../Model/TipoIncidente.php";

class TipoIncidenteDAO
{
    public function listar()
    {
        $conn = new Conexaobd();

        $sql = "SELECT * FROM tipo_incidente";
        $commit = $conn->getConexao()->query($sql);
        return $commit->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>