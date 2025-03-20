<?php

session_start();
if (isset($_SESSION['logado'])) {
    if ($_SESSION['logado']) {
        header('location: index.php');
    }
}

?>
<div class="header">
    <h1><a href="index.php" style="text-decoration:none; color:white;">FÁCIL CHAMADO</a></h1>
    <div class="header-direita">
        <div class="header-direita-conteudo">
            <a href="index.php">Home</a>
            <a href="login.php">Login / Registrar</a>
        </div>
    </div>
</div>