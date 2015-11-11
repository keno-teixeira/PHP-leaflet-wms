<?php

require_once '../../config/autoload.php';

$autentica = new Autentica();
$autentica->verificaSessao();

header('Content-type: text/json; charset=UTF-8');

if( ( ($_SESSION['tipo_id'] == 1) || ($_SESSION['tipo_id'] == 2) ) && ($_SESSION['id'] !=  $_POST['id']) ):

/**
retorna a resposata da desativação e validação
**/
if(isset($_POST['id'])):

	/**
	desativa usuário
	**/
	$usuarios = new Usuarios();
	$resultado = $usuarios->desativa($_POST['id']);

	if($resultado):
		echo json_encode(array("resultado" => "success", "mensagem" => "Usuário desativado com sucesso!"));
	else:
		echo json_encode(array("resultado" => "error", "mensagem" => "Não foi possível excluir o usuário, tente novamente mais tarde!"));
	endif;
else:
	echo json_encode(array("resultado" => "error", "mensagem" => "Permissão negada"));
endif;

else:
	echo json_encode(array("resultado" => "error", "mensagem" => "Permissão negada."));
endif;

exit;