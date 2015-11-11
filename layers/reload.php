<?php
require_once '../config/autoload.php';

$autentica = new Autentica();
$autentica->verificaSessao();

$rotina = new Rotina();
$geoLayers = (array) $rotina->getLayers();

$layers = new Layers();
$selectLayers = $layers->busca();

$numGeoLayers = count($geoLayers);
$numSelectLayers = count($selectLayers);

if($numSelectLayers < $numGeoLayers):
	//echo "Foram adicionadas novas layers.";
	while ($numSelectLayers < $numGeoLayers):
		$resultado = $layers->insere($geoLayers[$numSelectLayers]->name);
		$numSelectLayers++;
	endwhile;
else:
	//echo "Sem novas layers para adicionar.";
endif;