<?php

class Basemaps{

	private $con;

	public function __construct(){
		$this->con = Conexao::getConexao();
	}

	public function busca(){

		$sql = "SELECT * FROM basemaps ORDER BY id";

		try{
			$sth = $this->con->prepare($sql);
			$sth->execute();
			
			return $sth->fetchAll();
		}catch(PDOException $erro){
			$this->con->rollBack();
			echo 'Erro ao buscar basemaps ' . $erro->getMessage;
			exit();
		}

	}

}