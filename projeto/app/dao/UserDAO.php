<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require "../composer/vendor/autoload.php";
include_once "../config/database/Conexaobd.php";
include_once "../controller/UserController.php";
include_once "../Model/User.php";

$mail = new PHPMailer(true);

class UserDAO
{
    public function create(User $usuario)
    {
        try {
            $conn = new Conexaobd();
            $sql = "INSERT INTO usuario (id,nome,email,telefone,whatsapp,dt_nascimento, senha, email_confirm, cd_email_confirm, id_estado, id_cidade)
            VALUE (null, :nome, :email, :telefone, :whatsapp, :dt_nascimento, :senha, :email_confirm, :cd_email_confirm,:id_estado, :id_cidade)";
            if (!$this->validaEmail($usuario->getEmail())) {
                $commit = $conn->getConexao()->prepare($sql);
                $commit->bindValue(":nome", $usuario->getNome());
                $commit->bindValue(":email", $usuario->getEmail());
                $commit->bindValue(":telefone", $usuario->getTelefone());
                $commit->bindValue(":whatsapp", $usuario->getWhatsapp());
                $commit->bindValue(":dt_nascimento", $usuario->getDtNascimento());
                $commit->bindValue(":senha", $usuario->getSenha());
                $commit->bindValue(":email_confirm", $usuario->getEmailConfirm());
                $commit->bindValue(":cd_email_confirm", $usuario->getCdEmailConfirm());
                $commit->bindValue(":id_estado", $usuario->getIdEstado());
                $commit->bindValue(":id_cidade", $usuario->getIdCidade());
                $commit->execute();
                $this->enviarEmailVerificacao($usuario->getEmail(), $usuario->getNome(), $usuario->getCdEmailConfirm());
                echo json_encode(['msg' => 'Cadastrado com sucesso.']);
            } else {
                throw new Exception('Email existente !', 1);
            }
        } catch (Exception $e) {
            echo json_encode([
                'code' => $e->getCode(),
                'msg' => $e->getMessage()
            ]);
        }
    }

    public function logar(User $usuario)
    {
        try {
            $conn = new Conexaobd();
            if ($this->validaEmail($usuario->getEmail())) {
                if ($this->validaEmailConfirmado($usuario->getEmail())) {
                    $sql = "SELECT * FROM usuario
                        WHERE email = :email";
                    $commit = $conn->getConexao()->prepare($sql);
                    $commit->bindValue(':email', $usuario->getEmail());
                    $commit->execute();
                    $response = $commit->fetch();
                    if (password_verify($usuario->getSenha(), $response['senha'])) {
                        // Inicia Sessão no sistema

                        session_set_cookie_params(['httponly' => true]);
                        session_start();
                        $_SESSION['logado'] = true;
                        $_SESSION['user'] = ['id' => $response['id'], 'nome' => $response['nome'],];
                        echo json_encode([
                            'msg' => 'Logado com sucesso !',
                            'status' => 200
                        ]);

                    } else {
                        throw new Exception('Senha ou usuario invalido.', 400);
                    }
                } else {
                    throw new Exception('Usuario não validou Email ainda. Confirme o seu email atraves do link enviado via email.', 402);
                }

            } else {
                throw new Exception('Usuario não encontrado !', 400);
            }
        } catch (Exception $e) {
            echo json_encode([
                'msg' => $e->getMessage(),
                'status' => $e->getCode()
            ]);
        }
    }
    public function buscarPorId(User $usuario)
    {
        $conn = new Conexaobd();
        $sql = "SELECT * FROM usuario WHERE id = :id";
        $commit = $conn->getConexao()->prepare($sql);
        $commit->bindValue(":id", $usuario->getId());
        $commit->execute();
        return $response = $commit->fetch(PDO::FETCH_ASSOC);

    }
    public function validaEmailConfirmado($email)
    {
        $conn = new Conexaobd();
        $sql = "SELECT * FROM usuario WHERE email = :email";
        $commit = $conn->getConexao()->prepare($sql);
        $commit->bindValue(':email', $email);
        $commit->execute();
        $response = $commit->fetch();
        if ($response['email_confirm'] == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function validaEmail($gmail)
    {
        $conn = new Conexaobd();
        $sql = "SELECT * FROM usuario
        WHERE email = :email LIMIT 1";

        $commit = $conn->getConexao()->prepare($sql);
        $commit->bindParam(":email", $gmail);
        $commit->execute();
        $retorno = $commit->fetchAll();
        if (count($retorno) > 0) {
            return true;
        } else {
            return false;
        }

    }
    public function confirmarEmail(User $usuario)
    {
        try {
            if ($this->validaCdEmailConfirm(cdEmailConfirm: $usuario->getCdEmailConfirm())) {
                $conn = new Conexaobd();
                $sql = "UPDATE usuario
                        SET email_confirm = 1
                        WHERE cd_email_confirm = :cd_email_confirm";
                $commit = $conn->getConexao()->prepare($sql);
                $commit->bindValue(':cd_email_confirm', $usuario->getCdEmailConfirm());
                $commit->execute();
                echo json_encode([
                    'msg' => 'Email confirmado com sucesso !',
                    'status' => 200
                ]);
            } else {
                throw new Exception('Email nao encontrado', 500);
            }
        } catch (Exception $e) {
            echo json_encode([
                'msg' => $e->getMessage(),
                'status' => $e->getCode()
            ]);
        }

    }

    public function validaCdEmailConfirm($cdEmailConfirm)
    {
        $conn = new Conexaobd();
        $sql = "SELECT * FROM usuario WHERE cd_email_confirm = :cd_email_confirm";
        $commit = $conn->getConexao()->prepare($sql);
        $commit->bindParam("cd_email_confirm", $cdEmailConfirm);
        $commit->execute();
        $retorno = $commit->fetchAll();
        if (count($retorno) > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function enviarEmailVerificacao($email, $nome, $usuarioCode)
    {
        $usuario = new User();

        $mail = new PHPMailer();
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        $mail->SMTPSecure = 'tls';
        $mail->Username = 'isacsouzapedroso@gmail.com';
        $mail->Password = 'cgkmzhivugfsfdhk';
        $mail->Port = 587;

        $mail->setFrom('isacsouzapedroso@gmail.com', 'facil chamado');
        $mail->addReplyTo($email, 'Information');
        $mail->addAddress($email, $nome);
        $mail->isHTML(true);
        $mail->Subject = 'Validação de cadastro Facil Chamado';
        $body = "
            Conclua o cadastro.<br>
            Validação de Email referente seu cadastro no sistema Facil Chamado !<br>
            Clique no link abaixo para validar seu email:<br>
            <a href='http://localhost/facil_chamado/projeto/web/confirmar-email.php?codigo_valida=$usuarioCode'>http://localhost/projeto-teste-webbrain/version/v0.5/web/confirmar-email.php?codigo_valida=$usuarioCode</a>";
        $mail->Body = $body;
        $mail->send();
    }
}

?>