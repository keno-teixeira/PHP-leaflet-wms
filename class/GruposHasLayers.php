<?php

class GruposHasLayers{

	private $con;

	public function __construct(){
		$this->con = Conexao::getConexao();
	}

	public function insere($layers_id, $grupos_id){

		$sql = "INSERT INTO grupos_has_layers(layers_id, grupos_id) VALUES(:layers_id, :grupos_id)";

		try{
			$this->con->beginTransaction();

			$sth = $this->con->prepare($sql);
			$sth->bindValue(':layers_id', $layers_id, PDO::PARAM_INT);
			$sth->bindValue(':grupos_id', $grupos_id, PDO::PARAM_INT);
			$resultado = $sth->execute();
			
			$this->con->commit();

			return $resultado;
		}catch(PDOException $erro){
			$this->con->rollBack();
			echo 'Erro ao inserir layer de grupo ' . $erro->getMessage();
			exit();
		}

	}

	public function deleta($grupoId){

		$sql = "DELETE FROM grupos_has_layers WHERE grupos_id=:grupos_id";

		try{
			$this->con->beginTransaction();

			$sth = $this->con->prepare($sql);
			$sth->bindValue(':grupos_id', $grupoId, PDO::PARAM_INT);
			$resultado = $sth->execute();

			$this->con->commit();

			return $resultado;
		}catch(PDOException $erro){
			$this->con->rollBack();
			echo 'Erro ao deletar layer de grupo ' . $erro->getMessage();
			exit();
		}

	}

}