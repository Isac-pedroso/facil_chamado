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
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.0/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script type="text/javascript" src="http://ajax.microsoft.com/ajax/jquery/jquery-1.5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <script src="../js/jquery.mask.js"></script>
    <script src="../js/relacao-os.js"></script>
    <script src="../js/header-user.js"></script>
    <link href="../css/relacao-os.css" rel="stylesheet">
    <link href="../css/header-user.css" rel="stylesheet">
    <title>Relação de OS</title>
</head>

<body>
<div id="tela-carregamento"></div>
    <?php require_once('header-user.php'); ?>
    <div class="principal">
        <div class="relacao-os">
            <div class="filtros">
                <div class="conteudo-filtros">
                    <div class="titulo-filtros">
                        <h1>Filtros:</h1>
                    </div>
                    <div class="pesquisar">
                        <label for="">Ordem de Serviço:</label>
                        <div class="campo-os">
                            <div class="codigo-os">
                                <div class="titulo-os">
                                    <span>O.S</span>
                                </div>
                                <input type="text" class="form-control" value="" id="codigo-os">
                                <a id="buscar_os" class="btn btn-primary" style="margin-left:5px;"><i
                                        class="bi bi-search"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="inputs-select">
                        <div class="campo-tipo-incidente">
                            <label for="tipo-incidente">Tipo de incidente:</label>
                            <select class="form-control" name="tipo-incidente" id="tp_incidente">
                                <option value="all" selected>Todos</option>
                            </select>
                        </div>
                        <div class="campo-status">
                            <label for="status">Status:</label>
                            <select class="form-control" name="status" id="status">
                                <option value="all">Todos</option>
                                <option value="1" selected>Aberto</option>
                                <option value="2">Fechado</option>
                            </select>
                        </div>
                    </div>
                    <div class="btn-pesquisar-filtros">
                        <button id="pesquisar" class="btn btn-primary" style="margin-left:5px;"><i
                                class="bi bi-search"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="ordem-servicos-relacao">
        </div>
    </div>
</body>

</html>