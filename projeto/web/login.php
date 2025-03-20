<?php

if (isset($_SESSION['logado'])) {
    if ($_SESSION['logado']) {
        header('location: timeline.php');
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.5.js"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.0/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script type="text/javascript" src="http://ajax.microsoft.com/ajax/jquery/jquery-1.5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="../js/login.js"></script>
    <link href="../css/header-index.css" rel="stylesheet">
    <link href="../css/login.css" rel="stylesheet">
</head>

<body>
    <?php require_once("header-index.php") ?>
    <div class="conteudo-principal">

        <div class="info-sistema">
            <div class="info-conteudo">
                <h1>FÁCIL CHAMADO</h1>
                <h1>Bem vindo!</h1>
                <p">O seu sistema de controle de Ordem de Serviço.<br>Se cadastre abaixo !</p>
            </div>
            <a href="cadastro.php" class="btn btn-primary">Cadastrar-se</a>
        </div>
        <div class="conteudo-login">
            <form method="POST" id="frm-login">
                <h1 style="text-align:center;">LOGIN</h1>
                <div class="form-group w100">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" placeholder="teste@gmail.com" class="form-control">
                    <div id="emailError" class="msgError"></div>
                </div>
                <div class="form-group w100">
                    <label for="email">Senha</label>
                    <input type="password" name="senha" id="senha" placeholder="Senha" class="form-control">
                    <div id="senhaError" class="msgError"></div>
                </div>
                <div class="btn-logar">
                    <div id="sistemaError" class="msgError"></div>
                    <button class="btn btn-primary w100 h100" id="logar">Login</button>
                    <p><a href="">Esqueceu a senha ?</a></p>
                </div>
            </form>
        </div>
    </div>
</body>

</html>