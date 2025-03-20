$(document).ready(function () {

  const parametrosUrl = new URLSearchParams(window.location.search);
  const codigo_valida = parametrosUrl.get("codigo_valida");
  
  $.ajax({
    url: "../app/controller/UserController.php",
    type: "POST",
    data: "codigo_valida=" + codigo_valida + "&acao=confirmar_email",
    success: function (response) {
      const object = JSON.parse(response);
      try {
        if(object.status == 200){
            $(".principal").append($('<h1 class="nome-sistema" style="margin-bottom:20px;">Facil Chamado</h1><h1>Email validado com sucesso !</h1><h1>Muito obrigado, agora você já pode efetuar Login no sistema atravês da aba <a href="login.php">login.</a></h1>'));
        }
        if(object.status == 500){
          $(".principal").append($('<h1 class="nome-sistema" style="margin-bottom:20px;">Facil Chamado</h1><h1>Validação de email...!</h1><h1>Ocorreu algum erro ao validar seu Email !!!</a></h1>'))
        }
      } catch (error) {
        console.log(response);
      }
    },
    error: function () {
      console.log("Deu erro");
    },
  });
});
