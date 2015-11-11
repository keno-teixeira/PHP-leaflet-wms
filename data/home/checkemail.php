<?php
require_once '../../config/autoload.php';

header('Content-type: text/json; charset=UTF-8');

if(isset($_POST["email"])):
		sleep(1);

		$usuarios = new Usuarios();
		$resultado = $usuarios->buscaPorEmail($_POST["email"]);

		if(!empty($resultado)):
			$email = new Mail();
			$email->Subject = utf8_decode("Recuperação de senha");
    		$email->FromName = utf8_decode("SITURB - UNTEC");
    		$email->AddAddress($_POST["email"]);
    		$email->setBodyRecSenha('Recuperação de senha', 'Olá, Sr(a) ' . $resultado[0]["nome"] . ', esse e-mail é enviado quando solicitado através do sistema. Sua senha: ' . $resultado[0]["senha"]);
    		
    		// envia e-mail
    		if($email->Send()):
    			$return_arr["status"]=1;
    		else:
    			$return_arr["status"]=0;
    			$return_arr["msg"]="Não foi possível enviar um e-mail. Tente novamente mais tarde.";
    		endif;
		else:
			$return_arr["status"]=0;
			$return_arr["msg"]="Digite um e-mail válido !!";
		endif;

		echo json_encode($return_arr);
endif;

exit;