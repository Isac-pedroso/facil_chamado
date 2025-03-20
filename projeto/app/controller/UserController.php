<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require "../composer/vendor/autoload.php";
include_once "../config/database/Conexaobd.php";
include_once "../model/User.php";
include_once "../dao/UserDAO.php";

$mail = new PHPMailer(true);
$usuario = new User();
$usuarioDAO = new UserDAO();

$msgError;

$acao = $_REQUEST['acao'];

$cdEmailConfirm;
if(isset($_REQUEST['codigo_valida'])){
    $cdEmailConfirm = $_REQUEST['codigo_valida'];
}
if($acao == "cadastrar"){
    $usuario->setNome(strtolower($_POST['nome']));
    $usuario->setEmail(strtolower($_POST['email']));
    $usuario->setTelefone(preg_replace('/[ ()-]/i', '', $_POST['telefone']));
    $usuario->setWhatsapp(preg_replace('/[ ()-]/i', '', $_POST['whatsapp']));
    $usuario->setSenha(password_hash($_POST['senha'], PASSWORD_DEFAULT));
    $usuario->setDtNascimento($_POST['dt_nascimento']);
    $usuario->setCdEmailConfirm(md5(time().$usuario->getEmail()));
    $usuario->setIdEstado($_POST['estado']);
    $usuario->setIdCidade($_POST['cidade']);
    return $usuarioDAO->create($usuario);
}
if($acao == "confirmar_email"){
    $usuario->setCdEmailConfirm($cdEmailConfirm);
    return $usuarioDAO->confirmarEmail($usuario);
}
if($acao == "logar"){
    $usuario->setEmail($_POST['email']);
    $usuario->setSenha($_POST['senha']);

    return $usuarioDAO->logar($usuario);
}
if($acao == 'deslogar'){
    session_start();
    session_unset();
    session_destroy();
    echo json_encode(['code'=> 200]);
}
if($acao == "buscarPorId"){
    session_start();
    $usuario->setId($_SESSION['user']['id']);
    echo json_encode($usuarioDAO->buscarPorId($usuario));
}
?>