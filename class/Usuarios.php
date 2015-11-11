<?php

class Usuarios{

	private $con;

	public function __construct(){
		$this->con = Conexao::getConexao();
	}

	public function buscaConcatGrupo(){

		$sql = "SELECT u.id AS usuario_id, u.nome, u.email, u.orgao, tp.nome AS tipo, ";
		$sql .= "GROUP_CONCAT(g.nome SEPARATOR '; <br/>') AS grupo, ";
		$sql .= "CASE u.ativo WHEN 1 THEN 'Sim' WHEN 0 THEN 'Não' END as ativo ";
		$sql .= "FROM usuarios AS u " ;
		$sql .= "INNER JOIN tipo_usuario AS tp ON tp.id = u.tipo_usuario_id " ;
		$sql .= "INNER JOIN grupos_de_usuarios AS gu ON gu.usuarios_id = u.id ";
		$sql .= "INNER JOIN grupos AS g ON g.id = gu.grupos_id ";
		$sql .= "GROUP BY u.email";

		try{
			$this->con = Conexao::getConexao();

			$sth = $this->con->prepare($sql);
			$sth->execute();
			
			return $sth->fetchAll();
		}catch(PDOException $erro){
			echo 'Erro ao buscar usuário ' . $erro->getMessage;
			exit();
		}

	}


	public function buscaPorId($id){

		$sql = "SELECT u.id, u.nome, u.email, u.orgao, u.tipo_usuario_id, u.login, u.senha, ";
		$sql .= "tp.nome AS tipo, g.id AS grupos_id, g.nome AS grupo, u.ativo AS ativo_num, ";
		$sql .= "CASE u.ativo WHEN 1 THEN 'Sim' WHEN 0 THEN 'Não' END as ativo ";
		$sql .= "FROM usuarios AS u " ;
		$sql .= "INNER JOIN tipo_usuario AS tp ON tp.id = u.tipo_usuario_id " ;
		$sql .= "INNER JOIN grupos_de_usuarios AS gu ON gu.usuarios_id = u.id ";
		$sql .= "INNER JOIN grupos AS g ON g.id = gu.grupos_id ";
		$sql .= "WHERE u.id=:id";

		try{
			$this->con = Conexao::getConexao();

			$sth = $this->con->prepare($sql);
			$sth->bindValue(':id', $id, PDO::PARAM_INT);
			$sth->execute();
			
			return $sth->fetchAll();
		}catch(PDOException $erro){
			echo 'Erro ao buscar usuário ' . $erro->getMessage;
			exit();
		}

	}

	public function buscaPorDadosUnicos($email, $login){

		$sql = "SELECT email, login FROM usuarios WHERE email=:email OR login=:login";

		try{
			$this->con = Conexao::getConexao();

			$sth = $this->con->prepare($sql);
			$sth->bindValue(':email', $email, PDO::PARAM_STR);
			$sth->bindValue(':login', $login, PDO::PARAM_STR);
			$sth->execute();
			
			return $sth->fetchAll();
		}catch(PDOException $erro){
			echo 'Erro ao buscar usuário ' . $erro->getMessage;
			exit();
		}

	}

	public function buscaPorDadosUnicosExceto($email, $login, $id){

		$sql = "SELECT email, login FROM usuarios WHERE (email=:email OR login=:login) AND id!=:id";

		try{
			$this->con = Conexao::getConexao();

			$sth = $this->con->prepare($sql);
			$sth->bindValue(':email', $email, PDO::PARAM_STR);
			$sth->bindValue(':login', $login, PDO::PARAM_STR);
			$sth->bindValue(':id', $id, PDO::PARAM_STR);
			$sth->execute();
			
			return $sth->fetchAll();
		}catch(PDOException $erro){
			echo 'Erro ao buscar usuário ' . $erro->getMessage;
			exit();
		}

	}

	public function buscaPorEmail($email){

		$sql = "SELECT * FROM usuarios WHERE email=:email";

		try{
			$this->con = Conexao::getConexao();

			$sth = $this->con->prepare($sql);
			$sth->bindValue(':email', $email, PDO::PARAM_STR);
			$sth->execute();

			return $sth->fetchAll();
		}catch(PDOException $erro){
			echo 'Erro ao buscar usuário ' . $erro->getMessage;
			exit();
		}

	}

	public function buscaPorLoginSenha($login, $senha){

		$sql = "SELECT u.id, u.nome, u.login, u.senha, u.email, u.orgao, u.tipo_usuario_id, ";
		$sql .= "tp.nome AS tipo, g.id AS grupo_id, g.nome AS grupo, u.ativo AS ativo_num, ";
		$sql .= "CASE u.ativo WHEN 1 THEN 'Sim' WHEN 0 THEN 'Não' END as ativo ";
		$sql .= "FROM usuarios AS u " ;
		$sql .= "INNER JOIN tipo_usuario AS tp ON tp.id = u.tipo_usuario_id " ;
		$sql .= "INNER JOIN grupos_de_usuarios AS gu ON gu.usuarios_id = u.id ";
		$sql .= "INNER JOIN grupos AS g ON g.id = gu.grupos_id ";
		$sql .= "WHERE login=:login AND senha=:senha AND ativo=1";

		try{
			$sth = $this->con->prepare($sql);
			$sth->bindValue(':login', $login, PDO::PARAM_STR);
			$sth->bindValue(':senha', $senha, PDO::PARAM_STR);

			$sth->execute();

			return $sth->fetchAll();
		}catch(PDOException $erro){
			$this->con->rollBack();
			echo 'Erro ao inserir usuário ' . $erro->getMessage();
			exit();
		}

	}

