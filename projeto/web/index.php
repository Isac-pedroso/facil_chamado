<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="../css/index.css" rel="stylesheet">
    <link href="../css/header-index.css" rel="stylesheet">
    <script src="../js/index.js"></script>
</head>
<body>
    <?php require_once("header-index.php"); ?> 
    <div class="tela-inicial">
        <div class="plano-fundo"></div>
        <div class="info-tela-inicial">
            <h1>Bem vindo!</h1>
            <div>
            <p>O seu sistema de controle de Ordem de Serviço.</p>
            <a href="funcionalidades.php" class="btn btn-primary" id="btn_continuar">Funcionalidades</a>
            <a href="instrucoes.php" class="btn btn-primary" id="btn_continuar">Instruções</a>
            </div>
        </div>
    </div>
</body>
</html>