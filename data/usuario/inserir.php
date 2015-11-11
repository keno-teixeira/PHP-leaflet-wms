<?php

require_once '../../config/autoload.php';

$autentica = new Autentica();
$autentica->verificaSessao();

header('Content-type: text/json; charset=UTF-8');

if($_SESSION['tipo_id'] == 1 || $_SESSION['tipo_id'] == 2):

/**
verifica se o checkbox grupo foi preenchido
**/
$campoGrupo = false;

foreach($_POST as $chave => $valor):
	if(explode('-', $chave)[0] === 'grupo'):
		$campoGrupo = true;
	break;
	endif;
endforeach;

/**
valida os campos
**/
$valida = new DataValidator();
$valida->set('"Nome"', $_POST['nome'])->is_required();
$valida->set('"E-mail"', $_POST['email'])->is_required()->is_email();
$valida->set('"Login"', $_POST['login'])->is_required();
$valida->set('"Senha"', $_POST['senha'])->is_required();
$valida->set('"Repita a Senha"', $_POST['senha-repetida'])->is_required();

if($_SESSION['tipo_id'] == 1):
	$valida->set('"Tipo"', $_POST['tipo'])->is_required();
	$valida->set('"Orgão"', $_POST['orgao'])->is_required();
endif;

$valida->set('"Repita a senha"', $_POST['senha-repetida'])->is_required()->is_equals($_POST['senha'], false, '"Senha"');
$valida->set('"Grupo"', $campoGrupo)->is_required();

$usuarios = new Usuarios();
$resultado = $usuarios->buscaPorDadosUnicos($_POST['email'], $_POST['login']);

if(count($resultado) != 0):
	$valida->set('"E-mail"', $_POST['email'])->is_not_equals($resultado[0]['email']);
	$valida->set('"Login"', $_POST['login'])->is_not_equals($resultado[0]['login']);
endif;

/**
	retorna a resposata da inserção e validação
	**/
	if($valida->validate()):

	/**
	insere usuário
	**/
	if($_SESSION['tipo_id'] == 1):
		$idUsuario = $usuarios->insere($_POST['nome'], $_POST['email'], $_POST['orgao'], $_POST['login'], $_POST['senha'], $_POST['tipo']);
	else:
		$idUsuario = $usuarios->insere($_POST['nome'], $_POST['email'], $_SESSION['orgao'], $_POST['login'], $_POST['senha'], 3);
	endif;
	/**
	verifica se o usuario foi inserido
	**/

	if($idUsuario !== 0):

		$gruposDeUsuarios = new GruposDeUsuarios();
	$resultado = 1;

		/**
		insere grupo de usuário
		**/
		foreach($_POST as $chave => $valor):
			if(explode('-', $chave)[0] === 'grupo'):
				$resultado *= $gruposDeUsuarios->insere($idUsuario, $valor);
			endif;
		endforeach;

		if($resultado):
			echo json_encode(array("resultado" => "success", "mensagem" => "Usuário inserido com sucesso!"));
		else:
			echo json_encode(array("resultado" => "error", "mensagem" => "Não foi possível associar o usuário aos grupos, tente novamente mais tarde!"));
		endif;

	else:
		echo json_encode(array("resultado" => "error", "mensagem" => "Não foi possível inserir o usuário, tente novamente mais tarde!"));
	endif;
else:
	echo json_encode(array("resultado" => "error", "mensagem" => $valida->get_errors()));
endif;

else:
	echo json_encode(array("resultado" => "error", "mensagem" => "Permissão negada."));
endif;

exit;