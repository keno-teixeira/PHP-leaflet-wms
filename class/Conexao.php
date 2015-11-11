<?php

abstract class Conexao{

	private static $_conexao = null;

	private function __clone(){}

	static public function getConexao(){

		try{

			if(!isset(self::$_conexao)):
				self::$_conexao = new PDO(STRING_DB . ':dbname=' . NOME_DB . ';host=' . HOST, USUARIO, SENHA);
			endif;

			self::$_conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			return self::$_conexao;
		}catch(PDOException $erro){
			echo "Erro ao conectar " . $erro->getMessage();
			exit();
		}

	}

}