<?php

class Autentica{

	public function __construct(){
		if(!isset($_SESSION))
			session_start();
	}

	public function novaSessao($usuario){
		$_SESSION['id'] = $usuario['0']['id'];
		$_SESSION['nome'] = $usuario['0']['nome'];
		$_SESSION['orgao'] = $usuario['0']['orgao'];
		$_SESSION['email'] = $usuario['0']['email'];
		$_SESSION['login'] = $usuario['0']['login'];
		$_SESSION['senha'] = $usuario['0']['senha'];
		$_SESSION['tipo'] = $usuario['0']['tipo'];
		$_SESSION['tipo_id'] = $usuario['0']['tipo_usuario_id'];
	}

	public function verificaSessao(){
		if(isset($_SESSION['id'])):
			$usuarios = new Usuarios();
			$resultado = $usuarios->buscaPorId($_SESSION['id']);

			if(($resultado['0']['login'] !== $_SESSION['login']) || ($resultado['0']['senha'] !== $_SESSION['senha'])):
				header('Location: ' . URL_ROOT . 'erro/401.php');
			endif;
		else:
			header('Location: ' . URL_ROOT . 'erro/401.php');
		endif;
	}

	public function finalizaSessao(){
		session_destroy();
		header('Location: ' . URL_ROOT . 'home/index.php');
	}

	public function armazenarLogin($login){
		setcookie('login', $login);
	}

	public function recuperarLogin(){
		return $_COOKIE['login'];
	}

}