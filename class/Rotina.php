<?php

class Rotina{

	private $ch;
	private $output;

	public function __construct(){
		$this->ch = curl_init();
	}

	//http://admin:siturb2014@10.233.34.6/geoserver/rest/workspaces/layers/featuretypes.json
	public function getLayers(){
		curl_setopt($this->ch, CURLOPT_URL, "http://admin:siturb2014@10.233.34.6/geoserver/rest/workspaces/layers/featuretypes.json");
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
		$this->output = (object) json_decode(curl_exec($this->ch))->featureTypes->featureType;
		$this->fimLeitura();

		return $this->output;
	}

	// O Keno disse que o link funcionava, mas é mentira ele nem testou
	//http://admin:siturb2014@10.233.34.6/geoserver/rest/workspaces/basemap.json
	/*
	public function getBasemaps(){
		curl_setopt($this->ch, CURLOPT_URL, "http://admin:siturb2014@10.233.34.6/geoserver/rest/workspaces/basemap.json");
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
		$this->output = (object) json_decode(curl_exec($this->ch));
		$this->fimLeitura();

		return $this->output;
	}
	*/

	private function fimLeitura(){
		curl_close($this->ch);
	}

}