<?php
session_start();
if (!$_SESSION['logado']) {
    header('Location: login.php');
}
?>
<div class="header">
    <h1><a href="relacao-os.php" style="text-decoration:none; color:white;">FÁCIL CHAMADO</a></h1>
    <div class="header-direita">
        <div class="header-direita-conteudo">
            <a href="nova-os.php" class="btn-header" id="btn-nova-os">Nova O.S</a>
            <a href="relacao-os.php" class="btn-header" id="btn-relacao-os">Relação de O.S</a>
            <div class="dados-usuario">
                <a href="" id="name-user"><?php echo ($_SESSION['user']['nome']) ?></a>
                <a id="deslogar">Deslogar</a>
            </div>
        </div>
    </div>
</div>
<div class="prefeitura-nome" id="prefeitura-nome">
</div>