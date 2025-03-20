$(document).ready(function () {
  $("#descricao").summernote({
    height: 200,
  });
  // Carrega codigo da nova Ordem de Serviço
  carregaCdOrdemServico();
  function carregaCdOrdemServico() {
    $.ajax({
      url: "../app/controller/OrdemServicoController.php",
      type: "GET",
      data: "&acao=carregaId",
      dataType: "json",
      success: function (response) {
        const id = parseInt(response.id)+1;
        $("#codigo-os").val(id);
      },
    });
  }
  // Carrega todos os tipos de incidentes cadastrados no banco de dados
  carregaTiposIncidente();
  function carregaTiposIncidente() {
    $.ajax({
      url: "../app/controller/TipoIncidenteController.php",
      type: "GET",
      data: "&acao=listar",
      dataType: "json",
      success: function (response) {
        response.forEach(function (itens) {
          $("#tp_incidente").append(
            $(`<option value="${itens.id}">${itens.nome}</option>`)
          );
        });
      },
    });
  }

  // Adiciona ao botão do Header a class selecionado, visualmente deixando o botão ativado
  addBtnSelecionadoHeader();
  function addBtnSelecionadoHeader() {
    const div = document.querySelector("#btn-nova-os");
    div.classList.remove("btn-header");
    div.classList.add("btn-header-selecionado");
  }

  // Variavel Externa para guardar os Anexos
  const dt = new DataTransfer();
  const base64Codes = [];

  // Valida Anexo
  const validaAnexo = function (anexo) {
    var type = anexo.type;
    if (type == "image/png" || type == "image/jpeg" || type == "image/jpg") {
      return true;
    } else {
      return false;
    }
  };
  // Manipulação dos dados dos Anexos
  $("#anexos").change(function () {
    // Adiciona os anexos para a ordem de serviço
    for (let i = 0; i < this.files.length; i++) {
      if (validaAnexo(this.files[i])) {
        var reader = new FileReader();
        var nome = this.files[i].name;
        reader.readAsDataURL(this.files[i]);
        reader.onloadend = function () {
          typeof reader.result;
          base64Codes.push({ nome: nome, code: reader.result });
        };
        $(".todos-anexos").append(
          $(
            `<span class="anexo"><span id="deleteAnexo">X</span><span class="nome">${this.files[i].name}</span></span>`
          )
        );
      } else {
        alert("Tipo de arquivo não permitido !");
      }
    }
    /* Adiciona os anexos na variavel externa */
    /* Pára cada arquivo do input Adiciona os anexos na variavel externa */
    for (let file of this.files) {
      if (validaAnexo(file)) {
        dt.items.add(file);
      }
    }
    /* Adiciona os anexos colocados na variavel externa no input files */
    this.files = dt.files;

    /* Deleta o anexo expecifico */
    $("span#deleteAnexo").click(function () {
      let name = $(this).next("span.nome").text();
      $(this).parent().remove();
      for (var i = 0; i < dt.items.length; i++) {
        if (name === dt.items[i].getAsFile().name) {
          dt.items.remove(i);
          if (i == 0) {
            base64Codes.splice(0, 1);
          } else {
            base64Codes.splice(i, i);
          }
        }
      }
      document.getElementById("anexos").files = dt.files;
    });
  });

  /* VALIDAÇÕES DE CAMPOS DA ORDEM DE SERVIÇO */
  const validaCampos = [false, false, false, false, true];
  // Valida campo Tipo de incidente
  const validaTpIncidente = function () {
    const input = $("#tp_incidente").val();
    if (input == "#") {
      // Nenhum tipo selecionado
      addMsgError("<p>Nenhum tipo selecionado !</p>", "tpIncidenteError");
      addIsInValid("tp_incidente");
      addFalseValidaCampos(0);
      return false;
    } else {
      limpaMsgErro("tpIncidenteError");
      addIsValid("tp_incidente");
      addTrueValidaCampos(0);
      return true;
    }
  };
  // Valida campo descrição do problema
  const validaDescricao = function () {
    const input = $("#descricao").val();
    if (!input) {
      addMsgError("<p>Nenhum valor na Descrição !</p>", "descricaoError");
      addFalseValidaCampos(1);
    } else {
      if (input == "<p><br></p>") {
        addMsgError("<p>Nenhum valor na Descrição !</p>", "descricaoError");
        addFalseValidaCampos(1);
      } else {
        limpaMsgErro("descricaoError");
        addTrueValidaCampos(1);
      }
    }
  };
  // Valida campo observação
  const validaObservacao = function () {
    const input = $("#observacao").val();

    if (!input) {
      addIsInValid("observacao");
      addMsgError("<p>Nenhum valor na Observação !</p>", "observacaoError");
      addFalseValidaCampos(2);
    } else {
      addIsValid("observacao");
      limpaMsgErro("observacaoError");
      addTrueValidaCampos(2);
    }
  };
  // Valida os contatos cadastrados
  const validaContatos = function () {
    if (contatosOs.length == 0) {
      addMsgError("<p>Nenhum contato dadastrado !</p>", "contatoError");
      addFalseValidaCampos(3);
    } else {
      limpaMsgErro("contatoError");
      addTrueValidaCampos(3);
    }
  };
  // Adiciona True no array validaCampos
  const addTrueValidaCampos = function (idNumero) {
    validaCampos[idNumero] = true;
  };

  // Adiciona False no array validaCampos
  const addFalseValidaCampos = function (idNumero) {
    validaCampos[idNumero] = false;
  };

  $("#frm-ordem-servico").submit(function (e) {
    e.preventDefault();
    validaTpIncidente();
    validaDescricao();
    validaObservacao();
    validaContatos();

    var descricao = $("#descricao").val().replace(/<\/p>/g, '\n').replace(/<p>/g, '');
    var observacao = $("#observacao").val();
    var tp_incidente = $("#tp_incidente").val();
    if (
      validaCampos[0] == true &&
      validaCampos[1] == true &&
      validaCampos[2] == true &&
      validaCampos[3] == true &&
      validaCampos[4] == true
    ) {
      $.ajax({
        url: "../app/controller/OrdemServicoController.php",
        type: "POST",
        data: {
          //anexos: new ArrayBuffer(dt.files),
          descricao: descricao,
          observacao: observacao,
          tp_incidente: tp_incidente,
          anexosBase64: base64Codes,
          contatos: contatosOs,
          acao: "cadastrar",
        },
        beforeSend: function () {
          $("#tela-carregamento").append(
            $(`<div class="tela-carregamento-envio">
          <div class="spinner-border text-primary" role="status" style="padding:40px;"></div><span style="font-size:2em; padding-top: 30px; padding-left:15px; color:black;">Carregando...</span>
      </div>`)
          );
        },
        success: function (response) {
          console.log(response);
          const object = JSON.parse(response);
          try {
            if (object.code == 200) {
              alert("Mensagem: " + object["msg"]);
              window.location.href =
                "../web/ordem-servico.php?id=" + object.idOs;
            } else {
              alert(object.msg);
            }
          } catch (error) {
            console.log(response);
          }
        },
      });
    }
  });
});
// Valida se o numero de telefone atende aos requisitos do sistema
const validaTelefoneContato = function () {
  if (validaInputEspecificoVazio("telefone_contato")) {
    input = criarInputComId("telefone_contato").value.replace(/\D+/g, "");
    if (input.length < 11) {
      console.log("Numero de Telefone errado !", input);
      limpaMsgErro("telefoneContatoError");
      addMsgError(
        "<p class='msgTelefoneContatoAtivo'>Telefone invalido.</p",
        "telefoneContatoError"
      );
      addIsInValid("telefone_contato");
      return false;
    } else {
      if (/[0-9]/gm.test(input)) {
        limpaMsgErro("telefoneContatoError");
        addIsValid("telefoneContatoError");
        return true;
      }
    }
  } else {
    limpaMsgErro("telefoneError");
  }
};
// Valida input nome;
const validaNome = function () {
  input = criarInputComId("nm_contato");
  if (!validaInputEspecificoVazio("nm_contato")) {
    limpaMsgErro("nomeError");
    return false;
  }
  if (!input.value == "' or ' '='") {
    addIsInValid("nm_contato");
    limpaMsgErro("nomeContatoError");
    addMsgError(
      "<p>Não permitido caracteres Especiais</p>",
      "nomeContatoError"
    );
    return false;
  }
  if (/[^0-9A-Za-z\ ]/.test(input.value)) {
    addIsInValid("nm_contato");
    limpaMsgErro("nomeContatoError");
    addMsgError(
      "<p>Não permitido caracteres Especiais</p>",
      "nomeContatoError"
    );
    return false;
  }
  addIsValid("nm_contato");
  limpaMsgErro("nomeContatoError");
  return true;
};
// Valida se o input especifico esta vazio
const validaInputEspecificoVazio = function (inputId) {
  input = criarInputComId(inputId);
  if (!input.value) {
    return false;
  }
  return true;
};
// Retorna o input pelo id desejado
const criarInputComId = function (id) {
  return document.getElementById(id);
};
// Adiciona mensagem de erro
const addMsgError = function (msg, divNome) {
  $(`#${divNome}`).empty();
  $(`#${divNome}`).append(msg);
};
// Limpa a mensagem de erro
const limpaMsgErro = function (divNome) {
  $(`#${divNome}`).empty();
};
// Adiciona a classe Is-valid para o input
const addIsValid = function (inputId) {
  input = criarInputComId(inputId);
  input.classList.remove("is-invalid");
  input.classList.add("is-valid");
};
// Adiciona a classe Is-InValid para o input
const addIsInValid = function (inputId) {
  input = criarInputComId(inputId);
  input.classList.remove("is-valid");
  input.classList.add("is-invalid");
};
// Adiciona anexos na OS

