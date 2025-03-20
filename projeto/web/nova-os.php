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
    <script src="../js/jquery.mask.js"></script>
    <script src="../js/header-user.js"></script>
    <script src="../js/nova-os.js"></script>
    <link href="../css/header-user.css" rel="stylesheet">
    <link href="../css/nova-os.css" rel="stylesheet">
    <title>Nova Ordem de Serviço</title>
</head>

<body>
    <div id="tela-carregamento"></div>
    <?php require_once('header-user.php'); ?>
    <div class="principal">
        <div class="conteudo-nova-os">
            <form id="frm-ordem-servico" method="POST" enctype="multipart/form-data">
                <div class="cabecalho-os">
                    <!-- Salvar Ordem de Serviço -->
                    <div class="salvar-os">
                        <button class="btn btn-primary" id="salvar_os" type="submit">Salvar OS</button>
                    </div>
                    <div class="cabecalho-os-topo">
                        <!-- Codigo da Ordem de Serviço -->
                        <div class="codigo-os">
                            <div class="titulo-os">
                                <span>O.S</span>
                            </div>
                            <input type="text" class="form-control" value="" id="codigo-os" required disabled="true">
                        </div>
                    </div>
                    <div class="cabecalho-os-meio">
                        <!-- Tipo incidente -->
                        <div class="tipo-incidente">
                            <label for="tp_incidente">Tipo incidente:</label>
                            <select class="form-select" id="tp_incidente" name="tp_incidente" required>
                                <option value="#" selected>Tipo Incidente</option>
                            </select>
                            <div id="tpIncidenteError" class="msgError"></div>
                        </div>
                        <!-- Status da Ordem de Serviço -->
                        <div class="status-os">
                            <label for="stt_os">Status:</label>
                            <select class="form-select" id="stt_os" disabled="true">
                                <option value="1" selected>Aberta</option>'
                            </select>
                        </div>
                        <!-- Descrição do problema -->
                        <div class="descricao-problema">
                            <label for="desc_problema">Descrição do problema:</label>
                            <!--<textarea name="desc_problema" id="" class="form-control"></textarea>-->
                            <!-- <div id="descricao"></div> -->
                            <textarea name="descricao" id="descricao"></textarea>
                            <div id="descricaoError" class="msgError"></div>
                        </div>
                        <!-- Observação -->
                        <div class="observacao">
                            <label for="observacao">Observação:</label>
                            <textarea name="observacao" id="observacao" class="form-control"></textarea>
                            <div id="observacaoError" class="msgError"></div>
                        </div>
                        <!--Lista de contatos Telefonicos (1 ou Mais) Contendo o nome da pessoa -->
                        <div class="contatos">
                            <label for="contatos">Contatos:</label>
                            <div class="opcoes-contatos">
                                <a class="btn btn-primary" id="cad_contatos" type="submit" name="cadastrar_contato"
                                    onclick="abrirCadastroContato()">Adicionar</a>
                                <p>Quantidade: </p>
                                <div class="quantidade-contatos">

                                </div>
                                <div id="contatoError" class="msgError"></div>
                            </div>
                            <!-- Cadastro de contato -->
                            <div class="cad-contato">

                            </div>
                            <!-- Lista dos Contatos já cadastrados -->
                            <div class="todos-contatos">

                            </div>
                        </div>
                        <div class="anexos">
                            <label for="anexos">Anexos:</label>
                            <!-- Cadastro de contato -->
                            <div class="cad-anexos">
                                <input class="form-control form-control-lg" type="file" name="anexos[]" id="anexos"
                                    multiple required>
                            </div>
                            <!-- Lista dos Contatos já cadastrados -->
                            <div class="todos-anexos">

                            </div>
                        </div>
                        <div class="timeline panel-group">
                            <div class="panel panel-default">
                                <div class="titulo-timeline panel-heading">
                                    <h1 class="panel-title"><a data-toggle="collapse"
                                            href="#dados-timeline">Timeline:</a></h1>
                                </div>
                                <div class="dados-timeline panel-collapse collapse" id="dados-timeline">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
            </form>
            <!-- Footer da Tela da Nova OS-->
            <div class="footer-nova-os">

            </div>
        </div>
    </div>
    <script src="../js/nova-os.js"></script>
</body>

</html>