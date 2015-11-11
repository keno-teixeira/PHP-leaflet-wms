<?php

class TipoUsuario{

	public function __construct(){
		$this->con = Conexao::getConexao();
	}

	public function busca(){

		$sql = "SELECT * FROM tipo_usuario ORDER BY nome";

		try{
			$sth = $this->con->prepare($sql);
			$sth->execute();
			
			return $sth->fetchAll();
		}catch(PDOException $erro){
			echo 'Erro ao buscar tipo de usuário ' . $erro->getMessage;
			exit();
		}

	}

}