// Objeto armazena os Contatos salvos na ordem de serviço
const contatosOs = [];
// Abre tela de cadastro de contato
const abrirCadastroContato = function () {
  // Adiciona borda no cadastro do contato
  const divCadContato = document.querySelector(".cad-contato");
  divCadContato.classList.add("b-b");
  $(".cad-contato").empty();
  $(".cad-contato").append(
    $(`<div class="form-group campos-cad-contato">
                            <label for="telefone">Nome:</label>
                            <input type="text" id="nm_contato" name="telefone" placeholder="Nome" class="form-control">
                            <div id="nomeContatoError" class="msgError"></div>
                        </div>
                        <div class="form-group campos-cad-contato">
                            <label for="telefone">Telefone:</label>
                            <input type="text" id="telefone_contato" name="telefone" placeholder="(00) 00000-0000"
                                class="form-control" style="width:180px;">
                            <div id="telefoneContatoError" class="msgError"></div>
                        </div>
                        <div class="btns-cad-contato">
                          <div class="salvar-cad" style="margin-right:5px;">
                              <a class="btn btn-primary" onclick="salvarContato()">Salvar</a>
                          </div>
                          <div class="voltar-cad">
                              <a class="btn btn-primary" onclick="fecharCadastroContato()">voltar</a>
                          </div>
                        </div>`)
  );
  $("#telefone_contato").mask("(00) 00000-0000");
};
// Salva o contato na Ordem de Serviço
const salvarContato = function () {
  // Testes de inputs do Contato
  const inputs = [false, false];
  if (criarInputComId("nm_contato").value) {
    if (!validaNome()) {
      inputs[0] = false;
    } else {
      inputs[0] = true;
      addIsValid("nm_contato");
    }
  } else {
    addIsInValid("nm_contato");
    inputs[0] = false;
  }

  if (criarInputComId("telefone_contato").value) {
    if (!validaTelefoneContato()) {
      inputs[1] = false;
    } else {
      inputs[1] = true;
      addIsValid("telefone_contato");
    }
  } else {
    addIsInValid("telefone_contato");
    inputs[1] = false;
  }
  // Se os campos de cadastro do contato estiverem corretos, irá salvar o contato na OS
  if (inputs[0] == true && inputs[1] == true) {
    var qtd_contatos = contatosOs.length;
    $(".quantidade-contatos").empty();
    $(".quantidade-contatos").append(
      $(
        `<input type="text" disabled="true" value="${
          qtd_contatos + 1
        }" class="qtd-contatos" style="margin-left: 0px;" id="qtd_contatos">`
      )
    );
    contatosOs.push({
      nome: criarInputComId("nm_contato").value,
      numero: criarInputComId("telefone_contato").value.replace(/\D+/g, ""),
    });
    listarContatos();
  }
};
// Abrir tela de editar contato já Salvos na OS
const abrirEditarContato = function (idContato) {
  const divCadContato = document.querySelector(".cad-contato");
  divCadContato.classList.add("b-b");
  // console.log(contatosOs);
  $(".cad-contato").empty();
  $(".cad-contato").append(
    $(`<div class="form-group campos-cad-contato">
                            <label for="telefone">Nome:</label>
                            <input type="text" id="nm_contato" name="telefone" placeholder="Nome" class="form-control" value="${contatosOs[idContato].nome}">
                            <div id="nomeContatoError" class="msgError"></div>
                        </div>
                        <div class="form-group campos-cad-contato">
                            <label for="telefone">Telefone:</label>
                            <input type="text" id="telefone_contato" name="telefone" placeholder="(00) 00000-0000"
                                class="form-control" style="width:180px;" value="${contatosOs[idContato].numero}">
                            <div id="telefoneContatoError" class="msgError"></div>
                        </div>
                        <div class="btns-cad-contato">
                          <div class="salvar-cad" style="margin-right:5px;">
                              <a class="btn btn-primary" onclick="salvarContatoEditado(${idContato})">Editar</a>
                          </div>
                          <div class="voltar-cad">
                              <a class="btn btn-primary" onclick="fecharCadastroContato()">voltar</a>
                          </div>
                        </div>`)
  );
  $("#telefone_contato").mask("(00) 00000-0000");
};
// Salva o contato editado
const salvarContatoEditado = function (idContato) {
  console.log(criarInputComId("telefone_contato").value.replace(/\D+/g, ""));
  contatosOs[idContato] = {
    nome: criarInputComId("nm_contato").value,
    numero: criarInputComId("telefone_contato").value.replace(/\D+/g, ""),
  };
  listarContatos();
};
// Deletar contato salvo na OS
const deletarContato = function (idContato) {
  if (idContato == 0) {
    contatosOs.splice(0, 1);
  }
  contatosOs.splice(idContato, idContato);
  listarContatos();
};
// Listar Todos contatos salvos
const listarContatos = function () {
  $(".todos-contatos").empty();
  contatosOs.forEach(function (contato, index) {
    $(".todos-contatos").append(
      $(`<div class="contato">
                            <div class="contato-dados">
                                <label for="nome-contato">${contato.nome}</label>
                                <div class="numero-contato">
                                    <!-- Desativado - para Edição -->
                                    <!-- Ativado -->
                                    <input class="input-ativado" type="text" disabled="true" value="${contato.numero}">
                                </div>
                            </div>
                            <div class="contato-config">
                                <div class="btn-contato">
                                    <a><img src="../img/icons/edit.png" alt="" onclick="abrirEditarContato(${index})"></a>
                                </div>
                                <div class="btn-contato">
                                    <a><img src="../img/icons/remove.png" alt="" onclick="deletarContato(${index})"></a>
                                </div>
                            </div>
                        </div>`)
    );
  });
};
// Fecha tela de cadastro de contato
const fecharCadastroContato = function () {
  const divCadContato = document.querySelector(".cad-contato");
  divCadContato.classList.remove("b-b");
  $(".cad-contato").empty();
};
// Fechar Tela Ordem de Serviço
const fecharTelaOs = function () {
  $($(".conteudo_telas")).empty();
};
