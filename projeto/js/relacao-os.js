$(document).ready(function () {
  getDadosOs();
  $("#buscar_os").click(function (e) {
    const id_os = $("#codigo-os").val();
    e.preventDefault();
    // Busca ordem de serviço pelo ID
    $.ajax({
      url: "../app/controller/OrdemServicoController.php",
      type: "POST",
      data: { id_os: id_os, acao: "buscarDadosPorId" },
      dataType: "json",
      beforeSend: function () {
        $("#tela-carregamento").append(
          $(`<div class="tela-carregamento-envio">
          <div class="spinner-border text-primary" role="status" style="padding:40px;"></div><span style="font-size:2em; padding-top: 30px; padding-left:15px; color:black;">Carregando...</span>
      </div>`)
        );
      },
      success: (response) => {
        console.log(response);
        if (response) {
          $(".ordem-servicos-relacao").empty();
          carregarOS(response, 2);
        }else{
          alert('Ordem de Serviço não encontrada !');
        }
      },
      complete: function () {
        $("#tela-carregamento").empty();
      },
    });
  });
  carregaTiposIncidente();
  // Adiciona ao botão do Header a class selecionado, deixando visualmente o botão ativado
  function addBtnSelecionadoHeader() {
    const div = document.querySelector("#btn-relacao-os");
    div.classList.remove("btn-header");
    div.classList.add("btn-header-selecionado");
  }
  $("#pesquisar").click(function () {
    const stt_os = $("#status").val();
    const tp_incidente = $("#tp_incidente").val();
    $.ajax({
      url: "../app/controller/OrdemServicoController.php",
      type: "POST",
      data: { stt_os: stt_os, tp_incidente: tp_incidente, acao: "filtrar" },
      dataType: "json",
      beforeSend: function () {
        $("#tela-carregamento").append(
          $(`<div class="tela-carregamento-envio">
            <div class="spinner-border text-primary" role="status" style="padding:40px;"></div><span style="font-size:2em; padding-top: 30px; padding-left:15px; color:black;">Carregando...</span>
        </div>`)
        );
      },
      success: function (response) {
        $(".ordem-servicos-relacao").empty();
        carregarOS(response, 1);
      },
      complete: function () {
        $("#tela-carregamento").empty();
        console.log("concluido");
      },
    });
  });
  function carregaTiposIncidente() {
    $.ajax({
      url: "../app/controller/TipoIncidenteController.php",
      type: "GET",
      dataType: "json",
      success: function (response) {
        response.forEach(function (itens) {
          $("#tp_incidente").append(
            $(
              `<option value="${itens.id}" id="tpIncidenteId${itens.id}">${itens.nome}</option>`
            )
          );
        });
      },
    });
  }
  function getDadosOs() {
    $.post(
      "../app/controller/OrdemServicoController.php",
      { acao: "listar" },
      function (response) {
        carregarOS(response, 1);
      },
      "json"
    );
  }
  function carregarOS(response, code) {
    if (code == 1) {
      response.forEach(function (os) {
        var stt_os;
        if (parseInt(os.stt_os) == 1) {
          stt_os = "Aberta";
          classAbertaOuFechada = "stt_aberta";
        } else if (parseInt(os.stt_os) == 2) {
          stt_os = "Fechada";
          classAbertaOuFechada = "stt_fechada";
        }
        const conteudo = `
              <div class="ordem-servico ${classAbertaOuFechada}" onclick="abrirOs(${
          os.id
        })">
                <div class="cabecalho-os">
                    <div class="numero-da-os">
                        <div class="codigo-ordem-servico">
                            <div class="titulo-ordem-servico">
                                <span>O.S</span>
                            </div>
                            <input type="text" class="form-control" value="${parseInt(
                              os.id
                            )}" id="codigo-os" disabled="true">
                        </div>
                    </div>
                    <div class="status-os dados-os-configs">
                        <label for="">Status:</label>
                        <input type="text" value="${stt_os}" disabled="true">
                    </div>
                    <div class="tp-incidente-os dados-os-configs">
                        <label for="">Tipo de incidente:</label>
                        <input type="text" value="${os.nome}" disabled="true">
                    </div>
                </div>
                <div class="descricao-problema">
                    <div class="titulo-descricao">
                        <label for="desc_problema">Descrição do problema:</label>
                    </div>
                    <!--<textarea name="desc_problema" id="" class="form-control"></textarea>-->
                    <!-- <div id="descricao"></div> -->
                    <textarea name="descricao" id="descricaoId${
                      os.id
                    }" disabled>${os.descricao}</textarea>
                    <div id="descricaoError" class="msgError"></div>
                </div>
              </div>
      `;
        $(".ordem-servicos-relacao").append(conteudo);
        $(`#descricaoId${os.id}`).summernote({
          height: 50,
        });
        $(`#descricaoId${os.id}`).summernote("disable");
      });
    }
    if (code == 2) {
      console.log("teste");
      var stt_os;
      if (parseInt(response.stt_os) == 1) {
        stt_os = "Aberta";
        classAbertaOuFechada = "stt_aberta";
      } else if (parseInt(response.stt_os) == 2) {
        stt_os = "Fechada";
        classAbertaOuFechada = "stt_fechada";
      }
      const conteudo = `
            <div class="ordem-servico ${classAbertaOuFechada}" onclick="abrirOs(${
        response.id
      })">
              <div class="cabecalho-os">
                  <div class="numero-da-os">
                      <div class="codigo-ordem-servico">
                          <div class="titulo-ordem-servico">
                              <span>O.S</span>
                          </div>
                          <input type="text" class="form-control" value="${parseInt(
                            response.id
                          )}" id="codigo-os" disabled="true">
                      </div>
                  </div>
                  <div class="status-os dados-os-configs">
                      <label for="">Status:</label>
                      <input type="text" value="${stt_os}" disabled="true">
                  </div>
                  <div class="tp-incidente-os dados-os-configs">
                      <label for="">Tipo de incidente:</label>
                      <input type="text" value="${
                        response.nome
                      }" disabled="true">
                  </div>
              </div>
              <div class="descricao-problema">
                  <div class="titulo-descricao">
                      <label for="desc_problema">Descrição do problema:</label>
                  </div>
                  <!--<textarea name="desc_problema" id="" class="form-control"></textarea>-->
                  <!-- <div id="descricao"></div> -->
                  <textarea name="descricao" id="descricaoId${
                    response.id
                  }" disabled>${response.descricao}</textarea>
                  <div id="descricaoError" class="msgError"></div>
              </div>
            </div>
    `;
      $(".ordem-servicos-relacao").append(conteudo);
      $(`#descricaoId${response.id}`).summernote({
        height: 50,
      });
      $(`#descricaoId${response.id}`).summernote("disable");
    }
  }
  addBtnSelecionadoHeader();
});
function abrirOs(id) {
  window.location.href = `ordem-servico.php?id=${id}`;
}
