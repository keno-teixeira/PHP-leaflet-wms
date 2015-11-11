<?php

class GruposDeUsuarios{

	private $con;

	public function __construct(){
		$this->con = Conexao::getConexao();
	}

	public function insere($usuarioId, $grupoId){

		$sql = "INSERT INTO grupos_de_usuarios(usuarios_id, grupos_id) VALUES(:usuarios_id, :grupos_id)";

		try{
			$this->con->beginTransaction();

			$sth = $this->con->prepare($sql);
			$sth->bindValue(':usuarios_id', $usuarioId, PDO::PARAM_INT);
			$sth->bindValue(':grupos_id', $grupoId, PDO::PARAM_INT);
			$resultado = $sth->execute();

			$this->con->commit();

			return $resultado;
		}catch(PDOException $erro){
			$this->con->rollBack();
			echo 'Erro ao inserir grupo de usuário ' . $erro->getMessage();
			exit();
		}

	}

	public function deleta($usuarioId){

		$sql = "DELETE FROM grupos_de_usuarios WHERE usuarios_id=:usuarios_id";

		try{
			$this->con->beginTransaction();

			$sth = $this->con->prepare($sql);
			$sth->bindValue(':usuarios_id', $usuarioId, PDO::PARAM_INT);
			$resultado = $sth->execute();

			$this->con->commit();

			return $resultado;
		}catch(PDOException $erro){
			$this->con->rollBack();
			echo 'Erro deletar grupo de usuário ' . $erro->getMessage();
			exit();
		}

	}

}