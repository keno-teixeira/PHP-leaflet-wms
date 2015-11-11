<?php
require_once '../../config/autoload.php';

header('Content-type: text/json; charset=UTF-8');

if(isset($_POST["username"]) or isset($_POST["password"])):
		sleep(1);

		$usuarios = new Usuarios();
		$resultado = $usuarios->buscaPorLoginSenha($_POST["username"], $_POST["password"]);

		if(!empty($resultado)):
			$autentica = new Autentica();
			$autentica->novaSessao($resultado);

			//if(isset($_POST['lembrar']))
				//$autentica->armazenarLogin($_POST['username']);

			$return_arr["status"]=1;
		else:
			$return_arr["status"]=0;
		endif;

		echo json_encode($return_arr);
endif;

exit;