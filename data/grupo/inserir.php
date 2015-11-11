<?php

require_once '../../config/autoload.php';

$autentica = new Autentica();
$autentica->verificaSessao();

header('Content-type: text/json; charset=UTF-8');

if($_SESSION['tipo_id'] == 1):

/**
varifica se o checkbox basemaps foi checkado
**/
$campoBasemaps = false;
foreach($_POST as $chave => $valor):
	if(explode('-', $chave)[0] === 'basemap'):
		$campoBasemaps = true;
		break;
	endif;
endforeach;

/**
verifica se o checkbox layer foi checkado
**/
$campoLayers = false;
foreach($_POST as $chave => $valor):
	if(explode('-', $chave)[0] === 'layer'):
		$campoLayers = true;
		break;
	endif;
endforeach;

/**
valida os campos
**/
$valida = new DataValidator();
$valida->set('"Nome"', $_POST['nome'])->is_required();
$valida->set('"Basemaps"', $campoBasemaps)->is_required();
$valida->set('"Layers"', $campoLayers)->is_required();

if($valida->validate()):
	$grupo = new Grupos();
	$idGrupo = $grupo->insere($_POST['nome']);

	/**
	verifica se o grupo foi inserido
	**/
	if($idGrupo !== 0):

		$basemapsHasGrupos = new BasemapsHasGrupos();
		$gruposHasLayers = new GruposHasLayers();

		$resultado = 1;

		foreach($_POST as $chave => $valor):
			if(explode('-', $chave)[0] === 'basemap'):
				$resultado *= $basemapsHasGrupos->insere($valor, $idGrupo);
			elseif(explode('-', $chave)[0] === 'layer'):
				$resultado *= $gruposHasLayers->insere($valor, $idGrupo);
			endif;
		endforeach;

		/**
		verifica se o resultado foi inserido
		**/

		if($resultado):
			echo json_encode(array("resultado" => "success", "mensagem" => "Grupo inserido com sucesso!"));
		else:
			echo json_encode(array("resultado" => "error", "mensagem" => "Não foi possível associar o grupo a todos os basemaps ou layers, tente novamente mais tarde!"));
		endif;

	else:
		echo json_encode(array("resultado" => "error", "mensagem" => "Não foi possível inserir o grupo, tente novamente mais tarde!"));
	endif;
else:
	echo json_encode(array("resultado" => "error", "mensagem" => $valida->get_errors()));
endif;

else:
	echo json_encode(array("resultado" => "error", "mensagem" => "Permissão negada."));
endif;

exit;