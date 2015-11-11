<?php

define('URL_ROOT', 'http://' . $_SERVER['HTTP_HOST'] . '/siturb2/');
define('DIRECTORY_ROOT', $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'siturb2' . DIRECTORY_SEPARATOR);
define('DIRECTORY_CLASS', 'class' . DIRECTORY_SEPARATOR);
define('STRING_DB', 'mysql');
define('NOME_DB', 'siturb_authentication');
define('HOST', '10.233.34.10');
define('PORTA', '3306');
define('USUARIO', 'root');
define('SENHA', '');

class ClassAutoloader {

	public function __construct() {
		spl_autoload_extensions(".php");
		spl_autoload_register(array($this, 'loader'));
	}
	
	private function loader($classNome) {
		require_once DIRECTORY_ROOT . DIRECTORY_CLASS . $classNome . '.php';
	}

}

$autoloader = new ClassAutoloader();