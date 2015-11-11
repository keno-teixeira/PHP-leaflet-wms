<?php

class BasemapsHasGrupos{

	private $con;

	public function __construct(){
		$this->con = Conexao::getConexao();
	}

	public function insere($basemaps_id, $grupos_id){

		$sql = "INSERT INTO basemaps_has_grupos(basemaps_id, grupos_id) VALUES(:basemaps_id, :grupos_id)";

		try{
			$this->con->beginTransaction();

			$sth = $this->con->prepare($sql);
			$sth->bindValue(':basemaps_id', $basemaps_id, PDO::PARAM_INT);
			$sth->bindValue(':grupos_id', $grupos_id, PDO::PARAM_INT);
			$resultado = $sth->execute();
			
			$this->con->commit();

			return $resultado;
		}catch(PDOException $erro){
			$this->con->rollBack();
			echo 'Erro ao inserir basemap de grupo ' . $erro->getMessage();
			exit();
		}

	}

	public function deleta($grupoId){

		$sql = "DELETE FROM basemaps_has_grupos WHERE grupos_id=:grupos_id";

		try{
			$this->con->beginTransaction();

			$sth = $this->con->prepare($sql);
			$sth->bindValue(':grupos_id', $grupoId, PDO::PARAM_INT);
			$resultado = $sth->execute();

			$this->con->commit();

			return $resultado;
		}catch(PDOException $erro){
			$this->con->rollBack();
			echo 'Erro ao deletar basemap de grupo ' . $erro->getMessage();
			exit();
		}

	}

}