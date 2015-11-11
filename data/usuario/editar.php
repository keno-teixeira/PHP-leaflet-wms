<?php

require_once '../../config/autoload.php';

$autentica = new Autentica();
$autentica->verificaSessao();

header('Content-type: text/json; charset=UTF-8');

if( ( ($_SESSION['tipo_id'] == 1) || ($_SESSION['tipo_id'] == 2) ) && ($_SESSION['id'] !=  $_POST['id']) ):

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

if($_SESSION['tipo_id'] == 1):
	$valida->set('"Orgão"', $_POST['orgao'])->is_required();
	$valida->set('"Tipo"', $_POST['tipo'])->is_required();
endif;

$valida->set('"Grupo"', $campoGrupo)->is_required();
$valida->set('"Ativo"', $_POST['ativo'])->is_required();

$usuarios = new Usuarios();
$resultado = $usuarios->buscaPorDadosUnicosExceto($_POST['email'], "", $_POST['id']);

if(count($resultado) != 0):
	$valida->set('"E-mail"', $_POST['email'])->is_not_equals($resultado[0]['email']);
endif;

/**
retorna a resposata da inserção e validação
**/
if($valida->validate() && isset($_POST['id'])):

	/**
	edita usuário
	**/
	$usuarios = new Usuarios();
	
	if($_SESSION['tipo_id'] == 1):
		$resultadoUsuario = $usuarios->edita($_POST['nome'], $_POST['email'], $_POST['orgao'], $_POST['tipo'], $_POST['ativo'], $_POST['id']);
	else:
		$resultadoUsuario = $usuarios->editaPorGestor($_POST['nome'], $_POST['email'], $_POST['ativo'], $_POST['id']);
	endif;

	/**
	verifica se o usuário foi editado com sucesso
	**/
	if($resultadoUsuario):

	/**
	deleta grupo de usuário
	**/
	$gruposDeUsuarios = new GruposDeUsuarios();
	$resultadoDelecao =  $gruposDeUsuarios->deleta($_POST['id']);

	/**
	verifica a desassociação de grupos
	**/

		if($resultadoDelecao):

			/**
			insere grupo de usuário
			**/
			$resultado = 1;

			foreach($_POST as $chave => $valor):
				if(explode('-', $chave)[0] === 'grupo'):
					$resultado *= $gruposDeUsuarios->insere($_POST['id'], $valor);
				endif;
			endforeach;

			if($resultado):
				echo json_encode(array("resultado" => "success", "mensagem" => "Usuário editado com sucesso!"));
			else:
				echo json_encode(array("resultado" => "error", "mensagem" => "Não foi possível associar o usuário aos grupos, tente novamente mais tarde!"));
			endif;

		else:
			echo json_encode(array("resultado" => "error", "mensagem" => "Não foi possível desassociar o usuário aos grupos, tente novamente mais tarde!"));
		endif;
	else:
		echo json_encode(array("resultado" => "error", "mensagem" => "Não foi possível editar o usuário, tente novamente mais tarde!"));
	endif;
else:
	echo json_encode(array("resultado" => "error", "mensagem" => $valida->get_errors()));
endif;

else:
	echo json_encode(array("resultado" => "error", "mensagem" => "Permissão negada."));
endif;

exit;