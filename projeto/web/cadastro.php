<?php

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.5.js"></script>
    <script src="../js/cadastro.js"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.0/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script type="text/javascript" src="http://ajax.microsoft.com/ajax/jquery/jquery-1.5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="../js/jquery.mask.js"></script>
    <link href="../css/cadastro.css" rel="stylesheet">
    <link href="../css/header-index.css" rel="stylesheet">
    <title>Document</title>
</head>

<body>
    <!-- Header de usuario -->
    <?php require_once("header-index.php") ?>
    <div class="conteudo-principal">
        <div class="info-sistema">
            <div class="info-conteudo">
                <h1>FÁCIL CHAMADO</h1>
                <h1>Bem vindo!</h1>
                <p>O seu sistema de controle de Ordem de Serviço.<br>Caso já tenha cadastro, se logue abaixo !</p>
            </div>
            <a href="login.php" class="btn btn-primary">Login</a>
        </div>
        <!-- Conteudo da tela de cadastro -->
        <div class="conteudo-cadastro">
            <!-- Form para coletar dados de cadastro -->
            <form id="frm-cadastro" method="POST" action="../app/controller/UserController.php">
                <!-- Titulo de cadastro -->
                <h1 style="text-align:center;">CADASTRO</h1>
                <!-- Campo de coleta do nome -->
                <div class="form-group w100 mb-2" id="nomeDiv">
                    <label for="nome">Nome Completo</label>
                    <input type="text" id="nome" name="nome" placeholder="Meu Nome" class="form-control">
                    <div id="nomeError" class="msgError"></div>
                </div>
                <!-- Campo da data de nascimento -->
                <div class="form-group w100 mb-2" id="dtNascimentoDiv">
                    <label for="dt_nascimento">Data Nascimento</label>
                    <input type="date" id="dt_nascimento" name="dt_nascimento" placeholder="Senha" class="form-control">
                    <div id="dtNascimentoError" class="msgError"></div>
                </div>
                <!-- Campo de email -->
                <div class="form-group w100 mb-2">
                    <label for="email">Email</label>
                    <input type="text" id="email" name="email" placeholder="teste@gmail.com" class="form-control">
                    <div id="emailError" class="msgError"></div>
                </div>
                <!-- Campo de telefone -->
                <div class="form-group w100 mb-2">
                    <label for="telefone">Telefone</label>
                    <input type="text" id="telefone" name="telefone" placeholder="(48) 00000-0000" class="form-control">
                    <div id="telefoneError" class="msgError"></div>
                </div>
                <!-- Campo de whatsapp -->
                <div class="form-group w100 mb-2">
                    <label for="whatsapp">Whatsapp</label>
                    <input type="text" id="whatsapp" name="whatsapp" placeholder="(48) 00000-0000" class="form-control">
                    <div id="whatsappError" class="msgError"></div>
                </div>
                <!-- Campo de estado -->
                <div class="form-group w100 mb-2">
                    <label for="estado">Estado</label>
                    <select name="estado" id="estado" class="form-select w-100" style="float:right;"
                        onchange="listarCidades()">
                        <option value="#">Vazio</option>
                    </select>
                </div>
                <!-- Campo de cidade -->
                <div class="form-group w100 mb-2">
                    <label for="cidade">Cidade</label>
                    <select name="cidade" id="cidade" class="form-select w-100" style="float:right;">
                        <option value="#">Vazio</option>
                    </select>
                </div>
                <!-- Campo de senha -->
                <div class="form-group w100 mb-2">
                    <label for="senha">Senha</label>
                    <input type="password" id="senha" name="senha" placeholder="******" class="form-control">
                    <div id="senhaError" class="msgError"></div>
                </div>
                <!-- Campo de confirmação da senha -->
                <div class="form-group w100 mb-2">
                    <label for="confirm_senha">Confirmação de Senha</label>
                    <input type="password" id="confirm_senha" name="confirm_senha" placeholder="******"
                        class="form-control">
                    <div id="confirmSenhaError" class="msgError"></div>
                </div>
                <!-- Botão para efetuar o cadastro -->
                <div class="btn-logar">
                    <button class="btn btn-primary w100 h100" id="btn_enviar" type="submit"
                        name="cadastrar">Cadastrar</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        // Lista as cidades de determinado estado
        const listarCidades = function () {
            const idEstado = document.querySelector("#estado").value;
            $.ajax({
                url: "../json/Cidades.json",
                type: "GET",
                dataType: "json",
                success: function (response) {
                    $("#cidade").empty();
                    for (i = 0; i < response.length; i++) {
                        if (response[i].Estado == idEstado) {
                            $("#cidade").append($(`<option value='${response[i].ID}'>${response[i].Nome}</option>`));
                        }
                    }
                }
            })
        }
    </script>
</body>

</html>