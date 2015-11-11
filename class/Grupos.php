<?php

class Grupos{

	public function __construct(){
		$this->con = Conexao::getConexao();
	}

	public function busca(){

		$sql = "SELECT * FROM grupos ORDER BY id";

		try{
			$sth = $this->con->prepare($sql);
			$sth->execute();
			
			return $sth->fetchAll();
		}catch(PDOException $erro){
			$this->con->rollBack();
			echo 'Erro ao buscar grupos ' . $erro->getMessage;
			exit();
		}

	}

	public function buscaLayersBasemaps(){

		$sql = "SELECT bg.grupos_id, g.id, g.nome AS grupo, ";
		$sql .= "GROUP_CONCAT(DISTINCT(l.nome) SEPARATOR '; <br/>') AS layers, ";
		$sql .= "GROUP_CONCAT(DISTINCT(b.nome) SEPARATOR '; <br/>') AS basemaps ";
		$sql .= "FROM grupos AS g ";
		$sql .= "INNER JOIN basemaps_has_grupos AS bg ON g.id = bg.grupos_id "; 
		$sql .= "INNER JOIN grupos_has_layers AS gl ON g.id = gl.grupos_id ";
		$sql .= "INNER JOIN basemaps AS b ON b.id = bg.basemaps_id ";
		$sql .= "INNER JOIN layers AS l ON l.id = gl.layers_id ";
		$sql .= "GROUP BY g.nome";

		try{
			$sth = $this->con->prepare($sql);
			$sth->execute();
			
			return $sth->fetchAll();
		}catch(PDOException $erro){
			echo 'Erro ao buscar grupo ' . $erro->getMessage();
			exit();
		}

	}

	public function buscaPorId($id){

		$sql = "SELECT bg.grupos_id, g.id, g.nome AS nome, ";
		$sql .= "l.nome AS layers, b.nome AS basemaps, ";
		$sql .= "l.id AS layer_id, b.id AS basemap_id ";
		$sql .= "FROM grupos AS g ";
		$sql .= "INNER JOIN basemaps_has_grupos AS bg ON g.id = bg.grupos_id "; 
		$sql .= "INNER JOIN grupos_has_layers AS gl ON g.id = gl.grupos_id ";
		$sql .= "INNER JOIN basemaps AS b ON b.id = bg.basemaps_id ";
		$sql .= "INNER JOIN layers AS l ON l.id = gl.layers_id ";
		$sql .= "WHERE g.id=:id";

		try{
			$sth = $this->con->prepare($sql);
			$sth->bindValue(':id', $id, PDO::PARAM_INT);
			$sth->execute();
			
			return $sth->fetchAll();
		}catch(PDOException $erro){
			echo 'Erro ao buscar grupo ' . $erro->getMessage();
			exit();
		}

	}

	public function insere($nome){

		$sql = "INSERT INTO grupos(nome) VALUES(:nome)";

		try{
			$this->con->beginTransaction();

			$sth = $this->con->prepare($sql);
			$sth->bindValue(':nome', $nome, PDO::PARAM_STR);
			$sth->execute();
			$resultado = $this->con->lastInsertId();

			$this->con->commit();

			return $resultado;
		}catch(PDOException $erro){
			$this->con->rollBack();
			echo 'Erro ao inserir grupo ' . $erro->getMessage();
			exit();
		}

	}

	public function edita($nome, $id){

		$sql = "UPDATE grupos SET nome=:nome WHERE id=:id";

		try{
			$this->con->beginTransaction();

			$sth = $this->con->prepare($sql);
			$sth->bindValue(':nome', $nome, PDO::PARAM_STR);
			$sth->bindValue(':id', $id, PDO::PARAM_INT);
			$resultado = $sth->execute();
			
			$this->con->commit();

			return $resultado;
		}catch(PDOException $erro){
			$this->con->rollBack();
			echo 'Erro ao atualizar grupo ' . $erro->getMessage();
			exit();
		}

	}

}