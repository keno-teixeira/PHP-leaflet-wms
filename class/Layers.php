<?php

class Layers{

	public function __construct(){
		$this->con = Conexao::getConexao();
	}

	public function busca(){

		$sql = "SELECT * FROM layers ORDER BY id";

		try{
			$sth = $this->con->prepare($sql);
			$sth->execute();
			
			return $sth->fetchAll();
		}catch(PDOException $erro){
			echo 'Erro ao buscar layer ' . $erro->getMessage;
			exit();
		}

	}

	public function insere($nome){

		$sql = "INSERT INTO layers(nome, workspace, ativo) VALUES(:nome, \"layers\", true)";

		try{
			$this->con->beginTransaction();

			$sth = $this->con->prepare($sql);
			$sth->bindValue(':nome', $nome, PDO::PARAM_STR);
			$resultado = $sth->execute();
			
			$this->con->commit();

			return $resultado;
		}catch(PDOException $erro){
			$this->con->rollBack();
			echo 'Erro ao inserir layer ' . $erro->getMessage;
			exit();
		}

	}

}