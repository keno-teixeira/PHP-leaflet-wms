<?php

require_once DIRECTORY_ROOT . '/lib/phpmailer/class.phpmailer.php';

class Mail extends PHPMailer{

	public function __construct(){
		$this->IsSMTP();
		$this->Host = "cas.gdfnet.df.gov.br";
		$this->SMTPAuth = false;
		$this->Username = "";
		$this->Password = "";
		$this->From = "desenv.web@sedhab.df.gov.br";
	}

	function setBodyRecSenha($titulo, $conteudo) {
		$mensagem = '<!DOCTYPE html>';
		$mensagem.='<html>';
		$mensagem.='<head>';
		$mensagem.='	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">';
		$mensagem.='</head>';
		$mensagem.='<body style="font-familly: Arial;">';
		$mensagem.='	<h1>';
		$mensagem.= 		$titulo;
		$mensagem.='	</h1>';
		$mensagem.='	<p>';
		$mensagem.= 		$conteudo;
		$mensagem.='	</p>';
		$mensagem.='	<p style="color: red;font-weight: bold;">';
		$mensagem.='		Por favor não responda esse e-mail. Caso você não tenha solicitado a recuperação da sua senha não se preoucupe, basta excluir esse email.';
		$mensagem.='	</p>';
		$mensagem.='	<img src="' . URL_ROOT . 'assets/img/logo_black.png">';
		$mensagem.='	<address>';
		$mensagem.='		Secretaria de Estado de Habitação, Regularização e Desenvolvimento Urbano - SEDHAB<br/>';
		$mensagem.='		Unidade de Tecnologia da Informação - UNTEC<br/>';
		$mensagem.='		SCS Quadra 06 Bloco "A" 4º Andar - Brasília/DF CEP: 70.306.918<br/>';
		$mensagem.='		Telefones (61) 3214 - 4133 / 3214 - 4136<br/>';
		$mensagem.='	</address>';
		$mensagem.='</body>';
		$mensagem.='</html>';

		$mensagem = utf8_decode($mensagem);

		$this->Body = $mensagem;

		$this->IsHTML(true);
	}

}