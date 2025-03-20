<?php

session_start();

include_once "../dao/OrdemServicoDAO.php";
include_once "../dao/OsContatosDAO.php";
include_once "../dao/OsTimelineDAO.php";
include_once "../dao/AnexosDAO.php";
include_once "../Model/OsTimeline.php";
include_once "../Model/OrdemServico.php";
include_once "../Model/OsContatos.php";
include_once "../Model/Anexos.php";

$ordemServicoDao = new OrdemServicoDAO();
$ordemServico = new OrdemServico();
$osContatosDAO = new OsContatosDAO();
$osTimelineDAO = new OsTimelineDAO();
$anexosDAO = new AnexosDAO();

$acao = $_REQUEST['acao'];

if ($acao == "cadastrar") {
    $ordemServico->setIdUsuario($_SESSION['user']['id']);
    $ordemServico->setTpIncidente($_POST['tp_incidente']);
    $ordemServico->setDescricao($_POST['descricao']);
    $ordemServico->setObservacao($_POST['observacao']);
    if ($ordemServicoDao->create($ordemServico)) {
        $validacoes = [false, false, false];

        $contatos = $_POST['contatos'];
        // Cadastra os Contatos
        foreach ($contatos as $itens) {
            $osContato = new OsContatos();
            $osContato->setIdOrdemServico($ordemServico->getId());
            $osContato->setNome($itens['nome']);
            $osContato->setNumero($itens['numero']);

            if ($osContatosDAO->create($osContato)) {
                $validacoes[0] = true;
            } else {
                //$ordemServicoDao->delete($ordemServico->getId());
                echo json_encode(['msg' => 'Erro ao cadastrar contato !', 'code' => 400]);
                return;
            }
        }
        // Cadastra os Anexos
        $anexosBase64 = $_POST['anexosBase64'];
        foreach ($anexosBase64 as $key => $itens) {
            $anexos = new Anexos();

            $anexos->setIdOrdemServico($ordemServico->getId());
            $anexos->setNome($itens['nome']);
            $anexos->setNmCode($itens['code']);
            if ($anexosDAO->create($anexos)) {
                $validacoes[1] = true;
            } else {
                //$ordemServicoDao->delete($ordemServico->getId());
                echo json_encode(['msg' => 'Erro ao cadastrar anexo !', 'code' => 400]);
                return;
            }
        }
        // Cadastra nova timeline
        $osTimeline = new OsTimeline();
        $osTimeline->setIdUsuario($_SESSION['user']['id']);
        $osTimeline->setIdOrdemServico($ordemServico->getId());
        $osTimeline->setMensagem("Abertura de chamado.");
        $osTimeline->setData(date("Y-m-d H:i:s"));
        if ($osTimelineDAO->create($osTimeline)) {
            $validacoes[2] = true;
        } else {
            //$ordemServicoDao->delete($ordemServico->getId());
            echo json_encode(value: ['msg' => 'Erro ao cadastrar timeline !', 'code' => 400]);
            return;
        }
        if ($validacoes[0] == true && $validacoes[1] == true && $validacoes[2] == true) {
            echo json_encode(['msg' => 'Os salva com sucesso !', 'code' => 200, 'idOs' => $ordemServico->getId()]);
        }
    } else {
        echo json_encode(['msg' => 'Erro ao cadastrar ordem de serviço', 'code' => 400]);
    }
}
if ($acao == "update") {
    try {
        $id_usuario = $_SESSION['user']['id'];
        $id_os = $_POST['idOs'];
        $ordemServico->setId($id_os);
        $ordemServico->setIdUsuario($id_usuario);
        $ordemServico->setTpIncidente($_POST['tp_incidente']);
        $ordemServico->setDescricao($_POST['descricao']);
        $ordemServico->setObservacao($_POST['observacao']);

        $ordemServico->setSttOs($_POST['stt_os']);
        if ($ordemServicoDao->update($ordemServico)) {
            $osTimelineOs = new OsTimeline();
            $osTimelineOs->setIdOrdemServico($id_os);
            $osTimelineOs->setIdUsuario($id_usuario);
            $osTimelineOs->setMensagem("Atualizou a Ordem de Serviço");
            $osTimelineOs->setData(date("Y-m-d H:i:s"));
            $osTimelineDAO->create($osTimelineOs);
            // Adiciona um nova time line para a troca do status da OS
            if (isset($_POST['stt_os']) && $_POST['stt_os'] == 2) {
                $osTimelineOs = new OsTimeline();
                $osTimelineOs->setIdOrdemServico($id_os);
                $osTimelineOs->setIdUsuario($id_usuario);
                $osTimelineOs->setMensagem("Fechou a Ordem de Serviço");
                $osTimelineOs->setData(date("Y-m-d H:i:s"));
                $osTimelineDAO->create($osTimelineOs);
            }
            // Insere novos contatos
            if (isset($_POST['contatos']) && count($_POST['contatos']) > 0) {
                foreach ($_POST['contatos'] as $itens) {
                    $osContato = new OsContatos();
                    $osContato->setIdOrdemServico($id_os);
                    $osContato->setNome($itens['nome']);
                    $osContato->setNumero($itens['numero']);
                    if (!$osContatosDAO->create($osContato)) {
                        throw new Exception("Erro inserir contatos !");
                    }
                }
                $osTimeline = new OsTimeline();
                $osTimeline->setIdOrdemServico($id_os);
                $osTimeline->setIdUsuario($id_usuario);
                $osTimeline->setMensagem("Adicionou novos contatos.");
                $osTimeline->setData(date("Y-m-d H:i:s"));
                $osTimelineDAO->create($osTimeline);
            }
            // Deleta contatos já existentes na OS
            if (isset($_POST['contatosDeletados']) && count($_POST['contatosDeletados']) > 0) {
                foreach ($_POST['contatosDeletados'] as $contatosDeletados) {
                    $osContato = new OsContatos();
                    $osContato->setId($contatosDeletados['id_contato']);
                    if (!$osContatosDAO->delete($osContato)) {
                        throw new Exception('Erro ao deletar contatos !');
                    }
                }
                $osTimeline = new OsTimeline();
                $osTimeline->setIdOrdemServico($id_os);
                $osTimeline->setIdUsuario($id_usuario);
                $osTimeline->setMensagem("Removeu alguns contatos.");
                $osTimeline->setData(date("Y-m-d H:i:s"));
                $osTimelineDAO->create($osTimeline);
            }
            //Atualiza contatos já existentes na OS
            if (isset($_POST['contatosEditados']) && count($_POST['contatosEditados']) > 0) {
                foreach ($_POST['contatosEditados'] as $contatoEditado) {
                    $osContato = new OsContatos();
                    $osContato->setIdOrdemServico($id_os);
                    $osContato->setId($contatoEditado['id']);
                    $osContato->setNome($contatoEditado['nome']);
                    $osContato->setNumero($contatoEditado['numero']);
                    if (!$osContatosDAO->update($osContato)) {
                        throw new Exception('Erro ao editar contatos !');
                    }
                    $osTimeline = new OsTimeline();
                    $osTimeline->setIdOrdemServico($id_os);
                    $osTimeline->setIdUsuario($id_usuario);
                    $osTimeline->setMensagem("Editou alguns contatos.");
                    $osTimeline->setData(date("Y-m-d H:i:s"));
                    $osTimelineDAO->create($osTimeline);
                }
            }

            if (isset($_POST['anexosBase64']) && count($_POST['anexosBase64']) > 0) {
                foreach ($_POST['anexosBase64'] as $anexo) {
                    $osAnexos = new Anexos();
                    $osAnexos->setIdOrdemServico($id_os);
                    $osAnexos->setNmCode($anexo['code']);
                    $osAnexos->setNome($anexo['nome']);
                    if (!$anexosDAO->create($osAnexos)) {
                        throw new Exception('Erro ao inserir anexo !');
                    }
                }
                $osTimeline = new OsTimeline();
                $osTimeline->setIdOrdemServico($id_os);
                $osTimeline->setIdUsuario($id_usuario);
                $osTimeline->setMensagem("Adicinou novos anexos.");
                $osTimeline->setData(date("Y-m-d H:i:s"));
                $osTimelineDAO->create($osTimeline);
            }
            if (isset($_POST['anexosDeletados']) && count($_POST['anexosDeletados']) > 0) {
                foreach ($_POST['anexosDeletados'] as $anexoDeletado) {
                    $osAnexos = new Anexos();
                    $osAnexos->setId($anexoDeletado['id']);
                    if (!$anexosDAO->delete($osAnexos)) {
                        throw new Exception('Erro ao deletar anexos !');
                    }
                }
                $osTimeline = new OsTimeline();
                $osTimeline->setIdOrdemServico($id_os);
                $osTimeline->setIdUsuario($id_usuario);
                $osTimeline->setMensagem("Removeu alguns anexos.");
                $osTimeline->setData(date("Y-m-d H:i:s"));
                $osTimelineDAO->create($osTimeline);
            }
            echo json_encode(['msg' => 'Ordem de serviço Atualizada com sucesso !', 'code' => 200]);
        } else {
            throw new Exception('Erro ao atualizar Ordem de Serviço !', code: 400);
        }
    } catch (Exception $e) {
        echo json_encode(['msg' => $e->getMessage(), 'code' => $e->getCode()]);
    }
}
if ($acao == "buscarDadosPorId") {
    $ordemServico = new OrdemServico();
    $ordemServico->setId($_POST['id_os']);
    $ordemServico->setIdUsuario($_SESSION['user']['id']);
    echo json_encode($ordemServicoDao->buscarDadosPorId($ordemServico));

}
if ($acao == "buscarPorId") {
    $ordemServico = new OrdemServico();
    $ordemServico->setId($_POST['id_os']);
    if ($ordemServicoDao->buscarPorId($ordemServico)) {
        echo json_encode(['msg' => 'Ordem de serviço localizada !', 'code' => 200]);
    }
}
if ($acao == "filtrar") {
    // Dados vindo do front - end
    $tp_incidente = $_POST['tp_incidente'];
    $stt_os = $_POST['stt_os'];
    $ordemServico = new OrdemServico();
    $ordemServico->setIdUsuario($_SESSION['user']['id']);
    if ($tp_incidente == 'all' && $stt_os == 'all') {
        echo json_encode($ordemServicoDao->listar($ordemServico));
    } else if ($tp_incidente == 'all' && $stt_os >= 0) {
        $ordemServico->setSttOs(intval($stt_os));
        echo json_encode($ordemServicoDao->filtrarPorStt($ordemServico));
    } else if ($tp_incidente >= 0 && $stt_os == 'all') {
        $ordemServico->setTpIncidente(intval($tp_incidente));
        echo json_encode($ordemServicoDao->filtrarPorTp($ordemServico));
    } else if ($tp_incidente >= 1 && $stt_os >= 1) {
        $ordemServico->setTpIncidente(intval($tp_incidente));
        $ordemServico->setSttOs(intval($stt_os));
        echo json_encode($ordemServicoDao->filtrarTodos($ordemServico));
    }

}
if ($acao == "listar") {
    $ordemServico = new OrdemServico();
    $ordemServico->setSttOs(intval(1));
    $ordemServico->setIdUsuario($_SESSION['user']['id']);
    echo json_encode($ordemServicoDao->filtrarPorStt($ordemServico));
}
if ($acao == "listarPorId") {
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
    }
    if (isset($_REQUEST['id'])) {
        $id = $_REQUEST['id'];
    }
    $ordemServico->setId($id);
    echo json_encode($ordemServicoDao->listarPorId($ordemServico));
}

if ($acao == "carregaId") {
    echo json_encode($ordemServicoDao->carregaId());
}
?>