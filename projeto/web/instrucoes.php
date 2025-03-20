<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instruções</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <link href="../css/instrucoes.css" rel="stylesheet">
    <link href="../css/header-index.css" rel="stylesheet">
    <script src="../js/index.js"></script>
</head>

<body>
    <?php require_once("header-index.php"); ?>
    <div class="principal">
        <div class="conteudo-principal" id="funcionalidades">
            <div class="titulo-conteudo">
                <h1>Instruções</h1>
            </div>
            <div id="conteudo-funcionalidades">
                <div class="container">
                    <div class="section">
                        <h2>Abrir Chamado</h2>
                        <ul>
                            <li><b>Botão "Nova OS":</b> Gera uma nova Ordem de Serviço.</li>
                            <li><b>Tipo Incidente:</b> Selecionar o tipo de incidente da Ordem de Serviço.</li>
                            <li><b>Status:</b> O status já irá ficar como "Aberto".</li>
                            <li><b>Descrição:</b> Campo para inserir os detalhes da abertura do chamado.</li>
                            <li><b>Conclusão:</b> Inserir uma breve conclusão.</li>
                            <li><b>Contatos:</b> Inserir pelo menos um contato.</li>
                            <li><b>Anexos:</b> Inserir pelo menos um anexo.</li>
                        </ul>
                    </div>

                    <div class="section">
                        <h2>Aba Contatos</h2>
                        <ul>
                            <li><b>Botão "Adicionar":</b> Abre tela para cadastro de novo contato.</li>
                            <li>Todos os campos de contato são obrigatórios.</li>
                            <li><b>Nome:</b> Preencher o nome do contato.</li>
                            <li><b>Número:</b> Preencher o número do contato.</li>
                            <li><b>Botão "Salvar":</b> Salva o novo contato na Ordem de Serviço.</li>
                            <li><b>Botão "Voltar":</b> Fecha a tela de cadastro de contato.</li>
                            <li>Ao inserir um novo contato, ele irá para a aba de contatos salvos.</li>
                            <li>Para cada contato:
                                <ul>
                                    <li><b>Botão "Editar" (ícone de lápis):</b> Abre tela para edição de contato.</li>
                                    <li><b>Botão "Excluir" (ícone de lixeira):</b> Exclui o contato da Ordem de Serviço.
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>

                    <div class="section">
                        <h2>Aba Anexos</h2>
                        <ul>
                            <li><b>Clicar no campo de anexos:</b> Para adicionar um novo anexo.</li>
                            <li>Ao clicar no campo, escolha um anexo dentro do seu computador.</li>
                            <li>Apenas anexos de imagens são permitidos.</li>
                            <li>Selecionando o anexo, ele já será salvo na aba de anexos.</li>
                            <li>Para cada anexo:
                                <ul>
                                    <li><b>Botão "Excluir" (ícone de "X"):</b> Exclui o anexo da Ordem de Serviço.</li>
                                </ul>
                            </li>
                        </ul>
                    </div>

                    <div class="section">
                        <h2>Aba Timeline</h2>
                        <p>Na aba Timeline, todas as alterações feitas na Ordem de Serviço serão registradas
                            automaticamente.</p>
                    </div>
                </div>
            </div>
        </div>
</body>

</html>