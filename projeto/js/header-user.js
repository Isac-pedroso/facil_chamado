$(document).ready(() => {
  $.ajax({
    url: "../app/controller/UserController.php",
    type: "POST",
    data: { acao: "buscarPorId" },
    dataType: "json",
    success: function (response) {
      const user_id_cidade = response.id_cidade;
      $.get("../json/Cidades.json", (dados) => {
        dados.forEach((cidade) => {
          if (cidade.ID == user_id_cidade) {
            $("#prefeitura-nome").append(
              $(`<p>Prefeitura Municipal de ${cidade.Nome}</p>`)
            );
          }
        });
      });
    },
  });
  $("#deslogar").click(function () {
    $.ajax({
      url: "../app/controller/UserController.php",
      type: 'POST',
      data: { acao: "deslogar" },
      dataType: 'json',
      success: function (response) {
        alert("Deslogado do sistema !");
        window.location.href = '../web/index.php';
      }
    });
  });
});