	public function insere($nome, $email, $orgao, $login, $senha, $tipoUsuarioId){

		$sql = "INSERT INTO usuarios(nome, email, orgao, login, senha, ativo, tipo_usuario_id) VALUES(:nome, :email, :orgao, :login, :senha, true, :tipo_usuario_id)";

		try{
			$this->con->beginTransaction();

			$sth = $this->con->prepare($sql);
			$sth->bindValue(':nome', $nome, PDO::PARAM_STR);
			$sth->bindValue(':email', $email, PDO::PARAM_STR);
			$sth->bindValue(':orgao', $orgao, PDO::PARAM_STR);
			$sth->bindValue(':login', $login, PDO::PARAM_STR);
			$sth->bindValue(':senha', $senha, PDO::PARAM_STR);
			$sth->bindValue(':tipo_usuario_id', $tipoUsuarioId, PDO::PARAM_INT);
			$sth->execute();
			
			$idUsuario = $this->con->lastInsertId();

			$this->con->commit();

			return $idUsuario;
		}catch(PDOException $erro){
			$this->con->rollBack();
			echo 'Erro ao inserir usuário ' . $erro->getMessage();
			exit();
		}

	}

	public function edita($nome, $email, $orgao, $tipo_usuario_id, $ativo, $id){

		$sql = "UPDATE usuarios SET nome=:nome, email=:email, orgao=:orgao, tipo_usuario_id=:tipo_usuario_id, ativo=:ativo WHERE id=:id";

		try{
			$this->con->beginTransaction();

			$sth = $this->con->prepare($sql);
			$sth->bindValue(':nome', $nome, PDO::PARAM_STR);
			$sth->bindValue(':email', $email, PDO::PARAM_STR);
			$sth->bindValue(':orgao', $orgao, PDO::PARAM_STR);
			$sth->bindValue(':tipo_usuario_id', $tipo_usuario_id, PDO::PARAM_INT);
			$sth->bindValue(':ativo', $ativo, PDO::PARAM_INT);
			$sth->bindValue(':id', $id, PDO::PARAM_INT);
			$resultado = $sth->execute();
			
			$this->con->commit();

			return $resultado;
		}catch(PDOException $erro){
			$this->con->rollBack();
			echo 'Erro ao atualizar usuário ' . $erro->getMessage();
			exit();
		}

	}

	public function editaPorGestor($nome, $email, $ativo, $id){

		$sql = "UPDATE usuarios SET nome=:nome, email=:email, ativo=:ativo WHERE id=:id";

		try{
			$this->con->beginTransaction();

			$sth = $this->con->prepare($sql);
			$sth->bindValue(':nome', $nome, PDO::PARAM_STR);
			$sth->bindValue(':email', $email, PDO::PARAM_STR);
			$sth->bindValue(':ativo', $ativo, PDO::PARAM_INT);
			$sth->bindValue(':id', $id, PDO::PARAM_INT);
			$resultado = $sth->execute();
			
			$this->con->commit();

			return $resultado;
		}catch(PDOException $erro){
			$this->con->rollBack();
			echo 'Erro ao atualizar usuário ' . $erro->getMessage();
			exit();
		}

	}

	public function editaSenha($senha, $id){

		$sql = "UPDATE usuarios SET senha=:senha WHERE id=:id";

		try{
			$this->con->beginTransaction();

			$sth = $this->con->prepare($sql);
			$sth->bindValue(':senha', $senha, PDO::PARAM_STR);
			$sth->bindValue(':id', $id, PDO::PARAM_INT);
			$resultado = $sth->execute();
			
			$this->con->commit();

			return $resultado;
		}catch(PDOException $erro){
			$this->con->rollBack();
			echo 'Erro ao atualizar senha de usuário ' . $erro->getMessage();
			exit();
		}

	}

	public function desativa($id){

		$sql = "UPDATE usuarios SET ativo=0 WHERE id=:id";

		try{
			$this->con->beginTransaction();

			$sth = $this->con->prepare($sql);
			$sth->bindValue(':id', $id, PDO::PARAM_INT);
			$resultado = $sth->execute();

			$this->con->commit();

			return $resultado;
		}catch(PDOException $erro){
			$this->con->rollBack();
			echo 'Erro ao desativar usuário ' . $erro->getMessage();
			exit();
		}

	}

	public function buscaLayersNomes($id){

		$sql = "SELECT l.workspace, l.nome ";
		$sql .= "FROM usuarios AS u ";
		$sql .= "INNER JOIN tipo_usuario AS tp ON tp.id = u.tipo_usuario_id ";
		$sql .= "INNER JOIN grupos_de_usuarios AS gu ON gu.usuarios_id = u.id ";
		$sql .= "INNER JOIN grupos AS g ON g.id = gu.grupos_id ";
		$sql .= "INNER JOIN basemaps_has_grupos AS bg ON g.id = bg.grupos_id ";
		$sql .= "INNER JOIN grupos_has_layers AS gl ON g.id = gl.grupos_id ";
		$sql .= "INNER JOIN basemaps AS b ON b.id = bg.basemaps_id ";
		$sql .= "INNER JOIN layers AS l ON l.id = gl.layers_id ";
		$sql .= "WHERE u.id=:id";

		try{
			$this->con->beginTransaction();

			$sth = $this->con->prepare($sql);
			$sth->bindValue(':id', $id, PDO::PARAM_INT);
			$sth->execute();

			$this->con->commit();

			return $sth->fetchAll();
		}catch(PDOException $erro){
			$this->con->rollBack();
			echo 'Erro ao buscar layer ' . $erro->getMessage();
			exit();
		}

	}

}