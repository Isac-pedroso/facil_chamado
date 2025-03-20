$(document).ready(function () {
  //Mascara numero telefone
  $("#telefone").mask("(00) 00000-0000");

  //Mascara numero whatsapp
  $("#whatsapp").mask("(00) 00000-0000");

  // Array para guardar os Ids do front-end
  // Será utilizado para criar inputs em JS com estes IDS
  const inputsId = [
    "nome",
    "dt_nascimento",
    "email",
    "telefone",
    "whatsapp",
    "senha",
    "confirm_senha",
  ];

  // Array para guardar a validação dos campos(Inputs) de cadastro
  // Caso o campo(Input) do cadastro atender aos requisitos do sistema, podera fazer o cadastro
  const validaCampos = [
    false,
    false,
    false,
    false,
    false,
    false,
    false,
    false,
    false,
  ];

  // Valida se contem algum campo vazio (Não preenchido);
  const validaInputVazio = function () {
    // Ira verificar se cada Input esta preenchido
    for (var i = 0; i < inputsId.length; i++) {
      input = criarInputComId(inputsId[i]);

      // Condição
      if (!input.value) {
        // Se o input não estiver preenchido
        addIsInValid(inputsId[i]);
        addFalseValidaCampos(i);
      } else {
        // Se o input estiver preenchido
        addIsValid(inputsId[i]);
        addTrueValidaCampos(i);
      }
    }
  };

  // Valida o input nome
  const validaNome = function () {
    input = criarInputComId(inputsId[0]);
    // Condição
    if (!validaInputEspecificoVazio(inputsId[0])) {
      // Caso o input selecionado(Nome) estiver vazio
      addFalseValidaCampos(0);
      limpaMsgErro("nomeError");
      return false;
    }
    // Condição
    if (!input.value == "' or ' '='") {
      // Caso o input selecionado(nome) estiver com estes caracteres
      addIsInValid(inputsId[0]);
      addFalseValidaCampos(0);
      limpaMsgErro("nomeError");
      addMsgError("<p>Não permitido caracteres Especiais</p>", "nomeError");
      return false;
    }
    // Condição
    if (/[^0-9A-Za-z\ ]/.test(input.value)) {
      // Caso o input selecionado(Nome) conter caracteres invalidos
      addIsInValid(inputsId[0]);
      addFalseValidaCampos(0);
      limpaMsgErro("nomeError");
      addMsgError("<p>Não permitido caracteres Especiais</p>", "nomeError");
      return false;
    }
    // Caso tudo estiver certo
    addIsValid(inputsId[0]);
    addTrueValidaCampos(0);
    limpaMsgErro("nomeError");
    return true;
  };
  // Valida input Data Nascimento
  const validaDtNascimento = function () {
    const date = new Date();

    input = criarInputComId(inputsId[1]).value;

    // Retorna para a variavel dataAtual a data atual
    const dataAtual = date.toLocaleDateString();

    // Array para guardar cada parte da data atual: Dia, Mes e Ano
    dataAtualArray = [
      dataAtual.substring(0, 2),
      dataAtual.substring(3, 5),
      dataAtual.substring(6, 10),
    ];
    // Array para guardar cada parte da data selecionada: Dia, Mes e Ano
    dataSelecionadaArray = [
      input.substring(8, 10),
      input.substring(5, 7),
      input.substring(4, 0),
    ];

    // Condição
    if (validaInputEspecificoVazio(inputsId[1])) {
      // Caso o input selecionado(data) estiver preenchido
      // Retorna na variavel 'idadeAtual' a subtração dos anos
      var idadeAtual = dataAtualArray[2] - dataSelecionadaArray[2];
      // Condição
      if (dataSelecionadaArray[1] < dataAtualArray[1]) {
        // Caso o mes selecionado for menor que o mes atual
        idadeAtual = idadeAtual - 1;
      } else if (
        dataSelecionadaArray[1] == dataAtualArray[1] &&
        dataSelecionadaArray[0] < dataAtualArray[0]
      ) {
        // Caso o mes selecionado for igual ao mes da data atual e o dia da data selecionada for menor que o dia da data atual
        idadeAtual = idadeAtual - 1;
      }

      // Condição
      // Irá verificar se a idade é maior que 18 ou não
      if (idadeAtual < 18) {
        // Caso a idade for menor que 18
        addIsInValid(inputsId[1]);
        addFalseValidaCampos(1);
        if (!validaMsgErrorExistente("msgDtNascimentoAtivo")) {
          addMsgError(
            "<p class='msgDtNascimentoAtivo'>Só permitido maior de 18 anos.</p>",
            "dtNascimentoError"
          );
        }
        return false;
      }
      limpaMsgErro("dtNascimentoError");
      addTrueValidaCampos(1);
    } else {
      limpaMsgErro("dtNascimentoError");
      addFalseValidaCampos(1);
    }
  };

  // Valida input email
  const validaEmail = function () {
    if (validaInputEspecificoVazio(inputsId[2])) {
      input = criarInputComId(inputsId[2]).value;
      if (
        input.indexOf("@gmail.com") > 0 ||
        input.indexOf("@hotmail.com") > 0 ||
        input.indexOf("@outlook.com") > 0
      ) {
        limpaMsgErro("emailError");
        addIsValid(inputsId[2]);
        addTrueValidaCampos(2);
        return true;
      } else {
        limpaMsgErro("emailError");
        addMsgError(
          "<p class='msgEmailAtivo'>Email invalido.</p>",
          "emailError"
        );
        addIsInValid(inputsId[2]);
        addFalseValidaCampos(2);
        return false;
      }
    } else {
      limpaMsgErro("emailError");
    }
  };

  // Valida input telefone
  const validaTelefone = function () {
    if (validaInputEspecificoVazio(inputsId[3])) {
      input = criarInputComId(inputsId[3]).value.replace(/\D+/g, "");
      if (input.length < 11) {
        console.log("Numero de Whatsapp errado !", input);
        limpaMsgErro("telefoneError");
        addMsgError(
          "<p class='msgTelefoneAtivo'>Telefone invalido.</p",
          "telefoneError"
        );
        addIsInValid(inputsId[3]);
        addFalseValidaCampos(3);
        return false;
      } else {
        if (/[0-9]/gm.test(input)) {
          limpaMsgErro("telefoneError");
          addIsValid(inputsId[3]);
          addTrueValidaCampos(3);
          return true;
        }
      }
    } else {
      limpaMsgErro("telefoneError");
    }
  };
  // Valida input whatsapp
  const validaWhatsapp = function () {
    if (validaInputEspecificoVazio(inputsId[4])) {
      input = criarInputComId(inputsId[4]).value.replace(/\D+/g, "");
      if (input.length < 10) {
        limpaMsgErro("whatsappError");
        addMsgError(
          "<p class='msgWhatsappAtivo'>Whatsapp invalido.</p",
          "whatsappError"
        );
        addIsInValid(inputsId[4]);
        addFalseValidaCampos(4);
        return false;
      } else {
        if (/[0-9]/gm.test(input)) {
          limpaMsgErro("whatsappError");
          addIsValid(inputsId[4]);
          addTrueValidaCampos(4);
          return true;
        }
      }
    } else {
      limpaMsgErro("whatsappError");
    }
  };
  // Valida input Senha
  const validaSenha = function () {
    if (validaInputEspecificoVazio(inputsId[5])) {
      var input = criarInputComId(inputsId[5]);
      var especificacao = [true, true, true, true];
      if (!/[A-Z]/gm.test(input.value)) {
        especificacao[0] = false;
      } else if (!/[^0-9A-Za-z]/gm.test(input.value)) {
        especificacao[1] = false;
      } else if (!/[0-9]/gm.test(input.value)) {
        especificacao[2] = false;
      } else if (input.length <= 5) {
        especificacao[3] = false;
      }

      if (
        especificacao[0] == true &&
        especificacao[1] == true &&
        especificacao[2] == true &&
        especificacao[3] == true
      ) {
        limpaMsgErro("senhaError");
        addIsValid(inputsId[5]);
        addTrueValidaCampos(5);
        return true;
      } else {
        limpaMsgErro("senhaError");
        addMsgError(
          "<p class='msgSenhaAtivo'>Deve conter 1 letra maiscula, 1 simbolo, 1 numero e 5 caracteres.</p",
          "senhaError"
        );
        addIsInValid(inputsId[5]);
        addFalseValidaCampos(5);
        return false;
      }
    } else {
      limpaMsgErro("senhaError");
    }
  };

  // Valida input confirma senha
  const validaConfirmaSenha = function () {
    input = criarInputComId(inputsId[6]);
    inputSenha = criarInputComId(inputsId[5]);
    if (validaInputEspecificoVazio(inputsId[6])) {
      if (validaInputEspecificoVazio(inputsId[6])) {
        if (input.value == inputSenha.value) {
          limpaMsgErro("confirmSenhaError");
          addIsValid(inputsId[6]);
          addTrueValidaCampos(6);
        } else {
          limpaMsgErro("confirmSenhaError");
          addMsgError(
            "<p class='msgConfirmSenhaAtivo'>Senhas não são iguais.</p",
            "confirmSenhaError"
          );
          addIsInValid(inputsId[6]);
          addFalseValidaCampos(6);
        }
      }
    } else {
      limpaMsgErro("confirmSenhaError");
    }
  };

  // Valida select Estado
  const validaEstado = function () {
    var selectEstado = document.querySelector("#estado");
    if (selectEstado.value == "#") {
      selectEstado.classList.add("is-invalid");
      addFalseValidaCampos(7);
      return false;
    }
    selectEstado.classList.remove("is-invalid");
    selectEstado.classList.add("is-valid");
    addTrueValidaCampos(7);
  };

  // Valida select Cidade
  const validaCidade = function () {
    var selectCidade = document.querySelector("#cidade");
    if (selectCidade.value == "#") {
      selectCidade.classList.add("is-invalid");
      addFalseValidaCampos(8);
      return false;
    }
    selectCidade.classList.remove("is-invalid");
    selectCidade.classList.add("is-valid");
    addTrueValidaCampos(8);
  };

  // Valida se ja existe a mensagem de erro
  const validaMsgErrorExistente = function (idMsg) {
    var campo = document.querySelector(`.${idMsg}`);
    if (campo) {
      return true;
    } else {
      return false;
    }
  };
  // Adiciona true no array validaCampos
  const addTrueValidaCampos = function (idNumero) {
    validaCampos[idNumero] = true;
  };

  // Adiciona False no array validaCapos
  const addFalseValidaCampos = function (idNumero) {
    validaCampos[idNumero] = false;
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

  // Adiciona mensagem de erro
  const addMsgError = function (msg, divNome) {
    $(`#${divNome}`).append(msg);
  };
  const limpaMsgErro = function (divNome) {
    $(`#${divNome}`).empty();
  };

  // Lista no Select do Estado todos os estados retornados do arquivo Estado.json
  const listarEstados = function () {
    $.ajax({
      url: "../json/Estados.json",
      type: "GET",
      dataType: "json",
      success: function (response) {
        for (var i = 0; i < response.length; i++) {
          $("#estado").append(
            $(`<option value='${response[i].ID}'>${response[i].Nome}</option>`)
          );
        }
      },
    });
  };

  $(document).ready(function () {
    listarEstados();
  });

  $("#frm-cadastro").submit(function (e) {
    e.preventDefault();
    //Validação de cada inputs
    validaInputVazio();
    validaNome();
    validaDtNascimento();
    validaEmail();
    validaTelefone();
    validaWhatsapp();
    validaSenha();
    validaConfirmaSenha();
    validaEstado();
    validaCidade();

    console.log(validaCampos);
    var contadorTrue = 0;
    var statusCadastro = false;
    for (var i = 0; i <= validaCampos.length; i++) {
      console.log(validaCampos[i]);
      if (validaCampos[i] == true) {
        contadorTrue++;
      }
      if (i == 9) {
        if (contadorTrue == 9) {
          statusCadastro = true;
          console.log(contadorTrue);
        } else {
          statusCadastro = false;
        }
      }
    }

    // Caso status do Cadastros estiver todo Verdadeiro, irá jogar os dados para o back-end > PHP
    if (statusCadastro == true) {
      $.ajax({
        url: "../app/controller/UserController.php",
        type: "POST",
        data: $("#frm-cadastro").serialize() + "&acao=cadastrar",
        beforeSend: function () {
          var spinner =
            '<div class="spinner-border" role="status"></div><span>Carregando...</span>';
          $("#btn_enviar").html(spinner).fadeIn(200);
        },
        success: function (response) {
          const object = JSON.parse(response);
          try {
            if (object.code != 0) {
              alert(
                "Mensagem: " +
                  object["msg"] +
                  "\nVerifique seu E-mail para concluir o cadastro !"
              );
              window.location.href = "../web/login.php";
            } else {
              alert(object.msg);
            }
          } catch (error) {
            console.log(response);
          }
        },
        error: function () {
          console.log("Deu erro");
        },
      });
    }
  });
});
