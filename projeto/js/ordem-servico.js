$(document).ready(function () {
  // Renderiza campo descricao em summernote
  $("#descricao").summernote({
    height: 200,
  });
  // Id ordem serviço
  const params = new URLSearchParams(window.location.search);
  const idOs = params.get("id");
  var dadosOs = {};

  // Carrega codigo da nova Ordem de Serviço
  carregaCdOrdemServico();
  function carregaCdOrdemServico() {
    $("#codigo-os").val(idOs);
  }
  getDadosOs();

  function carregarDados(dadosOs) {
    if (parseInt(dadosOs.stt_os) == 2) {
      document.querySelector("#observacao").disabled = "true";
      $("#descricao").summernote("disable");
      document.querySelector("#tp_incidente").disabled = "true";
      document.querySelector("#stt_os").disabled = "true";
    }
    var tiposIncidentes = [];
    carregaTiposIncidente();
    carregaStatusOs();
    carregaDescricao();
    carregaObservacao();
    carregaContatos();
    carregaAnexos();
    carregaTimeLine();
    function carregaTiposIncidente() {
      $.ajax({
        url: "../app/controller/TipoIncidenteController.php",
        type: "GET",
        dataType: "json",
        success: function (response) {
          response.forEach(function (itens) {
            tiposIncidentes.push(itens);
            if (itens.id === dadosOs.tp_incidente) {
              $("#tp_incidente").append(
                $(
                  `<option value="${itens.id}" id="tpIncidenteId${itens.id}" selected>${itens.nome}</option>`
                )
              );
            } else {
              $("#tp_incidente").append(
                $(
                  `<option value="${itens.id}" id="tpIncidenteId${itens.id}">${itens.nome}</option>`
                )
              );
            }
          });
        },
      });
    }
    function carregaStatusOs() {
      if (dadosOs.stt_os == 1) {
        $("#stt_os").empty();
        $("#stt_os").append($('<option value="1" selected>Aberta</option>'));
        $("#stt_os").append($('<option value="2">Fechada</option>'));
        document.getElementById("stt_os").classList.add("stt_aberta");
      } else if (dadosOs.stt_os == 2) {
        $("#stt_os").empty();
        $("#stt_os").append($('<option value="2" selected>Fechada</option>'));
        document.getElementById("stt_os").classList.add("stt_fechada");
      }
    }
    function carregaDescricao() {
      $("#descricao").summernote("pasteHTML", dadosOs.descricao);
    }
    function carregaObservacao() {
      $("#observacao").val(dadosOs.observacao);
    }
    function carregaContatos() {
      $.ajax({
        url: "../app/controlLer/OsContatosController.php",
        type: "POST",
        data: { id_os: dadosOs.id, acao: "listar" },
        dataType: "json",
        success: function (response) {
          response.forEach(function (contato, index) {
            if (parseInt(dadosOs.stt_os) == 2) {
              $(".opcoes-contatos").empty;
              $(".contatos-da-os").append(
                $(`<div class="contato" id="contatoOs${contato.id}">
                            <div class="contato-dados">
                                <input class="input-ativado" type="text" id="nmContatoOsId${contato.id}" value="${contato.nome}">
                                <div class="numero-contato">
                                    <!-- Desativado - para Edição -->
                                    <!-- Ativado -->
                                    <input class="input-ativado" type="text" disabled="true" id="numeroContatoOsId${contato.id}" value="${contato.numero}">
                                </div>
                            </div>
                        </div>`)
              );
            } else if (parseInt(dadosOs.stt_os) == 1) {
              $(".contatos-da-os").append(
                $(`<div class="contato" id="contatoOs${contato.id}">
                            <div class="contato-dados">
                                <input class="input-ativado" type="text" id="nmContatoOsId${contato.id}" value="${contato.nome}">
                                <div class="numero-contato">
                                    <!-- Desativado - para Edição -->
                                    <!-- Ativado -->
                                    <input class="input-ativado" type="text" disabled="true" id="numeroContatoOsId${contato.id}" value="${contato.numero}">
                                </div>
                            </div>
                            <div class="contato-config">
                                <div class="btn-contato">
                                    <a><img src="../img/icons/edit.png" alt="" onclick="abrirEditarContato(${contato.id}, 1)"></a>
                                </div>
                                <div class="btn-contato">
                                    <a><img src="../img/icons/remove.png" alt="" onclick="deletarContato(${contato.id}, 1)"></a>
                                </div>
                            </div>
                        </div>`)
              );
            }
          });
        },
      });
    }
    function carregaAnexos() {
      $.ajax({
        url: "../app/controller/OsAnexosController.php",
        type: "POST",
        data: { id_os: dadosOs.id, acao: "listar" },
        dataType: "json",
        success: function (response) {
          if (parseInt(dadosOs.stt_os) == 2) {
            document.querySelector("#anexos").disabled = "true";
            response.forEach(function (anexo) {
              $(".anexos-da-os").append(
                $(
                  `<span class="anexo" id="anexoId${anexo.id}"><span class="nome" onclick="baixarAnexo(${anexo.id}, ${anexo.id_ordem_servico})">${anexo.nome}</span></span>`
                )
              );
            });
          } else if (parseInt(dadosOs.stt_os) == 1) {
            response.forEach(function (anexo) {
              $(".anexos-da-os").append(
                $(
                  `<span class="anexo" id="anexoId${anexo.id}"><span class="deleteAnexo" onclick="deletarAnexoOs(${anexo.id})">X</span><span class="nome" onclick="baixarAnexo(${anexo.id}, ${anexo.id_ordem_servico})">${anexo.nome}</span></span>`
                )
              );
            });
          }
        },
      });
    }
    function carregaTimeLine() {
      $.ajax({
        url: "../app/controller/OsTimelineController.php",
        type: "POST",
        data: { id_os: idOs, acao: "listar" },
        dataType: "json",
        success: function (response) {
          response.forEach(function (timeline) {
            $("#dados-timeline").append(
              $(`
                <div class="timeline-conteudo panel-body">
                  <p class="timeline-nome"><b>Nome: </b> ${timeline.nm_usuario}</p>
                  <p class="timeline-mensagem"><b>Mensagem: </b>${timeline.mensagem}
                  ${timeline.data}</p>
             </div>`)
            );
          });
        },
      });
    }
  }
  function getDadosOs() {
    $.ajax({
      url: "../app/controller/OrdemServicoController.php",
      type: "POST",
      data: { id: idOs, acao: "listarPorId" },
      dataType: "json",
      success: function (response) {
        dadosOs = response;
        carregarDados(dadosOs);
      },
    });
  }
  /* Salva/Atualiza a ordem de serviço */
  $("#frm-ordem-servico").submit(function (e) {
    e.preventDefault();
    var descricao = $("#descricao").val().replace(/<\/p>/g, '\n').replace(/<p>/g, '');
    var observacao = $("#observacao").val();
    var tp_incidente = $("#tp_incidente").val();
    var stt_os = $("#stt_os").val();
    if (parseInt(dadosOs.stt_os) == 2) {
      alert("Ordem de Serviço fechada. Impossivel salvar !");
    } else {
      $.ajax({
        url: "../app/controller/OrdemServicoController.php",
        type: "POST",
        data: {
          idOs: dadosOs.id,
          descricao: descricao,
          observacao: observacao,
          tp_incidente: tp_incidente,
          qtd_contatos: dadosOs.qtd_contatos,
          qtd_anexos: dadosOs.qtd_anexos,
          stt_os: stt_os,
          anexosBase64: base64Codes,
          anexosDeletados: anexosDeletados,
          contatos: contatosOs,
          contatosDeletados: contatosOsDeletados,
          contatosEditados: contatosOsEditados,
          acao: "update",
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
            if (object['code'] == 200) {
              alert(object["msg"]);
              window.location.href = "../web/ordem-servico.php?id=" + dadosOs.id;
            } else {
              alert(object["msg"]);
            }
          } catch (error) {
            console.log(response);
          }
        },
      });
    }
  });
  $("#buscar_os").click(function (e) {
    const id_os = $("#codigo-os").val();
    e.preventDefault();
    $.ajax({
      url: "../app/controller/OrdemServicoController.php",
      type: "POST",
      data: { id_os: id_os, acao: "buscarPorId" },
      beforeSend: function () {
        $("#tela-carregamento").append(
          $(`<div class="tela-carregamento-envio">
          <div class="spinner-border text-primary" role="status" style="padding:40px;"></div><span style="font-size:2em; padding-top: 30px; padding-left:15px; color:black;">Carregando...</span>
      </div>`)
        );
      },
      success: (response) => {
        const object = JSON.parse(response);
        try {
          if (object.code == 200) {
            window.location.href = "../web/ordem-servico.php?id=" + id_os;
          } else {
            alert("Mensagem: " + object.msg + " Code: " + object.code);
          }
        } catch (error) {
          console.log(response);
        }
      },
      complete: function () {
        $("#tela-carregamento").empty();
      },
    });
  });
  // Objetos gerencia midificações nos anexos
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
        $(".anexos-novos").append(
          $(
            `<span class="anexo"><span class="deleteAnexo" id="deleteAnexo">X</span><span class="nome">${this.files[i].name}</span></span>`
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
    $("span#deleteAnexoDaOs").click(function () {
      console.log("DELETE DA OS");
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
});
const anexosDeletados = [];
const deletarAnexoOs = function (id_anexo) {
  anexosDeletados.push({ id: id_anexo });
  $(`#anexoId${id_anexo}`).remove();
};

// Baixar o anexo já cadastrado na ordem de serviço
const baixarAnexo = function (id, idos) {
  console.log(id + "-" + idos);
  var teste = {};
  $.ajax({
    url: "../app/controller/OsAnexosController.php",
    type: "POST",
    data: { id: id, id_os: idos, acao: "buscarPorId" },
    dataType: "json",
    success: function (response) {
      const baixarPorLink = document.createElement("a");
      baixarPorLink.href = response.nm_code;
      baixarPorLink.download = response.nome;
      baixarPorLink.click();
    },
  });
};

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
// Objetos gerencia midificações nos contatos
const contatosOs = [];
const contatosOsDeletados = [];
const contatosOsEditados = [];
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
// Fecha tela de cadastro de contato
const fecharCadastroContato = function () {
  const divCadContato = document.querySelector(".cad-contato");
  divCadContato.classList.remove("b-b");
  $(".cad-contato").empty();
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
    listarContatos(2);
    console.log(contatosOs);
  }
};
// Abrir tela de editar contato já Salvos na OS
const abrirEditarContato = function (idContato, tipo) {
  if (tipo == 1) {
    const divCadContato = document.querySelector(".cad-contato");
    divCadContato.classList.add("b-b");
    $(".cad-contato").empty();
    $(".cad-contato").append(
      $(`<div class="form-group campos-cad-contato">
                            <label for="telefone">Nome:</label>
                            <input type="text" id="nm_contato" name="telefone" placeholder="Nome" class="form-control" value="${$(
                              `#nmContatoOsId${idContato}`
                            ).val()}">
                            <div id="nomeContatoError" class="msgError"></div>
                        </div>
                        <div class="form-group campos-cad-contato">
                            <label for="telefone">Telefone:</label>
                            <input type="text" id="telefone_contato" name="telefone" placeholder="(00) 00000-0000"
                                class="form-control" style="width:180px;" value="${$(
                                  `#numeroContatoOsId${idContato}`
                                ).val()}">
                            <div id="telefoneContatoError" class="msgError"></div>
                        </div>
                        <div class="btns-cad-contato">
                          <div class="salvar-cad" style="margin-right:5px;">
                              <a class="btn btn-primary" onclick="salvarContatoEditado(${idContato}, 1)">Editar</a>
                          </div>
                          <div class="voltar-cad">
                              <a class="btn btn-primary" onclick="fecharCadastroContato()">voltar</a>
                          </div>
                        </div>`)
    );
    $("#telefone_contato").mask("(00) 00000-0000");
  }
  if (tipo == 2) {
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
                              <a class="btn btn-primary" onclick="salvarContatoEditado(${idContato}, 2)">Editar</a>
                          </div>
                          <div class="voltar-cad">
                              <a class="btn btn-primary" onclick="fecharCadastroContato()">voltar</a>
                          </div>
                        </div>`)
    );
    $("#telefone_contato").mask("(00) 00000-0000");
  }
};
// Salva o contato editado
const salvarContatoEditado = function (idContato, tipo) {
  if (tipo == 1) {
    const nome = $(`#nm_contato`).val();
    const numero = $(`#telefone_contato`).val().replace(/\D+/g, "");
    contatosOsEditados.push({ id: idContato, nome: nome, numero: numero });
    $(`#nmContatoOsId${idContato}`).val(nome);
    $(`#numeroContatoOsId${idContato}`).val(numero);
    listarContatos(1);
  }
  if (tipo == 2) {
    contatosOs[idContato] = {
      nome: criarInputComId("nm_contato").value,
      numero: criarInputComId("telefone_contato").value.replace(/\D+/g, ""),
    };
    listarContatos(2);
  }
};
// Deletar contato salvo na OS
const deletarContato = function (idContato, tipo) {
  if (tipo == 1) {
    if (contatosOsEditados.length > 0) {
      contatosOsEditados.forEach((itens, index) => {
        if (itens.id == idContato) {
          if (index == 0) {
            contatosOsEditados.splice(0, 1);
          } else {
            contatosOsEditados.splice(index, index);
          }
          $(`#contatoOs${idContato}`).remove();
          contatosOsDeletados.push({ id_contato: idContato });
        }
      });
    } else {
      $(`#contatoOs${idContato}`).remove();
      contatosOsDeletados.push({ id_contato: idContato });
      console.log(contatosOsDeletados);
    }
  }
  if (tipo == 2) {
    if (idContato == 0) {
      contatosOs.splice(0, 1);
    }
    contatosOs.splice(idContato, idContato);
    listarContatos(2);
  }
};
// Listar Todos contatos salvos
const listarContatos = function (tipo) {
  if (tipo == 1) {
    contatosOs.forEach(function (contato, index) {
      $(".contatos-novos").append(
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
                                      <a><img src="../img/icons/edit.png" alt="" onclick="abrirEditarContato(${index}, 2)"></a>
                                  </div>
                                  <div class="btn-contato">
                                      <a><img src="../img/icons/remove.png" alt="" onclick="deletarContato(${index}, 2)"></a>
                                  </div>
                              </div>
                          </div>`)
      );
    });
  }
  if (tipo == 2) {
    $(".conteudo-contatos-novos").empty();
    contatosOs.forEach(function (contato, index) {
      $(".conteudo-contatos-novos").append(
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
                                      <a><img src="../img/icons/edit.png" alt="" onclick="abrirEditarContato(${index}, 2)"></a>
                                  </div>
                                  <div class="btn-contato">
                                      <a><img src="../img/icons/remove.png" alt="" onclick="deletarContato(${index}, 2)"></a>
                                  </div>
                              </div>
                          </div>`)
      );
    });
  }
};
