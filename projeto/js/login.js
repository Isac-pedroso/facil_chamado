$(document).ready(function () {
  const inputsId = ["email", "senha"];
  const validaCampos = [false, false];
  const validaInputVazio = function () {
    for (var i = 0; i < inputsId.length; i++) {
      input = criarInputComId(inputsId[i]);
      if (!input.value) {
        addIsInValid(inputsId[i]);
        addFalseValidaCampos(i);
      } else {
        addIsValid(inputsId[i]);
        addTrueValidaCampos(i);
      }
    }
  };
  // Valida input email
  const validaEmail = function () {
    if (validaInputEspecificoVazio(inputsId[0])) {
      input = criarInputComId(inputsId[0]).value;
      if (
        input.indexOf("@gmail.com") > 0 ||
        input.indexOf("@hotmail.com") > 0 ||
        input.indexOf("@outlook.com") > 0
      ) {
        limpaMsgErro("emailError");
        addIsValid(inputsId[0]);
        addTrueValidaCampos(0);
        return true;
      } else {
        limpaMsgErro("emailError");
        addMsgError(
          "<p class='msgEmailAtivo'>Email invalido.</p>",
          "emailError"
        );
        addIsInValid(inputsId[0]);
        addFalseValidaCampos(0);
        return false;
      }
    } else {
      limpaMsgErro("emailError");
    }
  };
  const validaSenha = function(){
    if(validaInputEspecificoVazio(inputsId[1])){
        addTrueValidaCampos(1);
    }
  }
  // Retorna o input pelo id desejado
  const criarInputComId = function (id) {
    return document.getElementById(id);
  };
  // Valida se o input especifico esta vazio
  const validaInputEspecificoVazio = function (inputId) {
    input = criarInputComId(inputId);
    if (!input.value) {
      return false;
    }
    return true;
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
  // Adiciona true no array validaCampos
  const addTrueValidaCampos = function (idNumero) {
    validaCampos[idNumero] = true;
  };

  // Adiciona False no array validaCapos
  const addFalseValidaCampos = function (idNumero) {
    validaCampos[idNumero] = false;
  };

  // Adiciona mensagem de erro
  const addMsgError = function (msg, divNome) {
    $(`#${divNome}`).append(msg);
  };
  const limpaMsgErro = function (divNome) {
    $(`#${divNome}`).empty();
  };
  $("#frm-login").submit(function (e) {
    e.preventDefault();
    validaInputVazio();
    validaEmail();
    validaSenha();
    var contadorTrue = 0;
    var statusLogin = false;
    for (var i = 0; i <= validaCampos.length-1; i++) {
      if (validaCampos[i] == true) {
        contadorTrue++;
      }
      if (i == 1) {
        if (contadorTrue == 2) {
          statusLogin = true;
        } else {
          statusLogin = false;
        }
      }
    }

    if (statusLogin == true) {
      $.ajax({
        url: "../app/controller/UserController.php",
        type: "POST",
        data: $("#frm-login").serialize() + "&acao=logar",
        beforeSend: function () {
          var spinner =
            '<div class="spinner-border" role="status"></div><span>Carregando...</span>';
          $("#logar").html(spinner).fadeIn(200);
        },
        success: function (response) {
          const object = JSON.parse(response);
          try {
            console.log(object.status);
            // Caso o usuario existir (Consultado pelo Email)
            if(object.status == 200){
               alert(object.msg);
               window.location.href = "../web/relacao-os.php";
            }else{
              // Caso o email estiver validado ou não
              if(object.status == 402){
                alert(object.msg);
              }else{
                limpaMsgErro('sistemaError');
                addMsgError('<p class="msgSistemaAtivo" style="margin-bottom:5px;">'+object.msg+'</p>', 'sistemaError');
              }
            }
          } catch (error) {
            console.log(response);
          }
        },
        complete: function(){
            $("#logar").empty();
            $("#logar").html('Login');
        }
      });
    }
  });
});
