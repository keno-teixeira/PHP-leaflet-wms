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

if($valida->validate() && isset($_POST['id'])):

	$grupos = new Grupos();
	$resultadoGrupos = $grupos->edita($_POST['nome'], $_POST['id']);

	/**
	verifica se o grupo foi editado
	**/
	if($resultadoGrupos):

		$basemapsHasGrupos = new BasemapsHasGrupos();
		$gruposHasLayers = new GruposHasLayers();

		$resultadoBasemaps = $basemapsHasGrupos->deleta($_POST['id']);

		/**
		verifica se o o basemap foi desassociado
		**/
		if($resultadoBasemaps):

			$resultadoLayers = $gruposHasLayers->deleta($_POST['id']);

			/**
			verifica se o a layer foi desassociada
			**/
			if($resultadoLayers):

				$resultado = 1;

				foreach($_POST as $chave => $valor):
					if(explode('-', $chave)[0] === 'basemap'):
						$resultado *= $basemapsHasGrupos->insere($valor, $_POST['id']);
					elseif(explode('-', $chave)[0] === 'layer'):
						$resultado *= $gruposHasLayers->insere($valor, $_POST['id']);
					endif;
				endforeach;

				/**
				verifica se a layer foi inserida
				**/
				if($resultado):
					echo json_encode(array("resultado" => "success", "mensagem" => "Grupo editado com sucesso!"));
				else:
					echo json_encode(array("resultado" => "error", "mensagem" => "Não foi possível associar o grupo a basemaps ou layers, tente novamente mais tarde!"));
				endif;
			else:
				echo json_encode(array("resultado" => "error", "mensagem" => "Não foi possível desassociar layers do grupo, tente novamente mais tarde!"));
			endif;
		else:
			echo json_encode(array("resultado" => "error", "mensagem" => "Não foi possível desassociar basemaps do grupo, tente novamente mais tarde!"));
		endif;

	else:
		echo json_encode(array("resultado" => "error", "mensagem" => "Não foi possível editar o grupo, tente novamente mais tarde!"));
	endif;
else:
	echo json_encode(array("resultado" => "error", "mensagem" => $valida->get_errors()));
endif;

else:
	echo json_encode(array("resultado" => "error", "mensagem" => "Permissão negada."));
endif;

exit;